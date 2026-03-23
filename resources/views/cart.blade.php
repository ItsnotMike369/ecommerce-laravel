<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Shopping Cart - ShopLine</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body { font-family: 'Inter', sans-serif; background: #f9f9fb; color: #1a1a2e; min-height: 100vh; display: flex; flex-direction: column; }

            .page-wrap { max-width: 1100px; margin: 40px auto; padding: 0 32px; flex: 1; width: 100%; }
            .page-title { font-size: 26px; font-weight: 700; color: #1a1a2e; margin-bottom: 28px; }

            /* ── Empty cart ── */
            .empty-cart { background: #fff; border: 1px solid #e8e8e8; border-radius: 14px; padding: 80px 40px; text-align: center; display: flex; flex-direction: column; align-items: center; }
            .empty-cart svg { width: 64px; height: 64px; color: #ccc; margin-bottom: 20px; display: block; }
            .empty-cart h2 { font-size: 20px; font-weight: 700; color: #1a1a2e; margin-bottom: 8px; }
            .empty-cart p { font-size: 14px; color: #888; margin-bottom: 28px; }
            .btn-continue { display: inline-flex; align-items: center; gap: 8px; padding: 13px 28px; background: #1a1a2e; color: #fff; font-size: 14px; font-weight: 600; border-radius: 8px; text-decoration: none; transition: background 0.15s; }
            .btn-continue:hover { background: #2d2d4e; }

            /* ── Cart layout ── */
            .cart-layout { display: grid; grid-template-columns: 1fr 320px; gap: 24px; align-items: start; }

            /* ── Select All bar ── */
            .select-all-bar {
                background: #fff;
                border: 1px solid #e8e8e8;
                border-radius: 14px;
                padding: 16px 24px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 12px;
            }
            .select-all-left { display: flex; align-items: center; gap: 12px; }
            .select-all-label { font-size: 14px; font-weight: 600; color: #1a1a2e; }
            .selected-count-text { font-size: 14px; color: #888; }

            /* ── Custom checkbox ── */
            .custom-checkbox {
                width: 20px;
                height: 20px;
                border: 2px solid #d0d0d0;
                border-radius: 5px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                transition: border-color 0.15s, background 0.15s;
                background: #fff;
            }
            .custom-checkbox.checked {
                background: #1a1a2e;
                border-color: #1a1a2e;
            }
            .custom-checkbox.indeterminate {
                background: #1a1a2e;
                border-color: #1a1a2e;
            }
            .custom-checkbox svg { display: none; }
            .custom-checkbox.checked svg,
            .custom-checkbox.indeterminate svg { display: block; }

            /* ── Cart items ── */
            .cart-items-list { display: flex; flex-direction: column; gap: 0; }
            .cart-items { background: #fff; border: 1px solid #e8e8e8; border-radius: 14px; overflow: hidden; }
            .cart-item { display: flex; align-items: center; gap: 18px; padding: 20px 24px; border-bottom: 1px solid #f0f0f0; transition: background 0.1s; }
            .cart-item:last-child { border-bottom: none; }
            .cart-item-checkbox { flex-shrink: 0; }
            .cart-item-img { width: 84px; height: 84px; border-radius: 10px; overflow: hidden; background: #f5f5f5; flex-shrink: 0; }
            .cart-item-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
            .cart-item-img-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; }
            .cart-item-img-placeholder svg { width: 32px; height: 32px; color: #ccc; }
            .cart-item-info { flex: 1; }
            .cart-item-name { font-size: 15px; font-weight: 600; color: #1a1a2e; margin-bottom: 4px; }
            .cart-item-unit { font-size: 13px; color: #888; }
            .cart-item-controls { display: flex; align-items: center; gap: 16px; margin-top: 10px; }
            .qty-control { display: flex; align-items: center; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; }
            .qty-btn { width: 34px; height: 34px; background: #fff; border: none; cursor: pointer; font-size: 16px; color: #444; display: flex; align-items: center; justify-content: center; transition: background 0.12s; font-family: 'Inter', sans-serif; }
            .qty-btn:hover { background: #f5f5f5; }
            .qty-num { width: 36px; text-align: center; font-size: 14px; font-weight: 600; color: #1a1a2e; background: #fff; border: none; border-left: 1px solid #e0e0e0; border-right: 1px solid #e0e0e0; padding: 0; line-height: 34px; }
            .btn-remove { display: flex; align-items: center; gap: 5px; font-size: 13px; color: #e53e3e; background: none; border: none; cursor: pointer; font-family: 'Inter', sans-serif; padding: 0; transition: color 0.12s; }
            .btn-remove:hover { color: #c53030; }
            .cart-item-price { font-size: 16px; font-weight: 700; color: #1a1a2e; min-width: 100px; text-align: right; }

            /* dimmed when unchecked */
            .cart-item.unselected { opacity: 0.5; }

            /* ── Order summary ── */
            .order-summary { background: #fff; border: 1px solid #e8e8e8; border-radius: 14px; padding: 24px; }
            .order-summary h3 { font-size: 17px; font-weight: 700; color: #1a1a2e; margin-bottom: 16px; }

            .selected-badge {
                background: #eef2ff;
                color: #4f6ef7;
                font-size: 13px;
                font-weight: 500;
                border-radius: 8px;
                padding: 10px 14px;
                margin-bottom: 18px;
                text-align: center;
            }

            .summary-row { display: flex; justify-content: space-between; font-size: 14px; color: #555; margin-bottom: 12px; }
            .summary-row.total { font-size: 16px; font-weight: 700; color: #1a1a2e; border-top: 1px solid #f0f0f0; padding-top: 14px; margin-top: 6px; }
            .summary-row span:last-child { font-weight: 500; }
            .summary-row.total span:last-child { font-weight: 700; }
            .free-shipping { color: #22a05a; font-weight: 600; }
            .btn-checkout { display: block; width: 100%; padding: 14px; background: #1a1a2e; color: #fff; font-size: 14px; font-weight: 600; border: none; border-radius: 8px; cursor: pointer; font-family: 'Inter', sans-serif; text-align: center; text-decoration: none; transition: background 0.15s; margin-top: 18px; }
            .btn-checkout:hover { background: #2d2d4e; }
            .btn-checkout:disabled { background: #aaa; cursor: not-allowed; }
            .btn-continue-shop { display: block; width: 100%; padding: 13px; background: #fff; color: #1a1a2e; font-size: 14px; font-weight: 600; border: 1px solid #e0e0e0; border-radius: 8px; cursor: pointer; font-family: 'Inter', sans-serif; text-align: center; text-decoration: none; transition: border-color 0.15s; margin-top: 10px; }
            .btn-continue-shop:hover { border-color: #aaa; }
            .summary-badges { margin-top: 20px; border-top: 1px solid #f0f0f0; padding-top: 16px; display: flex; flex-direction: column; gap: 8px; }
            .summary-badge { display: flex; align-items: center; gap: 7px; font-size: 12px; color: #666; }
            .summary-badge svg { width: 14px; height: 14px; color: #22a05a; flex-shrink: 0; }

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
            <h1 class="page-title">Shopping Cart</h1>

            @if(empty($cart))
                <div class="empty-cart">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 0 0-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <h2>Your cart is empty</h2>
                    <p>Add some products to get started</p>
                    <a href="{{ route('shop') }}" class="btn-continue">Continue Shopping</a>
                </div>
            @else
                @php
                    $cartCount = count($cart);
                    $subtotal  = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));
                    $tax       = $subtotal * 0.08;
                    $total     = $subtotal + $tax;
                @endphp

                <div class="cart-layout">
                    <!-- Left column: select-all bar + items -->
                    <div>
                        <!-- Select All bar -->
                        <div class="select-all-bar">
                            <div class="select-all-left">
                                <div class="custom-checkbox checked" id="select-all-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="select-all-label">Select All ({{ $cartCount }} {{ $cartCount === 1 ? 'item' : 'items' }})</span>
                            </div>
                            <span class="selected-count-text" id="selected-count-text">{{ $cartCount }} of {{ $cartCount }} selected</span>
                        </div>

                        <!-- Cart Items -->
                        <div class="cart-items" id="cart-items-container">
                            @foreach($cart as $productId => $item)
                            <div class="cart-item" id="cart-item-{{ $productId }}" data-id="{{ $productId }}"
                                 data-price="{{ $item['price'] }}" data-qty="{{ $item['quantity'] }}">
                                <div class="cart-item-checkbox">
                                    <div class="custom-checkbox checked item-checkbox" data-id="{{ $productId }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="cart-item-img">
                                    @if($item['image'])
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                    @else
                                        <div class="cart-item-img-placeholder">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 0 1 2.828 0L16 16m-2-2l1.586-1.586a2 2 0 0 1 2.828 0L20 14m-6-6h.01M6 20h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"/></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="cart-item-info">
                                    <div class="cart-item-name">{{ $item['name'] }}</div>
                                    <div class="cart-item-unit">&#8369;{{ number_format($item['price'], 2) }} each</div>
                                    <div class="cart-item-controls">
                                        <div class="qty-control">
                                            <button class="qty-btn qty-minus" data-id="{{ $productId }}">&#8722;</button>
                                            <span class="qty-num" id="qty-{{ $productId }}">{{ $item['quantity'] }}</span>
                                            <button class="qty-btn qty-plus" data-id="{{ $productId }}">&#43;</button>
                                        </div>
                                        <button class="btn-remove" data-id="{{ $productId }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16"/></svg>
                                            Remove
                                        </button>
                                    </div>
                                </div>
                                <div class="cart-item-price" id="item-total-{{ $productId }}">&#8369;{{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="order-summary">
                        <h3>Order Summary</h3>

                        <div class="selected-badge" id="selected-badge">
                            {{ $cartCount }} {{ $cartCount === 1 ? 'item' : 'items' }} selected for checkout
                        </div>

                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="summary-subtotal">&#8369;{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping</span>
                            <span class="free-shipping">FREE</span>
                        </div>
                        <div class="summary-row">
                            <span>Tax (8%)</span>
                            <span id="summary-tax">&#8369;{{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span id="summary-total">&#8369;{{ number_format($total, 2) }}</span>
                        </div>

                        <button id="btn-checkout" class="btn-checkout" onclick="proceedToCheckout()">
                            Proceed to Checkout ({{ $cartCount }})
                        </button>
                        <a href="{{ route('shop') }}" class="btn-continue-shop">Continue Shopping</a>

                        <div class="summary-badges">
                            <div class="summary-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Secure checkout
                            </div>
                            <div class="summary-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                30-day return policy
                            </div>
                            <div class="summary-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Free shipping on orders over &#8369;2,500
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @include('layouts._footer')

        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            /* ── Selection state ── */
            const selectedIds = new Set(
                [...document.querySelectorAll('.item-checkbox')].map(el => el.dataset.id)
            );

            function formatPHP(value) {
                return '₱' + value.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }

            function recalcSummary() {
                let subtotal = 0;
                document.querySelectorAll('.cart-item').forEach(row => {
                    const id  = row.dataset.id;
                    const qty = parseInt(document.getElementById('qty-' + id).textContent);
                    const price = parseFloat(row.dataset.price);
                    if (selectedIds.has(id)) subtotal += price * qty;
                });
                const tax   = subtotal * 0.08;
                const total = subtotal + tax;

                document.getElementById('summary-subtotal').textContent = formatPHP(subtotal);
                document.getElementById('summary-tax').textContent      = formatPHP(tax);
                document.getElementById('summary-total').textContent    = formatPHP(total);

                const count    = selectedIds.size;
                const total_items = document.querySelectorAll('.cart-item').length;
                const word     = count === 1 ? 'item' : 'items';

                document.getElementById('selected-badge').textContent      = count + ' ' + word + ' selected for checkout';
                document.getElementById('selected-count-text').textContent = count + ' of ' + total_items + ' selected';
                document.getElementById('btn-checkout').textContent        = 'Proceed to Checkout (' + count + ')';
                document.getElementById('btn-checkout').disabled           = count === 0;

                // Select All checkbox state
                const allBox = document.getElementById('select-all-box');
                allBox.classList.remove('checked', 'indeterminate');
                allBox.querySelector('svg').style.display = 'none';
                if (count === 0) {
                    // nothing
                } else if (count === total_items) {
                    allBox.classList.add('checked');
                    allBox.querySelector('svg').style.display = 'block';
                } else {
                    allBox.classList.add('indeterminate');
                    // show a dash for indeterminate
                    allBox.querySelector('svg').style.display = 'block';
                    allBox.querySelector('svg path').setAttribute('d', 'M5 12h14');
                }
            }

            function setItemChecked(id, checked) {
                const box  = document.querySelector('.item-checkbox[data-id="' + id + '"]');
                const row  = document.getElementById('cart-item-' + id);
                if (checked) {
                    selectedIds.add(id);
                    box.classList.add('checked');
                    row.classList.remove('unselected');
                } else {
                    selectedIds.delete(id);
                    box.classList.remove('checked');
                    row.classList.add('unselected');
                }
                recalcSummary();
            }

            // Item checkbox clicks
            document.querySelectorAll('.item-checkbox').forEach(box => {
                box.addEventListener('click', function () {
                    const id = this.dataset.id;
                    setItemChecked(id, !selectedIds.has(id));
                });
            });

            // Select All click
            document.getElementById('select-all-box').addEventListener('click', function () {
                const allIds = [...document.querySelectorAll('.cart-item')].map(r => r.dataset.id);
                const allSelected = allIds.every(id => selectedIds.has(id));
                allIds.forEach(id => setItemChecked(id, !allSelected));
            });

            function proceedToCheckout() {
                if (selectedIds.size === 0) return;
                const params = new URLSearchParams();
                selectedIds.forEach(id => params.append('selected[]', id));
                window.location.href = '{{ route('checkout') }}?' + params.toString();
            }

            /* ── Qty controls ── */
            function updateSummaryFromServer(data, id) {
                const row = document.getElementById('cart-item-' + id);
                if (row) row.dataset.qty = parseInt(document.getElementById('qty-' + id).textContent);
                // update cart badge
                const badge = document.querySelector('.cart-badge');
                if (badge) badge.textContent = data.count;
                recalcSummary();
            }

            document.querySelectorAll('.qty-minus').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id  = this.dataset.id;
                    const qty = parseInt(document.getElementById('qty-' + id).textContent) - 1;
                    if (qty < 1) return;
                    fetch('/cart/update/' + id, {
                        method: 'PATCH',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                        body: JSON.stringify({ quantity: qty })
                    }).then(r => r.json()).then(data => {
                        document.getElementById('qty-' + id).textContent = qty;
                        document.getElementById('item-total-' + id).textContent = '₱' + data.itemTotal;
                        document.getElementById('cart-item-' + id).dataset.qty = qty;
                        updateSummaryFromServer(data, id);
                    });
                });
            });

            document.querySelectorAll('.qty-plus').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id  = this.dataset.id;
                    const qty = parseInt(document.getElementById('qty-' + id).textContent) + 1;
                    fetch('/cart/update/' + id, {
                        method: 'PATCH',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                        body: JSON.stringify({ quantity: qty })
                    }).then(r => r.json()).then(data => {
                        document.getElementById('qty-' + id).textContent = qty;
                        document.getElementById('item-total-' + id).textContent = '₱' + data.itemTotal;
                        document.getElementById('cart-item-' + id).dataset.qty = qty;
                        updateSummaryFromServer(data, id);
                    });
                });
            });

            // Remove
            document.querySelectorAll('.btn-remove').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.dataset.id;
                    fetch('/cart/remove/' + id, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                    }).then(r => r.json()).then(data => {
                        selectedIds.delete(id);
                        const row = document.getElementById('cart-item-' + id);
                        if (row) row.remove();
                        const badge = document.querySelector('.cart-badge');
                        if (badge) badge.textContent = data.count;
                        if (data.empty) { location.reload(); return; }
                        recalcSummary();
                    });
                });
            });
        </script>
    </body>
</html>
