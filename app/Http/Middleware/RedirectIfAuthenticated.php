<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ?string ...$guards): Response
    {
        // Jika sudah login dan mencoba akses route login/register
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}