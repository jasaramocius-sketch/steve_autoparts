<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StaffDashboardController extends Controller
{
    public function index()
    {
        // Optional: Show some quick stats if you want
        $users = User::count();
        $activeUsers = User::where('status', 'active')->count();

        return view('staff.dashboard.index', compact('users', 'activeUsers'));
    }
    public function store(Request $request)
    {
    $request->validate([
    'name'=>'required',
    'email'=>'required|unique',
    'password'=>'required|min:6'
    ]);

    User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password),
        'role'=>'staff'
    ]);

    return redirect()
        ->route('staffs.index')
        ->with('success','Staff created successfully');

    }
}
