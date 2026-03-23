<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'image'    => $product->image,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'count'   => array_sum(array_column($cart, 'quantity')),
            ]);
        }

        return back()->with('success', $product->name . ' added to cart.');
    }

    public function update(Request $request, $productId)
    {
        $cart = session()->get('cart', []);
        $qty  = (int) $request->input('quantity', 1);

        if (isset($cart[$productId])) {
            if ($qty < 1) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $qty;
            }
            session()->put('cart', $cart);
        }

        if ($request->expectsJson()) {
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            $tax   = $subtotal * 0.08;
            $total = $subtotal + $tax;
            $itemTotal = isset($cart[$productId])
                ? $cart[$productId]['price'] * $cart[$productId]['quantity']
                : 0;

            return response()->json([
                'success'   => true,
                'count'     => array_sum(array_column($cart, 'quantity')),
                'subtotal'  => number_format($subtotal, 2),
                'tax'       => number_format($tax, 2),
                'total'     => number_format($total, 2),
                'itemTotal' => number_format($itemTotal, 2),
            ]);
        }

        return back();
    }

    public function remove(Request $request, $productId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);

        if ($request->expectsJson()) {
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            $tax   = $subtotal * 0.08;
            $total = $subtotal + $tax;

            return response()->json([
                'success'  => true,
                'count'    => array_sum(array_column($cart, 'quantity')),
                'subtotal' => number_format($subtotal, 2),
                'tax'      => number_format($tax, 2),
                'total'    => number_format($total, 2),
                'empty'    => count($cart) === 0,
            ]);
        }

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart');
    }
}
