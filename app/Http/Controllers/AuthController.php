<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\Compare;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    private function dashboardRoute()
    {
        if (!Auth::check()) {
            return null;
        }

        return in_array(Auth::user()->role, ['master_admin', 'admin', 'staff'])
            ? route('admin.dashboard')
            : route('user.dashboard');
    }

    private function mergeGuestData()
    {
        $userId = Auth::id();

        $guestWishlist = session('guest_wishlist', []);
        foreach ($guestWishlist as $productId) {
            Wishlist::firstOrCreate([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
        }
        session()->forget('guest_wishlist');

        $guestCompare = session('guest_compare', []);
        $existingCount = Compare::where('user_id', $userId)->count();
        $slotsAvailable = 3 - $existingCount;

        if ($slotsAvailable > 0) {
            $merged = 0;
            foreach ($guestCompare as $productId) {
                if ($merged >= $slotsAvailable) {
                    break;
                }

                $compare = Compare::firstOrCreate([
                    'user_id' => $userId,
                    'product_id' => $productId,
                ]);

                if ($compare->wasRecentlyCreated) {
                    $merged++;
                }
            }
        }

        session()->forget('guest_compare');
    }

    public function loginForm()
    {
        if ($route = $this->dashboardRoute()) {
            return redirect()->to($route);
        }

        return view('auth.login');
    }
    public function registerForm()
    {
        if ($route = $this->dashboardRoute()) {
            return redirect()->to($route);
        }

        return view('auth.register');
    }

    /**
     * Authenticate user against the database and store real data in session.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }

        $request->session()->regenerate();

        $user = Auth::user();
        $request->session()->put([
            'user_logged_in' => true,
            'user_profile' => $user->only(['id', 'name', 'email', 'role', 'phone', 'address', 'city', 'country']),
        ]);

        $this->mergeGuestData();

        if ($user->role === 'master_admin' || $user->role === 'admin' || $user->role === 'staff') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    }

    /**
     * Register a new customer account and log them in.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'customer',
        ]);

        Auth::login($user);

        $request->session()->regenerate();
        $request->session()->put([
            'user_logged_in' => true,
            'user_profile' => $user->only(['id', 'name', 'email', 'role', 'phone', 'address', 'city', 'country']),
        ]);

        $this->mergeGuestData();

        return redirect()->route('user.dashboard')->with('success', 'Account created successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
    public function showLogin()
    {
        if ($route = $this->dashboardRoute()) {
            return redirect()->to($route);
        }

        return view('auth.login');
    }

}
