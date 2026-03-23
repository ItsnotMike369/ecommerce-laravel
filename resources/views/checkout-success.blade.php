<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Order Placed - ShopLine</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body { font-family: 'Inter', sans-serif; background: #f9f9fb; color: #1a1a2e; min-height: 100vh; display: flex; flex-direction: column; }

            /* ── Success page ── */
            .page-wrap { max-width: 680px; margin: 60px auto; padding: 0 32px; flex: 1; width: 100%; }
            .success-card { background: #fff; border: 1px solid #e8e8e8; border-radius: 16px; padding: 48px 40px; text-align: center; }
            .success-icon { width: 72px; height: 72px; background: #f0fdf4; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; }
            .success-icon svg { width: 36px; height: 36px; color: #22a05a; }
            .success-card h1 { font-size: 24px; font-weight: 700; color: #1a1a2e; margin-bottom: 8px; }
            .success-card .order-num { font-size: 14px; color: #888; margin-bottom: 32px; }
            .success-card .order-num span { font-weight: 600; color: #1a1a2e; }

            /* ── Order details ── */
            .order-details { text-align: left; border: 1px solid #f0f0f0; border-radius: 12px; overflow: hidden; margin-bottom: 28px; }
            .order-section { padding: 20px 24px; border-bottom: 1px solid #f0f0f0; }
            .order-section:last-child { border-bottom: none; }
            .order-section h3 { font-size: 13px; font-weight: 600; color: #888; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px; }
            .order-items { display: flex; flex-direction: column; gap: 10px; }
            .order-item { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
            .order-item-left { display: flex; align-items: center; gap: 10px; flex: 1; }
            .order-item-img { width: 40px; height: 40px; border-radius: 7px; overflow: hidden; background: #f5f5f5; flex-shrink: 0; }
            .order-item-img img { width: 100%; height: 100%; object-fit: cover; }
            .order-item-name { font-size: 13px; font-weight: 500; color: #1a1a2e; }
            .order-item-qty { font-size: 12px; color: #888; }
            .order-item-price { font-size: 13px; font-weight: 600; color: #1a1a2e; white-space: nowrap; }
            .info-row { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 7px; }
            .info-row:last-child { margin-bottom: 0; }
            .info-row .label { color: #888; }
            .info-row .value { color: #1a1a2e; font-weight: 500; }
            .info-row.total { font-size: 15px; font-weight: 700; border-top: 1px solid #f0f0f0; padding-top: 10px; margin-top: 6px; }
            .info-row.total .label, .info-row.total .value { color: #1a1a2e; }
            .free-ship { color: #22a05a; font-weight: 600; }

            /* ── Actions ── */
            .success-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
            .btn-primary { display: inline-flex; align-items: center; gap: 8px; padding: 13px 28px; background: #1a1a2e; color: #fff; font-size: 14px; font-weight: 600; border-radius: 8px; text-decoration: none; transition: background 0.15s; }
            .btn-primary:hover { background: #2d2d4e; }
            .btn-secondary { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: #fff; color: #1a1a2e; font-size: 14px; font-weight: 600; border: 1px solid #e0e0e0; border-radius: 8px; text-decoration: none; transition: border-color 0.15s; }
            .btn-secondary:hover { border-color: #aaa; }

            /* ── Footer ── */
            footer { background: #1a2340; color: #ccc; padding: 56px 32px 28px; margin-top: auto; }
            .footer-grid { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr 1.5fr 2fr; gap: 48px; margin-bottom: 48px; }
            .footer-brand h3 { color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 10px; }
            .footer-brand p { font-size: 13px; line-height: 1.7; color: #aaa; margin-bottom: 16px; }
            .footer-socials { display: flex; gap: 12px; }
            .footer-socials a { color: #aaa; text-decoration: none; display: flex; align-items: center; transition: color 0.15s; }
            .footer-socials a:hover { color: #fff; }
            .footer-col h4 { color: #fff; font-size: 14px; font-weight: 600; margin-bottom: 18px; }
            .footer-col ul { list-style: none; }
            .footer-col ul li { margin-bottom: 10px; }
            .footer-col ul li a { color: #aaa; text-decoration: none; font-size: 13px; transition: color 0.15s; }
            .footer-col ul li a:hover { color: #fff; }
            .newsletter-form { display: flex; margin-top: 4px; border: 1px solid #2e3a5a; border-radius: 8px; overflow: hidden; background: #222d47; }
            .newsletter-form svg { margin-left: 12px; flex-shrink: 0; align-self: center; color: #666; width: 16px; height: 16px; }
            .newsletter-form input { flex: 1; padding: 11px 12px; background: transparent; border: none; color: #fff; font-size: 13px; outline: none; font-family: 'Inter', sans-serif; }
            .newsletter-form input::placeholder { color: #666; }
            .footer-bottom { max-width: 1100px; margin: 0 auto; border-top: 1px solid #2e3a5a; padding-top: 22px; text-align: center; font-size: 13px; color: #555; }
        </style>
    </head>
    <body>

        @include('layouts._navbar')

        <div class="page-wrap">
            <div class="success-card">
                <div class="success-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h1>Order Placed Successfully!</h1>
                <p class="order-num">Order <span>{{ $order['order_number'] }}</span> has been confirmed.</p>

                <div class="order-details">
                    <!-- Items -->
                    <div class="order-section">
                        <h3>Items Ordered</h3>
                        <div class="order-items">
                            @foreach($order['cart'] as $item)
                            <div class="order-item">
                                <div class="order-item-left">
                                    <div class="order-item-img">
                                        @if($item['image'])
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                        @else
                                            <div style="width:100%;height:100%;background:#f0f0f5;display:flex;align-items:center;justify-content:center;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 0 1 2.828 0L16 16m-2-2l1.586-1.586a2 2 0 0 1 2.828 0L20 14m-6-6h.01M6 20h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="order-item-name">{{ $item['name'] }}</div>
                                        <div class="order-item-qty">Qty: {{ $item['quantity'] }}</div>
                                    </div>
                                </div>
                                <div class="order-item-price">&#8369;{{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div class="order-section">
                        <h3>Payment Summary</h3>
                        <div class="info-row">
                            <span class="label">Subtotal</span>
                            <span class="value">&#8369;{{ number_format($order['subtotal'], 2) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Shipping</span>
                            @if($order['shipping_cost'] == 0)
                                <span class="value free-ship">FREE</span>
                            @else
                                <span class="value">&#8369;{{ number_format($order['shipping_cost'], 2) }}</span>
                            @endif
                        </div>
                        <div class="info-row">
                            <span class="label">Tax (8%)</span>
                            <span class="value">&#8369;{{ number_format($order['tax'], 2) }}</span>
                        </div>
                        <div class="info-row total">
                            <span class="label">Total Paid</span>
                            <span class="value">&#8369;{{ number_format($order['total'], 2) }}</span>
                        </div>
                    </div>

                    <!-- Delivery info -->
                    <div class="order-section">
                        <h3>Delivery Information</h3>
                        @if(!empty($order['customer']))
                        <div class="info-row">
                            <span class="label">Name</span>
                            <span class="value">{{ $order['customer']['first_name'] }} {{ $order['customer']['last_name'] }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Email</span>
                            <span class="value">{{ $order['customer']['email'] }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Address</span>
                            <span class="value">{{ $order['customer']['street'] }}, {{ $order['customer']['city'] }}, {{ $order['customer']['state'] }}</span>
                        </div>
                        @endif
                        <div class="info-row">
                            <span class="label">Shipping</span>
                            <span class="value">{{ ucfirst($order['shipping_method']) }} Shipping</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Payment</span>
                            <span class="value">
                                @if($order['payment_method'] === 'online') Credit/Debit Card
                                @elseif($order['payment_method'] === 'ewallet') E-Wallet
                                @else Cash on Delivery
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <div class="success-actions">
                    <a href="{{ route('shop') }}" class="btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 0 0-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Continue Shopping
                    </a>
                    <a href="{{ url('/') }}" class="btn-secondary">Back to Home</a>
                </div>
            </div>
        </div>

        @include('layouts._footer')

    </body>
</html>
