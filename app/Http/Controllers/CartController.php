<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart',compact('cart'));
    }

    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart')->with('success', 'Product removed from cart successfully.');
    }

    public function updateCart(Request $request)
    {
        $productId = $request->input('productId');
        $quantity = $request->input('quantity');

        if ($quantity < 1) {
            return response()->json(['success' => false, 'message' => 'Quantity cannot be less than 1.']);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            session()->put('cart', $cart);

            // session()->flash('success', 'Cart updated successfully.');
            return response()->json(['success' => true]);
        }

        session()->flash('error', 'Product not found in cart.');
        return response()->json(['success' => false, 'message' => 'Product not found in cart.']);
    }

    public function getCount()
    {
        $cart = session()->get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));
        return response()->json(['count' => $cartCount]);
    }
}
