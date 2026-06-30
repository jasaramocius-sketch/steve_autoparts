<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')->get();
        return view('admin.customers.index', compact('customers'));
    }
    public function edit($id)
    {
        $customer = User::findOrFail($id);

        if (Auth::user()->role !== 'master_admin' && $customer->role === 'master_admin') {
            return redirect()->route('admin.customers.index')->with('error', 'You cannot edit master admin users.');
        }

        return view('admin.customers.edit', compact('customer'));
    }

    public function profile()
    {
        $profile = Auth::user();

        return view('user.profile', compact('profile'));
    }   

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::user()->role !== 'master_admin' && $user->role === 'master_admin') {
            return redirect()->route('admin.customers.index')->with('error', 'You cannot delete master admin users.');
        }

        $user->delete();

        return redirect()->route('admin.customers.index');
    }
    
    public function dashboard()
    {   
        return view('user.dashboard');
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->city = $request->city;
        $user->country = $request->country;

        $saved = $user->save();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Incorrect current password']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }   
    public function customers()
    {
        $users = User::where('role', 'customer')->get();
        return view('admin.customers.index', compact('users'));
    }

    public function staff()
    {
        $users = User::whereIn('role', ['master_admin', 'admin', 'staff'])->get();
        return view('admin.staff.index', compact('users'));
    }

    public function createCustomer()
    {
        return view('admin.customers.create');
    }

    public function storeCustomer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'role' => 'customer',
        ]);

        return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (Auth::user()->role !== 'master_admin' && $user->role === 'master_admin') {
            return redirect()->route('admin.customers.index')->with('error', 'You cannot update master admin users.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'address', 'city', 'country']));

        return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully.');
    }

    public function createStaff()
    {
        return view('admin.staff.create');
    }

    public function storeStaff(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:255',
            'role' => 'required|in:admin,staff',
        ]);

        if (in_array($request->role, ['admin', 'master_admin']) && Auth::user()->role !== 'master_admin') {
            return back()->withErrors(['role' => 'Only master admin can create admin/master admin accounts.']);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        $label = ucfirst($request->role);
        return redirect()->route('admin.staff.index')->with('success', "{$label} created successfully.");
    }

    public function editStaff($id)
    {
        $user = User::findOrFail($id);
        return view('admin.staff.edit', compact('user'));
    }

    public function updateStaff(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,staff',
        ]);

        if ($user->role === 'master_admin') {
            return back()->withErrors(['role' => 'Cannot modify master admin accounts.']);
        }

        if (in_array($request->role, ['admin', 'master_admin']) && Auth::user()->role !== 'master_admin') {
            return back()->withErrors(['role' => 'Only master admin can assign admin/master admin role.']);
        }

        $data = $request->only(['name', 'email', 'phone', 'role']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('admin.staff.index')->with('success', 'User updated successfully.');
    }

    public function destroyStaff($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Staff deleted successfully.');
    }
}