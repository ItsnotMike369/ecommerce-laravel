<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Settings - Admin Panel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; color: #1e293b; display: flex; min-height: 100vh; }
        .sidebar { width: 200px; background: #0f172a; color: #94a3b8; display: flex; flex-direction: column; position: fixed; top: 0; left: 0; height: 100vh; z-index: 50; }
        .sidebar-brand { display: flex; align-items: center; gap: 10px; padding: 20px 18px; font-weight: 700; font-size: 15px; color: #fff; border-bottom: 1px solid #1e293b; }
        .sidebar-brand svg { width: 28px; height: 28px; }
        .sidebar-nav { flex: 1; padding: 12px 0; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 11px 18px; font-size: 14px; font-weight: 500; color: #94a3b8; text-decoration: none; transition: background 0.15s, color 0.15s; cursor: pointer; border: none; background: none; width: 100%; text-align: left; }
        .nav-item:hover { background: #1e293b; color: #e2e8f0; }
        .nav-item.active { background: #1e3a5f; color: #fff; border-radius: 6px; margin: 0 8px; padding: 11px 10px; width: calc(100% - 16px); }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
        .sidebar-logout { padding: 16px 0; border-top: 1px solid #1e293b; }
        .main { margin-left: 200px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 0 28px; height: 60px; display: flex; align-items: center; justify-content: flex-end; position: sticky; top: 0; z-index: 40; }
        .topbar-user { display: flex; align-items: center; gap: 10px; }
        .topbar-user .info { text-align: right; }
        .topbar-user .name { font-size: 14px; font-weight: 600; color: #1e293b; }
        .topbar-user .email { font-size: 12px; color: #64748b; }
        .avatar { width: 36px; height: 36px; border-radius: 50%; background: #334155; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; }
        .content { padding: 28px; flex: 1; }
        .page-title { font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .page-sub { font-size: 13px; color: #64748b; margin-bottom: 24px; }
        .settings-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .panel { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 24px; }
        .panel-title { font-size: 15px; font-weight: 700; color: #1e293b; margin-bottom: 18px; }
        .form-group { margin-bottom: 14px; }
        .form-label { display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 5px; }
        .form-input { width: 100%; padding: 9px 12px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 14px; outline: none; font-family: 'Inter', sans-serif; color: #1e293b; background: #f9fafb; transition: border-color 0.2s; }
        .form-input:focus { border-color: #6b7280; background: #fff; }
        .btn-save { display: inline-block; padding: 10px 20px; background: #0f172a; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: 'Inter', sans-serif; transition: background 0.2s; margin-top: 4px; width: 100%; }
        .btn-save:hover { background: #1e293b; }
        .method-row { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f1f5f9; }
        .method-row:last-of-type { border-bottom: none; }
        .method-name { font-size: 14px; font-weight: 500; color: #1e293b; }
        .method-sub  { font-size: 12px; color: #64748b; }
        .badge-enabled  { background: #1e293b; color: #fff; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 12px; }
        .badge-on  { background: #1e293b; color: #fff; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 12px; }
        .badge-off { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 12px; }
        .btn-config { font-size: 13px; font-weight: 500; color: #475569; text-decoration: none; padding: 7px 14px; border: 1px solid #e2e8f0; border-radius: 6px; background: #fff; cursor: pointer; font-family: 'Inter', sans-serif; width: 100%; margin-top: 12px; display: block; text-align: center; }
        .btn-config:hover { background: #f1f5f9; }
        .sysinfo-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        .sysinfo-row:last-child { border-bottom: none; }
        .sysinfo-key { color: #64748b; }
        .sysinfo-val { font-weight: 600; color: #1e293b; }
        .badge-healthy { background: #dcfce7; color: #166534; font-size: 12px; font-weight: 600; padding: 3px 10px; border-radius: 12px; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; font-size: 13px; padding: 10px 14px; border-radius: 8px; margin-bottom: 16px; }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand">
            <svg viewBox="0 0 28 28" fill="none"><rect width="28" height="28" rx="6" fill="#1e3a5f"/><rect x="6" y="8" width="16" height="3" rx="1.5" fill="#fff"/><rect x="6" y="13" width="10" height="3" rx="1.5" fill="#fff"/><rect x="6" y="18" width="13" height="3" rx="1.5" fill="#fff"/></svg>
            Admin Panel
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
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
            <a href="{{ route('admin.settings') }}" class="nav-item active">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
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
            <h1 class="page-title">Settings</h1>
            <p class="page-sub">Manage your store settings and preferences</p>

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <div class="settings-grid">
                <!-- General Settings -->
                <div class="panel">
                    <div class="panel-title">General Settings</div>
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Store Name</label>
                            <input class="form-input" type="text" value="E-Commerce Store" name="store_name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Store Email</label>
                            <input class="form-input" type="email" value="store@eshop.ph" name="store_email">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Store Phone</label>
                            <input class="form-input" type="text" value="+63 (2) 8123-4567" name="store_phone">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Store Address</label>
                            <input class="form-input" type="text" value="123 Commerce St., Makati City" name="store_address">
                        </div>
                        <button type="submit" class="btn-save">Save Changes</button>
                    </form>
                </div>

                <!-- Shipping Settings -->
                <div class="panel">
                    <div class="panel-title">Shipping Settings</div>
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Free Shipping Threshold</label>
                            <input class="form-input" type="number" value="1500" name="free_shipping_threshold">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Metro Manila Rate</label>
                            <input class="form-input" type="number" value="80" name="metro_rate">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Provincial Rate</label>
                            <input class="form-input" type="number" value="120" name="provincial_rate">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Order Processing Time (days)</label>
                            <input class="form-input" type="number" value="2" name="processing_days">
                        </div>
                        <button type="submit" class="btn-save">Save Changes</button>
                    </form>
                </div>

                <!-- Payment Methods -->
                <div class="panel">
                    <div class="panel-title">Payment Methods</div>
                    <div class="method-row">
                        <div>
                            <div class="method-name">Cash on Delivery</div>
                            <div class="method-sub">Accept COD payments</div>
                        </div>
                        <span class="badge-enabled">Enabled</span>
                    </div>
                    <div class="method-row">
                        <div>
                            <div class="method-name">E-Wallet</div>
                            <div class="method-sub">GCash, PayMaya</div>
                        </div>
                        <span class="badge-enabled">Enabled</span>
                    </div>
                    <div class="method-row">
                        <div>
                            <div class="method-name">Online Banking</div>
                            <div class="method-sub">Bank transfers</div>
                        </div>
                        <span class="badge-enabled">Enabled</span>
                    </div>
                    <button class="btn-config">Configure Payment Methods</button>
                </div>

                <!-- Notifications -->
                <div class="panel">
                    <div class="panel-title">Notifications</div>
                    <div class="method-row">
                        <div>
                            <div class="method-name">Order Notifications</div>
                            <div class="method-sub">Get notified of new orders</div>
                        </div>
                        <span class="badge-on">On</span>
                    </div>
                    <div class="method-row">
                        <div>
                            <div class="method-name">Low Stock Alerts</div>
                            <div class="method-sub">Alert when stock is low</div>
                        </div>
                        <span class="badge-on">On</span>
                    </div>
                    <div class="method-row">
                        <div>
                            <div class="method-name">Email Reports</div>
                            <div class="method-sub">Daily sales reports</div>
                        </div>
                        <span class="badge-off">Off</span>
                    </div>
                    <button class="btn-config">Manage Notifications</button>
                </div>

                <!-- Security -->
                <div class="panel">
                    <div class="panel-title">Security</div>
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Current Password</label>
                            <input class="form-input" type="password" name="current_password" placeholder="••••••••">
                        </div>
                        <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input class="form-input" type="password" name="new_password" placeholder="••••••••">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input class="form-input" type="password" name="confirm_password" placeholder="••••••••">
                        </div>
                        <button type="submit" class="btn-save">Update Password</button>
                    </form>
                </div>

                <!-- System Information -->
                <div class="panel">
                    <div class="panel-title">System Information</div>
                    <div class="sysinfo-row">
                        <span class="sysinfo-key">Version</span>
                        <span class="sysinfo-val">1.0.0</span>
                    </div>
                    <div class="sysinfo-row">
                        <span class="sysinfo-key">Database Size</span>
                        <span class="sysinfo-val">124 MB</span>
                    </div>
                    <div class="sysinfo-row">
                        <span class="sysinfo-key">Last Backup</span>
                        <span class="sysinfo-val">{{ \Carbon\Carbon::now()->subDays(3)->format('F d, Y') }}</span>
                    </div>
                    <div class="sysinfo-row">
                        <span class="sysinfo-key">System Status</span>
                        <span class="badge-healthy">Healthy</span>
                    </div>
                    <button class="btn-config" style="margin-top:16px;">Backup Database</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
