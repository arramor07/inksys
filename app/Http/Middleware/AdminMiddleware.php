<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            abort(403, 'You must be logged in.');
        }

        $user = auth()->user();
        
        if ($user->role !== 'admin') {
            abort(403, 'You are not authorized to access this page. Your role is: ' . ($user->role ?? 'none'));
        }

        return $next($request);
    }
}
