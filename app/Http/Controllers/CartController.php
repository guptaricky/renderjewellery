<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $cart = Cart::updateOrCreate(
            [
                'user_id' => Auth::user()->id,
                'product_id' => $request->product_id,
            ],
            [
                'quantity' => DB::raw('quantity + ' . $request->quantity),
            ]
        );

        return response()->json(['message' => 'Product added to cart!', 'cart' => $cart]);
    }

    public function viewCart()
    {
        $cart = Cart::with('product')->get();
        $total = $cart->sum(fn($item) => $item->product->price * $item->quantity);

        // return response()->json(['cart' => $cart, 'total' => $total]);
        return view('cart',['cart' => $cart, 'total' => $total]);
    }
}
