<?php

namespace App\Http\Middleware;

use App\Helpers\SiteChangeLogger;
use Closure;
use Illuminate\Http\Request;

class LogSiteChange
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $method = $request->method();
        $uri = $request->getRequestUri();
        $routeName = $request->route()?->getName();
        $isChangeAction = in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'], true);

        $context = [
            'route' => $routeName ?? null,
            'uri' => $uri,
            'ip' => $request->ip(),
            'user_id' => optional($request->user())->id,
            'status' => method_exists($response, 'status') ? $response->status() : null,
            'input_keys' => array_keys($request->except(['password', 'password_confirmation', 'token'])),
        ];

        $type = $isChangeAction ? 'change' : 'request';
        $message = $isChangeAction ? 'Site change action recorded' : 'Site request recorded';

        SiteChangeLogger::log($type, $message, $context);

        return $response;
    }
}
