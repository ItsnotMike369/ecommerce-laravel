<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products - Admin Panel</title>
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
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 22px; }
        .page-title { font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .page-sub { font-size: 13px; color: #64748b; }
        .btn-add { display: flex; align-items: center; gap: 6px; padding: 10px 18px; background: #0f172a; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: 'Inter', sans-serif; text-decoration: none; }
        .btn-add:hover { background: #1e293b; }

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

        .stock-badge { display: inline-flex; align-items: center; justify-content: center; padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: 700; min-width: 36px; }
        .stock-ok  { background: #1e293b; color: #fff; }
        .stock-low { background: #dc2626; color: #fff; }

        .action-btn { background: none; border: none; cursor: pointer; padding: 5px; border-radius: 6px; transition: background 0.15s; }
        .action-btn:hover { background: #f1f5f9; }
        .action-btn.edit svg { color: #475569; width: 16px; height: 16px; }
        .action-btn.del svg  { color: #dc2626; width: 16px; height: 16px; }

        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; font-size: 13px; padding: 10px 14px; border-radius: 8px; margin-bottom: 16px; }

        /* Modal overlay */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.55); z-index: 200; align-items: flex-start; justify-content: center; overflow-y: auto; padding: 32px 16px; }
        .modal-overlay.open { display: flex; }
        .modal { background: #fff; border-radius: 14px; width: 100%; max-width: 560px; margin: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.2); display: flex; flex-direction: column; }
        .modal-header { display: flex; align-items: center; justify-content: space-between; padding: 20px 24px 16px; border-bottom: 1px solid #f1f5f9; }
        .modal-title { font-size: 17px; font-weight: 700; color: #0f172a; }
        .modal-close { background: none; border: none; cursor: pointer; color: #94a3b8; padding: 4px; border-radius: 6px; line-height: 1; }
        .modal-close:hover { background: #f1f5f9; color: #475569; }
        .modal-body { padding: 20px 24px; overflow-y: auto; }
        .modal-footer { padding: 16px 24px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 10px; }

        .section-heading { font-size: 13px; font-weight: 700; color: #0f172a; margin-bottom: 14px; padding-bottom: 6px; border-bottom: 1px solid #f1f5f9; }
        .form-section { margin-bottom: 22px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-group { display: flex; flex-direction: column; gap: 5px; margin-bottom: 14px; }
        .form-group:last-child { margin-bottom: 0; }
        .form-label { font-size: 12px; font-weight: 600; color: #374151; }
        .form-input, .form-select, .form-textarea { width: 100%; padding: 9px 12px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 13px; font-family: 'Inter', sans-serif; color: #1e293b; background: #f9fafb; outline: none; transition: border-color 0.15s; }
        .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: #6b7280; background: #fff; }
        .form-textarea { resize: vertical; min-height: 80px; }
        .form-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; padding-right: 28px; }

        .image-preview-box { border: 2px dashed #e2e8f0; border-radius: 10px; background: #f8fafc; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 32px 16px; margin-bottom: 14px; min-height: 130px; }
        .image-preview-box svg { color: #cbd5e1; margin-bottom: 6px; }
        .image-preview-box span { font-size: 12px; color: #94a3b8; }
        .image-preview-box img { max-width: 100%; max-height: 120px; border-radius: 6px; object-fit: contain; }
        .upload-hint { font-size: 11px; color: #94a3b8; margin-top: 4px; }

        .upload-btn-label { display: flex; align-items: center; justify-content: center; gap: 6px; padding: 9px 12px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 13px; font-weight: 500; color: #374151; background: #f9fafb; cursor: pointer; transition: border-color 0.15s, background 0.15s; font-family: 'Inter', sans-serif; }
        .upload-btn-label:hover { background: #f1f5f9; border-color: #6b7280; }
        .upload-btn-label svg { color: #6b7280; }

        .or-divider { text-align: center; font-size: 12px; color: #94a3b8; margin: 10px 0; position: relative; }
        .or-divider::before, .or-divider::after { content: ''; position: absolute; top: 50%; width: 44%; height: 1px; background: #e5e7eb; }
        .or-divider::before { left: 0; }
        .or-divider::after { right: 0; }

        .checkbox-group { display: flex; flex-direction: column; gap: 12px; }
        .checkbox-item { display: flex; align-items: flex-start; gap: 12px; padding: 12px 14px; border: 1.5px solid #e5e7eb; border-radius: 10px; cursor: pointer; transition: border-color 0.15s, background 0.15s; }
        .checkbox-item:hover { border-color: #94a3b8; background: #f8fafc; }
        .checkbox-item input[type="checkbox"] { width: 16px; height: 16px; margin-top: 2px; accent-color: #0f172a; flex-shrink: 0; cursor: pointer; }
        .checkbox-item .cb-text .cb-title { font-size: 13px; font-weight: 600; color: #1e293b; }
        .checkbox-item .cb-text .cb-desc { font-size: 12px; color: #64748b; margin-top: 1px; }

        .btn-cancel { padding: 9px 20px; background: #f1f5f9; color: #374151; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Inter', sans-serif; }
        .btn-cancel:hover { background: #e2e8f0; }
        .btn-submit { display: flex; align-items: center; gap: 6px; padding: 9px 22px; background: #0f172a; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Inter', sans-serif; }
        .btn-submit:hover { background: #1e293b; }

        @media(max-width:520px){ .form-row { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <!-- Sidebar -->
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
            <a href="{{ route('admin.products') }}" class="nav-item active">
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
                    <h1 class="page-title">Product Management</h1>
                    <p class="page-sub">Manage your product inventory</p>
                </div>
                <button type="button" class="btn-add" onclick="openModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Add Product
                </button>
            </div>

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <div class="panel">
                <form method="GET" action="{{ route('admin.products') }}">
                    <div class="search-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
                        <input class="search-input" type="text" name="search" placeholder="Search products..." value="{{ $search }}">
                    </div>
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td style="font-weight:500;">{{ $product->name }}</td>
                            <td style="color:#64748b;">{{ $product->category->name ?? 'N/A' }}</td>
                            <td>₱{{ number_format($product->price, 2) }}</td>
                            <td>
                                <span class="stock-badge {{ $product->stock < 30 ? 'stock-low' : 'stock-ok' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td>
                                <button class="action-btn edit" title="Edit"
                                    onclick="openEditModal({
                                        id: {{ $product->id }},
                                        name: {{ json_encode($product->name) }},
                                        sku: {{ json_encode($product->sku) }},
                                        brand: {{ json_encode($product->brand) }},
                                        category_id: {{ $product->category_id ?? 'null' }},
                                        description: {{ json_encode($product->description) }},
                                        price: {{ json_encode($product->price) }},
                                        sale_price: {{ json_encode($product->sale_price) }},
                                        stock: {{ json_encode($product->stock) }},
                                        weight: {{ json_encode($product->weight) }},
                                        dimensions: {{ json_encode($product->dimensions) }},
                                        image: {{ json_encode($product->image ? Storage::disk('public')->url($product->image) : null) }},
                                        tags: {{ json_encode($product->tags) }},
                                        is_featured: {{ $product->is_featured ? 'true' : 'false' }},
                                        is_hot_offer: {{ $product->is_hot_offer ? 'true' : 'false' }},
                                        is_new_arrival: {{ $product->is_new_arrival ? 'true' : 'false' }}
                                    })">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form method="POST" action="{{ route('admin.products.delete', $product->id) }}" style="display:inline;" onsubmit="return confirm('Delete this product?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn del" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" style="text-align:center;color:#94a3b8;padding:32px;">No products found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add New Product Modal -->
    <div class="modal-overlay" id="addProductModal" onclick="handleOverlayClick(event)">
        <div class="modal">
            <div class="modal-header">
                <span class="modal-title">Add New Product</span>
                <button type="button" class="modal-close" onclick="closeModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" id="addProductForm">
                @csrf
                <div class="modal-body">

                    <!-- Basic Information -->
                    <div class="form-section">
                        <p class="section-heading">Basic Information</p>

                        <div class="form-group">
                            <label class="form-label" for="prod_name">Product Name *</label>
                            <input type="text" id="prod_name" name="name" class="form-input" placeholder="Enter product name" required value="{{ old('name') }}">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="prod_sku">SKU / Product Code</label>
                                <input type="text" id="prod_sku" name="sku" class="form-input" placeholder="e.g., PROD-001" value="{{ old('sku') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="prod_brand">Brand</label>
                                <input type="text" id="prod_brand" name="brand" class="form-input" placeholder="Enter brand name" value="{{ old('brand') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="prod_category">Category *</label>
                            <select id="prod_category" name="category_id" class="form-select" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="prod_desc">Description</label>
                            <textarea id="prod_desc" name="description" class="form-textarea" placeholder="Enter detailed product description">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <!-- Pricing & Inventory -->
                    <div class="form-section">
                        <p class="section-heading">Pricing &amp; Inventory</p>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="prod_price">Regular Price (₱) *</label>
                                <input type="number" id="prod_price" name="price" class="form-input" placeholder="0.00" min="0" step="0.01" required value="{{ old('price') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="prod_sale_price">Sale Price (₱)</label>
                                <input type="number" id="prod_sale_price" name="sale_price" class="form-input" placeholder="0.00 (optional)" min="0" step="0.01" value="{{ old('sale_price') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="prod_stock">Stock Quantity *</label>
                            <input type="number" id="prod_stock" name="stock" class="form-input" placeholder="0" min="0" required value="{{ old('stock') }}">
                        </div>
                    </div>

                    <!-- Shipping -->
                    <div class="form-section">
                        <p class="section-heading">Shipping</p>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="prod_weight">Weight (kg)</label>
                                <input type="text" id="prod_weight" name="weight" class="form-input" placeholder="e.g., 0.5" value="{{ old('weight') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="prod_dimensions">Dimensions (L x W x H cm)</label>
                                <input type="text" id="prod_dimensions" name="dimensions" class="form-input" placeholder="e.g., 20 x 15 x 10" value="{{ old('dimensions') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Product Image -->
                    <div class="form-section">
                        <p class="section-heading">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-right:4px;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21"/></svg>
                            Product Image
                        </p>

                        <div class="image-preview-box" id="imagePreviewBox">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21"/></svg>
                            <span id="previewLabel">No image selected</span>
                            <span class="upload-hint">Upload or enter Image URL below</span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Upload Image File</label>
                            <label class="upload-btn-label" for="prod_image_file">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                Click to upload or drag and drop
                            </label>
                            <input type="file" id="prod_image_file" name="image_file" accept="image/*" style="display:none;" onchange="previewImage(event)">
                            <span class="upload-hint">PNG, JPG, GIF up to 10MB</span>
                        </div>

                    </div>

                    <!-- Tags & Keywords -->
                    <div class="form-section">
                        <p class="section-heading">Tags &amp; Keywords</p>

                        <div class="form-group">
                            <label class="form-label" for="prod_tags">Product Tags</label>
                            <input type="text" id="prod_tags" name="tags" class="form-input" placeholder="e.g., wireless, portable, bluetooth (comma separated)" value="{{ old('tags') }}">
                            <span class="upload-hint">Separate tags with commas for better searchability</span>
                        </div>
                    </div>

                    <!-- Product Visibility -->
                    <div class="form-section" style="margin-bottom:0;">
                        <p class="section-heading">Product Visibility</p>

                        <div class="checkbox-group">
                            <label class="checkbox-item">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <div class="cb-text">
                                    <div class="cb-title">Featured Product</div>
                                    <div class="cb-desc">Show this product in featured section</div>
                                </div>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="is_hot_offer" value="1" {{ old('is_hot_offer') ? 'checked' : '' }}>
                                <div class="cb-text">
                                    <div class="cb-title">Hot Offer</div>
                                    <div class="cb-desc">Mark as a special offer</div>
                                </div>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="is_new_arrival" value="1" {{ old('is_new_arrival') ? 'checked' : '' }}>
                                <div class="cb-text">
                                    <div class="cb-title">New Arrival</div>
                                    <div class="cb-desc">Display in new arrivals section</div>
                                </div>
                            </label>
                        </div>
                    </div>

                </div><!-- /.modal-body -->

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Add Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal-overlay" id="editProductModal" onclick="handleEditOverlayClick(event)">
        <div class="modal">
            <div class="modal-header">
                <span class="modal-title">Edit Product</span>
                <button type="button" class="modal-close" onclick="closeEditModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form method="POST" id="editProductForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">

                    <!-- Basic Information -->
                    <div class="form-section">
                        <p class="section-heading">Basic Information</p>

                        <div class="form-group">
                            <label class="form-label" for="edit_name">Product Name *</label>
                            <input type="text" id="edit_name" name="name" class="form-input" placeholder="Enter product name" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="edit_sku">SKU / Product Code</label>
                                <input type="text" id="edit_sku" name="sku" class="form-input" placeholder="e.g., PROD-001">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="edit_brand">Brand</label>
                                <input type="text" id="edit_brand" name="brand" class="form-input" placeholder="Enter brand name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="edit_category">Category *</label>
                            <select id="edit_category" name="category_id" class="form-select" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="edit_desc">Description</label>
                            <textarea id="edit_desc" name="description" class="form-textarea" placeholder="Enter detailed product description"></textarea>
                        </div>
                    </div>

                    <!-- Pricing & Inventory -->
                    <div class="form-section">
                        <p class="section-heading">Pricing &amp; Inventory</p>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="edit_price">Regular Price (₱) *</label>
                                <input type="number" id="edit_price" name="price" class="form-input" placeholder="0.00" min="0" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="edit_sale_price">Sale Price (₱)</label>
                                <input type="number" id="edit_sale_price" name="sale_price" class="form-input" placeholder="0.00 (optional)" min="0" step="0.01">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="edit_stock">Stock Quantity *</label>
                            <input type="number" id="edit_stock" name="stock" class="form-input" placeholder="0" min="0" required>
                        </div>
                    </div>

                    <!-- Shipping Details -->
                    <div class="form-section">
                        <p class="section-heading">Shipping Details</p>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="edit_weight">Weight (kg)</label>
                                <input type="text" id="edit_weight" name="weight" class="form-input" placeholder="e.g., 0.5">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="edit_dimensions">Dimensions (L x W x H cm)</label>
                                <input type="text" id="edit_dimensions" name="dimensions" class="form-input" placeholder="e.g., 20 x 15 x 10">
                            </div>
                        </div>
                    </div>

                    <!-- Product Image -->
                    <div class="form-section">
                        <p class="section-heading">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-right:4px;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21"/></svg>
                            Product Image
                        </p>

                        <div class="image-preview-box" id="editImagePreviewBox">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21"/></svg>
                            <span>No image selected</span>
                            <span class="upload-hint">Upload or enter Image URL below</span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Upload Image File</label>
                            <label class="upload-btn-label" for="edit_image_file">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                Click to upload or drag and drop
                            </label>
                            <input type="file" id="edit_image_file" name="image_file" accept="image/*" style="display:none;" onchange="editPreviewImage(event)">
                            <span class="upload-hint">PNG, JPG, GIF up to 10MB</span>
                        </div>

                        <div class="or-divider">or</div>

                        <div class="form-group">
                            <label class="form-label" for="edit_image_url">Image URL</label>
                            <input type="text" id="edit_image_url" name="image_url" class="form-input" placeholder="Paste an image URL from the web" oninput="editPreviewUrl(this.value)">
                        </div>
                    </div>

                    <!-- Tags & Keywords -->
                    <div class="form-section">
                        <p class="section-heading">Tags &amp; Keywords</p>

                        <div class="form-group">
                            <label class="form-label" for="edit_tags">Product Tags</label>
                            <input type="text" id="edit_tags" name="tags" class="form-input" placeholder="e.g., wireless, portable, bluetooth (comma separated)">
                            <span class="upload-hint">Separate tags with commas for better searchability</span>
                        </div>
                    </div>

                    <!-- Product Visibility -->
                    <div class="form-section" style="margin-bottom:0;">
                        <p class="section-heading">Product Visibility</p>

                        <div class="checkbox-group">
                            <label class="checkbox-item">
                                <input type="checkbox" id="edit_is_featured" name="is_featured" value="1">
                                <div class="cb-text">
                                    <div class="cb-title">Featured Product</div>
                                    <div class="cb-desc">Show this product in featured section</div>
                                </div>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" id="edit_is_hot_offer" name="is_hot_offer" value="1">
                                <div class="cb-text">
                                    <div class="cb-title">Hot Offer</div>
                                    <div class="cb-desc">Mark as a special offer</div>
                                </div>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" id="edit_is_new_arrival" name="is_new_arrival" value="1">
                                <div class="cb-text">
                                    <div class="cb-title">New Arrival</div>
                                    <div class="cb-desc">Display in new arrivals section</div>
                                </div>
                            </label>
                        </div>
                    </div>

                </div><!-- /.modal-body -->

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('addProductModal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeModal() {
            document.getElementById('addProductModal').classList.remove('open');
            document.body.style.overflow = '';
        }
        function handleOverlayClick(e) {
            if (e.target === document.getElementById('addProductModal')) closeModal();
        }
        function previewImage(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                showPreview(e.target.result);
            };
            reader.readAsDataURL(file);
        }
        function showPreview(src) {
            const box = document.getElementById('imagePreviewBox');
            box.innerHTML = '<img src="' + src + '" alt="Preview" onerror="resetPreview()">';
        }
        function resetPreview() {
            const box = document.getElementById('imagePreviewBox');
            box.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21"/></svg><span id="previewLabel">No image selected</span><span class="upload-hint">Upload or enter Image URL below</span>';
        }
        @if($errors->any())
            openModal();
        @endif

        function openEditModal(p) {
            const form = document.getElementById('editProductForm');
            form.action = '/admin/products/' + p.id;

            document.getElementById('edit_name').value        = p.name || '';
            document.getElementById('edit_sku').value         = p.sku || '';
            document.getElementById('edit_brand').value       = p.brand || '';
            document.getElementById('edit_desc').value        = p.description || '';
            document.getElementById('edit_price').value       = p.price || '';
            document.getElementById('edit_sale_price').value  = p.sale_price || '';
            document.getElementById('edit_stock').value       = p.stock || '';
            document.getElementById('edit_weight').value      = p.weight || '';
            document.getElementById('edit_dimensions').value  = p.dimensions || '';
            document.getElementById('edit_tags').value        = p.tags || '';
            document.getElementById('edit_image_url').value   = '';
            document.getElementById('edit_image_file').value  = '';

            const catSelect = document.getElementById('edit_category');
            catSelect.value = p.category_id || '';

            document.getElementById('edit_is_featured').checked   = !!p.is_featured;
            document.getElementById('edit_is_hot_offer').checked  = !!p.is_hot_offer;
            document.getElementById('edit_is_new_arrival').checked = !!p.is_new_arrival;

            const box = document.getElementById('editImagePreviewBox');
            if (p.image) {
                box.innerHTML = '<img src="' + p.image + '" alt="Image Preview" style="max-width:100%;max-height:160px;border-radius:6px;object-fit:contain;"><div style="font-size:12px;color:#64748b;margin-top:6px;">Image Preview</div>';
            } else {
                box.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21"/></svg><span>No image selected</span><span class="upload-hint">Upload or enter Image URL below</span>';
            }

            document.getElementById('editProductModal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeEditModal() {
            document.getElementById('editProductModal').classList.remove('open');
            document.body.style.overflow = '';
        }
        function handleEditOverlayClick(e) {
            if (e.target === document.getElementById('editProductModal')) closeEditModal();
        }
        function editPreviewImage(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                const box = document.getElementById('editImagePreviewBox');
                box.innerHTML = '<img src="' + e.target.result + '" alt="Preview" style="max-width:100%;max-height:160px;border-radius:6px;object-fit:contain;">';
            };
            reader.readAsDataURL(file);
        }
        function editPreviewUrl(val) {
            const box = document.getElementById('editImagePreviewBox');
            if (val) {
                box.innerHTML = '<img src="' + val + '" alt="Preview" style="max-width:100%;max-height:160px;border-radius:6px;object-fit:contain;" onerror="this.parentElement.innerHTML=\'<span style=\'color:#dc2626;font-size:12px;\'>Invalid image URL</span>\'">';
            } else {
                box.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21"/></svg><span>No image selected</span>';
            }
        }
    </script>
</body>
</html>
