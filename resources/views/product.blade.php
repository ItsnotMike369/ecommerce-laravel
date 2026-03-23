<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $product->name }} - ShopLine</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body { font-family: 'Inter', sans-serif; background: #f9f9fb; color: #1a1a2e; min-height: 100vh; display: flex; flex-direction: column; }

            /* ── Breadcrumb ── */
            .breadcrumb-wrap { max-width: 1100px; margin: 20px auto; padding: 0 32px; font-size: 13px; color: #888; }
            .breadcrumb-wrap a { color: #888; text-decoration: none; }
            .breadcrumb-wrap a:hover { color: #1a1a2e; }
            .breadcrumb-wrap span { margin: 0 5px; }
            .breadcrumb-wrap .current { color: #1a1a2e; font-weight: 500; }

            /* ── Product Layout ── */
            .product-container { max-width: 1100px; margin: 0 auto 48px; padding: 0 32px; flex: 1; width: 100%; }
            .product-main { background: #fff; border: 1px solid #e8e8e8; border-radius: 16px; padding: 32px; display: grid; grid-template-columns: 1fr 1fr; gap: 48px; }

            /* ── Gallery ── */
            .product-gallery {}
            .gallery-main { aspect-ratio: 1/1; border-radius: 12px; overflow: hidden; background: #f0f0f5; margin-bottom: 12px; }
            .gallery-main img { width: 100%; height: 100%; object-fit: cover; display: block; }
            .gallery-main-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; }
            .gallery-main-placeholder svg { width: 80px; height: 80px; color: #ccc; }
            .gallery-thumbs { display: flex; gap: 10px; }
            .gallery-thumb { width: 68px; height: 68px; border-radius: 8px; overflow: hidden; border: 2px solid transparent; cursor: pointer; background: #f0f0f5; flex-shrink: 0; transition: border-color 0.15s; }
            .gallery-thumb:hover { border-color: #aaa; }
            .gallery-thumb.active { border-color: #1a2340; }
            .gallery-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
            .gallery-thumb-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; }
            .gallery-thumb-placeholder svg { width: 24px; height: 24px; color: #ccc; }

            /* ── Product Info ── */
            .product-info {}
            .product-badge { display: inline-block; background: #eef2ff; color: #4f6ef7; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 20px; margin-bottom: 12px; }
            .product-title { font-size: 28px; font-weight: 700; color: #1a1a2e; margin-bottom: 12px; line-height: 1.3; }
            .product-pricing { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
            .price-current { font-size: 26px; font-weight: 700; color: #1a1a2e; }
            .price-original { font-size: 16px; color: #aaa; text-decoration: line-through; }
            .price-discount { font-size: 13px; font-weight: 600; color: #e04444; background: #fff0f0; padding: 3px 8px; border-radius: 6px; }
            .product-stock-badge { display: flex; align-items: center; gap: 6px; font-size: 14px; color: #22a05a; font-weight: 500; margin-bottom: 20px; }
            .product-stock-badge svg { width: 16px; height: 16px; }
            .product-stock-badge.out { color: #e04444; }

            .divider { height: 1px; background: #f0f0f0; margin: 20px 0; }

            .product-desc-label { font-size: 15px; font-weight: 600; color: #1a1a2e; margin-bottom: 8px; }
            .product-desc-text { font-size: 14px; color: #555; line-height: 1.7; }

            /* ── Quantity ── */
            .qty-label { font-size: 14px; font-weight: 600; color: #1a1a2e; margin-bottom: 10px; }
            .qty-control { display: flex; align-items: center; gap: 0; margin-bottom: 20px; }
            .qty-btn { width: 36px; height: 36px; border: 1px solid #e0e0e0; background: #fff; color: #1a1a2e; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.15s; }
            .qty-btn:first-child { border-radius: 8px 0 0 8px; }
            .qty-btn:last-child { border-radius: 0 8px 8px 0; }
            .qty-btn:hover { background: #f0f0f5; }
            .qty-input { width: 52px; height: 36px; border: 1px solid #e0e0e0; border-left: none; border-right: none; text-align: center; font-size: 14px; font-weight: 600; font-family: 'Inter', sans-serif; color: #1a1a2e; outline: none; -moz-appearance: textfield; }
            .qty-input::-webkit-outer-spin-button, .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; }
            .qty-max { font-size: 12px; color: #888; margin-left: 12px; }

            /* ── Action Buttons ── */
            .product-actions { display: flex; gap: 12px; margin-bottom: 16px; }
            .btn-cart { flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 13px 20px; background: #1a2340; color: #fff; font-size: 14px; font-weight: 600; border: none; border-radius: 10px; cursor: pointer; font-family: 'Inter', sans-serif; transition: background 0.15s; }
            .btn-cart:hover { background: #2d3a60; }
            .btn-cart svg { width: 16px; height: 16px; }
            .btn-buynow { flex: 1; display: flex; align-items: center; justify-content: center; padding: 13px 20px; background: #fff; color: #1a2340; font-size: 14px; font-weight: 600; border: 2px solid #1a2340; border-radius: 10px; cursor: pointer; font-family: 'Inter', sans-serif; transition: background 0.15s, color 0.15s; text-decoration: none; }
            .btn-buynow:hover { background: #1a2340; color: #fff; }
            .product-action-icons { display: flex; gap: 12px; }
            .icon-btn { width: 40px; height: 40px; border: 1px solid #e0e0e0; border-radius: 8px; background: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.15s, border-color 0.15s; }
            .icon-btn:hover { background: #f0f0f5; border-color: #aaa; }
            .icon-btn svg { width: 17px; height: 17px; color: #555; }

            /* ── Tabs ── */
            .product-tabs { margin-top: 28px; }
            .tab-nav { display: flex; border-bottom: 2px solid #f0f0f0; margin-bottom: 24px; }
            .tab-btn { padding: 10px 24px; font-size: 14px; font-weight: 500; color: #888; border: none; background: none; cursor: pointer; font-family: 'Inter', sans-serif; border-bottom: 2px solid transparent; margin-bottom: -2px; transition: color 0.15s, border-color 0.15s; }
            .tab-btn.active { color: #1a2340; border-bottom-color: #1a2340; font-weight: 600; }
            .tab-btn:hover:not(.active) { color: #1a1a2e; }
            .tab-content { display: none; }
            .tab-content.active { display: block; }

            /* ── Specs table ── */
            .specs-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0; border: 1px solid #e8e8e8; border-radius: 10px; overflow: hidden; }
            .spec-item { display: flex; gap: 0; border-bottom: 1px solid #f0f0f0; }
            .spec-item:last-child { border-bottom: none; }
            .spec-item:nth-last-child(2):nth-child(odd) { border-bottom: none; }
            .spec-label { font-size: 13px; font-weight: 600; color: #555; padding: 14px 18px; background: #f9f9fb; min-width: 140px; border-right: 1px solid #f0f0f0; }
            .spec-value { font-size: 13px; color: #1a1a2e; padding: 14px 18px; }

            /* ── Reviews placeholder ── */
            .reviews-placeholder { text-align: center; padding: 40px 0; color: #aaa; font-size: 14px; }

            /* ── Shipping info ── */
            .shipping-list { list-style: none; }
            .shipping-list li { display: flex; align-items: flex-start; gap: 10px; font-size: 14px; color: #555; padding: 10px 0; border-bottom: 1px solid #f0f0f0; }
            .shipping-list li:last-child { border-bottom: none; }
            .shipping-list li svg { width: 16px; height: 16px; color: #1a2340; flex-shrink: 0; margin-top: 1px; }

            /* ── Related Products ── */
            .related-section { margin-top: 48px; }
            .related-section h2 { font-size: 20px; font-weight: 700; color: #1a1a2e; margin-bottom: 20px; }
            .related-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; }
            .product-card { border: 1px solid #e8e8e8; border-radius: 12px; overflow: hidden; background: #fff; display: flex; flex-direction: column; transition: box-shadow 0.15s; text-decoration: none; color: inherit; }
            .product-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
            .product-img { aspect-ratio: 4/3; overflow: hidden; background: #f5f5f5; }
            .product-img img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.3s; }
            .product-card:hover .product-img img { transform: scale(1.04); }
            .product-img-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #f0f0f5; }
            .product-img-placeholder svg { width: 32px; height: 32px; color: #ccc; }
            .product-body { padding: 14px; flex: 1; display: flex; flex-direction: column; }
            .product-category { font-size: 11px; color: #6b8cce; font-weight: 500; margin-bottom: 4px; }
            .product-name { font-size: 14px; font-weight: 600; color: #1a1a2e; margin-bottom: 6px; }
            .product-price { font-size: 15px; font-weight: 700; color: #1a1a2e; margin-top: auto; }

            /* ── Footer ── */
            footer { background: #1a2340; color: #ccc; padding: 56px 32px 28px; margin-top: auto; }
            .footer-grid { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr 1.5fr 2fr; gap: 48px; margin-bottom: 48px; }
            .footer-brand h3 { color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 10px; }
            .footer-brand p { font-size: 13px; line-height: 1.7; color: #aaa; }
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

            @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        </style>
    </head>
    <body>

        @include('layouts._navbar')

        <!-- Breadcrumb -->
        <nav class="breadcrumb-wrap">
            <a href="{{ url('/') }}">Home</a>
            <span>/</span>
            <a href="{{ route('shop') }}">Shop</a>
            @if($product->category)
                <span>/</span>
                <a href="{{ route('shop', ['category' => $product->category->name]) }}">{{ $product->category->name }}</a>
            @endif
            <span>/</span>
            <span class="current">{{ $product->name }}</span>
        </nav>

        <div class="product-container">

            <!-- Main product section -->
            <div class="product-main">

                <!-- Gallery -->
                <div class="product-gallery">
                    <div class="gallery-main" id="gallery-main">
                        @if($product->image)
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" id="main-img">
                        @else
                            <div class="gallery-main-placeholder">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 0 1 2.828 0L16 16m-2-2l1.586-1.586a2 2 0 0 1 2.828 0L20 14m-6-6h.01M6 20h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="gallery-thumbs">
                        @if($product->image)
                            @for($t = 0; $t < 4; $t++)
                            <div class="gallery-thumb {{ $t === 0 ? 'active' : '' }}" onclick="setThumb(this, '{{ $product->image }}')">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}">
                            </div>
                            @endfor
                        @else
                            @for($t = 0; $t < 4; $t++)
                            <div class="gallery-thumb {{ $t === 0 ? 'active' : '' }}">
                                <div class="gallery-thumb-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 0 1 2.828 0L16 16m-2-2l1.586-1.586a2 2 0 0 1 2.828 0L20 14m-6-6h.01M6 20h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"/></svg>
                                </div>
                            </div>
                            @endfor
                        @endif
                    </div>
                </div>

                <!-- Info -->
                <div class="product-info">
                    @if($product->category)
                        <span class="product-badge">{{ $product->category->name }}</span>
                    @endif
                    <h1 class="product-title">{{ $product->name }}</h1>

                    @php
                        $originalPrice = $product->price * 1.17;
                        $discountPct = 17;
                    @endphp
                    <div class="product-pricing">
                        <span class="price-current">&#8369;{{ number_format($product->price, 2) }}</span>
                        <span class="price-original">&#8369;{{ number_format($originalPrice, 2) }}</span>
                        <span class="price-discount">{{ $discountPct }}% OFF</span>
                    </div>

                    @if($product->stock > 0)
                        <div class="product-stock-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>
                            {{ $product->stock }} in stock
                        </div>
                    @else
                        <div class="product-stock-badge out">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>
                            Out of stock
                        </div>
                    @endif

                    <div class="divider"></div>

                    @if($product->description)
                        <div class="product-desc-label">Description</div>
                        <p class="product-desc-text">{{ $product->description }}</p>
                        <div class="divider"></div>
                    @endif

                    <div class="qty-label">Quantity</div>
                    <div class="qty-control">
                        <button class="qty-btn" onclick="changeQty(-1)" type="button">&#8722;</button>
                        <input class="qty-input" type="number" id="qty" value="1" min="1" max="{{ $product->stock }}">
                        <button class="qty-btn" onclick="changeQty(1)" type="button">&#43;</button>
                        <span class="qty-max">Max: {{ $product->stock }} available</span>
                    </div>

                    <div class="product-actions">
                        @if($product->stock > 0)
                            <button type="button" class="btn-cart" id="add-to-cart-btn" onclick="addToCart({{ $product->id }}, this)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h11M10 19a1 1 0 1 0 2 0 1 1 0 0 0-2 0zm7 0a1 1 0 1 0 2 0 1 1 0 0 0-2 0z"/></svg>
                                Add to Cart
                            </button>
                            <a href="{{ route('cart') }}" class="btn-buynow">Buy Now</a>
                        @else
                            <button type="button" class="btn-cart" disabled style="opacity:0.5;cursor:not-allowed;">Out of Stock</button>
                        @endif
                    </div>
                    <div class="product-action-icons">
                        <button class="icon-btn" id="wishlist-btn" title="Add to Wishlist" type="button" onclick="toggleWishlist({{ $product->id }}, this)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 0 1 6.364 0L12 7.636l1.318-1.318a4.5 4.5 0 1 1 6.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 0 1 0-6.364z"/></svg>
                        </button>
                        <button class="icon-btn" title="Share" type="button" onclick="navigator.share ? navigator.share({title:'{{ addslashes($product->name) }}',url:window.location.href}) : navigator.clipboard.writeText(window.location.href)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 1 1 0-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 1 0 0-2.684M18 19.5a3 3 0 1 0 0-2.684"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="product-tabs">
                <div class="tab-nav">
                    <button class="tab-btn active" onclick="switchTab(this, 'specs')">Specifications</button>
                    <button class="tab-btn" onclick="switchTab(this, 'reviews')">Reviews</button>
                    <button class="tab-btn" onclick="switchTab(this, 'shipping')">Shipping Info</button>
                </div>

                <!-- Specifications -->
                <div class="tab-content active" id="tab-specs">
                    <div class="specs-grid">
                        @if($product->category)
                        <div class="spec-item">
                            <div class="spec-label">Category</div>
                            <div class="spec-value">{{ $product->category->name }}</div>
                        </div>
                        @endif
                        <div class="spec-item">
                            <div class="spec-label">Availability</div>
                            <div class="spec-value">{{ $product->stock > 0 ? 'In Stock (' . $product->stock . ' units)' : 'Out of Stock' }}</div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-label">SKU</div>
                            <div class="spec-value">PRD-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-label">Price</div>
                            <div class="spec-value">&#8369;{{ number_format($product->price, 2) }}</div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-label">Compatibility</div>
                            <div class="spec-value">PC, Xbox, PlayStation</div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-label">Connection</div>
                            <div class="spec-value">Wireless &amp; Wired</div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-label">Battery Life</div>
                            <div class="spec-value">40 hours</div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-label">Features</div>
                            <div class="spec-value">Programmable buttons</div>
                        </div>
                    </div>
                </div>

                <!-- Reviews -->
                <div class="tab-content" id="tab-reviews">
                    <div class="reviews-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:48px;height:48px;margin-bottom:12px;display:block;margin-left:auto;margin-right:auto;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-5l-3 3v-3z"/></svg>
                        No reviews yet. Be the first to review this product!
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="tab-content" id="tab-shipping">
                    <ul class="shipping-list">
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 1 0 0-4h-.5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H5zm9 4v4m-4-4v4"/></svg>
                            <div><strong>Standard Shipping</strong> — 3-5 business days. Free on orders over ₱1,500.</div>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <div><strong>Express Shipping</strong> — 1-2 business days. Additional fee applies.</div>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 0 0 4.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 0 1-15.357-2m15.357 2H15"/></svg>
                            <div><strong>Returns</strong> — 30-day return policy. Items must be unused and in original packaging.</div>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <div><strong>Secure Packaging</strong> — All items are carefully packed to prevent damage during transit.</div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Related Products -->
            @if($related->count())
            <div class="related-section">
                <h2>Related Products</h2>
                <div class="related-grid">
                    @foreach($related as $rel)
                    <a href="{{ route('product.show', $rel->id) }}" class="product-card">
                        <div class="product-img">
                            @if($rel->image)
                                <img src="{{ $rel->image }}" alt="{{ $rel->name }}" loading="lazy">
                            @else
                                <div class="product-img-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 0 1 2.828 0L16 16m-2-2l1.586-1.586a2 2 0 0 1 2.828 0L20 14m-6-6h.01M6 20h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="product-body">
                            <div class="product-category">{{ $rel->category->name ?? '' }}</div>
                            <div class="product-name">{{ $rel->name }}</div>
                            <div class="product-price">&#8369;{{ number_format($rel->price, 2) }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        @include('layouts._footer')

        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function changeQty(delta) {
                const input = document.getElementById('qty');
                const max = parseInt(input.max) || 999;
                let val = parseInt(input.value) || 1;
                val = Math.max(1, Math.min(max, val + delta));
                input.value = val;
            }

            function setThumb(el, src) {
                document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('active'));
                el.classList.add('active');
                const mainImg = document.getElementById('main-img');
                if (mainImg) mainImg.src = src;
            }

            function switchTab(btn, tabId) {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById('tab-' + tabId).classList.add('active');
            }

            // Track wishlist state per product on this page
            const _inWishlist = {{ session()->has('wishlist.' . $product->id) ? 'true' : 'false' }};
            let wishlistState = _inWishlist;

            // Set initial heart state
            (function() {
                const btn = document.getElementById('wishlist-btn');
                if (btn && wishlistState) {
                    btn.style.background = '#fff0f3';
                    btn.style.borderColor = '#fca5a5';
                    btn.querySelector('svg').style.color = '#ef4444';
                    btn.querySelector('svg path').setAttribute('fill', '#ef4444');
                    btn.querySelector('svg path').setAttribute('stroke', '#ef4444');
                    btn.title = 'Remove from Wishlist';
                }
            })();

            function toggleWishlist(productId, btn) {
                const url = wishlistState
                    ? '/wishlist/remove/' + productId
                    : '/wishlist/add/' + productId;

                btn.disabled = true;
                fetch(url, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/json' }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        wishlistState = !wishlistState;
                        const svg = btn.querySelector('svg');
                        const path = btn.querySelector('svg path');
                        if (wishlistState) {
                            btn.style.background = '#fff0f3';
                            btn.style.borderColor = '#fca5a5';
                            svg.style.color = '#ef4444';
                            path.setAttribute('fill', '#ef4444');
                            path.setAttribute('stroke', '#ef4444');
                            btn.title = 'Remove from Wishlist';
                        } else {
                            btn.style.background = '';
                            btn.style.borderColor = '';
                            svg.style.color = '';
                            path.setAttribute('fill', 'none');
                            path.setAttribute('stroke', 'currentColor');
                            btn.title = 'Add to Wishlist';
                        }
                    }
                    btn.disabled = false;
                })
                .catch(() => { btn.disabled = false; });
            }

            function addToCart(productId, btn) {
                const qty = parseInt(document.getElementById('qty').value) || 1;
                const original = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="animation:spin 0.6s linear infinite"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 0 0 4.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 0 1-15.357-2m15.357 2H15"/></svg> Adding...';

                fetch('/cart/add/' + productId, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: JSON.stringify({ quantity: qty })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        const badge = document.getElementById('cart-badge');
                        if (badge) {
                            badge.textContent = data.count;
                            badge.style.display = 'flex';
                        }
                        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Added!';
                        btn.style.background = '#22a05a';
                        setTimeout(() => {
                            btn.innerHTML = original;
                            btn.style.background = '';
                            btn.disabled = false;
                        }, 1500);
                    }
                })
                .catch(() => {
                    btn.innerHTML = original;
                    btn.disabled = false;
                });
            }
        </script>
    </body>
</html>
