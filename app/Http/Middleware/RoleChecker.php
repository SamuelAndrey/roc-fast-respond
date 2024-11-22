<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleChecker
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws HttpException
     */
    public function handle(Request $request, Closure $next, ...$roles){
        foreach ($roles as $role) {
            if (Auth::check() && Auth::user()->role == $role) {
                return $next($request);
            }
        }

        throw new HttpException(403, 'You are not authorized to access this page.');
    }
}
