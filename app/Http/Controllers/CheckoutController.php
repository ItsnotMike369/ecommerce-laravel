<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart');
        }

        $step            = session()->get('checkout_step', 1);
        $customerInfo    = session()->get('checkout_customer', []);
        $shippingMethod  = session()->get('checkout_shipping', 'standard');

        return view('checkout', compact('cart', 'step', 'customerInfo', 'shippingMethod'));
    }

    public function saveCustomer(Request $request)
    {
        $request->validate([
            'first_name'   => 'required|string|max:100',
            'last_name'    => 'required|string|max:100',
            'email'        => 'required|email|max:150',
            'phone'        => 'required|string|max:30',
            'street'       => 'required|string|max:255',
            'city'         => 'required|string|max:100',
            'state'        => 'required|string|max:100',
            'zip'          => 'required|string|max:20',
            'country'      => 'required|string|max:100',
        ]);

        session()->put('checkout_customer', $request->only(
            'first_name', 'last_name', 'email', 'phone',
            'street', 'city', 'state', 'zip', 'country'
        ));
        session()->put('checkout_step', 2);

        return redirect()->route('checkout');
    }

    public function saveShipping(Request $request)
    {
        $request->validate([
            'shipping_method' => 'required|in:standard,express,overnight',
        ]);

        session()->put('checkout_shipping', $request->shipping_method);
        session()->put('checkout_step', 3);

        return redirect()->route('checkout');
    }

    public function backToStep(Request $request)
    {
        $data = $request->json()->all() ?: $request->all();
        $step = (int) ($data['step'] ?? 1);
        session()->put('checkout_step', max(1, $step));

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('checkout');
    }

    public function placeOrder(Request $request)
    {
        $paymentMethod = $request->input('payment_method', 'online');

        if ($paymentMethod === 'online') {
            $request->validate([
                'card_number'   => 'required|string',
                'card_name'     => 'required|string',
                'card_expiry'   => 'required|string',
                'card_cvv'      => 'required|string',
            ]);
        }

        $cart           = session()->get('cart', []);
        $customerInfo   = session()->get('checkout_customer', []);
        $shippingMethod = session()->get('checkout_shipping', 'standard');

        $subtotal = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));
        $shippingCost = match($shippingMethod) {
            'express'   => 15.99,
            'overnight' => 29.99,
            default     => 0,
        };
        $tax   = $subtotal * 0.08;
        $total = $subtotal + $shippingCost + $tax;

        $order = Order::create([
            'user_id'        => Auth::id(),
            'order_number'   => 'ORD-' . strtoupper(uniqid()),
            'first_name'     => $customerInfo['first_name'] ?? '',
            'last_name'      => $customerInfo['last_name'] ?? '',
            'email'          => $customerInfo['email'] ?? '',
            'phone'          => $customerInfo['phone'] ?? null,
            'street'         => $customerInfo['street'] ?? null,
            'city'           => $customerInfo['city'] ?? null,
            'state'          => $customerInfo['state'] ?? null,
            'zip'            => $customerInfo['zip'] ?? null,
            'country'        => $customerInfo['country'] ?? null,
            'shipping_method'=> $shippingMethod,
            'shipping_cost'  => $shippingCost,
            'payment_method' => $paymentMethod,
            'subtotal'       => $subtotal,
            'tax'            => $tax,
            'total'          => $total,
            'status'         => 'pending',
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item['id'] ?? null,
                'product_name' => $item['name'],
                'price'        => $item['price'],
                'quantity'     => $item['quantity'],
                'subtotal'     => $item['price'] * $item['quantity'],
            ]);
        }

        $orderData = [
            'order_number'   => $order->order_number,
            'customer'       => $customerInfo,
            'cart'           => $cart,
            'shipping_method'=> $shippingMethod,
            'shipping_cost'  => $shippingCost,
            'payment_method' => $paymentMethod,
            'subtotal'       => $subtotal,
            'tax'            => $tax,
            'total'          => $total,
            'placed_at'      => $order->created_at->toDateTimeString(),
        ];

        session()->forget(['cart', 'checkout_step', 'checkout_customer', 'checkout_shipping']);
        session()->put('last_order', $orderData);

        return redirect()->route('checkout.success');
    }

    public function success()
    {
        $order = session()->get('last_order');

        if (!$order) {
            return redirect()->route('shop');
        }

        return view('checkout-success', compact('order'));
    }
}
