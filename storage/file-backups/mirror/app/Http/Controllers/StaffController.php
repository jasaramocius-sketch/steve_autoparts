<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['staff'])->get();
        return view('admin.staff.index', compact('users'));
    }
}