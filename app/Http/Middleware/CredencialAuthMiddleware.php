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
    public function handle($request, Closure $next)
    {
        $apiSecret = env('API_SECRET');
        $providedSecret = $request->header('Api-Secret');

        if ($providedSecret !== $apiSecret) {
            return response()->json(['message' => 'Credencial inválida'], 401);
        }

        return $next($request);
    }
}
