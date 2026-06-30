<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    /**
     * Add product to wishlist
     */
    public function add(Request $request)
    {
        if (session('user_profile.id')) {

            Wishlist::firstOrCreate([
                'user_id' => session('user_profile.id'),
                'product_id' => $request->product_id
            ]);

            $count = Wishlist::where(
                'user_id',
                session('user_profile.id')
            )->count();
        } else {

            $wishlist = session()->get('guest_wishlist', []);

            if (!in_array($request->product_id, $wishlist)) {
                $wishlist[] = $request->product_id;
            }

            session()->put('guest_wishlist', $wishlist);

            $count = count($wishlist);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist!',
            'count' => $count
        ]);
    }

    /**
     * Wishlist Page
     */
    public function index()
    {
        // Logged In User Wishlist
        if (session('user_profile.id')) {

            $wishlist = Wishlist::with('product')
                ->where('user_id', session('user_profile.id'))
                ->latest()
                ->get();

            return view('user.wishlist', compact('wishlist'));
        }

        // Guest Wishlist
        $guestWishlist = session()->get('guest_wishlist', []);

        $wishlist = collect();

        if (!empty($guestWishlist)) {

            $products = Product::whereIn(
                'id',
                $guestWishlist
            )->get();

            foreach ($products as $product) {

                $wishlist->push((object)[
                    'id' => $product->id,
                    'product_id' => $product->id,
                    'product' => $product
                ]);
            }
        }

        return view('user.wishlist', compact('wishlist'));
    }

    /**
     * Remove Product
     */
    public function remove($id)
    {
        // Logged In User
        if (session('user_profile.id') && session('user_profile.id')) {

            Wishlist::where('id', $id)
                ->where(
                    'user_id',
                    session('user_profile.id')
                )
                ->delete();

            return back()->with(
                'success',
                'Product removed from wishlist'
            );
        }

        // Guest User
        $wishlist = session()->get(
            'guest_wishlist',
            []
        );

        $wishlist = array_diff(
            $wishlist,
            [$id]
        );

        session()->put(
            'guest_wishlist',
            $wishlist
        );

        return back()->with(
            'success',
            'Product removed from wishlist'
        );
    }

    /**
     * Move Wishlist Product To Cart
     */
    public function moveToCart(Request $request)
    {
        $wishlist = Wishlist::with('product')
            ->findOrFail($request->wishlist_id);

        $cart = session()->get('cart', []);

        $productId = $wishlist->product_id;

        if (isset($cart[$productId])) {

            $cart[$productId]['quantity']++;
        } else {

            $cart[$productId] = [
                'id' => $wishlist->product->id,
                'name' => $wishlist->product->name,
                'price' => $wishlist->product->price,
                'image' => $wishlist->product->image,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);

        $wishlist->delete();

        return back()->with(
            'success',
            'Product moved to cart'
        );
    }

    /**
     * Clear All Wishlist
     */
    public function clearAll()
    {
        if (session('user_profile.id')) {
            Wishlist::where('user_id', session('user_profile.id'))->delete();
        } else {
            session()->forget('guest_wishlist');
        }

        return back()->with('success', 'Wishlist cleared successfully');
    }

    /**
     * Wishlist Count
     */
    public function count()
    {
        if (session('user_profile.id')) {

            return Wishlist::where(
                'user_id',
                session('user_profile.id')
            )->count();
        }

        return count(
            session()->get(
                'guest_wishlist',
                []
            )
        );
    }
}