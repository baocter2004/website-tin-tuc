<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserCheckCommentLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!auth()->check()) {
            session()->put('url.intended', url()->previous());
            return redirect()->back()->withErrors([
                'messages' => 'Bạn Phải Đăng Nhập Mới Bình Luận Được !!!',
                'link' => route('auth.login')
            ]);
        }
        return $next($request);
    }
}
