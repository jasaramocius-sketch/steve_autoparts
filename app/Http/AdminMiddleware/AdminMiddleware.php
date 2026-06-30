<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        $profile = session('user_profile');
        if (! $profile || $profile['role'] !== 'master_admin') {
            return redirect()->route('user.dashboard')
                ->with('error', 'You are not authorized to access the admin area.');
        }
        return $next($request);
    }
}
