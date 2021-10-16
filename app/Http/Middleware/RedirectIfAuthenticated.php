<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect('/');
            }
        }

        return $next($request);
    }
}

/*-------------------------------------------------------------------------

このミドルウェアはユーザーが認証済みの場合はコントローラーなどの後続のプログラムに処理を
渡さずにリダイレクトしてしまいます。リダイレクト先がデフォルトでは '/home' と記述されて
いますが、今回のアプリケーションにはそのような URL を持つページは存在しないのでホームペ
ージの URL / に書き換えます。

------------------------------------------------------------------------*/
