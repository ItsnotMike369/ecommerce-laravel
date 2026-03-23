<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $wishlist = session()->get('wishlist', []);

        $wishlist[$productId] = [
            'id'    => $product->id,
            'name'  => $product->name,
            'price' => $product->price,
            'image' => $product->image,
        ];

        session()->put('wishlist', $wishlist);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'count'   => count($wishlist),
                'added'   => true,
            ]);
        }

        return back()->with('success', $product->name . ' added to wishlist.');
    }

    public function remove(Request $request, $productId)
    {
        $wishlist = session()->get('wishlist', []);
        unset($wishlist[$productId]);
        session()->put('wishlist', $wishlist);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'count'   => count($wishlist),
            ]);
        }

        return back()->with('success', 'Item removed from wishlist.');
    }
}
