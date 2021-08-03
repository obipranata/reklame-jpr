<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class cekUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if($user){
            if($user->level == 3){
                return $next($request);
            }else{
                if ($user->level == 1) {
                    return redirect('/vendor');
                }else if ($user->level == 2) {
                    return redirect('/vendor/pesanan');
                }else if ($user->level == 4) {
                    return redirect('/dinas/izinvendor');
                }
            }
        }else{
            return $next($request);
        }
    }
}
