<?php

namespace App\Http\Controllers;

class StaffController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['staff'])->get();

        return view('admin.staff.index', compact('users'));
    }
}
