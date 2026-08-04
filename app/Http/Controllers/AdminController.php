<?php

namespace App\Http\Controllers;

use App\Models\FileRevision;
use App\Models\Order;
use App\Models\Product;
use App\Models\Revision;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $topProducts = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        if ($topProducts->isNotEmpty()) {
            $products = Product::whereIn('id', $topProducts->pluck('product_id'))->get()->keyBy('id');
            $topProducts = $topProducts->map(fn($item) => tap($item, fn($i) => $i->product = $products->get($i->product_id)));
        }

        $ordersByStatus = Order::selectRaw("status, COUNT(*) as count")->groupBy('status')->get();

        $dbRevenue = Order::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total_amount) as total")->groupBy('month')->orderBy('month')->take(12)->pluck('total', 'month');

        $monthlyRevenueData = collect();
        for ($i = 11; $i >= 0; $i--) {
            $key = now()->subMonths($i)->format('Y-m');
            $monthlyRevenueData->put($key, (float) ($dbRevenue->get($key) ?? 0));
        }

        $weeklyRevenue = Order::selectRaw("YEARWEEK(created_at, 1) as week, SUM(total_amount) as total")
            ->where('created_at', '>=', now()->subWeeks(12))
            ->groupBy('week')
            ->orderBy('week')
            ->pluck('total', 'week');

        $weeklyRevenueData = collect();
        for ($i = 11; $i >= 0; $i--) {
            $start = now()->subWeeks($i)->startOfWeek();
            $key = $start->format('Y-m-d');
            $weekKey = (int)$start->format('oW');
            $weeklyRevenueData->put($key, (float) ($weeklyRevenue->get($weekKey) ?? 0));
        }

        $dailyRevenue = Order::selectRaw("DATE(created_at) as date, SUM(total_amount) as total")
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $dailyRevenueData = collect();
        for ($i = 29; $i >= 0; $i--) {
            $key = now()->subDays($i)->format('Y-m-d');
            $dailyRevenueData->put($key, (float) ($dailyRevenue->get($key) ?? 0));
        }

        $hourlyRevenue = Order::selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:00:00') as hour, SUM(total_amount) as total")
            ->whereDate('created_at', today())
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('total', 'hour');

        $hourlyRevenueData = collect();
        $currentHour = (int)now()->format('H');
        for ($h = 0; $h <= $currentHour; $h++) {
            $key = now()->format('Y-m-d') . ' ' . str_pad($h, 2, '0', STR_PAD_LEFT) . ':00:00';
            $hourlyRevenueData->put($key, (float) ($hourlyRevenue->get($key) ?? 0));
        }

        $fiveMinRevenue = Order::selectRaw("
            FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(created_at) / 300) * 300) as interval_time,
            SUM(total_amount) as total
        ")
            ->whereDate('created_at', today())
            ->groupBy('interval_time')
            ->orderBy('interval_time')
            ->pluck('total', 'interval_time');

        $fiveMinRevenueData = collect();
        $current = now()->startOfDay();
        $now = now();
        while ($current <= $now) {
            $key = $current->format('Y-m-d H:i:s');
            $fiveMinRevenueData->put($key, (float) ($fiveMinRevenue->get($key) ?? 0));
            $current->addMinutes(5);
        }

        return view('admin.dashboard', [
            'totalOrders' => Order::count(),
            'totalRevenue' => Order::sum('total_amount'),
            'totalProducts' => Product::count(),
            'totalCustomers' => User::where('role', 'customer')->count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'recentOrders' => Order::with('user')->latest()->take(5)->get(),
            'ordersByStatus' => $ordersByStatus,
            'monthlyRevenue' => $monthlyRevenueData,
            'ordersByStatusJson' => $ordersByStatus->pluck('count', 'status'),
            'monthlyRevenueJson' => $monthlyRevenueData,
            'weeklyRevenueJson' => $weeklyRevenueData,
            'dailyRevenueJson' => $dailyRevenueData,
            'hourlyRevenueJson' => $hourlyRevenueData,
            'fiveMinRevenueJson' => $fiveMinRevenueData,
            'topProducts' => $topProducts,
        ]);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone'   => 'nullable|string|max:255|regex:/^[0-9+\-\s()]*$/',
            'address' => 'nullable|string|max:255',
            'city'    => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'address', 'city', 'country']));

        session()->put('user_profile', $user->only(['id', 'name', 'email', 'role', 'phone', 'address', 'city', 'country']));

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Incorrect current password']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }

    public function todayRevenue(Request $request)
    {
        $range = $request->get('range', '5min');

        if ($range === 'hourly') {
            $hourlyRevenue = Order::selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:00:00') as hour, SUM(total_amount) as total")
                ->whereDate('created_at', today())
                ->groupBy('hour')
                ->orderBy('hour')
                ->pluck('total', 'hour');

            $data = collect();
            $currentHour = (int)now()->format('H');
            for ($h = 0; $h <= $currentHour; $h++) {
                $key = now()->format('Y-m-d') . ' ' . str_pad($h, 2, '0', STR_PAD_LEFT) . ':00:00';
                $data->put($key, (float) ($hourlyRevenue->get($key) ?? 0));
            }

            return response()->json($data);
        }

        $todayRevenue = Order::selectRaw("
            FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(created_at) / 300) * 300) as interval_time,
            SUM(total_amount) as total
        ")
            ->whereDate('created_at', today())
            ->groupBy('interval_time')
            ->orderBy('interval_time')
            ->pluck('total', 'interval_time');

        $fiveMinIntervals = collect();
        $current = now()->startOfDay();
        $now = now();
        while ($current <= $now) {
            $key = $current->format('Y-m-d H:i:s');
            $fiveMinIntervals->put($key, (float) ($todayRevenue->get($key) ?? 0));
            $current->addMinutes(5);
        }

        return response()->json($fiveMinIntervals);
    }

    public function headerSettings()
    {
        $settings = Setting::getAllAsArray();
        $categories = \App\Models\Category::with('children')->orderBy('name')->get();
        return view('admin.settings.header', compact('settings', 'categories'));
    }

    public function logs(Request $request)
    {
        $directory = storage_path('logs/site-changes');
        $files = [];

        if (is_dir($directory)) {
            $files = array_values(array_filter(scandir($directory), function ($file) {
                return preg_match('/\.log$/', $file);
            }));
            rsort($files);
        }

        $selectedFile = $request->get('file', $files[0] ?? null);
        $contents = [];

        if ($selectedFile && is_file($directory . DIRECTORY_SEPARATOR . $selectedFile)) {
            $contents = file($directory . DIRECTORY_SEPARATOR . $selectedFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        }

        return view('admin.logs.index', compact('files', 'selectedFile', 'contents'));
    }

    public function revisions(Request $request)
    {
        $sortBy = in_array($request->sort_by, ['id', 'created_at', 'action', 'model_type']) ? $request->sort_by : 'created_at';
        $sortDir = $request->sort_dir === 'asc' ? 'asc' : 'desc';
        $perPage = in_array((int)$request->per_page, [10, 20, 50, 100]) ? (int)$request->per_page : 20;
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        $revisions = Revision::with('user');
        if ($dateFrom) {
            $revisions->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $revisions->whereDate('created_at', '<=', $dateTo);
        }

        $revisions = $revisions->orderBy($sortBy, $sortDir)
            ->paginate($perPage)
            ->appends($request->query())
            ->onEachSide(1);

        return view('admin.revisions.index', compact('revisions', 'sortBy', 'sortDir'));
    }

    public function revisionDetail($id)
    {
        $rev = Revision::with('user')->findOrFail($id);
        return view('admin.revisions.detail', compact('rev'));
    }

    public function fileRevisions(Request $request)
    {
        $sortBy = in_array($request->sort_by, ['id', 'created_at', 'event', 'file_path']) ? $request->sort_by : 'created_at';
        $sortDir = $request->sort_dir === 'asc' ? 'asc' : 'desc';
        $perPage = in_array((int)$request->per_page, [10, 20, 50, 100]) ? (int)$request->per_page : 20;
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        $fileRevisions = FileRevision::with('user');
        if ($dateFrom) {
            $fileRevisions->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $fileRevisions->whereDate('created_at', '<=', $dateTo);
        }

        $fileRevisions = $fileRevisions->orderBy($sortBy, $sortDir)
            ->paginate($perPage)
            ->appends($request->query())
            ->onEachSide(1);

        return view('admin.file-revisions.index', compact('fileRevisions', 'sortBy', 'sortDir'));
    }

    public function fileRevisionDownload($id)
    {
        $rev = FileRevision::findOrFail($id);
        if (!$rev->backup_path) {
            return abort(404);
        }
        $path = storage_path('file-backups/archive/' . $rev->backup_path);
        if (!file_exists($path)) {
            return abort(404, 'Backup file not found.');
        }
        return response()->download($path, basename($rev->file_path) . '.bak');
    }

    public function fileRevisionDiff($id)
    {
        $rev = FileRevision::with('user')->findOrFail($id);
        return view('admin.file-revisions.diff', compact('rev'));
    }

    public function updateHeaderSettings(Request $request)
    {
        $keys = [
            'header_logo', 'header_phone', 'header_support_text', 'header_email',
            'header_address', 'footer_copyright', 'header_favicon', 'mobile_logo', 'footer_logo',
            'nav_menu',
        ];

        $imageKeys = ['header_logo', 'header_favicon', 'mobile_logo', 'footer_logo'];

        foreach ($keys as $key) {
            $managerKey = 'image_from_manager_' . $key;
            if (in_array($key, $imageKeys) && $request->filled($managerKey)) {
                $sourcePath = storage_path('app/public/' . $request->input($managerKey));
                if (file_exists($sourcePath)) {
                    $filename = time() . '_' . uniqid() . '.' . pathinfo($request->input($managerKey), PATHINFO_EXTENSION);
                    copy($sourcePath, public_path('assets/images/' . $filename));
                    Setting::set($key, $filename);
                }
            } elseif ($request->hasFile($key)) {
                $file = $request->file($key);
                $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/images'), $filename);
                Setting::set($key, $filename);
            } elseif ($request->has($key)) {
                Setting::set($key, $request->input($key));
            }
        }

        return redirect()->route('admin.settings.header')->with('success', 'Header settings updated successfully.');
    }

    public function footerSettings()
    {
        $settings = Setting::getAllAsArray();
        return view('admin.settings.footer', compact('settings'));
    }

    public function updateFooterSettings(Request $request)
    {
        $data = json_decode((string) $request->input('footer_columns', '[]'), true);

        if (!is_array($data)) {
            return back()->with('error', 'Invalid footer columns data.');
        }

        $allowedTypes = ['links', 'newsletter', 'contact'];
        $allowedSpans = [2, 3, 4, 6, 12];

        $columns = [];
        foreach ($data as $col) {
            if (!is_array($col)) {
                continue;
            }

            $type = in_array($col['type'] ?? '', $allowedTypes) ? $col['type'] : 'links';
            $span = in_array((int) ($col['span'] ?? 2), $allowedSpans) ? (int) $col['span'] : 2;

            $links = [];
            foreach (($col['links'] ?? []) as $link) {
                if (!is_array($link)) {
                    continue;
                }
                $label = trim((string) ($link['label'] ?? ''));
                $url = trim((string) ($link['url'] ?? ''));
                if ($label === '' && $url === '') {
                    continue;
                }
                $links[] = ['label' => $label, 'url' => $url];
            }

            $columns[] = [
                'type' => $type,
                'heading' => trim((string) ($col['heading'] ?? '')),
                'span' => $span,
                'links' => $links,
            ];
        }

        Setting::set('footer_columns', json_encode($columns));

        return redirect()->route('admin.settings.footer')->with('success', 'Footer settings updated successfully.');
    }
}
