<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Orders - Admin Panel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; color: #1e293b; display: flex; min-height: 100vh; }

        /* ── Sidebar ── */
        .sidebar { width: 200px; background: #0f172a; color: #94a3b8; display: flex; flex-direction: column; position: fixed; top: 0; left: 0; height: 100vh; z-index: 50; }
        .sidebar-brand { display: flex; align-items: center; gap: 10px; padding: 20px 18px; font-weight: 700; font-size: 15px; color: #fff; border-bottom: 1px solid #1e293b; }
        .sidebar-brand svg { width: 28px; height: 28px; }
        .sidebar-nav { flex: 1; padding: 12px 0; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 11px 18px; font-size: 14px; font-weight: 500; color: #94a3b8; text-decoration: none; transition: background 0.15s, color 0.15s; cursor: pointer; border: none; background: none; width: 100%; text-align: left; }
        .nav-item:hover { background: #1e293b; color: #e2e8f0; }
        .nav-item.active { background: #1e3a5f; color: #fff; border-radius: 6px; margin: 0 8px; padding: 11px 10px; width: calc(100% - 16px); }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
        .sidebar-logout { padding: 16px 0; border-top: 1px solid #1e293b; }

        /* ── Main ── */
        .main { margin-left: 200px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 0 28px; height: 60px; display: flex; align-items: center; justify-content: flex-end; position: sticky; top: 0; z-index: 40; }
        .topbar-user { display: flex; align-items: center; gap: 10px; }
        .topbar-user .info { text-align: right; }
        .topbar-user .name { font-size: 14px; font-weight: 600; color: #1e293b; }
        .topbar-user .email { font-size: 12px; color: #64748b; }
        .avatar { width: 36px; height: 36px; border-radius: 50%; background: #334155; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; }
        .content { padding: 28px; flex: 1; }
        .page-title { font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .page-sub { font-size: 13px; color: #64748b; margin-bottom: 22px; }

        /* ── Table Panel ── */
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
        .status-badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .status-pending    { background: #fef9c3; color: #854d0e; }
        .status-processing { background: #dbeafe; color: #1e40af; }
        .status-shipped    { background: #dcfce7; color: #166534; }
        .status-delivered  { background: #f0fdf4; color: #15803d; }
        .status-cancelled  { background: #fee2e2; color: #991b1b; }
        .btn-view { font-size: 13px; font-weight: 500; color: #475569; text-decoration: none; padding: 5px 12px; border: 1px solid #e2e8f0; border-radius: 6px; transition: background 0.15s; cursor: pointer; background: none; font-family: 'Inter', sans-serif; }
        .btn-view:hover { background: #f1f5f9; }

        /* ── Modal Overlay ── */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(15,23,42,0.45); z-index: 100; align-items: center; justify-content: center; padding: 20px; }
        .modal-overlay.open { display: flex; }
        .modal { background: #fff; border-radius: 14px; width: 100%; max-width: 520px; max-height: 90vh; display: flex; flex-direction: column; box-shadow: 0 20px 60px rgba(0,0,0,0.18); animation: modalIn 0.18s ease; }
        @keyframes modalIn { from { opacity:0; transform:scale(0.96) translateY(8px); } to { opacity:1; transform:scale(1) translateY(0); } }

        /* ── Modal Header ── */
        .modal-header { padding: 20px 24px 0; display: flex; align-items: flex-start; justify-content: space-between; flex-shrink: 0; }
        .modal-header-left .modal-title { font-size: 18px; font-weight: 700; color: #1e293b; }
        .modal-header-left .modal-subtitle { font-size: 13px; color: #64748b; margin-top: 2px; }
        .modal-close { width: 30px; height: 30px; border-radius: 6px; border: none; background: none; cursor: pointer; color: #94a3b8; display: flex; align-items: center; justify-content: center; transition: background 0.15s, color 0.15s; flex-shrink: 0; }
        .modal-close:hover { background: #f1f5f9; color: #475569; }

        /* ── Modal Tabs ── */
        .modal-tabs { display: flex; gap: 0; padding: 16px 24px 0; border-bottom: 1px solid #e2e8f0; flex-shrink: 0; }
        .modal-tab { font-size: 13px; font-weight: 500; color: #64748b; padding: 8px 14px; border: none; background: none; cursor: pointer; border-bottom: 2px solid transparent; margin-bottom: -1px; transition: color 0.15s, border-color 0.15s; font-family: 'Inter', sans-serif; }
        .modal-tab:hover { color: #1e293b; }
        .modal-tab.active { color: #1d4ed8; border-bottom-color: #1d4ed8; font-weight: 600; }

        /* ── Modal Body ── */
        .modal-body { flex: 1; overflow-y: auto; padding: 20px 24px; }
        .tab-panel { display: none; }
        .tab-panel.active { display: block; }

        /* ── Overview Tab ── */
        .overview-stats { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; margin-bottom: 20px; }
        .stat-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 14px; }
        .stat-card .stat-label { font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 4px; }
        .stat-card .stat-value { font-size: 15px; font-weight: 700; color: #1e293b; }
        .stat-card .stat-value.green { color: #15803d; }
        .section-block { border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; margin-bottom: 16px; }
        .section-block:last-child { margin-bottom: 0; }
        .section-heading { display: flex; align-items: center; gap: 7px; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 14px; }
        .section-heading svg { width: 15px; height: 15px; color: #64748b; flex-shrink: 0; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .info-grid.cols-1 { grid-template-columns: 1fr; }
        .info-field .field-label { font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 3px; }
        .info-field .field-value { font-size: 14px; color: #1e293b; font-weight: 500; }
        .info-field .field-value.muted { color: #475569; font-weight: 400; }
        .address-block { font-size: 14px; color: #475569; line-height: 1.6; }

        /* ── Items Tab ── */
        .order-item-row { display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid #f1f5f9; }
        .order-item-row:last-of-type { border-bottom: none; }
        .item-img { width: 48px; height: 48px; border-radius: 8px; background: #f1f5f9; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden; }
        .item-img img { width: 100%; height: 100%; object-fit: cover; }
        .item-img svg { width: 22px; height: 22px; color: #94a3b8; }
        .item-info { flex: 1; min-width: 0; }
        .item-name { font-size: 14px; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .item-qty { font-size: 12px; color: #64748b; margin-top: 2px; }
        .item-price-col { text-align: right; flex-shrink: 0; }
        .item-price { font-size: 14px; font-weight: 700; color: #1e293b; }
        .item-unit-price { font-size: 12px; color: #94a3b8; margin-top: 2px; }
        .summary-block { margin-top: 16px; border-top: 1px solid #e2e8f0; padding-top: 14px; }
        .summary-row { display: flex; justify-content: space-between; align-items: center; font-size: 14px; color: #475569; margin-bottom: 8px; }
        .summary-row.total { font-size: 15px; font-weight: 700; color: #1e293b; border-top: 1px solid #e2e8f0; padding-top: 10px; margin-top: 4px; margin-bottom: 0; }
        .summary-row .ship-method { color: #1d4ed8; font-size: 13px; }

        /* ── Tracking Tab ── */
        .tracking-timeline { padding: 4px 0 8px; }
        .timeline-item { display: flex; gap: 14px; padding-bottom: 24px; position: relative; }
        .timeline-item:last-child { padding-bottom: 0; }
        .timeline-icon { flex-shrink: 0; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; position: relative; z-index: 1; }
        .timeline-icon.done { background: #dcfce7; border: 2px solid #16a34a; }
        .timeline-icon.done svg { color: #16a34a; }
        .timeline-icon.active { background: #dbeafe; border: 2px solid #3b82f6; }
        .timeline-icon.active svg { color: #3b82f6; }
        .timeline-icon.pending { background: #f1f5f9; border: 2px solid #cbd5e1; }
        .timeline-icon.pending svg { color: #94a3b8; }
        .timeline-icon svg { width: 13px; height: 13px; }
        .timeline-line { position: absolute; left: 13px; top: 28px; bottom: 0; width: 2px; background: #e2e8f0; z-index: 0; }
        .timeline-item:last-child .timeline-line { display: none; }
        .timeline-content { flex: 1; padding-top: 3px; }
        .timeline-content .tl-title { font-size: 14px; font-weight: 600; color: #1e293b; }
        .timeline-content .tl-desc { font-size: 13px; color: #64748b; margin-top: 3px; }
        .timeline-content .tl-time { font-size: 12px; color: #94a3b8; margin-top: 4px; }
        .est-delivery { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 12px 16px; margin-top: 16px; display: flex; align-items: center; gap: 10px; }
        .est-delivery svg { width: 16px; height: 16px; color: #3b82f6; flex-shrink: 0; }
        .est-delivery .ed-label { font-size: 12px; color: #64748b; margin-bottom: 2px; }
        .est-delivery .ed-date { font-size: 15px; font-weight: 700; color: #1d4ed8; }

        /* ── Modal Footer ── */
        .modal-footer { padding: 14px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; gap: 10px; }
        .btn-secondary { font-size: 13px; font-weight: 500; color: #475569; padding: 8px 18px; border: 1px solid #e2e8f0; border-radius: 7px; background: #fff; cursor: pointer; font-family: 'Inter', sans-serif; transition: background 0.15s; }
        .btn-secondary:hover { background: #f1f5f9; }
        .btn-primary { font-size: 13px; font-weight: 600; color: #fff; padding: 8px 18px; border: none; border-radius: 7px; background: #1d4ed8; cursor: pointer; font-family: 'Inter', sans-serif; display: flex; align-items: center; gap: 7px; transition: background 0.15s; }
        .btn-primary:hover { background: #1e40af; }
        .btn-primary svg { width: 14px; height: 14px; }

        /* ── Spinner ── */
        .modal-loading { display: flex; align-items: center; justify-content: center; padding: 48px 0; color: #94a3b8; font-size: 14px; gap: 10px; }
        .spinner { width: 20px; height: 20px; border: 2px solid #e2e8f0; border-top-color: #1d4ed8; border-radius: 50%; animation: spin 0.7s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
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
            <a href="{{ route('admin.orders') }}" class="nav-item active">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h11M10 19a1 1 0 100 2 1 1 0 000-2zm7 0a1 1 0 100 2 1 1 0 000-2z"/></svg>
                Orders
            </a>
            <a href="{{ route('admin.customers') }}" class="nav-item">
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
            <h1 class="page-title">Order Management</h1>
            <p class="page-sub">View and manage customer orders</p>

            <div class="panel">
                <form method="GET" action="{{ route('admin.orders') }}">
                    <div class="search-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
                        <input class="search-input" type="text" name="search" placeholder="Search orders..." value="{{ $search }}">
                    </div>
                </form>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td style="font-weight:600;">#{{ $order->id }}</td>
                            <td>{{ isset($order->first_name) ? $order->first_name.' '.$order->last_name : ($order->customer_name ?? 'N/A') }}</td>
                            <td style="color:#64748b;">{{ isset($order->created_at) ? \Carbon\Carbon::parse($order->created_at)->format('Y-m-d') : 'N/A' }}</td>
                            <td>{{ $order->items_count ?? '—' }}</td>
                            <td style="font-weight:600;">₱{{ number_format($order->total ?? 0, 2) }}</td>
                            <td><span class="status-badge status-{{ strtolower($order->status ?? 'pending') }}">{{ ucfirst($order->status ?? 'Pending') }}</span></td>
                            <td>
                                <button class="btn-view" onclick="openOrderModal({{ $order->id }})">View Details</button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" style="text-align:center;color:#94a3b8;padding:32px;">No orders found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════
         Order Details Modal
    ══════════════════════════════════════════ -->
    <div class="modal-overlay" id="orderModal" onclick="handleOverlayClick(event)">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-header-left">
                    <div class="modal-title">Order Details</div>
                    <div class="modal-subtitle" id="modalSubtitle">Loading…</div>
                </div>
                <button class="modal-close" onclick="closeModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="modal-tabs">
                <button class="modal-tab active" onclick="switchTab('overview', this)">Overview</button>
                <button class="modal-tab" onclick="switchTab('items', this)">Order Items</button>
                <button class="modal-tab" onclick="switchTab('tracking', this)">Tracking</button>
            </div>

            <div class="modal-body" id="modalBody">
                <div class="modal-loading"><div class="spinner"></div> Loading order…</div>
            </div>

            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>

    <script>
        const detailUrl = id => `/admin/orders/${id}`;
        let currentOrder = null;
        let currentTab = 'overview';

        function openOrderModal(id) {
            currentOrder = null;
            currentTab = 'overview';
            document.getElementById('modalSubtitle').textContent = 'Loading…';
            document.getElementById('modalBody').innerHTML = '<div class="modal-loading"><div class="spinner"></div> Loading order…</div>';
            document.querySelectorAll('.modal-tab').forEach((t, i) => t.classList.toggle('active', i === 0));
            document.getElementById('orderModal').classList.add('open');
            document.body.style.overflow = 'hidden';

            fetch(detailUrl(id), { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.json())
                .then(order => {
                    currentOrder = order;
                    document.getElementById('modalSubtitle').textContent = `Order ID: #${order.id}`;
                    renderTab('overview');
                })
                .catch(() => {
                    document.getElementById('modalBody').innerHTML = '<div class="modal-loading" style="color:#ef4444;">Failed to load order details.</div>';
                });
        }

        function closeModal() {
            document.getElementById('orderModal').classList.remove('open');
            document.body.style.overflow = '';
        }

        function handleOverlayClick(e) {
            if (e.target === document.getElementById('orderModal')) closeModal();
        }

        function switchTab(tab, el) {
            currentTab = tab;
            document.querySelectorAll('.modal-tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            if (currentOrder) renderTab(tab);
        }

        function renderTab(tab) {
            const body = document.getElementById('modalBody');
            if (tab === 'overview')  body.innerHTML = buildOverview(currentOrder);
            if (tab === 'items')     body.innerHTML = buildItems(currentOrder);
            if (tab === 'tracking')  body.innerHTML = buildTracking(currentOrder);
        }

        function fmt(n) {
            return '₱' + Number(n || 0).toLocaleString('en-PH', { minimumFractionDigits: 2 });
        }

        function fmtDate(d) {
            if (!d) return '—';
            return new Date(d).toISOString().split('T')[0];
        }

        function capitalize(s) {
            return s ? s.charAt(0).toUpperCase() + s.slice(1) : '—';
        }

        function statusClass(s) {
            const map = { pending: 'status-pending', processing: 'status-processing', shipped: 'status-shipped', delivered: 'status-delivered', cancelled: 'status-cancelled' };
            return map[(s || 'pending').toLowerCase()] || 'status-pending';
        }

        function buildOverview(o) {
            const fullName = `${o.first_name || ''} ${o.last_name || ''}`.trim() || '—';
            const trackingNum = o.tracking_number || '—';
            return `
            <div class="overview-stats">
                <div class="stat-card">
                    <div class="stat-label">Status</div>
                    <div><span class="status-badge ${statusClass(o.status)}">${capitalize(o.status)}</span></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Order Date</div>
                    <div class="stat-value">${fmtDate(o.created_at)}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Total Amount</div>
                    <div class="stat-value green">${fmt(o.total)}</div>
                </div>
            </div>

            <div class="section-block">
                <div class="section-heading">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Customer Information
                </div>
                <div class="info-grid">
                    <div class="info-field">
                        <div class="field-label">Name</div>
                        <div class="field-value">${fullName}</div>
                    </div>
                    <div class="info-field">
                        <div class="field-label">Email</div>
                        <div class="field-value muted">${o.email || '—'}</div>
                    </div>
                    <div class="info-field">
                        <div class="field-label">Phone</div>
                        <div class="field-value muted">${o.phone || '—'}</div>
                    </div>
                    <div class="info-field">
                        <div class="field-label">Tracking Number</div>
                        <div class="field-value muted">${trackingNum}</div>
                    </div>
                </div>
            </div>

            <div class="section-block">
                <div class="section-heading">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Shipping Address
                </div>
                <div class="address-block">
                    <strong>${fullName}</strong><br>
                    ${o.street || ''}<br>
                    ${[o.city, o.state, o.zip].filter(Boolean).join(', ')}<br>
                    ${o.country || ''}<br>
                    ${o.phone ? `<span style="color:#94a3b8">${o.phone}</span>` : ''}
                </div>
            </div>`;
        }

        function buildItems(o) {
            const items = o.items || [];
            const itemsHtml = items.length === 0
                ? '<p style="color:#94a3b8;font-size:14px;text-align:center;padding:24px 0;">No items found.</p>'
                : items.map(item => `
                    <div class="order-item-row">
                        <div class="item-img">
                            ${item.image ? `<img src="/storage/${item.image}" alt="">` : `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 9l4-4 4 4 4-4 4 4"/></svg>`}
                        </div>
                        <div class="item-info">
                            <div class="item-name">${item.product_name || 'Product'}</div>
                            <div class="item-qty">Quantity: ${item.quantity || 1}</div>
                        </div>
                        <div class="item-price-col">
                            <div class="item-price">${fmt(item.subtotal || item.price * item.quantity)}</div>
                            <div class="item-unit-price">${fmt(item.price)}</div>
                        </div>
                    </div>`).join('');

            const subtotal = parseFloat(o.subtotal || 0);
            const shipping = parseFloat(o.shipping_cost || 0);
            const total    = parseFloat(o.total || 0);
            const shipMethod = o.shipping_method ? capitalize(o.shipping_method) : 'Standard';

            return `
            <div class="section-heading" style="margin-bottom:4px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h11M10 19a1 1 0 100 2 1 1 0 000-2zm7 0a1 1 0 100 2 1 1 0 000-2z"/></svg>
                Order Items (${items.length})
            </div>
            <div style="border:1px solid #e2e8f0;border-radius:10px;padding:4px 14px 0;">
                ${itemsHtml}
            </div>
            <div class="summary-block">
                <div style="font-size:13px;font-weight:700;color:#334155;margin-bottom:10px;">Order Summary</div>
                <div class="summary-row"><span>Subtotal</span><span>${fmt(subtotal)}</span></div>
                <div class="summary-row"><span>Shipping <span class="ship-method">(${shipMethod} Shipping)</span></span><span>${fmt(shipping)}</span></div>
                <div class="summary-row total"><span>Total</span><span>${fmt(total)}</span></div>
            </div>`;
        }

        function buildTracking(o) {
            const status = (o.status || 'pending').toLowerCase();
            const steps = [
                { key: 'pending',    label: 'Pending',    desc: 'Order received and is being processed.' },
                { key: 'processing', label: 'Processing', desc: 'Order is being packed and prepared for shipment.' },
                { key: 'shipped',    label: 'Shipped',    desc: 'Order has been shipped and is on its way to the customer.' },
                { key: 'delivered',  label: 'Delivered',  desc: 'Order has been delivered successfully.' },
            ];

            const order = ['pending', 'processing', 'shipped', 'delivered'];
            const currentIndex = order.indexOf(status);

            const isCancelled = status === 'cancelled';

            const timelineHtml = isCancelled
                ? `<div style="text-align:center;padding:28px 0;color:#ef4444;font-size:14px;font-weight:600;">This order has been cancelled.</div>`
                : steps.map((step, i) => {
                    let iconType = 'pending';
                    if (i < currentIndex) iconType = 'done';
                    else if (i === currentIndex) iconType = 'active';

                    const checkIcon = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`;
                    const circleIcon = `<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/></svg>`;

                    return `
                    <div class="timeline-item">
                        <div style="position:relative;display:flex;flex-direction:column;align-items:center;">
                            <div class="timeline-icon ${iconType}">${iconType === 'done' ? checkIcon : circleIcon}</div>
                            <div class="timeline-line"></div>
                        </div>
                        <div class="timeline-content">
                            <div class="tl-title">${step.label}</div>
                            <div class="tl-desc">${step.desc}</div>
                            ${i <= currentIndex ? `<div class="tl-time">${fmtDate(o.created_at)} • Processing Center</div>` : ''}
                        </div>
                    </div>`;
                }).join('');

            const estDelivery = o.estimated_delivery || (() => {
                const d = new Date(o.created_at || Date.now());
                d.setDate(d.getDate() + 7);
                return d.toISOString().split('T')[0];
            })();

            return `
            <div class="section-heading" style="margin-bottom:12px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                Order Tracking
            </div>
            <div class="tracking-timeline">${timelineHtml}</div>
            ${!isCancelled ? `
            <div class="est-delivery">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <div>
                    <div class="ed-label">Estimated Delivery</div>
                    <div class="ed-date">${estDelivery}</div>
                </div>
            </div>` : ''}`;
        }

        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
    </script>
</body>
</html>
