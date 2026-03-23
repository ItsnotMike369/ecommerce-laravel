<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Checkout - ShopLine</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body { font-family: 'Inter', sans-serif; background: #f9f9fb; color: #1a1a2e; min-height: 100vh; display: flex; flex-direction: column; }

            /* ── Page wrap ── */
            .page-wrap { max-width: 1100px; margin: 40px auto; padding: 0 32px; flex: 1; width: 100%; }

            /* ── Stepper ── */
            .stepper { display: flex; align-items: center; justify-content: center; gap: 0; margin-bottom: 36px; }
            .step { display: flex; align-items: center; gap: 10px; }
            .step-circle { width: 34px; height: 34px; border-radius: 50%; border: 2px solid #e0e0e0; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: #aaa; background: #fff; transition: all 0.2s; flex-shrink: 0; }
            .step-circle.active { background: #1a1a2e; border-color: #1a1a2e; color: #fff; }
            .step-circle.done { background: #22a05a; border-color: #22a05a; color: #fff; }
            .step-label { font-size: 14px; font-weight: 500; color: #aaa; }
            .step-label.active { color: #1a1a2e; }
            .step-label.done { color: #22a05a; }
            .step-sep { width: 40px; height: 2px; background: #e0e0e0; margin: 0 8px; }
            .step-sep.done { background: #22a05a; }

            /* ── Checkout layout ── */
            .checkout-layout { display: grid; grid-template-columns: 1fr 320px; gap: 24px; align-items: start; }

            /* ── Panel card ── */
            .panel { background: #fff; border: 1px solid #e8e8e8; border-radius: 14px; padding: 28px 32px; }
            .panel h2 { font-size: 17px; font-weight: 700; color: #1a1a2e; margin-bottom: 22px; }
            .panel h3 { font-size: 15px; font-weight: 600; color: #1a1a2e; margin-bottom: 16px; margin-top: 24px; }
            .panel h3:first-of-type { margin-top: 0; }

            /* ── Form grid ── */
            .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
            .form-group { display: flex; flex-direction: column; gap: 6px; }
            .form-group.full { grid-column: 1 / -1; }
            .form-group label { font-size: 13px; font-weight: 500; color: #444; }
            .form-group label span { color: #e53e3e; }
            .form-group input { padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; color: #1a1a2e; outline: none; transition: border-color 0.15s; background: #fafafa; }
            .form-group input:focus { border-color: #aaa; background: #fff; }
            .form-group input.error { border-color: #e53e3e; }

            /* ── Form divider ── */
            .form-divider { border: none; border-top: 1px solid #f0f0f0; margin: 24px 0 20px; }

            /* ── Shipping options ── */
            .shipping-option { border: 1px solid #e0e0e0; border-radius: 10px; padding: 16px 18px; margin-bottom: 12px; cursor: pointer; display: flex; align-items: center; gap: 14px; transition: border-color 0.15s; }
            .shipping-option:hover { border-color: #aaa; }
            .shipping-option.selected { border-color: #1a1a2e; background: #fafafa; }
            .shipping-option input[type=radio] { accent-color: #1a1a2e; width: 16px; height: 16px; cursor: pointer; flex-shrink: 0; }
            .shipping-option-icon { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; color: #555; flex-shrink: 0; }
            .shipping-option-icon svg { width: 20px; height: 20px; }
            .shipping-option-info { flex: 1; }
            .shipping-option-name { font-size: 14px; font-weight: 600; color: #1a1a2e; }
            .shipping-option-desc { font-size: 12px; color: #888; margin-top: 2px; }
            .shipping-option-price { font-size: 14px; font-weight: 700; color: #1a1a2e; }
            .shipping-option-price.free { color: #22a05a; }

            /* ── Shipping address display ── */
            .address-card { background: #f9f9fb; border: 1px solid #e8e8e8; border-radius: 10px; padding: 18px 20px; margin-top: 20px; }
            .address-card h4 { font-size: 14px; font-weight: 600; color: #1a1a2e; margin-bottom: 10px; }
            .address-card p { font-size: 13px; color: #555; line-height: 1.7; }
            .address-card a { font-size: 12px; color: #6b8cce; text-decoration: none; display: inline-block; margin-top: 10px; }
            .address-card a:hover { text-decoration: underline; }

            /* ── Payment methods ── */
            .payment-option { border: 1px solid #e0e0e0; border-radius: 10px; padding: 16px 18px; margin-bottom: 12px; cursor: pointer; display: flex; align-items: center; gap: 14px; transition: border-color 0.15s; }
            .payment-option:hover { border-color: #aaa; }
            .payment-option.selected { border-color: #1a1a2e; background: #fafafa; }
            .payment-option input[type=radio] { accent-color: #1a1a2e; width: 16px; height: 16px; cursor: pointer; flex-shrink: 0; }
            .payment-option-icon { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; color: #555; flex-shrink: 0; }
            .payment-option-icon svg { width: 20px; height: 20px; }
            .payment-option-info { flex: 1; }
            .payment-option-name { font-size: 14px; font-weight: 600; color: #1a1a2e; }
            .payment-option-sub { font-size: 12px; color: #888; margin-top: 2px; }

            /* ── Card details ── */
            .card-details { margin-top: 20px; display: none; }
            .card-details.show { display: block; }
            .card-details h4 { font-size: 14px; font-weight: 600; color: #1a1a2e; margin-bottom: 14px; }
            .card-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
            .card-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 14px; }
            .card-group.half { }
            .card-group label { font-size: 13px; font-weight: 500; color: #444; }
            .card-group label span { color: #e53e3e; }
            .card-group input { padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; color: #1a1a2e; outline: none; transition: border-color 0.15s; background: #fafafa; }
            .card-group input:focus { border-color: #aaa; background: #fff; }

            /* ── E-wallet ── */
            .ewallet-details { margin-top: 20px; display: none; }
            .ewallet-details.show { display: block; }
            .ewallet-details h4 { font-size: 14px; font-weight: 600; color: #1a1a2e; margin-bottom: 16px; }
            .ewallet-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
            .ewallet-btn { border: 1px solid #e0e0e0; border-radius: 10px; padding: 16px 12px; display: flex; flex-direction: column; align-items: center; gap: 8px; cursor: pointer; transition: border-color 0.15s; background: #fff; font-family: 'Inter', sans-serif; }
            .ewallet-btn:hover { border-color: #aaa; }
            .ewallet-btn.selected { border-color: #1a1a2e; background: #fafafa; }
            .ewallet-btn span { font-size: 13px; font-weight: 500; color: #1a1a2e; }
            .ewallet-icon { width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }

            /* ── COD ── */
            .cod-notice { margin-top: 20px; display: none; background: #fffbeb; border: 1px solid #f6e05e; border-radius: 10px; padding: 16px 18px; }
            .cod-notice.show { display: block; }
            .cod-notice h4 { font-size: 14px; font-weight: 600; color: #d97706; margin-bottom: 6px; }
            .cod-notice p { font-size: 13px; color: #92400e; line-height: 1.6; }

            /* ── Form buttons ── */
            .form-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 28px; gap: 12px; }
            .btn-back { padding: 12px 24px; background: #fff; color: #1a1a2e; font-size: 14px; font-weight: 600; border: 1px solid #e0e0e0; border-radius: 8px; cursor: pointer; font-family: 'Inter', sans-serif; text-decoration: none; transition: border-color 0.15s; }
            .btn-back:hover { border-color: #aaa; }
            .btn-next { padding: 12px 28px; background: #1a1a2e; color: #fff; font-size: 14px; font-weight: 600; border: none; border-radius: 8px; cursor: pointer; font-family: 'Inter', sans-serif; transition: background 0.15s; }
            .btn-next:hover { background: #2d2d4e; }

            /* ── Order summary sidebar ── */
            .order-summary { background: #fff; border: 1px solid #e8e8e8; border-radius: 14px; padding: 24px; }
            .order-summary h3 { font-size: 17px; font-weight: 700; color: #1a1a2e; margin-bottom: 18px; }
            .summary-item { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
            .summary-item-img { width: 48px; height: 48px; border-radius: 8px; overflow: hidden; background: #f5f5f5; flex-shrink: 0; }
            .summary-item-img img { width: 100%; height: 100%; object-fit: cover; }
            .summary-item-img-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; }
            .summary-item-img-placeholder svg { width: 20px; height: 20px; color: #ccc; }
            .summary-item-info { flex: 1; }
            .summary-item-name { font-size: 13px; font-weight: 500; color: #1a1a2e; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 140px; }
            .summary-item-qty { font-size: 12px; color: #888; }
            .summary-item-price { font-size: 13px; font-weight: 600; color: #1a1a2e; white-space: nowrap; }
            .summary-divider { border: none; border-top: 1px solid #f0f0f0; margin: 14px 0; }
            .summary-row { display: flex; justify-content: space-between; font-size: 14px; color: #555; margin-bottom: 10px; }
            .summary-row.total { font-size: 16px; font-weight: 700; color: #1a1a2e; border-top: 1px solid #f0f0f0; padding-top: 12px; margin-top: 4px; }
            .free-shipping { color: #22a05a; font-weight: 600; }
            .secure-note { display: flex; align-items: center; gap: 7px; font-size: 12px; color: #888; margin-top: 18px; }
            .secure-note svg { width: 14px; height: 14px; color: #22a05a; flex-shrink: 0; }

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

            /* ── Validation ── */
            .field-error { font-size: 12px; color: #e53e3e; margin-top: 4px; display: none; }
            .field-error.show { display: block; }
        </style>
    </head>
    <body>

        @include('layouts._navbar')

        @php
            $subtotal = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));
            $shippingCosts = ['standard' => 0, 'express' => 15.99, 'overnight' => 29.99];
            $shippingCost  = $shippingCosts[$shippingMethod] ?? 0;
            $tax           = $subtotal * 0.08;
            $total         = $subtotal + $shippingCost + $tax;
        @endphp

        <div class="page-wrap">
            <!-- Stepper -->
            <div class="stepper">
                <div class="step">
                    <div class="step-circle {{ $step > 1 ? 'done' : ($step == 1 ? 'active' : '') }}">
                        @if($step > 1)
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        @else
                            1
                        @endif
                    </div>
                    <span class="step-label {{ $step > 1 ? 'done' : ($step == 1 ? 'active' : '') }}">Customer Info</span>
                </div>
                <div class="step-sep {{ $step > 1 ? 'done' : '' }}"></div>
                <div class="step">
                    <div class="step-circle {{ $step > 2 ? 'done' : ($step == 2 ? 'active' : '') }}">
                        @if($step > 2)
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        @else
                            2
                        @endif
                    </div>
                    <span class="step-label {{ $step > 2 ? 'done' : ($step == 2 ? 'active' : '') }}">Shipping</span>
                </div>
                <div class="step-sep {{ $step > 2 ? 'done' : '' }}"></div>
                <div class="step">
                    <div class="step-circle {{ $step == 3 ? 'active' : '' }}">3</div>
                    <span class="step-label {{ $step == 3 ? 'active' : '' }}">Payment</span>
                </div>
            </div>

            <div class="checkout-layout">
                <!-- Left panel -->
                <div>
                    {{-- ── STEP 1: Customer Info ── --}}
                    @if($step == 1)
                    <div class="panel">
                        <h2>Customer Information</h2>

                        @if($errors->any())
                            <div style="background:#fff5f5;border:1px solid #fed7d7;border-radius:8px;padding:12px 16px;margin-bottom:18px;font-size:13px;color:#c53030;">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('checkout.customer') }}" id="customer-form">
                            @csrf

                            <h3>Contact Information</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>First Name <span>*</span></label>
                                    <input type="text" name="first_name" value="{{ old('first_name', $customerInfo['first_name'] ?? '') }}" placeholder="John" class="{{ $errors->has('first_name') ? 'error' : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Last Name <span>*</span></label>
                                    <input type="text" name="last_name" value="{{ old('last_name', $customerInfo['last_name'] ?? '') }}" placeholder="Doe" class="{{ $errors->has('last_name') ? 'error' : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Email <span>*</span></label>
                                    <input type="email" name="email" value="{{ old('email', $customerInfo['email'] ?? '') }}" placeholder="john.doe@example.com" class="{{ $errors->has('email') ? 'error' : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Phone <span>*</span></label>
                                    <input type="text" name="phone" value="{{ old('phone', $customerInfo['phone'] ?? '') }}" placeholder="+1 (555) 000-0000" class="{{ $errors->has('phone') ? 'error' : '' }}">
                                </div>
                            </div>

                            <hr class="form-divider">
                            <h3>Shipping Address</h3>

                            <div class="form-row">
                                <div class="form-group full">
                                    <label>Street Address <span>*</span></label>
                                    <input type="text" name="street" value="{{ old('street', $customerInfo['street'] ?? '') }}" placeholder="123 Main Street" class="{{ $errors->has('street') ? 'error' : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>City <span>*</span></label>
                                    <input type="text" name="city" value="{{ old('city', $customerInfo['city'] ?? '') }}" placeholder="New York" class="{{ $errors->has('city') ? 'error' : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>State / Province <span>*</span></label>
                                    <input type="text" name="state" value="{{ old('state', $customerInfo['state'] ?? '') }}" placeholder="NY" class="{{ $errors->has('state') ? 'error' : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>ZIP / Postal Code <span>*</span></label>
                                    <input type="text" name="zip" value="{{ old('zip', $customerInfo['zip'] ?? '') }}" placeholder="10001" class="{{ $errors->has('zip') ? 'error' : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Country <span>*</span></label>
                                    <input type="text" name="country" value="{{ old('country', $customerInfo['country'] ?? 'Philippines') }}" placeholder="Philippines" class="{{ $errors->has('country') ? 'error' : '' }}">
                                </div>
                            </div>

                            <div class="form-actions">
                                <a href="{{ route('cart') }}" class="btn-back">Back to Cart</a>
                                <button type="submit" class="btn-next">Continue to Shipping</button>
                            </div>
                        </form>
                    </div>
                    @endif

                    {{-- ── STEP 2: Shipping ── --}}
                    @if($step == 2)
                    <div class="panel">
                        <h2>Choose Shipping Method</h2>

                        <form method="POST" action="{{ route('checkout.shipping') }}" id="shipping-form">
                            @csrf

                            <label class="shipping-option {{ $shippingMethod === 'standard' ? 'selected' : '' }}" id="opt-standard">
                                <input type="radio" name="shipping_method" value="standard" {{ $shippingMethod === 'standard' ? 'checked' : '' }} onchange="selectShipping(this)">
                                <div class="shipping-option-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zm-2 5H6"/></svg>
                                </div>
                                <div class="shipping-option-info">
                                    <div class="shipping-option-name">Standard Shipping</div>
                                    <div class="shipping-option-desc">Delivery in 5-7 business days</div>
                                </div>
                                <div class="shipping-option-price free">FREE</div>
                            </label>

                            <label class="shipping-option {{ $shippingMethod === 'express' ? 'selected' : '' }}" id="opt-express">
                                <input type="radio" name="shipping_method" value="express" {{ $shippingMethod === 'express' ? 'checked' : '' }} onchange="selectShipping(this)">
                                <div class="shipping-option-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                <div class="shipping-option-info">
                                    <div class="shipping-option-name">Express Shipping</div>
                                    <div class="shipping-option-desc">Delivery in 2-3 business days</div>
                                </div>
                                <div class="shipping-option-price">&#8369;15.99</div>
                            </label>

                            <label class="shipping-option {{ $shippingMethod === 'overnight' ? 'selected' : '' }}" id="opt-overnight">
                                <input type="radio" name="shipping_method" value="overnight" {{ $shippingMethod === 'overnight' ? 'checked' : '' }} onchange="selectShipping(this)">
                                <div class="shipping-option-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>
                                </div>
                                <div class="shipping-option-info">
                                    <div class="shipping-option-name">Overnight Shipping</div>
                                    <div class="shipping-option-desc">Next day delivery</div>
                                </div>
                                <div class="shipping-option-price">&#8369;29.99</div>
                            </label>

                            <div class="form-actions">
                                <button type="button" class="btn-back" onclick="goBack(1)">Back</button>
                                <button type="submit" class="btn-next">Continue to Payment</button>
                            </div>
                        </form>

                        @if(!empty($customerInfo))
                        <div class="address-card">
                            <h4>Shipping Address</h4>
                            <p>
                                {{ $customerInfo['first_name'] }} {{ $customerInfo['last_name'] }}<br>
                                {{ $customerInfo['street'] }}<br>
                                {{ $customerInfo['city'] }}, {{ $customerInfo['state'] }} {{ $customerInfo['zip'] }}<br>
                                {{ $customerInfo['country'] }}
                            </p>
                            <form method="POST" action="{{ route('checkout.back') }}" style="display:inline;">
                                @csrf
                                <input type="hidden" name="step" value="1">
                                <button type="submit" style="background:none;border:none;padding:0;cursor:pointer;font-size:12px;color:#6b8cce;text-decoration:none;font-family:'Inter',sans-serif;margin-top:10px;">Change Address</button>
                            </form>
                        </div>
                        @endif
                    </div>
                    @endif

                    {{-- ── STEP 3: Payment ── --}}
                    @if($step == 3)
                    <div class="panel">
                        <h2>Payment Method</h2>

                        @if($errors->any())
                            <div style="background:#fff5f5;border:1px solid #fed7d7;border-radius:8px;padding:12px 16px;margin-bottom:18px;font-size:13px;color:#c53030;">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('checkout.place') }}" id="payment-form">
                            @csrf

                            <!-- Online Payment -->
                            <div class="payment-option selected" id="pay-online-opt">
                                <input type="radio" name="payment_method" value="online" checked onchange="selectPayment('online')">
                                <div class="payment-option-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3z"/></svg>
                                </div>
                                <div class="payment-option-info">
                                    <div class="payment-option-name">Online Payment</div>
                                    <div class="payment-option-sub">Pay with credit/debit card</div>
                                </div>
                            </div>

                            <!-- E-Wallet -->
                            <div class="payment-option" id="pay-ewallet-opt">
                                <input type="radio" name="payment_method" value="ewallet" onchange="selectPayment('ewallet')">
                                <div class="payment-option-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 0 0 1.946-.806 3.42 3.42 0 0 1 4.438 0 3.42 3.42 0 0 0 1.946.806 3.42 3.42 0 0 1 3.138 3.138 3.42 3.42 0 0 0 .806 1.946 3.42 3.42 0 0 1 0 4.438 3.42 3.42 0 0 0-.806 1.946 3.42 3.42 0 0 1-3.138 3.138 3.42 3.42 0 0 0-1.946.806 3.42 3.42 0 0 1-4.438 0 3.42 3.42 0 0 0-1.946-.806 3.42 3.42 0 0 1-3.138-3.138 3.42 3.42 0 0 0-.806-1.946 3.42 3.42 0 0 1 0-4.438 3.42 3.42 0 0 0 .806-1.946 3.42 3.42 0 0 1 3.138-3.138z"/></svg>
                                </div>
                                <div class="payment-option-info">
                                    <div class="payment-option-name">E-Wallet</div>
                                    <div class="payment-option-sub">PayPal, Apple Pay, Google Pay</div>
                                </div>
                            </div>

                            <!-- Cash on Delivery -->
                            <div class="payment-option" id="pay-cod-opt">
                                <input type="radio" name="payment_method" value="cod" onchange="selectPayment('cod')">
                                <div class="payment-option-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2m2 4h10a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2zm7-5a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/></svg>
                                </div>
                                <div class="payment-option-info">
                                    <div class="payment-option-name">Cash on Delivery</div>
                                    <div class="payment-option-sub">Pay when you receive</div>
                                </div>
                            </div>

                            <!-- Card Details (shown for Online) -->
                            <div class="card-details show" id="card-details">
                                <h4>Card Details</h4>
                                <div class="card-group">
                                    <label>Card Number <span>*</span></label>
                                    <input type="text" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19" id="card-number-input">
                                </div>
                                <div class="card-group">
                                    <label>Cardholder Name <span>*</span></label>
                                    <input type="text" name="card_name" placeholder="John Doe">
                                </div>
                                <div class="card-row">
                                    <div class="card-group half">
                                        <label>Expiry Date <span>*</span></label>
                                        <input type="text" name="card_expiry" placeholder="MM/YY" maxlength="5" id="card-expiry-input">
                                    </div>
                                    <div class="card-group half">
                                        <label>CVV <span>*</span></label>
                                        <input type="text" name="card_cvv" placeholder="123" maxlength="4">
                                    </div>
                                </div>
                            </div>

                            <!-- E-Wallet selection -->
                            <div class="ewallet-details" id="ewallet-details">
                                <h4>Select E-Wallet</h4>
                                <div class="ewallet-grid">
                                    <button type="button" class="ewallet-btn" onclick="selectWallet(this)">
                                        <div class="ewallet-icon" style="background:#0070ba;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#fff" viewBox="0 0 24 24"><path d="M7.144 19.532l1.049-5.751c.11-.606.691-1.002 1.304-.948.524.047 1.15.051 1.701-.012 2.733-.319 4.925-2.441 5.367-5.158.008-.05.016-.1.022-.15C17.735 8.96 18 10.01 18 11.126c0 4.026-3.42 7.29-7.648 7.29-.66 0-1.298-.08-1.907-.228L7.144 19.532zm11.33-11.483c-.23-2.898-2.742-5.208-5.934-5.208-3.475 0-6.29 2.571-6.29 5.74 0 .244.017.486.048.723-2.565.667-4.298 3.062-3.735 5.636L4.14 20.156c-.126.693.505 1.27 1.202 1.103l2.43-.598C8.97 21.539 10.31 22 11.756 22 16.327 22 20 18.514 20 14.187c0-2.2-.883-4.208-2.526-5.638z"/></svg>
                                        </div>
                                        <span>PayPal</span>
                                    </button>
                                    <button type="button" class="ewallet-btn" onclick="selectWallet(this)">
                                        <div class="ewallet-icon" style="background:#1a1a2e;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#fff" viewBox="0 0 24 24"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
                                        </div>
                                        <span>Apple Pay</span>
                                    </button>
                                    <button type="button" class="ewallet-btn" onclick="selectWallet(this)">
                                        <div class="ewallet-icon" style="background:#34a853;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#fff" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                                        </div>
                                        <span>Google Pay</span>
                                    </button>
                                </div>
                                <input type="hidden" name="ewallet_provider" id="ewallet-provider" value="">
                            </div>

                            <!-- Cash on Delivery notice -->
                            <div class="cod-notice" id="cod-notice">
                                <h4>Cash on Delivery</h4>
                                <p>Please keep the exact amount ready. Our delivery partner will collect the payment upon delivery.</p>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn-back" onclick="goBack(2)">Back</button>
                                <button type="submit" class="btn-next">Place Order</button>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>

                <!-- Order Summary sidebar -->
                <div class="order-summary">
                    <h3>Order Summary</h3>

                    @foreach($cart as $item)
                    <div class="summary-item">
                        <div class="summary-item-img">
                            @if($item['image'])
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                            @else
                                <div class="summary-item-img-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 0 1 2.828 0L16 16m-2-2l1.586-1.586a2 2 0 0 1 2.828 0L20 14m-6-6h.01M6 20h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="summary-item-info">
                            <div class="summary-item-name">{{ $item['name'] }}</div>
                            <div class="summary-item-qty">Qty: {{ $item['quantity'] }}</div>
                        </div>
                        <div class="summary-item-price">&#8369;{{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                    </div>
                    @endforeach

                    <hr class="summary-divider">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>&#8369;{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        @if($shippingCost == 0)
                            <span class="free-shipping">FREE</span>
                        @else
                            <span>&#8369;{{ number_format($shippingCost, 2) }}</span>
                        @endif
                    </div>
                    <div class="summary-row">
                        <span>Tax</span>
                        <span>&#8369;{{ number_format($tax, 2) }}</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>&#8369;{{ number_format($total, 2) }}</span>
                    </div>

                    <div class="secure-note">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2zm10-10V7a4 4 0 0 0-8 0v4h8z"/></svg>
                        Your payment information is secure and encrypted
                    </div>
                </div>
            </div>
        </div>

        @include('layouts._footer')

        <script>
            function selectShipping(radio) {
                document.querySelectorAll('.shipping-option').forEach(el => el.classList.remove('selected'));
                radio.closest('.shipping-option').classList.add('selected');
            }

            function selectPayment(method) {
                document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('selected'));
                document.getElementById('pay-' + method + '-opt').classList.add('selected');

                document.getElementById('card-details').classList.toggle('show', method === 'online');
                document.getElementById('ewallet-details').classList.toggle('show', method === 'ewallet');
                document.getElementById('cod-notice').classList.toggle('show', method === 'cod');
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function goBack(step) {
                fetch('{{ route("checkout.back") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ step: step })
                }).then(() => window.location.href = '{{ route("checkout") }}');
            }

            function selectWallet(btn) {
                document.querySelectorAll('.ewallet-btn').forEach(b => b.classList.remove('selected'));
                btn.classList.add('selected');
                document.getElementById('ewallet-provider').value = btn.querySelector('span').textContent;
            }

            // Card number formatting
            const cardInput = document.getElementById('card-number-input');
            if (cardInput) {
                cardInput.addEventListener('input', function () {
                    let v = this.value.replace(/\D/g, '').substring(0, 16);
                    this.value = v.replace(/(.{4})/g, '$1 ').trim();
                });
            }

            // Expiry formatting
            const expiryInput = document.getElementById('card-expiry-input');
            if (expiryInput) {
                expiryInput.addEventListener('input', function () {
                    let v = this.value.replace(/\D/g, '').substring(0, 4);
                    if (v.length >= 3) v = v.substring(0,2) + '/' + v.substring(2);
                    this.value = v;
                });
            }
        </script>
    </body>
</html>
