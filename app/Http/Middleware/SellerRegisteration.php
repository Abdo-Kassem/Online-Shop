<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SellerRegisteration
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
        if(str_contains($request->url(),'/create/shop')){

            if(!session()->has('seller')){
                return redirect()->route('seller.register.form');
            }

        }elseif(str_contains($request->url(),'/create/wallet')){

            if(!session()->has('shop')){
                return redirect()->route('seller.create.shop.form');
            }

        }
        return $next($request);
    }
}
