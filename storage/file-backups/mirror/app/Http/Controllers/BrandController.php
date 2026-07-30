<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function brands(Request $request)
    {
        $search = $request->get('search', '');
        $sort = $request->get('sort', 'latest');

        $brandsQuery = Brand::where('status', true)
            ->withCount(['products' => fn($q) => $q->where('status', true)]);

        if ($search !== '') {
            $brandsQuery->where('name', 'like', "%{$search}%");
        }

        if ($sort === 'name') {
            $brandsQuery->orderBy('name');
        } elseif ($sort === 'oldest') {
            $brandsQuery->orderBy('created_at', 'asc');
        } else {
            $brandsQuery->orderBy('created_at', 'desc');
        }

        $brands = $brandsQuery->paginate(12)->appends($request->only(['search', 'sort']));

        return view('brands', compact('brands', 'search', 'sort'));
    }
}
