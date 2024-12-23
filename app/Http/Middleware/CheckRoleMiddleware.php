<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        /**
         * @var User
         */
        $user = Auth::user();

        if (($role === 'admin' && $user->isAdmin()) ||
            ($role === 'editor' && $user->isEditor()) ||
            ($role === 'author' && $user->isAuthor())
        ) {
            return $next($request);
        }

        return redirect()->route('client.index');
    }
}
