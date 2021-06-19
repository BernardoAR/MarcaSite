<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecaLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Checa por api e por web
        if (!Auth::guard('api')->check() && !Auth::check()) {
            return response()->json(['msg' => 'Acesso Negado.'], 403);
        }
        return $next($request);
    }
}
