<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Wishlist;
use App\Models\Compare;
use App\Models\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use App\Helpers\SiteChangeLogger;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('Helpers/currency.php');
        require_once app_path('Helpers/image.php');
        require_once app_path('Helpers/date.php');
        require_once app_path('Helpers/SiteChangeLogger.php');
        require_once app_path('Helpers/NotificationHelper.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.gs-pagination');
        Paginator::defaultSimpleView('vendor.pagination.gs-pagination');

        // Fetch dynamic currency rates from Unirate API
        try {
            $dynamicCurrencies = cache()->remember('dynamic_currency_rates', 43200, function () {
                $defaultCurrencies = config('currencies', []);

                $response = \Illuminate\Support\Facades\Http::timeout(5)->get('https://api.unirateapi.com/api/widget/v1/rates?base=USD');
                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['rates'])) {
                        $rates = $data['rates'];
                        foreach ($defaultCurrencies as $code => $info) {
                            if (isset($rates[$code])) {
                                $defaultCurrencies[$code]['rate'] = $rates[$code];
                            }
                        }
                    }
                }
                return $defaultCurrencies;
            });

            config(['currencies' => $dynamicCurrencies]);
        } catch (\Exception $e) {
            logger()->error('Failed to fetch/apply dynamic currencies: ' . $e->getMessage());
        }

        View::composer('*', function ($view) {

            $wishlistCount = 0;
            $compareCount = 0;
            $wishedProductIds = [];
            $unreadNotificationCount = 0;

            $loggedIn = session('user_logged_in') && session('user_profile.id');

            if (!$loggedIn && Auth::check()) {
                $user = Auth::user();
                session()->put([
                    'user_logged_in' => true,
                    'user_profile'   => $user->only(['id', 'name', 'email', 'role', 'phone', 'address', 'city', 'country']),
                ]);
                $loggedIn = true;
            }

            if ($loggedIn) {
                $userId = session('user_profile.id');
                $wishlistCount = Wishlist::where('user_id', $userId)->count();
                $wishedProductIds = Wishlist::where('user_id', $userId)->pluck('product_id')->toArray();
                $compareCount = Compare::where('user_id', $userId)->count();
                $unreadNotificationCount = Notification::where('user_id', $userId)->unread()->count();
            } else {
                $wishedProductIds = session('guest_wishlist', []);
                $wishlistCount = count($wishedProductIds);
                $compareCount = count(session('guest_compare', []));
            }

            $cart = session('cart', []);
            $cartCount = count($cart);
            $cartTotal = array_sum(array_map(fn($item) => ($item['price'] ?? 0) * ($item['qty'] ?? ($item['quantity'] ?? 0)), $cart));

            $mobileCategoryTree = cache()->remember('front_mobile_category_tree_v1', 21600, function () {
                $tree = \App\Models\Category::topLevel()
                    ->where('status', true)
                    ->with('childrenRecursive')
                    ->get();

                $productCounts = \App\Models\Product::where('status', true)
                    ->selectRaw('category_id, COUNT(*) as count')
                    ->groupBy('category_id')
                    ->pluck('count', 'category_id');

                $setDescendantCount = function ($category, $counts) use (&$setDescendantCount) {
                    $total = $counts->get($category->id, 0);
                    foreach ($category->children as $child) {
                        $total += $setDescendantCount($child, $counts);
                    }
                    $category->descendant_count = $total;
                    return $total;
                };

                $tree->each(function ($cat) use ($setDescendantCount, $productCounts) {
                    $setDescendantCount($cat, $productCounts);
                });

                return $tree;
            });

            $view->with([
                'wishlistCount' => $wishlistCount,
                'wishedProductIds' => $wishedProductIds,
                'compareCount' => $compareCount,
                'cartCount' => $cartCount,
                'cartTotal' => $cartTotal,
                'unreadNotificationCount' => $unreadNotificationCount,
                'mobileCategoryTree' => $mobileCategoryTree,
            ]);
        });

        if (app()->runningInConsole()) {
            SiteChangeLogger::log('info', 'Application booted in console');
        }

        \App\Models\Category::saved(fn () => cache()->forget('front_mobile_category_tree_v1'));
        \App\Models\Category::deleted(fn () => cache()->forget('front_mobile_category_tree_v1'));
    }
}
