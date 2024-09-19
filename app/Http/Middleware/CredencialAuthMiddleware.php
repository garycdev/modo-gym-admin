<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CredencialAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $apiSecret = env('APP_CREDENCIAL');
        $providedSecret = $request->header('Api-Secret');

        if ($providedSecret !== $apiSecret) {
            return response()->json(['message' => "Credencial Invalido"], 401);
        }

        return $next($request);
    }
}
