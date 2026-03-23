<script>
    (function () {
        var existing = document.querySelector("link[rel~='icon']");
        if (!existing) {
            var link = document.createElement('link');
            link.rel = 'icon';
            link.type = 'image/png';
            link.href = '/images/shopline-logo.png';
            document.head.appendChild(link);
        }
    })();
</script>
<style>
    /* ── ShopLine Navbar ── */
    .shopnav { position: sticky; top: 0; z-index: 100; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.06); }
    .shopnav-topbar { background: #f3f4f6; border-bottom: 1px solid #e5e7eb; height: 36px; display: flex; align-items: center; justify-content: space-between; padding: 0 32px; font-size: 12px; color: #6b7280; }
    .shopnav-topbar a { color: #6b7280; text-decoration: none; }
    .shopnav-topbar a:hover { color: #374151; }
    .shopnav-topbar-left { display: flex; align-items: center; gap: 5px; }
    .shopnav-topbar-right { display: flex; align-items: center; gap: 16px; }
    .shopnav-topbar-right .lang { display: flex; align-items: center; gap: 4px; }
    .shopnav-middle { height: 64px; display: flex; align-items: center; justify-content: space-between; padding: 0 32px; gap: 24px; border-bottom: 1px solid #f3f4f6; }
    .shopnav-brand { display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 20px; color: #111827; text-decoration: none; flex-shrink: 0; }
    .shopnav-brand .brand-icon { width: 36px; height: 36px; background: #1f2937; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
    .shopnav-search { flex: 1; max-width: 560px; }
    .shopnav-search form { display: flex; border: 1.5px solid #e5e7eb; border-radius: 8px; overflow: hidden; }
    .shopnav-search input { flex: 1; padding: 9px 16px; border: none; font-size: 14px; background: #fff; outline: none; color: #374151; font-family: 'Inter', sans-serif; }
    .shopnav-search input::placeholder { color: #9ca3af; }
    .shopnav-search button { background: #2563eb; border: none; padding: 0 16px; cursor: pointer; display: flex; align-items: center; transition: background 0.15s; }
    .shopnav-search button:hover { background: #1d4ed8; }
    .shopnav-actions { display: flex; align-items: center; gap: 20px; flex-shrink: 0; font-size: 13px; color: #4b5563; }
    .shopnav-actions a { color: #4b5563; text-decoration: none; display: flex; align-items: center; gap: 5px; transition: color 0.15s; }
    .shopnav-actions a:hover { color: #2563eb; }
    .shopnav-bottom { height: 44px; display: flex; align-items: center; padding: 0 32px; gap: 4px; border-bottom: 1px solid #f3f4f6; position: relative; }
    .shopnav-bottom a { font-size: 14px; color: #4b5563; font-weight: 500; text-decoration: none; padding: 8px 12px; border-radius: 6px; transition: background 0.15s, color 0.15s; white-space: nowrap; }
    .shopnav-bottom a:hover { background: #f9fafb; color: #111827; }
    .shopnav-bottom a.hot { color: #f97316; display: flex; align-items: center; gap: 5px; }
</style>

<header class="shopnav">

    <!-- Top bar -->
    <div class="shopnav-topbar">
        <div class="shopnav-topbar-left">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.134 2 5 5.134 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.866-3.134-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/></svg>
            <span>Metro Manila, Philippines</span>
        </div>
        <div class="shopnav-topbar-right">
            <a href="{{ route('customer-service') }}" style="display:flex;align-items:center;gap:4px;">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 11a3 3 0 1 0 6 0 3 3 0 0 0-6 0M3 11a9 9 0 1 0 18 0 9 9 0 0 0-18 0"/></svg>
                Support
            </a>
            <div class="lang">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M2 12h20M12 2a15.3 15.3 0 0 1 0 20M12 2a15.3 15.3 0 0 0 0 20"/></svg>
                <span>English | PHP</span>
                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </div>
        </div>
    </div>

    <!-- Middle row -->
    <div class="shopnav-middle">
        <a href="{{ url('/') }}" class="shopnav-brand">
            <img src="{{ asset('images/shopline-logo.png') }}" alt="ShopLine" style="height:40px;width:auto;">
            ShopLine
        </a>

        <div class="shopnav-search">
            <form action="{{ route('shop') }}" method="GET">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search">
                <button type="submit">
                    <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                </button>
            </form>
        </div>

        <div class="shopnav-actions">
            @auth
                <a href="{{ route('account') }}">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A8 8 0 1 1 18.88 17.804M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/></svg>
                    {{ Auth::user()->name }}
                </a>
            @else
                <a href="{{ route('login') }}">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A8 8 0 1 1 18.88 17.804M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/></svg>
                    Account
                </a>
            @endauth
            <a href="{{ route('account') }}?tab=wishlist" style="position:relative;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 0 1 6.364 0L12 7.636l1.318-1.318a4.5 4.5 0 1 1 6.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 0 1 0-6.364z"/></svg>
                Wishlist
                @php $wishlistCount = count(session()->get('wishlist', [])); @endphp
                @if($wishlistCount > 0)
                    <span style="position:absolute;top:-7px;right:-9px;background:#ef4444;color:#fff;font-size:10px;font-weight:700;width:17px;height:17px;border-radius:50%;display:flex;align-items:center;justify-content:center;">{{ $wishlistCount }}</span>
                @endif
            </a>
            <a href="{{ route('cart') }}" style="position:relative;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h11M10 19a1 1 0 1 0 2 0 1 1 0 0 0-2 0zm7 0a1 1 0 1 0 2 0 1 1 0 0 0-2 0z"/></svg>
                My cart
                @php $cartCount = array_sum(array_column(session()->get('cart', []), 'quantity')); @endphp
                @if($cartCount > 0)
                    <span style="position:absolute;top:-7px;right:-9px;background:#2563eb;color:#fff;font-size:10px;font-weight:700;width:17px;height:17px;border-radius:50%;display:flex;align-items:center;justify-content:center;">{{ $cartCount }}</span>
                @endif
            </a>
        </div>
    </div>

    <!-- Bottom nav links -->
    <div class="shopnav-bottom">
        <a href="{{ route('shop') }}" class="hot">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 0 0-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 0 0-.613 3.58 2.64 2.64 0 0 1-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 0 0 5.05 6.05 6.981 6.981 0 0 0 3 11a7 7 0 1 0 14 0c0-3.368-2.29-6.25-4.605-8.447z" clip-rule="evenodd"/></svg>
            Hot offers
        </a>
        <a href="{{ route('shop') }}">Recommends</a>
        <a href="{{ route('shop') }}">New arrivals</a>
        <a href="{{ route('shop') }}">Bestsellers</a>
        <a href="{{ route('shop', ['category' => 'Gift Boxes']) }}">Gift boxes</a>
        <a href="{{ route('about') }}">About us</a>

    </div>

</header>

