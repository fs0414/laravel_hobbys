<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;

class CartSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('cart')) {
            $request->session()->flush();
            $cart = Cart::create();
            // dd($cart);
            Session::put('cart', $cart->id);
            // dd(Session::get('cart'));
        }
        // dd(Session::get('cart'));
        return $next($request);
    }
}
