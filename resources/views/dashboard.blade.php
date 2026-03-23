<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - ShopLine</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; color: #1e293b; display: flex; min-height: 100vh; }

        .sidebar {
            width: 220px; background: #0f172a; color: #94a3b8;
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
            transition: background 0.15s, color 0.15s;
            cursor: pointer; border: none; background: none; width: 100%; text-align: left;
        }
        .nav-item:hover { background: #1e293b; color: #e2e8f0; }
        .nav-item.active { background: #1e3a5f; color: #fff; border-radius: 6px; margin: 0 8px; padding: 11px 10px; width: calc(100% - 16px); }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
        .sidebar-logout { padding: 16px 0; border-top: 1px solid #1e293b; }

        .main { margin-left: 220px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

        .topbar {
            background: #fff; border-bottom: 1px solid #e2e8f0;
            padding: 0 28px; height: 60px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 40;
        }
        .topbar-left { font-size: 14px; color: #64748b; }
        .topbar-user { display: flex; align-items: center; gap: 10px; }
        .topbar-user .info { text-align: right; }
        .topbar-user .name { font-size: 14px; font-weight: 600; color: #1e293b; }
        .topbar-user .role { font-size: 12px; color: #64748b; }
        .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: #1e3a5f; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700;
        }

        .content { padding: 28px; flex: 1; }
        .page-title { font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .page-sub { font-size: 13px; color: #64748b; margin-bottom: 24px; }

        .welcome-card {
            background: #fff; border-radius: 12px; border: 1px solid #e2e8f0;
            padding: 32px; display: flex; align-items: center; gap: 20px;
            margin-bottom: 24px;
        }
        .welcome-avatar {
            width: 64px; height: 64px; border-radius: 50%;
            background: #1e3a5f; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 26px; font-weight: 700; flex-shrink: 0;
        }
        .welcome-text h2 { font-size: 20px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .welcome-text p { font-size: 14px; color: #64748b; }

        .quick-links { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .quick-card {
            background: #fff; border-radius: 12px; border: 1px solid #e2e8f0;
            padding: 22px; text-decoration: none; color: inherit;
            display: flex; flex-direction: column; gap: 10px;
            transition: box-shadow 0.15s, border-color 0.15s;
        }
        .quick-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.08); border-color: #cbd5e1; }
        .quick-icon {
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .quick-icon.blue   { background: #dbeafe; color: #2563eb; }
        .quick-icon.green  { background: #dcfce7; color: #16a34a; }
        .quick-icon.purple { background: #f3e8ff; color: #9333ea; }
        .quick-icon svg { width: 20px; height: 20px; }
        .quick-card h3 { font-size: 15px; font-weight: 600; color: #1e293b; }
        .quick-card p  { font-size: 13px; color: #64748b; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <svg viewBox="0 0 28 28" fill="none">
                <rect width="28" height="28" rx="6" fill="#1e3a5f"/>
                <path stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 11V8a5 5 0 0 1 10 0v3M5 11h18l-1.5 10H6.5L5 11z"/>
            </svg>
            ShopLine
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item active">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <a href="{{ route('shop') }}" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Shop
            </a>
            <a href="{{ route('cart') }}" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h11M10 19a1 1 0 100 2 1 1 0 000-2zm7 0a1 1 0 100 2 1 1 0 000-2z"/></svg>
                My Cart
            </a>
            <a href="{{ route('profile.edit') }}" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A8 8 0 1 1 18.88 17.804M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/></svg>
                My Profile
            </a>
        </nav>
        <div class="sidebar-logout">
            <form method="POST" action="{{ route('logout') }}">
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
            <span class="topbar-left">Welcome back, {{ Auth::user()->name }}!</span>
            <div class="topbar-user">
                <div class="info">
                    <div class="name">{{ Auth::user()->name }}</div>
                    <div class="role">{{ Auth::user()->email }}</div>
                </div>
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            </div>
        </header>

        <div class="content">
            <h1 class="page-title">My Dashboard</h1>
            <p class="page-sub">Manage your account, browse the shop, and track your orders.</p>

            <!-- Welcome card -->
            <div class="welcome-card">
                <div class="welcome-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="welcome-text">
                    <h2>Hello, {{ Auth::user()->name }}!</h2>
                    <p>You're logged in as <strong>{{ Auth::user()->email }}</strong>. Here's a quick overview of your account.</p>
                </div>
            </div>

            <!-- Quick links -->
            <div class="quick-links">
                <a href="{{ route('shop') }}" class="quick-card">
                    <div class="quick-icon blue">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <h3>Browse Shop</h3>
                    <p>Explore our full product catalog.</p>
                </a>
                <a href="{{ route('cart') }}" class="quick-card">
                    <div class="quick-icon green">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h11M10 19a1 1 0 100 2 1 1 0 000-2zm7 0a1 1 0 100 2 1 1 0 000-2z"/></svg>
                    </div>
                    <h3>My Cart</h3>
                    <p>View and manage your cart items.</p>
                </a>
                <a href="{{ route('profile.edit') }}" class="quick-card">
                    <div class="quick-icon purple">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A8 8 0 1 1 18.88 17.804M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/></svg>
                    </div>
                    <h3>My Profile</h3>
                    <p>Update your profile and password.</p>
                </a>
            </div>
        </div>
    </div>

</body>
</html>
