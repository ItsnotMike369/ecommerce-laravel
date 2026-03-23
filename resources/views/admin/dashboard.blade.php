<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Admin Panel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; color: #1e293b; display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 200px; background: #0f172a; color: #94a3b8;
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; height: 100vh; z-index: 50;
        }
        .sidebar-brand {
            display: flex; align-items: center; gap: 10px;
            padding: 20px 18px; font-weight: 700; font-size: 15px; color: #fff;
            border-bottom: 1px solid #1e293b;
        }
        .sidebar-brand svg { width: 28px; height: 28px; }
        .sidebar-nav { flex: 1; padding: 12px 0; }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 11px 18px; font-size: 14px; font-weight: 500;
            color: #94a3b8; text-decoration: none;
            border-radius: 0; transition: background 0.15s, color 0.15s;
            cursor: pointer; border: none; background: none; width: 100%; text-align: left;
        }
        .nav-item:hover { background: #1e293b; color: #e2e8f0; }
        .nav-item.active { background: #1e3a5f; color: #fff; border-radius: 6px; margin: 0 8px; padding: 11px 10px; width: calc(100% - 16px); }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
        .sidebar-logout { padding: 16px 0; border-top: 1px solid #1e293b; }

        /* Main */
        .main { margin-left: 200px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

        /* Top bar */
        .topbar {
            background: #fff; border-bottom: 1px solid #e2e8f0;
            padding: 0 28px; height: 60px;
            display: flex; align-items: center; justify-content: flex-end;
            position: sticky; top: 0; z-index: 40;
        }
        .topbar-user { display: flex; align-items: center; gap: 10px; }
        .topbar-user .info { text-align: right; }
        .topbar-user .name { font-size: 14px; font-weight: 600; color: #1e293b; }
        .topbar-user .email { font-size: 12px; color: #64748b; }
        .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: #334155; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700;
        }

        /* Content */
        .content { padding: 28px; flex: 1; }
        .page-title { font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .page-sub { font-size: 13px; color: #64748b; margin-bottom: 24px; }

        /* Stat cards */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
        .stat-card {
            background: #fff; border-radius: 12px; padding: 20px;
            border: 1px solid #e2e8f0;
            display: flex; flex-direction: column; gap: 8px;
        }
        .stat-header { display: flex; align-items: center; justify-content: space-between; }
        .stat-label { font-size: 13px; color: #64748b; font-weight: 500; }
        .stat-icon {
            width: 36px; height: 36px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }
        .stat-icon.green { background: #dcfce7; color: #16a34a; }
        .stat-icon.blue  { background: #dbeafe; color: #2563eb; }
        .stat-icon.purple{ background: #f3e8ff; color: #9333ea; }
        .stat-icon.orange{ background: #ffedd5; color: #ea580c; }
        .stat-icon svg   { width: 18px; height: 18px; }
        .stat-value { font-size: 26px; font-weight: 700; color: #1e293b; }
        .stat-badge { font-size: 12px; color: #16a34a; font-weight: 500; }

        /* Two-col */
        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .panel { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 22px; }
        .panel-title { font-size: 15px; font-weight: 700; color: #1e293b; margin-bottom: 16px; }

        /* Recent orders table */
        .orders-list { width: 100%; }
        .order-row {
            display: grid; grid-template-columns: 60px 1fr auto auto;
            align-items: center; gap: 12px;
            padding: 12px 0; border-bottom: 1px solid #f1f5f9;
        }
        .order-row:last-child { border-bottom: none; }
        .order-id { font-size: 14px; font-weight: 600; color: #1e293b; }
        .order-name { font-size: 13px; color: #64748b; }
        .order-amount { font-size: 14px; font-weight: 600; color: #1e293b; text-align: right; }
        .order-status {
            font-size: 11px; font-weight: 600; padding: 3px 8px;
            border-radius: 12px; text-align: center;
        }
        .status-pending    { background: #fef9c3; color: #854d0e; }
        .status-processing { background: #dbeafe; color: #1e40af; }
        .status-shipped    { background: #dcfce7; color: #166534; }
        .status-delivered  { background: #f0fdf4; color: #15803d; }

        /* Low stock */
        .stock-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 12px 0; border-bottom: 1px solid #f1f5f9;
        }
        .stock-row:last-child { border-bottom: none; }
        .stock-name { font-size: 14px; font-weight: 500; color: #1e293b; }
        .stock-cat  { font-size: 12px; color: #64748b; }
        .stock-badge {
            font-size: 12px; font-weight: 600; padding: 3px 10px;
            border-radius: 12px; background: #dc2626; color: #fff;
        }

        /* Toast */
        .toast {
            position: fixed; bottom: 24px; right: 24px;
            background: #fff; border: 1px solid #e2e8f0;
            border-radius: 10px; padding: 12px 18px;
            display: flex; align-items: center; gap: 10px;
            font-size: 13px; font-weight: 500; color: #1e293b;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            animation: fadeOut 0.5s ease 3s forwards;
        }
        .toast svg { color: #16a34a; width: 18px; height: 18px; }
        @keyframes fadeOut { to { opacity: 0; pointer-events: none; } }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <svg viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="28" height="28" rx="6" fill="#1e3a5f"/>
                <rect x="6" y="8" width="16" height="3" rx="1.5" fill="#fff"/>
                <rect x="6" y="13" width="10" height="3" rx="1.5" fill="#fff"/>
                <rect x="6" y="18" width="13" height="3" rx="1.5" fill="#fff"/>
            </svg>
            Admin Panel
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item active">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1" stroke-linecap="round"/><rect x="14" y="3" width="7" height="7" rx="1" stroke-linecap="round"/><rect x="3" y="14" width="7" height="7" rx="1" stroke-linecap="round"/><rect x="14" y="14" width="7" height="7" rx="1" stroke-linecap="round"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.products') }}" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Products
            </a>
            <a href="{{ route('admin.orders') }}" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h11M10 19a1 1 0 100 2 1 1 0 000-2zm7 0a1 1 0 100 2 1 1 0 000-2z"/></svg>
                Orders
            </a>
            <a href="{{ route('admin.customers') }}" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Customers
            </a>
            <a href="{{ route('admin.settings') }}" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3" stroke-width="2"/></svg>
                Settings
            </a>
        </nav>
        <div class="sidebar-logout">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <div class="main">
        <header class="topbar">
            <div class="topbar-user">
                <div class="info">
                    <div class="name">Admin User</div>
                    <div class="email">{{ Auth::user()->email }}</div>
                </div>
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            </div>
        </header>

        <div class="content">
            <h1 class="page-title">Dashboard Overview</h1>
            <p class="page-sub">Welcome back, Admin! Here's what's happening today.</p>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Total Revenue</span>
                        <div class="stat-icon green">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div class="stat-value">₱{{ number_format($totalRevenue, 0) }}</div>
                    <div class="stat-badge">↑ +12.5%</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Total Orders</span>
                        <div class="stat-icon blue">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h11"/></svg>
                        </div>
                    </div>
                    <div class="stat-value">{{ $totalOrders }}</div>
                    <div class="stat-badge">↑ +8.2%</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Total Products</span>
                        <div class="stat-icon purple">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                    </div>
                    <div class="stat-value">{{ $totalProducts }}</div>
                    <div class="stat-badge">↑ +5.4%</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Total Customers</span>
                        <div class="stat-icon orange">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                    </div>
                    <div class="stat-value">{{ $totalCustomers }}</div>
                    <div class="stat-badge">↑ +15.3%</div>
                </div>
            </div>

            <!-- Bottom panels -->
            <div class="two-col">
                <!-- Recent Orders -->
                <div class="panel">
                    <div class="panel-title">Recent Orders</div>
                    @forelse($recentOrders as $order)
                    <div class="order-row">
                        <div>
                            <div class="order-id">#{{ $order->id }}</div>
                            <div class="order-name">{{ $order->customer_name ?? 'Customer' }}</div>
                        </div>
                        <div></div>
                        <div class="order-amount">₱{{ number_format($order->total ?? 0, 2) }}</div>
                        <span class="order-status status-{{ strtolower($order->status ?? 'pending') }}">{{ ucfirst($order->status ?? 'Pending') }}</span>
                    </div>
                    @empty
                    <p style="font-size:13px;color:#94a3b8;text-align:center;padding:20px 0;">No orders yet.</p>
                    @endforelse
                </div>

                <!-- Low Stock -->
                <div class="panel">
                    <div class="panel-title">Low Stock Products</div>
                    @forelse($lowStockProducts as $product)
                    <div class="stock-row">
                        <div>
                            <div class="stock-name">{{ $product->name }}</div>
                            <div class="stock-cat">{{ $product->category->name ?? 'Uncategorized' }}</div>
                        </div>
                        <span class="stock-badge">{{ $product->stock }} left</span>
                    </div>
                    @empty
                    <p style="font-size:13px;color:#94a3b8;text-align:center;padding:20px 0;">All products are well stocked.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="toast">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Admin logged in successfully!
    </div>

</body>
</html>
