<?php
namespace App\Http\Middleware;

use Closure;
use App;
use Redirect;

class UseSSL
{
    public function handle($request, Closure $next)
    {
        if (($request->server('HTTP_X_FORWARDED_PROTO') != 'https') && app()->environment('local')) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}