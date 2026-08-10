<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class RedirectIfStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    //public function handle(Request $request, Closure $next): Response
    //{
    //  return $next($request);
    //}
    public function handle(Request $request, Closure $next)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user && $user->hasRole('student')) {
            return redirect()->route('portal.home');
        }

        return $next($request);
    }
}
