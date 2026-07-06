<?php

namespace App\Http\Middleware;

use App\Support\AuthSession;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! AuthSession::check()) {
            return redirect()->route('login')
                ->with('error', 'Please sign in to continue.');
        }

        return $next($request);
    }
}
