<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ request('category') ? request('category') : 'Shop' }} - ShopLine</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body { font-family: 'Inter', sans-serif; background: #f9f9fb; color: #1a1a2e; min-height: 100vh; display: flex; flex-direction: column; }


            /* ── Page header ── */
            .page-header { background: #fff; border-bottom: 1px solid #f0f0f0; padding: 28px 32px; }
            .page-header-inner { max-width: 1100px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; }
            .page-header h1 { font-size: 24px; font-weight: 700; color: #1a1a2e; }
            .page-header p { font-size: 14px; color: #888; margin-top: 2px; }

            /* ── Layout ── */
            .shop-layout { max-width: 1100px; margin: 32px auto; padding: 0 32px; display: grid; grid-template-columns: 220px 1fr; gap: 28px; flex: 1; width: 100%; }

            /* ── Sidebar ── */
            .sidebar { flex-shrink: 0; }
            .sidebar-card { background: #fff; border: 1px solid #e8e8e8; border-radius: 12px; padding: 20px; margin-bottom: 16px; }
            .sidebar-card h3 { font-size: 14px; font-weight: 600; color: #1a1a2e; margin-bottom: 14px; }
            .sidebar-filters-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
            .sidebar-filters-header h3 { margin-bottom: 0; }
            .clear-all { font-size: 12px; color: #888; text-decoration: none; transition: color 0.15s; }
            .clear-all:hover { color: #1a1a2e; }
            .category-filter { list-style: none; }
            .category-filter li { margin-bottom: 6px; }
            .category-filter label { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #555; cursor: pointer; padding: 5px 6px; border-radius: 6px; transition: background 0.15s; }
            .category-filter label:hover { background: #f0f0f6; color: #1a1a2e; }
            .category-filter input[type=checkbox] { accent-color: #1a2340; width: 14px; height: 14px; flex-shrink: 0; cursor: pointer; }
            .category-filter input[type=checkbox]:checked + span { font-weight: 600; color: #1a1a2e; }
            /* Price range */
            .price-range-inputs { display: flex; align-items: center; gap: 8px; margin-top: 12px; }
            .price-range-inputs input[type=number] { width: 70px; padding: 6px 8px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 12px; font-family: 'Inter', sans-serif; color: #1a1a2e; outline: none; }
            .price-range-inputs input[type=number]:focus { border-color: #aaa; }
            .price-range-inputs span { font-size: 12px; color: #888; }
            .price-slider-wrap { margin-top: 10px; }
            .price-slider { width: 100%; accent-color: #1a2340; }
            .price-labels { display: flex; justify-content: space-between; font-size: 11px; color: #aaa; margin-top: 4px; }
            /* Availability */
            .availability-label { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #555; cursor: pointer; margin-top: 4px; }
            .availability-label input[type=checkbox] { accent-color: #1a2340; width: 14px; height: 14px; cursor: pointer; }
            /* Sort */
            .sort-select { padding: 7px 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 13px; font-family: 'Inter', sans-serif; color: #1a1a2e; background: #fff; outline: none; cursor: pointer; }
            .sort-select:focus { border-color: #aaa; }

            /* ── Main area ── */
            .shop-main {}
            .shop-toolbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
            .shop-toolbar p { font-size: 13px; color: #888; }
            .shop-toolbar p span { font-weight: 600; color: #1a1a2e; }
            .shop-toolbar-right { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #888; }

            /* ── Search form ── */
            .search-form { display: flex; gap: 8px; margin-bottom: 20px; }
            .search-form input { flex: 1; padding: 9px 14px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; outline: none; font-family: 'Inter', sans-serif; color: #1a1a2e; }
            .search-form input:focus { border-color: #aaa; }
            .search-form button { padding: 9px 18px; background: #1a2340; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Inter', sans-serif; transition: background 0.15s; }
            .search-form button:hover { background: #2d3a60; }

            /* ── Product grid ── */
            .products-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
            .product-card { border: 1px solid #e8e8e8; border-radius: 12px; overflow: hidden; background: #fff; display: flex; flex-direction: column; transition: box-shadow 0.15s; }
            .product-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
            .product-img { aspect-ratio: 4/3; overflow: hidden; background: #f5f5f5; }
            .product-img img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.3s; }
            .product-card:hover .product-img img { transform: scale(1.04); }
            .product-img-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #f0f0f5; }
            .product-img-placeholder svg { width: 40px; height: 40px; color: #ccc; }
            .product-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
            .product-category { font-size: 12px; color: #6b8cce; font-weight: 500; margin-bottom: 6px; }
            .product-name { font-size: 15px; font-weight: 600; color: #1a1a2e; margin-bottom: 8px; }
            .product-desc { font-size: 12px; color: #999; margin-bottom: 8px; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
            .product-price { font-size: 16px; font-weight: 700; color: #1a1a2e; margin-bottom: 4px; }
            .product-stock { font-size: 12px; color: #888; margin-bottom: 14px; flex: 1; }
            .btn-add-cart { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 11px; background: #1a1a2e; color: #fff; font-size: 13px; font-weight: 600; border: none; border-radius: 8px; cursor: pointer; text-decoration: none; transition: background 0.15s; font-family: 'Inter', sans-serif; }
            .btn-add-cart:hover { background: #2d2d4e; }
            .btn-add-cart svg { width: 15px; height: 15px; }

            /* ── Empty state ── */
            .empty-state { text-align: center; padding: 80px 20px; background: #fff; border-radius: 12px; border: 1px solid #e8e8e8; }
            .empty-state svg { width: 56px; height: 56px; color: #ccc; margin-bottom: 16px; }
            .empty-state h3 { font-size: 18px; font-weight: 600; color: #1a1a2e; margin-bottom: 8px; }
            .empty-state p { font-size: 14px; color: #888; }

            /* ── Pagination ── */
            .pagination-wrap { margin-top: 32px; display: flex; justify-content: center; align-items: center; gap: 6px; flex-wrap: wrap; }
            .pagination-wrap a, .pagination-wrap span {
                display: inline-flex; align-items: center; justify-content: center;
                min-width: 36px; height: 36px; padding: 0 10px;
                border: 1px solid #e0e0e0; border-radius: 8px;
                font-size: 13px; font-weight: 500; text-decoration: none;
                color: #1a1a2e; background: #fff; transition: all 0.15s; cursor: pointer;
            }
            .pagination-wrap a:hover { background: #f0f0f6; border-color: #aaa; }
            .pagination-wrap span.active { background: #1a2340; color: #fff; border-color: #1a2340; }
            .pagination-wrap span.disabled { color: #ccc; cursor: default; background: #fafafa; }

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
        </style>
    </head>
    <body>

        @include('layouts._navbar')

        @php
            /** @var \Illuminate\Pagination\LengthAwarePaginator $products */
            $activeCategory = request('category');
            $activeCategories = request()->has('categories') ? (array) request('categories') : ($activeCategory ? [$activeCategory] : []);
        @endphp

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-inner">
                <div>
                    <h1>{{ $activeCategory ?? 'Product Catalog' }}</h1>
                    <p>Browse our collection of {{ $products->total() }} products</p>
                </div>
            </div>
        </div>

        <!-- Shop Layout -->
        <div class="shop-layout">

            <!-- Sidebar -->
            <aside class="sidebar">
                <div class="sidebar-card">
                    <form method="GET" action="{{ route('shop') }}" id="filter-form">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif

                        <div class="sidebar-filters-header">
                            <h3>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="vertical-align:middle;margin-right:5px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 .707 1.707L13 12.414V19a1 1 0 0 1-1.447.894l-4-2A1 1 0 0 1 7 17v-4.586L3.293 5.707A1 1 0 0 1 3 5V4z"/></svg>
                                Filters
                            </h3>
                            <a href="{{ route('shop') }}" class="clear-all">Clear All</a>
                        </div>

                        <h3 style="font-size:13px;margin-bottom:10px;">Categories</h3>
                        <ul class="category-filter">
                            @foreach($categories as $cat)
                            <li>
                                <label>
                                    <input type="checkbox" name="categories[]" value="{{ $cat->name }}"
                                        {{ in_array($cat->name, $activeCategories) ? 'checked' : '' }}
                                        onchange="document.getElementById('filter-form').submit()">
                                    <span>{{ $cat->name }}</span>
                                </label>
                            </li>
                            @endforeach
                        </ul>

                        <h3 style="font-size:13px;margin-top:18px;margin-bottom:10px;">Price Range</h3>
                        <div class="price-range-inputs">
                            <input type="number" name="min_price" value="{{ request('min_price', 0) }}" min="0" placeholder="0">
                            <span>—</span>
                            <input type="number" name="max_price" value="{{ request('max_price', 50000) }}" min="0" placeholder="50000">
                        </div>
                        <div class="price-labels"><span>0</span><span>50000</span></div>

                        <h3 style="font-size:13px;margin-top:18px;margin-bottom:10px;">Availability</h3>
                        <label class="availability-label">
                            <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }} onchange="document.getElementById('filter-form').submit()">
                            In Stock Only
                        </label>
                        <button type="submit" style="margin-top:14px;width:100%;padding:9px;background:#1a2340;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;">Apply</button>
                    </form>
                </div>
            </aside>

            <!-- Main -->
            <main class="shop-main">

                <!-- Search bar -->
                <form method="GET" action="{{ route('shop') }}" class="search-form">
                    @foreach($activeCategories as $cat)
                        <input type="hidden" name="categories[]" value="{{ $cat }}">
                    @endforeach
                    <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}">
                    <button type="submit">Search</button>
                </form>

                <div class="shop-toolbar">
                    <p>
                        Showing <span>{{ $products->count() }}</span> of <span>{{ $products->total() }}</span> products
                    </p>
                    <div class="shop-toolbar-right">
                        Sort by:
                        <select class="sort-select" onchange="window.location.href=this.value">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'default']) }}" {{ request('sort','default') === 'default' ? 'selected' : '' }}>Default</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name: A–Z</option>
                        </select>
                    </div>
                </div>

                @if($products->count())
                <div class="products-grid">
                    @foreach($products as $product)
                    <div class="product-card">
                        <a href="{{ route('product.show', $product->id) }}" class="product-img" style="text-decoration:none;display:block;">
                            @if($product->image)
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" loading="lazy">
                            @else
                                <div class="product-img-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 0 1 2.828 0L16 16m-2-2l1.586-1.586a2 2 0 0 1 2.828 0L20 14m-6-6h.01M6 20h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"/></svg>
                                </div>
                            @endif
                        </a>
                        <div class="product-body">
                            <div class="product-category">{{ $product->category->name ?? '' }}</div>
                            <a href="{{ route('product.show', $product->id) }}" class="product-name" style="text-decoration:none;color:inherit;">{{ $product->name }}</a>
                            @if($product->description)
                                <div class="product-desc">{{ $product->description }}</div>
                            @endif
                            <div class="product-price">&#8369;{{ number_format($product->price, 2) }}</div>
                            <div class="product-stock">{{ $product->stock }} in stock</div>
                            <button type="button" class="btn-add-cart" onclick="addToCart({{ $product->id }}, this)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h11M10 19a1 1 0 1 0 2 0 1 1 0 0 0-2 0zm7 0a1 1 0 1 0 2 0 1 1 0 0 0-2 0z"/></svg>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($products->lastPage() > 1)
                <div class="pagination-wrap">
                    {{-- Previous --}}
                    @if($products->onFirstPage())
                        <span class="disabled">&lsaquo;</span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}">&lsaquo;</a>
                    @endif

                    {{-- Page numbers --}}
                    @for($i = 1; $i <= $products->lastPage(); $i++)
                        @if($i === $products->currentPage())
                            <span class="active">{{ $i }}</span>
                        @else
                            <a href="{{ $products->url($i) }}">{{ $i }}</a>
                        @endif
                    @endfor

                    {{-- Next --}}
                    @if($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}">&rsaquo;</a>
                    @else
                        <span class="disabled">&rsaquo;</span>
                    @endif
                </div>
                @endif

                @else
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7m16 0v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-5m16 0H4m8-9v9"/></svg>
                    <h3>No products found</h3>
                    <p>Try a different category or search term.</p>
                </div>
                @endif

            </main>
        </div>

        @include('layouts._footer')

        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function addToCart(productId, btn) {
                const original = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="animation:spin 0.6s linear infinite"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 0 0 4.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 0 1-15.357-2m15.357 2H15"/></svg> Adding...';

                fetch('/cart/add/' + productId, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: JSON.stringify({})
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        const badge = document.getElementById('cart-badge');
                        if (badge) {
                            badge.textContent = data.count;
                            badge.style.display = 'flex';
                        }
                        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Added!';
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
        <style>
            @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        </style>
    </body>
</html>
