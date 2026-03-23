<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customers - Admin Panel</title>
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
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 20px; }
        .page-title { font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .page-sub { font-size: 13px; color: #64748b; }
        .btn-add { display: flex; align-items: center; gap: 6px; padding: 10px 18px; background: #0f172a; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: 'Inter', sans-serif; text-decoration: none; }
        .btn-add:hover { background: #1e293b; }
        .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 22px; }
        .stat-card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 18px 20px; display: flex; align-items: center; justify-content: space-between; }
        .stat-label { font-size: 13px; color: #64748b; margin-bottom: 4px; }
        .stat-value { font-size: 22px; font-weight: 700; color: #1e293b; }
        .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .stat-icon.blue   { background: #dbeafe; color: #2563eb; }
        .stat-icon.green  { background: #dcfce7; color: #16a34a; }
        .stat-icon.purple { background: #f3e8ff; color: #9333ea; }
        .stat-icon svg { width: 20px; height: 20px; }
        .panel { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 22px; }
        .search-wrap { position: relative; margin-bottom: 20px; }
        .search-wrap svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 15px; height: 15px; color: #9ca3af; pointer-events: none; }
        .search-input { width: 100%; padding: 10px 14px 10px 38px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 14px; outline: none; font-family: 'Inter', sans-serif; color: #1e293b; background: #f9fafb; }
        .search-input:focus { border-color: #6b7280; background: #fff; }
        table { width: 100%; border-collapse: collapse; }
        thead th { font-size: 13px; font-weight: 600; color: #475569; text-align: left; padding: 10px 12px; border-bottom: 1px solid #e2e8f0; }
        tbody td { font-size: 14px; color: #1e293b; padding: 13px 12px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: #f8fafc; }
        .cust-id { font-size: 12px; font-weight: 600; color: #475569; font-family: monospace; }
        .status-active   { background: #1e293b; color: #fff; font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 12px; }
        .status-inactive { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 12px; }
        .action-btn { background: none; border: none; cursor: pointer; padding: 5px; border-radius: 6px; transition: background 0.15s; }
        .action-btn:hover { background: #f1f5f9; }
        .action-btn svg { color: #475569; width: 15px; height: 15px; }
        .btn-view { font-size: 13px; font-weight: 500; color: #475569; text-decoration: none; padding: 5px 12px; border: 1px solid #e2e8f0; border-radius: 6px; transition: background 0.15s; cursor: pointer; background: none; font-family: 'Inter', sans-serif; }
        .btn-view:hover { background: #f1f5f9; }

        /* ── Modal Overlay ── */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 100; align-items: center; justify-content: center; }
        .modal-overlay.active { display: flex; }

        /* ── View Customer Modal ── */
        .modal-box { background: #fff; border-radius: 14px; width: 100%; max-width: 560px; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.18); position: relative; }
        .modal-header { padding: 22px 24px 16px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: flex-start; justify-content: space-between; }
        .modal-header-info h2 { font-size: 20px; font-weight: 700; color: #1e293b; }
        .modal-header-info p { font-size: 13px; color: #64748b; margin-top: 2px; }
        .modal-close { background: none; border: none; cursor: pointer; color: #94a3b8; padding: 4px; border-radius: 6px; line-height: 1; }
        .modal-close:hover { color: #475569; background: #f1f5f9; }
        .modal-close svg { width: 18px; height: 18px; }
        .modal-body { padding: 20px 24px; }

        /* stats mini-row */
        .mini-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 20px; }
        .mini-stat { border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px; }
        .mini-stat-label { font-size: 11px; color: #64748b; margin-bottom: 6px; }
        .mini-stat-val { font-size: 17px; font-weight: 700; color: #1e293b; }
        .mini-stat-val.green { color: #16a34a; }
        .mini-stat-icon { width: 28px; height: 28px; border-radius: 7px; display: flex; align-items: center; justify-content: center; margin-bottom: 6px; }
        .mini-stat-icon.blue   { background: #dbeafe; color: #2563eb; }
        .mini-stat-icon.green  { background: #dcfce7; color: #16a34a; }
        .mini-stat-icon.orange { background: #ffedd5; color: #ea580c; }
        .mini-stat-icon.teal   { background: #ccfbf1; color: #0d9488; }
        .mini-stat-icon svg { width: 14px; height: 14px; }

        /* sections */
        .section-title { font-size: 13px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 7px; margin-bottom: 12px; }
        .section-title svg { width: 15px; height: 15px; color: #64748b; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 20px; }
        .info-cell { border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px; display: flex; align-items: flex-start; gap: 10px; }
        .info-cell-icon { color: #64748b; margin-top: 1px; flex-shrink: 0; }
        .info-cell-icon svg { width: 15px; height: 15px; }
        .info-cell-label { font-size: 11px; color: #94a3b8; margin-bottom: 2px; }
        .info-cell-val { font-size: 13px; font-weight: 500; color: #1e293b; }

        /* activity */
        .activity-section { margin-bottom: 20px; }
        .activity-row { display: flex; align-items: flex-start; justify-content: space-between; padding: 11px 0; border-bottom: 1px solid #f1f5f9; }
        .activity-row:last-child { border-bottom: none; }
        .activity-label { font-size: 13px; font-weight: 600; color: #1e293b; }
        .activity-sub { font-size: 11px; color: #94a3b8; margin-top: 2px; }
        .activity-val { font-size: 13px; font-weight: 600; color: #1e293b; }
        .activity-val.green { color: #16a34a; }
        .activity-val.blue  { color: #2563eb; }

        /* purchase summary */
        .purchase-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 20px; }
        .purchase-card { border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px; }
        .purchase-card-label { font-size: 11px; color: #64748b; margin-bottom: 6px; }
        .purchase-card-val { font-size: 22px; font-weight: 700; }
        .purchase-card-val.green  { color: #16a34a; }
        .purchase-card-val.yellow { color: #ca8a04; }
        .purchase-card-val.red    { color: #dc2626; }

        /* insights */
        .insights-section { margin-bottom: 4px; }
        .insight-row { margin-bottom: 12px; }
        .insight-row-label { font-size: 12px; color: #64748b; margin-bottom: 6px; }
        .tag-list { display: flex; flex-wrap: wrap; gap: 6px; }
        .tag { font-size: 11px; font-weight: 500; padding: 3px 10px; border-radius: 12px; border: 1px solid #e2e8f0; color: #475569; background: #f8fafc; }
        .tag.dark { background: #1e293b; color: #fff; border-color: #1e293b; }

        /* modal footer */
        .modal-footer { padding: 16px 24px; border-top: 1px solid #f1f5f9; display: flex; gap: 10px; }
        .modal-footer-btn { flex: 1; display: flex; align-items: center; justify-content: center; gap: 7px; padding: 10px 0; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; border: 1px solid #e2e8f0; background: #fff; color: #1e293b; font-family: 'Inter', sans-serif; transition: background 0.15s; }
        .modal-footer-btn:hover { background: #f8fafc; }
        .modal-footer-btn svg { width: 14px; height: 14px; }

        /* ── Sub-modals (Send Email / Edit Customer) ── */
        .submodal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.55); z-index: 200; align-items: center; justify-content: center; padding: 16px; }
        .submodal-overlay.active { display: flex; }
        .submodal-box { background: #fff; border-radius: 14px; width: 100%; max-width: 500px; box-shadow: 0 24px 64px rgba(0,0,0,0.22); }
        .submodal-box.wide { max-width: 500px; }
        .submodal-header { padding: 22px 24px 16px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: flex-start; justify-content: space-between; }
        .submodal-header-info h3 { font-size: 18px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px; }
        .submodal-header-info h3 svg { width: 18px; height: 18px; color: #475569; }
        .submodal-header-info p { font-size: 13px; color: #64748b; margin-top: 3px; }
        .submodal-body { padding: 22px 24px; }
        .form-group { margin-bottom: 18px; }
        .form-label { font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 7px; display: block; }
        .form-input { width: 100%; padding: 11px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; color: #1e293b; outline: none; background: #f1f5f9; }
        .form-input:focus { border-color: #6b7280; background: #fff; }
        .form-input.readonly { background: #f1f5f9; color: #64748b; cursor: default; }
        textarea.form-input { resize: vertical; min-height: 140px; }
        .submodal-footer { padding: 18px 24px; border-top: 1px solid #f1f5f9; display: flex; gap: 10px; align-items: center; }
        .btn-cancel { flex: 1; padding: 11px 0; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; border: 1px solid #e2e8f0; background: #fff; color: #1e293b; font-family: 'Inter', sans-serif; transition: background 0.15s; text-align: center; }
        .btn-cancel:hover { background: #f1f5f9; }
        .btn-submit { flex: 2; padding: 11px 0; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; border: none; background: #0f172a; color: #fff; font-family: 'Inter', sans-serif; display: flex; align-items: center; justify-content: center; gap: 7px; transition: background 0.15s; }
        .btn-submit:hover { background: #1e293b; }
        .btn-submit svg { width: 14px; height: 14px; }

        /* toggle switch */
        .toggle-wrap { display: flex; align-items: center; gap: 10px; margin-top: 4px; }
        .toggle { position: relative; width: 40px; height: 22px; }
        .toggle input { opacity: 0; width: 0; height: 0; }
        .toggle-slider { position: absolute; inset: 0; background: #e2e8f0; border-radius: 22px; cursor: pointer; transition: background 0.2s; }
        .toggle-slider:before { content: ''; position: absolute; width: 16px; height: 16px; left: 3px; top: 3px; background: #fff; border-radius: 50%; transition: transform 0.2s; }
        .toggle input:checked + .toggle-slider { background: #1e293b; }
        .toggle input:checked + .toggle-slider:before { transform: translateX(18px); }
        .toggle-label { font-size: 13px; font-weight: 500; color: #1e293b; }
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
            <a href="{{ route('admin.customers') }}" class="nav-item active">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Customers
            </a>
            <a href="{{ route('admin.settings') }}" class="nav-item">
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
            <div class="page-header">
                <div>
                    <h1 class="page-title">Customer Management</h1>
                    <p class="page-sub">View and manage customer accounts</p>
                </div>
            </div>

            <div class="stats-row">
                <div class="stat-card">
                    <div>
                        <div class="stat-label">Total Customers</div>
                        <div class="stat-value">{{ $totalCustomers }}</div>
                    </div>
                    <div class="stat-icon blue">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                </div>
                <div class="stat-card">
                    <div>
                        <div class="stat-label">Active Customers</div>
                        <div class="stat-value">{{ $totalCustomers }}</div>
                    </div>
                    <div class="stat-icon green">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </div>
                </div>
                <div class="stat-card">
                    <div>
                        <div class="stat-label">Total Revenue</div>
                        <div class="stat-value">₱{{ number_format($totalRevenue, 0) }}</div>
                    </div>
                    <div class="stat-icon purple">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>

            <div class="panel">
                <form method="GET" action="{{ route('admin.customers') }}">
                    <div class="search-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
                        <input class="search-input" type="text" name="search" placeholder="Search customers..." value="{{ $search }}">
                    </div>
                </form>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Location</th>
                            <th>Orders</th>
                            <th>Total Spent</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                        <tr>
                            <td><span class="cust-id">CUST{{ str_pad($customer->id, 3, '0', STR_PAD_LEFT) }}</span></td>
                            <td style="font-weight:500;">{{ $customer->name }}</td>
                            <td style="color:#64748b;">{{ $customer->email }}</td>
                            <td style="color:#64748b;">—</td>
                            <td style="color:#64748b;">0</td>
                            <td style="color:#64748b;">₱0</td>
                            @php $isActive = $customer->created_at && $customer->created_at->diffInDays(now()) <= 7; @endphp
                            <td>
                                @if($isActive)
                                    <span class="status-active">Active</span>
                                @else
                                    <span class="status-inactive">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn-view" onclick="openViewModal({{ $customer->id }}, '{{ addslashes($customer->name) }}', '{{ addslashes($customer->email) }}', '{{ $customer->created_at ? $customer->created_at->format('M d, Y') : 'N/A' }}', {{ $isActive ? 'true' : 'false' }})">View</button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" style="text-align:center;color:#94a3b8;padding:32px;">No customers found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════
         VIEW CUSTOMER MODAL
    ══════════════════════════════════════════ -->
    <div class="modal-overlay" id="viewModal">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-header-info">
                    <h2 id="vm-name">Customer Name</h2>
                    <p id="vm-custid">Customer ID: —</p>
                </div>
                <button class="modal-close" onclick="closeViewModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="modal-body">

                <!-- Mini stats -->
                <div class="mini-stats">
                    <div class="mini-stat">
                        <div class="mini-stat-icon blue">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h11M10 19a1 1 0 100 2 1 1 0 000-2zm7 0a1 1 0 100 2 1 1 0 000-2z"/></svg>
                        </div>
                        <div class="mini-stat-label">Total Orders</div>
                        <div class="mini-stat-val">0</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-icon green">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="mini-stat-label">Total Spent</div>
                        <div class="mini-stat-val green">₱0</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-icon orange">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        </div>
                        <div class="mini-stat-label">Avg. Order</div>
                        <div class="mini-stat-val">₱0</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-icon teal">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div class="mini-stat-label">Status</div>
                        <div id="vm-status-badge"><span class="status-active" style="font-size:10px;">Active</span></div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="section-title">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Contact Information
                </div>
                <div class="info-grid">
                    <div class="info-cell">
                        <div class="info-cell-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                        <div>
                            <div class="info-cell-label">Email Address</div>
                            <div class="info-cell-val" id="vm-email">—</div>
                        </div>
                    </div>
                    <div class="info-cell">
                        <div class="info-cell-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                        <div>
                            <div class="info-cell-label">Location</div>
                            <div class="info-cell-val">—</div>
                        </div>
                    </div>
                    <div class="info-cell">
                        <div class="info-cell-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
                        <div>
                            <div class="info-cell-label">Phone Number</div>
                            <div class="info-cell-val">—</div>
                        </div>
                    </div>
                    <div class="info-cell">
                        <div class="info-cell-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                        <div>
                            <div class="info-cell-label">Member Since</div>
                            <div class="info-cell-val" id="vm-since">—</div>
                        </div>
                    </div>
                </div>

                <!-- Account Activity -->
                <div class="section-title">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Account Activity
                </div>
                <div class="activity-section">
                    <div class="activity-row">
                        <div>
                            <div class="activity-label">Last Order Date</div>
                            <div class="activity-sub">Most recent purchase</div>
                        </div>
                        <div class="activity-val">—</div>
                    </div>
                    <div class="activity-row">
                        <div>
                            <div class="activity-label">Account Created</div>
                            <div class="activity-sub">Registration date</div>
                        </div>
                        <div class="activity-val" id="vm-created">—</div>
                    </div>
                    <div class="activity-row">
                        <div>
                            <div class="activity-label">Customer Lifetime Value</div>
                            <div class="activity-sub">Total revenue generated</div>
                        </div>
                        <div class="activity-val green">₱0</div>
                    </div>
                    <div class="activity-row">
                        <div>
                            <div class="activity-label">Average Order Value</div>
                            <div class="activity-sub">Per transaction</div>
                        </div>
                        <div class="activity-val blue">₱0</div>
                    </div>
                </div>

                <!-- Purchase Summary -->
                <div class="section-title">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h11M10 19a1 1 0 100 2 1 1 0 000-2zm7 0a1 1 0 100 2 1 1 0 000-2z"/></svg>
                    Purchase Summary
                </div>
                <div class="purchase-grid">
                    <div class="purchase-card">
                        <div class="purchase-card-label">Completed Orders</div>
                        <div class="purchase-card-val green">0</div>
                    </div>
                    <div class="purchase-card">
                        <div class="purchase-card-label">Pending Orders</div>
                        <div class="purchase-card-val yellow">0</div>
                    </div>
                    <div class="purchase-card">
                        <div class="purchase-card-label">Cancelled Orders</div>
                        <div class="purchase-card-val red">0</div>
                    </div>
                </div>

                <!-- Customer Insights -->
                <div class="section-title">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Customer Insights
                </div>
                <div class="insights-section">
                    <div class="insight-row">
                        <div class="insight-row-label">Customer Tags</div>
                        <div class="tag-list">
                            <span class="tag">Regular Customer</span>
                        </div>
                    </div>
                    <div class="insight-row">
                        <div class="insight-row-label">Payment Preferences</div>
                        <div class="tag-list">
                            <span class="tag">—</span>
                        </div>
                    </div>
                    <div class="insight-row">
                        <div class="insight-row-label">Favorite Categories</div>
                        <div class="tag-list">
                            <span class="tag">—</span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="modal-footer-btn" id="vm-send-email-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Send Email
                </button>
                <button class="modal-footer-btn" id="vm-edit-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Customer
                </button>
                <button class="modal-footer-btn" onclick="closeViewModal()">Close</button>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════
         SEND EMAIL SUB-MODAL
    ══════════════════════════════════════════ -->
    <div class="submodal-overlay" id="sendEmailModal">
        <div class="submodal-box">
            <div class="submodal-header">
                <div class="submodal-header-info">
                    <h3>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Send Email
                    </h3>
                    <p id="sem-subtitle">Compose email to customer</p>
                </div>
                <button class="modal-close" onclick="closeSendEmailModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="submodal-body">
                <div class="form-group">
                    <label class="form-label">To</label>
                    <input type="text" class="form-input readonly" id="sem-to" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Subject <span style="color:#dc2626;">*</span></label>
                    <input type="text" class="form-input" id="sem-subject" placeholder="Enter email subject">
                </div>
                <div class="form-group">
                    <label class="form-label">Message <span style="color:#dc2626;">*</span></label>
                    <textarea class="form-input" id="sem-message" placeholder="Enter your message"></textarea>
                </div>
            </div>
            <div class="submodal-footer">
                <button class="btn-cancel" onclick="closeSendEmailModal()">Cancel</button>
                <button class="btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Send Email
                </button>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════
         EDIT CUSTOMER SUB-MODAL
    ══════════════════════════════════════════ -->
    <div class="submodal-overlay" id="editModal">
        <div class="submodal-box">
            <div class="submodal-header">
                <div class="submodal-header-info">
                    <h3>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Customer
                    </h3>
                    <p>Update customer information</p>
                </div>
                <button class="modal-close" onclick="closeEditModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="submodal-body">
                <input type="hidden" id="edit-id">
                <div class="form-group">
                    <label class="form-label">Full Name <span style="color:#dc2626;">*</span></label>
                    <input type="text" class="form-input" id="edit-name" placeholder="Full Name">
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address <span style="color:#dc2626;">*</span></label>
                    <input type="email" class="form-input" id="edit-email" placeholder="Email Address">
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-input" id="edit-phone" placeholder="Phone Number">
                </div>
                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-input" id="edit-location" placeholder="Location">
                </div>
            </div>
            <div class="submodal-footer">
                <button class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                <button class="btn-submit" onclick="submitEdit()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Save Changes
                </button>
            </div>
        </div>
    </div>

    <script>
        let activeCustomerId   = null;
        let activeCustomerName = null;
        let activeCustomerEmail= null;

        function openViewModal(id, name, email, since, isActive) {
            activeCustomerId    = id;
            activeCustomerName  = name;
            activeCustomerEmail = email;

            document.getElementById('vm-name').textContent   = name;
            document.getElementById('vm-custid').textContent = 'Customer ID: CUST' + String(id).padStart(3, '0');
            document.getElementById('vm-email').textContent  = email;
            document.getElementById('vm-since').textContent  = since;
            document.getElementById('vm-created').textContent= since;

            var badge = document.getElementById('vm-status-badge');
            if (isActive) {
                badge.innerHTML = '<span class="status-active" style="font-size:10px;">Active</span>';
            } else {
                badge.innerHTML = '<span class="status-inactive" style="font-size:10px;">Inactive</span>';
            }

            document.getElementById('viewModal').classList.add('active');
        }

        function closeViewModal() {
            document.getElementById('viewModal').classList.remove('active');
        }

        document.getElementById('vm-send-email-btn').addEventListener('click', function () {
            document.getElementById('sem-to').value      = activeCustomerEmail || '';
            document.getElementById('sem-subtitle').textContent = 'Compose email to ' + (activeCustomerName || 'customer');
            document.getElementById('sem-subject').value = '';
            document.getElementById('sem-message').value = '';
            document.getElementById('sendEmailModal').classList.add('active');
        });

        function closeSendEmailModal() {
            document.getElementById('sendEmailModal').classList.remove('active');
        }

        document.getElementById('vm-edit-btn').addEventListener('click', function () {
            openEditModal(activeCustomerId, activeCustomerName, activeCustomerEmail);
        });

        function openEditModal(id, name, email) {
            document.getElementById('edit-id').value    = id;
            document.getElementById('edit-name').value  = name;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-phone').value = '';
            document.getElementById('edit-location').value = '';
            document.getElementById('editModal').classList.add('active');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
        }

        function submitEdit() {
            closeEditModal();
        }

        document.getElementById('viewModal').addEventListener('click', function (e) {
            if (e.target === this) closeViewModal();
        });
        document.getElementById('sendEmailModal').addEventListener('click', function (e) {
            if (e.target === this) closeSendEmailModal();
        });
        document.getElementById('editModal').addEventListener('click', function (e) {
            if (e.target === this) closeEditModal();
        });
    </script>
</body>
</html>
