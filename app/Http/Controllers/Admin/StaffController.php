<?php

namespace App\Http\Controllers\Admin;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::query()->withTrashed();

        if ($request->has('trashed')) {
            $staffs = $query->onlyTrashed()->latest()->get();
            $showTrashed = true;
        } else {
            $staffs = $query->whereNull('deleted_at')->latest()->get();
            $showTrashed = false;
        }

        return view('admin.staff.index', compact('staffs', 'showTrashed'));
    }

    public function restore($id)
    {
        Staff::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.staff.index')->with('success', 'Staff restored successfully.');
    }

    public function forceDelete($id)
    {
        $staff = Staff::onlyTrashed()->findOrFail($id);
        $staff->forceDelete();
        return redirect()->route('admin.staff.index')->with('success', 'Staff permanently deleted.');
    }
}