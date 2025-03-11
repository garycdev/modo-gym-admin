<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

class SanctumJsonMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (AuthenticationException $e) {
            return response()->json(['message' => 'No autorizado. Token inválido o no proporcionado.'], 401);
        }
    }
}
