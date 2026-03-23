<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Account - ShopLine</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; color: #1e293b; min-height: 100vh; display: flex; flex-direction: column; }

        /* ── Page wrapper ── */
        .page-wrapper { max-width: 1100px; margin: 0 auto; padding: 24px 24px 48px; flex: 1; display: flex; gap: 28px; align-items: flex-start; }

        /* ── Left sidebar ── */
        .account-sidebar {
            width: 220px; flex-shrink: 0;
            background: #fff; border: 1px solid #e5e7eb; border-radius: 14px;
            overflow: hidden;
            position: sticky; top: 24px;
        }
        .account-sidebar-profile {
            padding: 18px 16px 16px;
            border-bottom: 1px solid #f0f2f5;
            display: flex; align-items: center; gap: 10px;
        }
        .account-avatar {
            width: 40px; height: 40px; border-radius: 50%;
            background: #f3f4f6; color: #6b7280;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .account-avatar svg { width: 22px; height: 22px; }
        .account-sidebar-profile .user-name { font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 1px; }
        .account-sidebar-profile .user-email { font-size: 11px; color: #6b7280; }
        .account-sidebar-nav { padding: 10px 0; }
        .acct-nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 11px 18px; font-size: 14px; font-weight: 500;
            color: #4b5563; text-decoration: none;
            transition: background 0.15s, color 0.15s;
            cursor: pointer; border: none; border-left: 3px solid transparent;
            background: none; width: 100%;
            text-align: left; font-family: 'Inter', sans-serif;
        }
        .acct-nav-item:hover { background: #f9fafb; color: #111827; }
        .acct-nav-item.active { background: #1e293b; color: #fff; font-weight: 600; border-left: 3px solid #1e293b; }
        .acct-nav-item.active svg { color: #fff; }
        .acct-nav-item svg { width: 17px; height: 17px; flex-shrink: 0; }
        .acct-nav-item.logout { color: #ef4444; }
        .acct-nav-item.logout:hover { background: #fef2f2; color: #dc2626; }
        .sidebar-divider { border: none; border-top: 1px solid #f0f2f5; margin: 4px 0; }

        /* ── Right content panel ── */
        .account-content { flex: 1; min-width: 0; }
        .tab-panel { display: none; }
        .tab-panel.active { display: block; }
        .content-header { margin-bottom: 20px; }
        .content-header h2 { font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 3px; }
        .content-header p { font-size: 13px; color: #6b7280; }

        .panel {
            background: #fff; border: 1px solid #e5e7eb; border-radius: 14px;
            padding: 28px; margin-bottom: 20px;
        }
        .panel-title { font-size: 17px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .panel-sub { font-size: 13px; color: #6b7280; margin-bottom: 22px; }

        /* ── Forms ── */
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px; }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px; }
        .form-input {
            width: 100%; max-width: 100%; box-sizing: border-box;
            padding: 9px 12px; border: 1px solid #d1d5db;
            border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif;
            color: #1e293b; background: #fff; outline: none; transition: border-color 0.15s;
        }
        .form-input:focus { border-color: #1e293b; box-shadow: 0 0 0 3px rgba(30,41,59,0.08); }
        .form-error { font-size: 12px; color: #dc2626; margin-top: 4px; }

        .btn-primary {
            padding: 10px 22px; background: #1e293b; color: #fff;
            border: none; border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; font-family: 'Inter', sans-serif; transition: background 0.15s;
        }
        .btn-primary:hover { background: #0f172a; }
        .btn-danger {
            padding: 10px 22px; background: #dc2626; color: #fff;
            border: none; border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; font-family: 'Inter', sans-serif; transition: background 0.15s;
        }
        .btn-danger:hover { background: #b91c1c; }
        .btn-secondary {
            padding: 10px 22px; background: #fff; color: #374151;
            border: 1px solid #d1d5db; border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; font-family: 'Inter', sans-serif; transition: background 0.15s;
        }
        .btn-secondary:hover { background: #f9fafb; }
        .btn-outline-dark {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 18px; background: #1e293b; color: #fff;
            border: none; border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; font-family: 'Inter', sans-serif; text-decoration: none; transition: background 0.15s;
        }
        .btn-outline-dark:hover { background: #0f172a; }
        .saved-msg { font-size: 13px; color: #16a34a; font-weight: 500; margin-left: 12px; }

        /* ── Orders search ── */
        .orders-search-wrap { margin-bottom: 16px; position: relative; }
        .orders-search-wrap svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #9ca3af; pointer-events: none; }
        .orders-search-input {
            width: 100%; padding: 10px 12px 10px 36px;
            border: 1px solid #e5e7eb; border-radius: 10px;
            font-size: 14px; font-family: 'Inter', sans-serif;
            color: #1e293b; background: #fff; outline: none;
            transition: border-color 0.15s;
        }
        .orders-search-input:focus { border-color: #1e293b; box-shadow: 0 0 0 3px rgba(30,41,59,0.08); }
        .orders-search-input::placeholder { color: #9ca3af; }

        /* ── Orders tab ── */
        .order-card {
            border: 1px solid #e5e7eb; border-radius: 10px; padding: 18px 20px;
            margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between;
            gap: 16px; transition: box-shadow 0.15s;
        }
        .order-card:hover { box-shadow: 0 2px 12px rgba(0,0,0,0.07); }
        .order-info .order-id { font-size: 15px; font-weight: 700; color: #1e293b; margin-bottom: 2px; }
        .order-info .order-date { font-size: 12px; color: #6b7280; margin-bottom: 6px; }
        .order-info .order-meta { font-size: 13px; color: #374151; }
        .order-right { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }
        .order-badge {
            padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;
        }
        .badge-delivered { background: #1e293b; color: #fff; }
        .badge-shipped { background: #1e3a5f; color: #fff; }
        .badge-processing { background: #f3f4f6; color: #374151; }
        .badge-cancelled { background: #fef2f2; color: #dc2626; }
        .btn-view { font-size: 13px; font-weight: 500; color: #1e293b; text-decoration: none; border: 1px solid #d1d5db; padding: 6px 14px; border-radius: 7px; transition: background 0.15s; cursor: pointer; background: #fff; font-family: 'Inter', sans-serif; }
        .btn-view:hover { background: #f9fafb; }
        .empty-state { text-align: center; padding: 48px 20px; color: #9ca3af; }
        .empty-state svg { width: 48px; height: 48px; margin: 0 auto 14px; display: block; opacity: 0.4; }
        .empty-state p { font-size: 14px; margin-bottom: 16px; }

        /* ── Order Detail Modal ── */
        .order-modal-box {
            background: #fff; border-radius: 16px; padding: 0;
            width: 100%; max-width: 520px; max-height: 92vh;
            box-shadow: 0 8px 40px rgba(0,0,0,0.18);
            display: flex; flex-direction: column; overflow: hidden;
        }
        .order-modal-header {
            padding: 20px 24px 16px;
            border-bottom: 1px solid #f0f2f5;
            display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; flex-shrink: 0;
        }
        .order-modal-header-left { display: flex; align-items: flex-start; gap: 12px; }
        .order-modal-icon { width: 38px; height: 38px; border-radius: 8px; background: #f0f4ff; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .order-modal-icon svg { width: 20px; height: 20px; color: #1e293b; }
        .order-modal-title { font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 2px; }
        .order-modal-sub { font-size: 12px; color: #6b7280; }
        .order-modal-body { padding: 20px 24px; overflow-y: auto; flex: 1; }
        .order-modal-body::-webkit-scrollbar { width: 4px; }
        .order-modal-body::-webkit-scrollbar-track { background: #f1f5f9; }
        .order-modal-body::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .order-modal-footer { padding: 14px 24px; border-top: 1px solid #f0f2f5; display: flex; justify-content: flex-end; gap: 10px; flex-shrink: 0; }
        /* Order meta strip */
        .order-meta-strip { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 20px; }
        .order-meta-cell { background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px 14px; }
        .order-meta-cell .omc-label { font-size: 11px; color: #6b7280; margin-bottom: 3px; display: flex; align-items: center; gap: 5px; }
        .order-meta-cell .omc-label svg { width: 13px; height: 13px; }
        .order-meta-cell .omc-value { font-size: 13px; font-weight: 600; color: #1e293b; }
        /* Timeline */
        .order-timeline-title { font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 14px; display: flex; align-items: center; gap: 6px; }
        .order-timeline-title svg { width: 15px; height: 15px; }
        .timeline { display: flex; flex-direction: column; gap: 0; margin-bottom: 20px; }
        .timeline-item { display: flex; gap: 14px; position: relative; }
        .timeline-item:not(:last-child) .timeline-line { position: absolute; left: 15px; top: 32px; width: 2px; height: calc(100% + 2px); background: #e5e7eb; z-index: 0; }
        .timeline-item.done .timeline-line { background: #1e293b; }
        .timeline-dot { width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; z-index: 1; margin-top: 2px; }
        .timeline-dot.done { background: #1e293b; }
        .timeline-dot.active { background: #fff; border: 2px solid #1e293b; }
        .timeline-dot.pending { background: #fff; border: 2px solid #e5e7eb; }
        .timeline-dot svg { width: 14px; height: 14px; }
        .timeline-content { padding-bottom: 20px; flex: 1; }
        .timeline-content .tc-title { font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 2px; }
        .timeline-content.dim .tc-title { color: #9ca3af; }
        .timeline-content .tc-desc { font-size: 12px; color: #6b7280; margin-bottom: 4px; }
        .timeline-content .tc-meta { font-size: 11px; color: #9ca3af; display: flex; align-items: center; gap: 8px; }
        .tc-meta svg { width: 11px; height: 11px; }
        /* Estimated delivery */
        .est-delivery { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .est-delivery svg { width: 18px; height: 18px; color: #2563eb; flex-shrink: 0; }
        .est-delivery-text .edt-label { font-size: 11px; color: #2563eb; font-weight: 600; }
        .est-delivery-text .edt-date { font-size: 14px; font-weight: 700; color: #1e293b; }
        /* Address block */
        .order-section-title { font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }
        .order-section-title svg { width: 14px; height: 14px; }
        .order-address-box { background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px 16px; margin-bottom: 20px; }
        .order-address-box .addr-name { font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .order-address-box .addr-line { font-size: 13px; color: #374151; }
        .order-address-box .addr-phone { font-size: 12px; color: #6b7280; margin-top: 6px; display: flex; align-items: center; gap: 5px; }
        .order-address-box .addr-phone svg { width: 12px; height: 12px; }
        /* Items list */
        .order-items-list { display: flex; flex-direction: column; gap: 10px; margin-bottom: 4px; }
        .order-item-row { display: flex; align-items: center; gap: 12px; border: 1px solid #e5e7eb; border-radius: 10px; padding: 10px 12px; }
        .order-item-img { width: 44px; height: 44px; background: #f3f4f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden; }
        .order-item-img img { width: 100%; height: 100%; object-fit: cover; }
        .order-item-info { flex: 1; min-width: 0; }
        .order-item-info .oi-name { font-size: 13px; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .order-item-info .oi-qty { font-size: 12px; color: #6b7280; }
        .order-item-price { font-size: 13px; font-weight: 700; color: #1e293b; flex-shrink: 0; }
        /* Order total summary */
        .order-total-block { border-top: 1px solid #f0f2f5; padding-top: 12px; margin-top: 4px; }
        .order-total-row { display: flex; justify-content: space-between; font-size: 12px; color: #6b7280; margin-bottom: 5px; }
        .order-total-row.grand { font-size: 14px; font-weight: 700; color: #1e293b; margin-top: 6px; border-top: 1px solid #e5e7eb; padding-top: 8px; }

        /* ── Wishlist tab ── */
        .wishlist-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
        .wishlist-card {
            border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden;
            display: flex; flex-direction: column; background: #fff;
            transition: box-shadow 0.15s;
        }
        .wishlist-card:hover { box-shadow: 0 2px 12px rgba(0,0,0,0.07); }
        .wishlist-img { aspect-ratio: 4/3; background: #f5f5f5; display: flex; align-items: center; justify-content: center; }
        .wishlist-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .wishlist-img-placeholder { color: #d1d5db; }
        .wishlist-body { padding: 14px; flex: 1; display: flex; flex-direction: column; gap: 8px; }
        .wishlist-name { font-size: 14px; font-weight: 600; color: #1e293b; }
        .wishlist-price { font-size: 15px; font-weight: 700; color: #1e293b; }
        .wishlist-actions { display: flex; gap: 8px; }
        .btn-cart-small {
            flex: 1; padding: 8px; background: #1e293b; color: #fff;
            border: none; border-radius: 7px; font-size: 12px; font-weight: 600;
            cursor: pointer; font-family: 'Inter', sans-serif; text-align: center; text-decoration: none;
            display: flex; align-items: center; justify-content: center; transition: background 0.15s;
        }
        .btn-cart-small:hover { background: #0f172a; }
        .btn-remove-small {
            padding: 8px 10px; border: 1px solid #e5e7eb; background: #fff;
            color: #6b7280; border-radius: 7px; font-size: 12px; font-weight: 600;
            cursor: pointer; font-family: 'Inter', sans-serif; transition: background 0.15s, color 0.15s;
        }
        .btn-remove-small:hover { background: #fef2f2; color: #dc2626; border-color: #fecaca; }

        /* ── Addresses tab ── */
        /* ── Payment Methods tab ── */
        .payment-card {
            border: 1px solid #e5e7eb; border-radius: 10px; padding: 16px 20px;
            display: flex; align-items: center; gap: 14px; margin-bottom: 12px;
        }
        .payment-icon {
            width: 40px; height: 40px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 800; color: #fff; flex-shrink: 0;
        }
        .payment-icon.visa { background: #1a1f71; }
        .payment-icon.mc { background: #eb001b; }
        .payment-icon.gcash { background: #007aff; }
        .payment-icon.paymaya { background: #4cb749; }
        .payment-info { flex: 1; }
        .payment-info .pm-name { font-size: 14px; font-weight: 600; color: #1e293b; }
        .payment-info .pm-sub { font-size: 12px; color: #6b7280; }
        .pm-badge { background: #1e293b; color: #fff; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 10px; display: inline-block; margin-top: 4px; }
        .payment-actions { display: flex; align-items: center; gap: 10px; }
        .btn-set-default { font-size: 12px; font-weight: 500; color: #2563eb; border: none; background: none; cursor: pointer; font-family: 'Inter', sans-serif; }
        .btn-del-pm { color: #ef4444; background: none; border: none; cursor: pointer; padding: 4px; display: flex; }
        .add-payment-btn {
            width: 100%; padding: 13px; border: 2px dashed #d1d5db; border-radius: 10px;
            background: none; color: #6b7280; font-size: 14px; font-weight: 500;
            cursor: pointer; font-family: 'Inter', sans-serif; transition: border-color 0.15s, color 0.15s;
            display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 4px;
        }
        .add-payment-btn:hover { border-color: #9ca3af; color: #374151; }
        .pref-row { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f3f4f6; }
        .pref-row:last-child { border-bottom: none; }
        .pref-info .pref-title { font-size: 14px; font-weight: 600; color: #1e293b; }
        .pref-info .pref-sub { font-size: 12px; color: #6b7280; }
        .toggle-check { width: 18px; height: 18px; accent-color: #1e293b; cursor: pointer; }

        /* ── Settings tab ── */
        .settings-section { margin-bottom: 28px; }
        .settings-section-title { font-size: 15px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .settings-section-sub { font-size: 12px; color: #6b7280; margin-bottom: 16px; }
        .settings-row { display: flex; align-items: center; justify-content: space-between; padding: 13px 0; border-bottom: 1px solid #f3f4f6; }
        .settings-row:last-child { border-bottom: none; }
        .settings-row-info .sr-title { font-size: 14px; font-weight: 500; color: #1e293b; }
        .settings-row-info .sr-sub { font-size: 12px; color: #6b7280; }
        .settings-row-action { font-size: 13px; font-weight: 500; }
        .toggle-wrap { display: flex; align-items: center; }
        .notif-toggle { width: 18px; height: 18px; accent-color: #1e293b; cursor: pointer; }
        .btn-text-link { background: none; border: none; font-size: 13px; font-weight: 600; color: #2563eb; cursor: pointer; font-family: 'Inter', sans-serif; padding: 0; }
        /* Security action buttons */
        .btn-action-outline {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 14px; background: #fff; color: #1e293b;
            border: 1.5px solid #d1d5db; border-radius: 8px;
            font-size: 12px; font-weight: 600; cursor: pointer;
            font-family: 'Inter', sans-serif; transition: background 0.15s, border-color 0.15s;
            white-space: nowrap;
        }
        .btn-action-outline:hover { background: #f9fafb; border-color: #9ca3af; }
        .btn-action-outline svg { width: 14px; height: 14px; flex-shrink: 0; }
        .btn-action-blue {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 14px; background: #eff6ff; color: #2563eb;
            border: 1.5px solid #bfdbfe; border-radius: 8px;
            font-size: 12px; font-weight: 600; cursor: pointer;
            font-family: 'Inter', sans-serif; transition: background 0.15s, border-color 0.15s;
            white-space: nowrap;
        }
        .btn-action-blue:hover { background: #dbeafe; border-color: #93c5fd; }
        .btn-action-blue svg { width: 14px; height: 14px; flex-shrink: 0; }
        /* Danger Zone */
        .danger-zone { border: 1.5px solid #fecaca; border-radius: 12px; overflow: hidden; }
        .dz-header { background: #fff5f5; padding: 16px 20px 12px; border-bottom: 1.5px solid #fecaca; }
        .dz-title { font-size: 14px; font-weight: 700; color: #dc2626; margin-bottom: 2px; display: flex; align-items: center; gap: 7px; }
        .dz-title svg { width: 16px; height: 16px; flex-shrink: 0; }
        .dz-sub { font-size: 12px; color: #9ca3af; }
        .dz-row {
            display: flex; align-items: center; justify-content: space-between;
            gap: 16px; padding: 16px 20px;
            border-bottom: 1px solid #fff0f0;
            background: #fff;
        }
        .dz-row:last-child { border-bottom: none; }
        .dz-row-info { min-width: 0; flex: 1; }
        .dz-row-title { font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 2px; display: flex; align-items: center; gap: 6px; }
        .dz-row-title svg { width: 15px; height: 15px; flex-shrink: 0; }
        .dz-row-sub { font-size: 12px; color: #6b7280; }
        .dz-row > button { flex-shrink: 0; white-space: nowrap; }
        .btn-deactivate {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; background: #fff; color: #374151;
            border: 1.5px solid #d1d5db; border-radius: 8px;
            font-size: 12px; font-weight: 600; cursor: pointer;
            font-family: 'Inter', sans-serif; transition: background 0.15s, border-color 0.15s, color 0.15s;
        }
        .btn-deactivate:hover { background: #fef9c3; border-color: #fde047; color: #92400e; }
        .btn-deactivate svg { width: 14px; height: 14px; flex-shrink: 0; }
        .btn-delete-account {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; background: #dc2626; color: #fff;
            border: none; border-radius: 8px;
            font-size: 12px; font-weight: 600; cursor: pointer;
            font-family: 'Inter', sans-serif; transition: background 0.15s;
        }
        .btn-delete-account:hover { background: #b91c1c; }
        .btn-delete-account svg { width: 14px; height: 14px; flex-shrink: 0; }

        /* ── Modal ── */
        .modal-backdrop {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.4); z-index: 100;
            align-items: center; justify-content: center;
        }
        .modal-backdrop.open { display: flex; }
        .modal-box {
            background: #fff; border-radius: 14px; padding: 28px;
            width: 100%; max-width: 440px; box-shadow: 0 8px 32px rgba(0,0,0,0.15);
        }
        .modal-box h2 { font-size: 17px; font-weight: 700; color: #1e293b; margin-bottom: 8px; }
        .modal-box p { font-size: 13px; color: #64748b; margin-bottom: 18px; line-height: 1.6; }
        .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }

        /* ── Add Payment Modal ── */
        .pm-modal-box {
            background: #fff; border-radius: 16px; padding: 0;
            width: 100%; max-width: 520px; max-height: 90vh;
            box-shadow: 0 8px 40px rgba(0,0,0,0.18);
            display: flex; flex-direction: column; overflow: hidden;
        }
        .pm-modal-header {
            padding: 22px 24px 16px;
            border-bottom: 1px solid #f0f2f5;
            display: flex; align-items: flex-start; justify-content: space-between;
            gap: 12px; flex-shrink: 0;
        }
        .pm-modal-header-left { display: flex; align-items: flex-start; gap: 12px; }
        .pm-modal-header-icon {
            width: 38px; height: 38px; border-radius: 8px;
            background: #f0f4ff; display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .pm-modal-header-icon svg { width: 20px; height: 20px; color: #1e293b; }
        .pm-modal-title { font-size: 17px; font-weight: 700; color: #1e293b; margin-bottom: 2px; }
        .pm-modal-subtitle { font-size: 13px; color: #6b7280; }
        .pm-modal-close {
            background: none; border: none; cursor: pointer;
            color: #9ca3af; padding: 4px; display: flex; border-radius: 6px;
            transition: background 0.15s, color 0.15s;
        }
        .pm-modal-close:hover { background: #f3f4f6; color: #374151; }
        .pm-modal-body { padding: 20px 24px; overflow-y: auto; flex: 1; }
        .pm-modal-footer {
            padding: 16px 24px;
            border-top: 1px solid #f0f2f5;
            display: flex; gap: 10px; justify-content: space-between;
            flex-shrink: 0;
        }
        /* type selector */
        .pm-type-label { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 10px; }
        .pm-type-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 20px; }
        .pm-type-btn {
            border: 1.5px solid #e5e7eb; border-radius: 10px; padding: 14px 8px;
            background: #fff; cursor: pointer; font-family: 'Inter', sans-serif;
            display: flex; flex-direction: column; align-items: center; gap: 8px;
            transition: border-color 0.15s, background 0.15s;
            font-size: 12px; font-weight: 500; color: #374151; text-align: center;
        }
        .pm-type-btn:hover { border-color: #9ca3af; background: #f9fafb; }
        .pm-type-btn.selected { border-color: #1e293b; background: #f0f4ff; color: #1e293b; font-weight: 600; }
        .pm-type-btn svg { width: 22px; height: 22px; }
        .pm-type-btn .pm-type-icon-badge {
            width: 28px; height: 28px; border-radius: 6px;
            background: #007aff; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 800;
        }
        /* form section */
        .pm-form-section { border-top: 1px solid #f0f2f5; padding-top: 16px; }
        .pm-form-section-title { font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 2px; }
        .pm-form-section-sub { font-size: 12px; color: #6b7280; margin-bottom: 14px; }
        .pm-form-group { margin-bottom: 14px; }
        .pm-form-label { display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 5px; }
        .pm-form-label span { color: #ef4444; }
        .pm-form-input {
            width: 100%; padding: 9px 12px; border: 1px solid #d1d5db;
            border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif;
            color: #1e293b; background: #fff; outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .pm-form-input:focus { border-color: #1e293b; box-shadow: 0 0 0 3px rgba(30,41,59,0.08); }
        .pm-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .pm-form-select {
            width: 100%; padding: 9px 12px; border: 1px solid #d1d5db;
            border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif;
            color: #1e293b; background: #fff; outline: none;
            transition: border-color 0.15s; cursor: pointer;
        }
        .pm-form-select:focus { border-color: #1e293b; box-shadow: 0 0 0 3px rgba(30,41,59,0.08); }
        /* security notice */
        .pm-security-notice {
            background: #eff6ff; border: 1px solid #bfdbfe;
            border-radius: 10px; padding: 12px 14px;
            display: flex; gap: 10px; align-items: flex-start;
            margin-top: 4px;
        }
        .pm-security-notice svg { width: 16px; height: 16px; color: #2563eb; flex-shrink: 0; margin-top: 1px; }
        .pm-security-notice-text .sn-title { font-size: 13px; font-weight: 600; color: #1d4ed8; margin-bottom: 2px; }
        .pm-security-notice-text .sn-body { font-size: 12px; color: #3b82f6; line-height: 1.5; }
        /* accepted logos */
        .pm-accepted { margin-top: 14px; }
        .pm-accepted-label { font-size: 12px; font-weight: 600; color: #6b7280; margin-bottom: 8px; }
        .pm-accepted-logos { display: flex; flex-wrap: wrap; gap: 6px; }
        .pm-logo-chip {
            border: 1px solid #e5e7eb; border-radius: 6px; padding: 4px 10px;
            font-size: 11px; font-weight: 700; color: #374151; background: #fff;
        }
        /* action buttons inside modal footer */
        .pm-btn-cancel {
            padding: 10px 22px; background: #fff; color: #374151;
            border: 1px solid #d1d5db; border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; font-family: 'Inter', sans-serif; transition: background 0.15s;
            flex: 1;
        }
        .pm-btn-cancel:hover { background: #f9fafb; }
        .pm-btn-submit {
            padding: 10px 22px; background: #1e293b; color: #fff;
            border: none; border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; font-family: 'Inter', sans-serif; transition: background 0.15s;
            display: flex; align-items: center; gap: 7px; flex: 1.4; justify-content: center;
        }
        .pm-btn-submit:hover { background: #0f172a; }
        .pm-btn-submit svg { width: 15px; height: 15px; }

        /* ── Footer ── */
        footer { background: #111827; color: #9ca3af; padding: 48px 32px 0; margin-top: auto; }
        .footer-grid { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 40px; padding-bottom: 40px; border-bottom: 1px solid #1f2937; }
        .footer-brand h3 { font-size: 17px; font-weight: 700; color: #fff; margin-bottom: 10px; }
        .footer-brand p { font-size: 13px; line-height: 1.7; }
        .footer-socials { display: flex; gap: 12px; margin-top: 14px; }
        .footer-socials a { color: #9ca3af; transition: color 0.15s; }
        .footer-socials a:hover { color: #fff; }
        .footer-col h4 { font-size: 13px; font-weight: 700; color: #fff; margin-bottom: 14px; text-transform: uppercase; letter-spacing: 0.06em; }
        .footer-col ul { list-style: none; }
        .footer-col ul li { margin-bottom: 9px; }
        .footer-col ul li a { font-size: 13px; color: #9ca3af; text-decoration: none; transition: color 0.15s; }
        .footer-col ul li a:hover { color: #fff; }
        .newsletter-form { display: flex; align-items: center; gap: 8px; background: #1f2937; border-radius: 8px; padding: 4px 12px 4px 10px; border: 1px solid #374151; }
        .newsletter-form svg { width: 16px; height: 16px; color: #6b7280; flex-shrink: 0; }
        .newsletter-form input { background: none; border: none; color: #e5e7eb; font-size: 13px; outline: none; flex: 1; font-family: 'Inter', sans-serif; padding: 6px 0; }
        .newsletter-form input::placeholder { color: #6b7280; }
        .footer-bottom { max-width: 1100px; margin: 0 auto; text-align: center; padding: 20px 0; font-size: 12px; color: #4b5563; }

        @media (max-width: 768px) {
            .page-wrapper { flex-direction: column; }
            .account-sidebar { width: 100%; position: static; }
            .form-row { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 28px; }
        }
    </style>
</head>
<body>

    @include('layouts._navbar')

    <div class="page-wrapper">

        <!-- ── Sidebar ── -->
        <aside class="account-sidebar">
            <div class="account-sidebar-profile">
                <div class="account-avatar">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A8 8 0 1 1 18.88 17.804M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/></svg>
                </div>
                <div>
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-email">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <nav class="account-sidebar-nav">
                <a href="#" class="acct-nav-item {{ $tab === 'profile' ? 'active' : '' }}" data-tab="profile" onclick="switchTab('profile'); return false;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A8 8 0 1 1 18.88 17.804M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/></svg>
                    Profile
                </a>
                <a href="#" class="acct-nav-item {{ $tab === 'orders' ? 'active' : '' }}" data-tab="orders" onclick="switchTab('orders'); return false;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Orders
                </a>
                <a href="#" class="acct-nav-item {{ $tab === 'wishlist' ? 'active' : '' }}" data-tab="wishlist" onclick="switchTab('wishlist'); return false;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 010-6.364z"/></svg>
                    Wishlist
                </a>
                <a href="#" class="acct-nav-item {{ $tab === 'addresses' ? 'active' : '' }}" data-tab="addresses" onclick="switchTab('addresses'); return false;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Addresses
                </a>
                <a href="#" class="acct-nav-item {{ $tab === 'payment' ? 'active' : '' }}" data-tab="payment" onclick="switchTab('payment'); return false;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    Payment Methods
                </a>
                <a href="#" class="acct-nav-item {{ $tab === 'settings' ? 'active' : '' }}" data-tab="settings" onclick="switchTab('settings'); return false;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
                    Settings
                </a>
                <hr class="sidebar-divider">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="acct-nav-item logout">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- ── Main content ── -->
        <div class="account-content">

            <!-- ═══════════════════════════════════════════ -->
            <!-- TAB: PROFILE                               -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="tab-panel {{ $tab === 'profile' ? 'active' : '' }}" id="tab-profile">

                <div class="content-header">
                    <h2>Personal Information</h2>
                    <p>Manage your personal details and password</p>
                </div>

                <div class="panel">
                    <div class="panel-title">Personal Information</div>
                    <div class="panel-sub">Update your personal details</div>

                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="form-row">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">First Name</label>
                                @php $nameParts = explode(' ', old('name', $user->name), 2); @endphp
                                <input name="first_name" type="text" class="form-input" value="{{ $nameParts[0] ?? '' }}" placeholder="First Name" required>
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Last Name</label>
                                <input name="last_name" type="text" class="form-input" value="{{ $nameParts[1] ?? '' }}" placeholder="Last Name">
                            </div>
                        </div>
                        <input type="hidden" name="name" id="combined-name">

                        <div class="form-row" style="margin-top:18px;">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Email</label>
                                <input id="email" name="email" type="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                                @if($errors->get('email'))
                                    @foreach($errors->get('email') as $msg)
                                        <div class="form-error">{{ $msg }}</div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Phone Number</label>
                                <input name="phone" type="tel" class="form-input" value="{{ old('phone') }}" placeholder="+1 (555) 123-4567">
                            </div>
                        </div>

                        <div style="display:flex;align-items:center;margin-top:20px;">
                            <button type="submit" class="btn-primary">Save Changes</button>
                            @if (session('status') === 'profile-updated')
                                <span class="saved-msg">Saved successfully.</span>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="panel">
                    <div class="panel-title">Change Password</div>
                    <div class="panel-sub">Update your password to keep your account secure</div>

                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label class="form-label">Current Password</label>
                            <input id="update_password_current_password" name="current_password" type="password" class="form-input" autocomplete="current-password">
                            @if($errors->updatePassword->get('current_password'))
                                @foreach($errors->updatePassword->get('current_password') as $msg)
                                    <div class="form-error">{{ $msg }}</div>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input id="update_password_password" name="password" type="password" class="form-input" autocomplete="new-password">
                            @if($errors->updatePassword->get('password'))
                                @foreach($errors->updatePassword->get('password') as $msg)
                                    <div class="form-error">{{ $msg }}</div>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm New Password</label>
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-input" autocomplete="new-password">
                        </div>

                        <div style="display:flex;align-items:center;">
                            <button type="submit" class="btn-primary">Update Password</button>
                            @if (session('status') === 'password-updated')
                                <span class="saved-msg">Password updated.</span>
                            @endif
                        </div>
                    </form>
                </div>

            </div><!-- /tab-profile -->

            <!-- ═══════════════════════════════════════════ -->
            <!-- TAB: ORDERS                                -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="tab-panel {{ $tab === 'orders' ? 'active' : '' }}" id="tab-orders">

                <div class="content-header">
                    <h2>Order History</h2>
                    <p>View and track your order history</p>
                </div>

                <div class="panel">
                    <div class="orders-search-wrap">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
                        <input type="text" class="orders-search-input" id="orders-search" placeholder="Search orders..." oninput="filterOrders(this.value)">
                    </div>

                    @if(isset($orders) && $orders->count())
                        @foreach($orders as $order)
                            @php
                                $statusClass = match(strtolower($order->status ?? 'processing')) {
                                    'delivered' => 'badge-delivered',
                                    'shipped'   => 'badge-shipped',
                                    'cancelled' => 'badge-cancelled',
                                    default     => 'badge-processing',
                                };
                                $statusLabel = ucfirst($order->status ?? 'Processing');
                            @endphp
                            @php
                                $orderItems = $order->items->map(function($i) {
                                    return [
                                        'name'     => $i->product_name,
                                        'qty'      => $i->quantity,
                                        'price'    => number_format($i->price, 2),
                                        'subtotal' => number_format($i->subtotal, 2),
                                    ];
                                })->values()->toArray();
                            @endphp
                            <div class="order-card">
                                <div class="order-info">
                                    <div class="order-id">Order #ORD-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</div>
                                    <div class="order-date">{{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d') }}</div>
                                    <div class="order-meta">{{ $order->items->count() }} item(s) &bull; ₱{{ number_format($order->total, 2) }}</div>
                                </div>
                                <div class="order-right">
                                    <span class="order-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                                    <button class="btn-view" onclick="openOrderDetail({
                                        id: '{{ $order->id }}',
                                        number: 'ORD-{{ str_pad($order->id, 3, "0", STR_PAD_LEFT) }}',
                                        date: '{{ \Carbon\Carbon::parse($order->created_at)->format("Y-m-d") }}',
                                        status: '{{ $statusLabel }}',
                                        statusClass: '{{ $statusClass }}',
                                        shipping: '{{ addslashes($order->shipping_method ?? "Standard Shipping") }}',
                                        payment: '{{ addslashes($order->payment_method ?? "Cash on Delivery") }}',
                                        subtotal: '{{ number_format($order->subtotal ?? $order->total, 2) }}',
                                        tax: '{{ number_format($order->tax ?? 0, 2) }}',
                                        shippingCost: '{{ number_format($order->shipping_cost ?? 0, 2) }}',
                                        total: '{{ number_format($order->total, 2) }}',
                                        name: '{{ addslashes(($order->first_name ?? "") . " " . ($order->last_name ?? "")) }}',
                                        street: '{{ addslashes($order->street ?? "") }}',
                                        city: '{{ addslashes($order->city ?? "") }}',
                                        state: '{{ addslashes($order->state ?? "") }}',
                                        zip: '{{ addslashes($order->zip ?? "") }}',
                                        phone: '{{ addslashes($order->phone ?? "") }}',
                                        items: {{ json_encode($orderItems) }}
                                    })">View Details</button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <p>You haven't placed any orders yet.</p>
                            <a href="{{ route('shop') }}" class="btn-primary">Start Shopping</a>
                        </div>
                    @endif
                </div>
            </div><!-- /tab-orders -->

            <!-- ═══════════════════════════════════════════ -->
            <!-- TAB: WISHLIST                              -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="tab-panel {{ $tab === 'wishlist' ? 'active' : '' }}" id="tab-wishlist">

                <div class="content-header">
                    <h2>My Wishlist</h2>
                    <p>Items you've saved for later</p>
                </div>

                <div class="panel">

                    @php $wishlist = session('wishlist', []); @endphp
                    @if(count($wishlist))
                        <div class="wishlist-grid">
                            @foreach($wishlist as $item)
                            <div class="wishlist-card">
                                <div class="wishlist-img">
                                    @if(!empty($item['image']))
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                    @else
                                        <svg class="wishlist-img-placeholder" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9l4-4 4 4 4-4 4 4"/><circle cx="8.5" cy="13.5" r="1.5"/></svg>
                                    @endif
                                </div>
                                <div class="wishlist-body">
                                    <div class="wishlist-name">{{ $item['name'] }}</div>
                                    <div class="wishlist-price">₱{{ number_format($item['price'], 2) }}</div>
                                    <div class="wishlist-actions">
                                        <button class="btn-cart-small" onclick="wishlistAddToCart({{ $item['id'] }}, this)">Add to Cart</button>
                                        <button class="btn-remove-small" onclick="removeFromWishlist({{ $item['id'] }})">Remove</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 010-6.364z"/></svg>
                            <p>Your wishlist is empty.</p>
                            <a href="{{ route('shop') }}" class="btn-primary">Explore Products</a>
                        </div>
                    @endif
                </div>
            </div><!-- /tab-wishlist -->

            <!-- ═══════════════════════════════════════════ -->
            <!-- TAB: ADDRESSES                             -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="tab-panel {{ $tab === 'addresses' ? 'active' : '' }}" id="tab-addresses">

                <div class="content-header">
                    <h2>Addresses</h2>
                    <p>Manage your delivery addresses</p>
                </div>

                <div class="panel">

                    <form method="post" action="{{ route('account.address.save') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Street Address</label>
                            <input name="street" type="text" class="form-input" value="{{ old('street', $user->address_street ?? '') }}" placeholder="123 Main Street">
                        </div>
                        <div class="form-row">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">City</label>
                                <input name="city" type="text" class="form-input" value="{{ old('city', $user->address_city ?? '') }}" placeholder="New York">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">State/Province</label>
                                <input name="state" type="text" class="form-input" value="{{ old('state', $user->address_state ?? '') }}" placeholder="NY">
                            </div>
                        </div>
                        <div class="form-row" style="margin-top:18px;">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">ZIP/Postal Code</label>
                                <input name="zip" type="text" class="form-input" value="{{ old('zip', $user->address_zip ?? '') }}" placeholder="10001">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Country</label>
                                <input name="country" type="text" class="form-input" value="{{ old('country', $user->address_country ?? 'Philippines') }}" placeholder="Philippines">
                            </div>
                        </div>
                        <div style="margin-top:20px;">
                            <button type="submit" class="btn-primary">Save Address</button>
                            @if(session('status') === 'address-saved')
                                <span class="saved-msg">Address saved.</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div><!-- /tab-addresses -->

            <!-- ═══════════════════════════════════════════ -->
            <!-- TAB: PAYMENT METHODS                       -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="tab-panel {{ $tab === 'payment' ? 'active' : '' }}" id="tab-payment">

                <div class="content-header">
                    <h2>Payment Methods</h2>
                    <p>Manage your saved payment methods</p>
                </div>

                @if(session('success') && $tab === 'payment')
                    <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;font-size:13px;padding:10px 14px;border-radius:8px;margin-bottom:16px;">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="panel" id="pm-list-panel">

                    @forelse($paymentMethods as $pm)
                    <div class="payment-card" id="pm-row-{{ $pm->id }}">
                        <div class="payment-icon {{ $pm->icon_class }}">{{ $pm->icon_text }}</div>
                        <div class="payment-info">
                            <div class="pm-name">{{ $pm->label }}</div>
                            @if($pm->sub_label)
                                <div class="pm-sub">{{ $pm->sub_label }}</div>
                            @endif
                            @if($pm->is_default)
                                <span class="pm-badge">Default</span>
                            @endif
                        </div>
                        <div class="payment-actions">
                            @if(!$pm->is_default)
                                <button class="btn-set-default" onclick="pmSetDefault({{ $pm->id }})">Set Default</button>
                            @endif
                            <button class="btn-del-pm" title="Remove" onclick="pmDelete({{ $pm->id }})">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                    @empty
                        <p id="pm-empty-msg" style="font-size:13px;color:#6b7280;text-align:center;padding:20px 0;">No payment methods saved yet.</p>
                    @endforelse

                    <button class="add-payment-btn" onclick="document.getElementById('add-payment-modal').classList.add('open')">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Add New Payment Method
                    </button>
                </div>

                <div class="panel">
                    <div class="panel-title" style="margin-bottom:14px;">Payment Preferences</div>
                    <div class="panel-sub" style="margin-bottom:14px;">Set your default payment options</div>

                    <div class="pref-row">
                        <div class="pref-info">
                            <div class="pref-title">Save cards for faster checkout</div>
                            <div class="pref-sub">Securely save payment methods for future purchases</div>
                        </div>
                        <input type="checkbox" class="toggle-check" checked>
                    </div>
                    <div class="pref-row">
                        <div class="pref-info">
                            <div class="pref-title">Cash on Delivery (COD)</div>
                            <div class="pref-sub">Enable COD as a payment option</div>
                        </div>
                        <input type="checkbox" class="toggle-check" checked>
                    </div>
                </div>
            </div><!-- /tab-payment -->

            <!-- ═══════════════════════════════════════════ -->
            <!-- TAB: SETTINGS                              -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="tab-panel {{ $tab === 'settings' ? 'active' : '' }}" id="tab-settings">

                <div class="content-header">
                    <h2>Settings</h2>
                    <p>Manage your account preferences</p>
                </div>

                <div class="panel">

                    <!-- Notification Preferences -->
                    <div class="settings-section">
                        <div class="settings-section-title">Notification Preferences</div>
                        <div class="settings-section-sub">Choose which updates you want to receive</div>
                        <div class="settings-row">
                            <div class="settings-row-info"><div class="sr-title">Order Updates</div><div class="sr-sub">Receive email notifications about your orders</div></div>
                            <input type="checkbox" class="notif-toggle" checked>
                        </div>
                        <div class="settings-row">
                            <div class="settings-row-info"><div class="sr-title">Promotions &amp; Offers</div><div class="sr-sub">Get notified about special deals and discounts</div></div>
                            <input type="checkbox" class="notif-toggle" checked>
                        </div>
                        <div class="settings-row">
                            <div class="settings-row-info"><div class="sr-title">Newsletter</div><div class="sr-sub">Receive newsletter with new products and tips</div></div>
                            <input type="checkbox" class="notif-toggle">
                        </div>
                        <div class="settings-row">
                            <div class="settings-row-info"><div class="sr-title">System Notifications</div><div class="sr-sub">Receive email messages for system updates</div></div>
                            <input type="checkbox" class="notif-toggle">
                        </div>
                        <div class="settings-row">
                            <div class="settings-row-info"><div class="sr-title">Push Notifications</div><div class="sr-sub">Receive push notifications for important updates</div></div>
                            <input type="checkbox" class="notif-toggle">
                        </div>
                        <div style="margin-top:16px;">
                            <button class="btn-primary">Save Preferences</button>
                        </div>
                    </div>

                    <!-- Privacy & Security -->
                    <div class="settings-section">
                        <div class="settings-section-title">Privacy &amp; Security</div>
                        <div class="settings-section-sub">Manage your privacy and security settings</div>
                        <div class="settings-row">
                            <div class="settings-row-info">
                                <div class="sr-title">Two-Factor Authentication</div>
                                <div class="sr-sub">Add an extra layer of security to your account</div>
                            </div>
                            <button class="btn-action-blue" onclick="openTfaModal()">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                Enable 2FA
                            </button>
                        </div>
                        <div class="settings-row">
                            <div class="settings-row-info"><div class="sr-title">Profile Visibility</div><div class="sr-sub">Control who can see your profile information</div></div>
                            <input type="checkbox" class="notif-toggle" checked>
                        </div>
                        <div class="settings-row">
                            <div class="settings-row-info"><div class="sr-title">Data Sharing</div><div class="sr-sub">Allow us to share data with trusted partners</div></div>
                            <input type="checkbox" class="notif-toggle">
                        </div>
                        <div class="settings-row">
                            <div class="settings-row-info">
                                <div class="sr-title">Login Activity</div>
                                <div class="sr-sub">View your recent login history</div>
                            </div>
                            <button class="btn-action-outline" onclick="openLoginActivityModal()">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                View Activity
                            </button>
                        </div>
                    </div>

                    <!-- Language & Region -->
                    <div class="settings-section">
                        <div class="settings-section-title">Language &amp; Region</div>
                        <div class="settings-section-sub">Set your preferred language and regional settings</div>
                        <div class="form-group">
                            <label class="form-label">Language</label>
                            <select class="form-input"><option>English</option><option>Filipino</option></select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Currency</label>
                            <select class="form-input"><option>PHP - Philippine Peso</option><option>USD - US Dollar</option></select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Timezone</label>
                            <select class="form-input"><option>Asia/Manila (UTC+8)</option><option>UTC</option></select>
                        </div>
                        <button class="btn-primary">Save Settings</button>
                    </div>

                    <!-- Danger Zone -->
                    <div class="danger-zone">
                        <div class="dz-header">
                            <div class="dz-title">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                                Danger Zone
                            </div>
                            <div class="dz-sub">Irreversible account actions — proceed with caution</div>
                        </div>
                        <div class="dz-row">
                            <div class="dz-row-info">
                                <div class="dz-row-title">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                    Deactivate Account
                                </div>
                                <div class="dz-row-sub">Temporarily disable your account — you can reactivate it anytime</div>
                            </div>
                            <button class="btn-deactivate" onclick="document.getElementById('deactivate-modal').classList.add('open')">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                Deactivate
                            </button>
                        </div>
                        <div class="dz-row">
                            <div class="dz-row-info">
                                <div class="dz-row-title" style="color:#dc2626;">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:#dc2626;"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Delete Account
                                </div>
                                <div class="dz-row-sub">Permanently delete your account and all associated data — this cannot be undone</div>
                            </div>
                            <button class="btn-delete-account" onclick="document.getElementById('delete-modal').classList.add('open')">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Delete Account
                            </button>
                        </div>
                    </div>

                </div>
            </div><!-- /tab-settings -->

        </div><!-- /.account-content -->
    </div><!-- /.page-wrapper -->

    @include('layouts._footer')

    <!-- Add Payment Method Modal -->
    <div class="modal-backdrop" id="add-payment-modal">
        <div class="pm-modal-box">

            <!-- Header -->
            <div class="pm-modal-header">
                <div class="pm-modal-header-left">
                    <div class="pm-modal-header-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    </div>
                    <div>
                        <div class="pm-modal-title">Add Payment Method</div>
                        <div class="pm-modal-subtitle">Choose a payment method type and fill in the details</div>
                    </div>
                </div>
                <button class="pm-modal-close" onclick="document.getElementById('add-payment-modal').classList.remove('open')">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <!-- Body -->
            <div class="pm-modal-body">

                <!-- Type Selector -->
                <div class="pm-type-label">Select Payment Method Type</div>
                <div class="pm-type-grid">
                    <button type="button" class="pm-type-btn selected" id="pm-type-card" onclick="switchPmType('card')">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                        Credit/Debit Card
                    </button>
                    <button type="button" class="pm-type-btn" id="pm-type-ewallet" onclick="switchPmType('ewallet')">
                        <div class="pm-type-icon-badge">GC</div>
                        E-Wallet (GCash, PayMaya)
                    </button>
                    <button type="button" class="pm-type-btn" id="pm-type-bank" onclick="switchPmType('bank')">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 10v11M12 10v11M16 10v11"/></svg>
                        Bank Account
                    </button>
                </div>

                <!-- Credit/Debit Card Form -->
                <div class="pm-form-section" id="pm-form-card">
                    <div class="pm-form-section-title">Credit/Debit Card Details</div>
                    <div class="pm-form-section-sub">Enter your card information</div>

                    <div class="pm-form-group">
                        <label class="pm-form-label">Card Number <span>*</span></label>
                        <input type="text" class="pm-form-input" placeholder="1234 5678 9012 3456" maxlength="19" id="pm-card-number">
                    </div>
                    <div class="pm-form-group">
                        <label class="pm-form-label">Cardholder Name <span>*</span></label>
                        <input type="text" class="pm-form-input" placeholder="JOHN DOE" id="pm-card-name">
                    </div>
                    <div class="pm-form-row">
                        <div class="pm-form-group" style="margin-bottom:0;">
                            <label class="pm-form-label">Expiry Date <span>*</span></label>
                            <input type="text" class="pm-form-input" placeholder="MM/YY" maxlength="5" id="pm-card-expiry">
                        </div>
                        <div class="pm-form-group" style="margin-bottom:0;">
                            <label class="pm-form-label">CVV <span>*</span></label>
                            <input type="text" class="pm-form-input" placeholder="123" maxlength="4" id="pm-card-cvv">
                        </div>
                    </div>
                    <div class="pm-form-group" style="margin-top:14px;">
                        <label class="pm-form-label">Card Type</label>
                        <select class="pm-form-select" id="pm-card-type">
                            <option value="">Auto-detect</option>
                            <option value="visa">Visa</option>
                            <option value="mastercard">Mastercard</option>
                            <option value="amex">American Express</option>
                        </select>
                    </div>
                </div>

                <!-- E-Wallet Form -->
                <div class="pm-form-section" id="pm-form-ewallet" style="display:none;">
                    <div class="pm-form-section-title">E-Wallet Details</div>
                    <div class="pm-form-section-sub">Enter your e-wallet information</div>

                    <div class="pm-form-group">
                        <label class="pm-form-label">Provider</label>
                        <select class="pm-form-select" id="pm-ew-provider">
                            <option value="">Select provider</option>
                            <option value="gcash">GCash</option>
                            <option value="paymaya">PayMaya</option>
                            <option value="grabpay">GrabPay</option>
                            <option value="shopeepay">ShopeePay</option>
                        </select>
                    </div>
                    <div class="pm-form-group">
                        <label class="pm-form-label">Phone Number <span>*</span></label>
                        <input type="tel" class="pm-form-input" placeholder="+63 917 123 4567" id="pm-ew-phone">
                    </div>
                    <div class="pm-form-group">
                        <label class="pm-form-label">Account Name <span>*</span></label>
                        <input type="text" class="pm-form-input" placeholder="Juan Dela Cruz" id="pm-ew-name">
                    </div>
                </div>

                <!-- Bank Account Form -->
                <div class="pm-form-section" id="pm-form-bank" style="display:none;">
                    <div class="pm-form-section-title">Bank Account Details</div>
                    <div class="pm-form-section-sub">Enter your bank account information</div>

                    <div class="pm-form-group">
                        <label class="pm-form-label">Bank Name <span>*</span></label>
                        <input type="text" class="pm-form-input" placeholder="e.g., BDO, BPI, Metrobank" id="pm-bank-name">
                    </div>
                    <div class="pm-form-group">
                        <label class="pm-form-label">Account Number <span>*</span></label>
                        <input type="text" class="pm-form-input" placeholder="1234567890" id="pm-bank-account">
                    </div>
                    <div class="pm-form-group">
                        <label class="pm-form-label">Account Holder Name <span>*</span></label>
                        <input type="text" class="pm-form-input" placeholder="Juan Dela Cruz" id="pm-bank-holder">
                    </div>
                    <div class="pm-form-group">
                        <label class="pm-form-label">Account Type</label>
                        <select class="pm-form-select" id="pm-bank-type">
                            <option value="">Select type</option>
                            <option value="savings">Savings</option>
                            <option value="checking">Checking</option>
                        </select>
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="pm-security-notice" style="margin-top:18px;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <div class="pm-security-notice-text">
                        <div class="sn-title">Secure Payment Information</div>
                        <div class="sn-body">Your payment information is encrypted and stored securely. We never share your financial details with third parties. All transactions are processed through secure payment gateways compliant with PCI DSS standards.</div>
                    </div>
                </div>

                <!-- Accepted Methods -->
                <div class="pm-accepted">
                    <div class="pm-accepted-label">Accepted Payment Methods</div>
                    <div class="pm-accepted-logos">
                        <span class="pm-logo-chip">Visa</span>
                        <span class="pm-logo-chip">Mastercard</span>
                        <span class="pm-logo-chip">American Express</span>
                        <span class="pm-logo-chip">GCash</span>
                        <span class="pm-logo-chip">PayMaya</span>
                        <span class="pm-logo-chip">BDO</span>
                        <span class="pm-logo-chip">BPI</span>
                        <span class="pm-logo-chip">Metrobank</span>
                    </div>
                </div>

            </div><!-- /.pm-modal-body -->

            <!-- Footer -->
            <div class="pm-modal-footer">
                <button type="button" class="pm-btn-cancel" onclick="document.getElementById('add-payment-modal').classList.remove('open')">Cancel</button>
                <button type="button" class="pm-btn-submit" id="pm-submit-btn" onclick="handleAddPayment()">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    <span id="pm-submit-label">Add Card</span>
                </button>
            </div>

            <input type="hidden" id="pm-store-url" value="{{ route('payment.store') }}">
            <input type="hidden" id="pm-csrf" value="{{ csrf_token() }}">

        </div>
    </div>

    <!-- Order Detail Modal -->
    <div class="modal-backdrop" id="order-detail-modal">
        <div class="order-modal-box">
            <div class="order-modal-header">
                <div class="order-modal-header-left">
                    <div class="order-modal-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <div class="order-modal-title" id="od-title">Track Your Order</div>
                        <div class="order-modal-sub" id="od-sub">Order ID-1001</div>
                    </div>
                </div>
                <button class="pm-modal-close" onclick="document.getElementById('order-detail-modal').classList.remove('open')">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="order-modal-body">
                <!-- Status + meta strip -->
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                    <div style="font-size:14px;font-weight:700;color:#1e293b;" id="od-order-label">Order #ORD-001</div>
                    <span id="od-status-badge" class="order-badge"></span>
                </div>
                <div style="font-size:11px;color:#9ca3af;margin-bottom:14px;">Tracking: <span id="od-tracking" style="font-weight:600;color:#374151;"></span></div>
                <div class="order-meta-strip">
                    <div class="order-meta-cell">
                        <div class="omc-label"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>Order Date</div>
                        <div class="omc-value" id="od-date"></div>
                    </div>
                    <div class="order-meta-cell">
                        <div class="omc-label"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8"/></svg>Shipping</div>
                        <div class="omc-value" id="od-shipping"></div>
                    </div>
                    <div class="order-meta-cell">
                        <div class="omc-label"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7H4a2 2 0 00-2 2v6a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 3v4M8 3v4"/></svg>Total Items</div>
                        <div class="omc-value" id="od-items-count"></div>
                    </div>
                </div>

                <!-- Shipment Timeline -->
                <div class="order-timeline-title">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Shipment Timeline
                </div>
                <div class="timeline" id="od-timeline"></div>

                <!-- Estimated Delivery -->
                <div class="est-delivery" id="od-est-delivery">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <div class="est-delivery-text">
                        <div class="edt-label">Estimated Delivery</div>
                        <div class="edt-date" id="od-est-date"></div>
                    </div>
                </div>

                <!-- Delivery Address -->
                <div class="order-section-title">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Delivery Address
                </div>
                <div class="order-address-box">
                    <div class="addr-name" id="od-addr-name"></div>
                    <div class="addr-line" id="od-addr-line"></div>
                    <div class="addr-phone" id="od-addr-phone">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span id="od-addr-phone-text"></span>
                    </div>
                </div>

                <!-- Items in Order -->
                <div class="order-section-title">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    Items in This Order
                </div>
                <div class="order-items-list" id="od-items-list"></div>

                <!-- Order Total -->
                <div class="order-total-block">
                    <div class="order-total-row"><span>Subtotal</span><span id="od-subtotal"></span></div>
                    <div class="order-total-row"><span>Shipping</span><span id="od-shipping-cost"></span></div>
                    <div class="order-total-row"><span>Tax</span><span id="od-tax"></span></div>
                    <div class="order-total-row grand"><span>Total</span><span id="od-total"></span></div>
                </div>
            </div>
            <div class="order-modal-footer">
                <button type="button" class="pm-btn-cancel" onclick="document.getElementById('order-detail-modal').classList.remove('open')">Close</button>
            </div>
        </div>
    </div>

    <!-- Deactivate Account Modal -->
    <div class="modal-backdrop" id="deactivate-modal">
        <div class="modal-box">
            <h2>Deactivate Your Account?</h2>
            <p>Your account will be temporarily disabled. You can reactivate it at any time by logging back in. During deactivation, your profile and data will not be visible to others.</p>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="document.getElementById('deactivate-modal').classList.remove('open')">Cancel</button>
                <button type="button" class="btn-primary" onclick="document.getElementById('deactivate-modal').classList.remove('open')">Confirm Deactivation</button>
            </div>
        </div>
    </div>

    <!-- Two-Factor Authentication Modal -->
    <div class="modal-backdrop" id="tfa-modal">
        <div class="pm-modal-box" style="max-width:480px;">
            <!-- Header -->
            <div class="pm-modal-header">
                <div class="pm-modal-header-left">
                    <div class="pm-modal-header-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:20px;height:20px;color:#1e293b;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <div>
                        <div class="pm-modal-title">Two-Factor Authentication Setup</div>
                        <div class="pm-modal-subtitle" id="tfa-subtitle">Secure your account with an additional layer of protection</div>
                    </div>
                </div>
                <button class="pm-modal-close" onclick="closeTfaModal()">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <!-- ── STEP 1: Choose Method ── -->
            <div class="pm-modal-body" id="tfa-step-1">
                <div style="font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Choose Your 2FA Method</div>
                <div style="font-size:12px;color:#6b7280;margin-bottom:16px;">Select how you want to receive verification codes</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px;">
                    <button type="button" class="pm-type-btn selected" id="tfa-type-app" onclick="selectTfaMethod('app')" style="padding:18px 10px;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="width:28px;height:28px;"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                        <span style="font-size:13px;font-weight:600;">Authenticator App</span>
                        <span style="font-size:11px;color:#6b7280;font-weight:400;">Use an app like Google Authenticator or Authy</span>
                    </button>
                    <button type="button" class="pm-type-btn" id="tfa-type-sms" onclick="selectTfaMethod('sms')" style="padding:18px 10px;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="width:28px;height:28px;"><path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        <span style="font-size:13px;font-weight:600;">SMS Text Message</span>
                        <span style="font-size:11px;color:#6b7280;font-weight:400;">Receive codes via text message</span>
                    </button>
                </div>
                <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:10px;padding:14px 16px;">
                    <div style="display:flex;align-items:flex-start;gap:10px;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="#d97706" stroke-width="2" style="width:16px;height:16px;flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                        <div>
                            <div style="font-size:12px;font-weight:600;color:#92400e;margin-bottom:4px;">Why Enable 2FA?</div>
                            <ul style="font-size:11px;color:#b45309;line-height:1.7;padding-left:14px;">
                                <li>Protects your account even if your password is compromised</li>
                                <li>Prevents unauthorized access to your personal information</li>
                                <li>Secures your payment methods and order history</li>
                                <li>Required for certain high-value transactions</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── STEP 2a: Authenticator App — QR Code ── -->
            <div class="pm-modal-body" id="tfa-step-2-app" style="display:none;">
                <div style="font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Scan QR Code</div>
                <div style="font-size:12px;color:#6b7280;margin-bottom:18px;">Open your authenticator app and scan the QR code below to link your account.</div>
                <div style="display:flex;justify-content:center;margin-bottom:18px;">
                    <div style="width:160px;height:160px;background:#f3f4f6;border:1px solid #e5e7eb;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                        <!-- Simulated QR code grid -->
                        <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="120" height="120" fill="white"/>
                            <rect x="8" y="8" width="40" height="40" rx="4" fill="#1e293b"/>
                            <rect x="14" y="14" width="28" height="28" rx="2" fill="white"/>
                            <rect x="20" y="20" width="16" height="16" rx="1" fill="#1e293b"/>
                            <rect x="72" y="8" width="40" height="40" rx="4" fill="#1e293b"/>
                            <rect x="78" y="14" width="28" height="28" rx="2" fill="white"/>
                            <rect x="84" y="20" width="16" height="16" rx="1" fill="#1e293b"/>
                            <rect x="8" y="72" width="40" height="40" rx="4" fill="#1e293b"/>
                            <rect x="14" y="78" width="28" height="28" rx="2" fill="white"/>
                            <rect x="20" y="84" width="16" height="16" rx="1" fill="#1e293b"/>
                            <rect x="56" y="56" width="8" height="8" fill="#1e293b"/>
                            <rect x="68" y="56" width="8" height="8" fill="#1e293b"/>
                            <rect x="56" y="68" width="8" height="8" fill="#1e293b"/>
                            <rect x="68" y="68" width="8" height="8" fill="#1e293b"/>
                            <rect x="80" y="56" width="8" height="8" fill="#1e293b"/>
                            <rect x="92" y="68" width="8" height="8" fill="#1e293b"/>
                            <rect x="80" y="80" width="8" height="8" fill="#1e293b"/>
                            <rect x="104" y="56" width="8" height="8" fill="#1e293b"/>
                            <rect x="56" y="80" width="8" height="8" fill="#1e293b"/>
                            <rect x="68" y="92" width="8" height="8" fill="#1e293b"/>
                            <rect x="92" y="80" width="8" height="8" fill="#1e293b"/>
                            <rect x="104" y="92" width="8" height="8" fill="#1e293b"/>
                        </svg>
                    </div>
                </div>
                <div style="text-align:center;margin-bottom:16px;">
                    <div style="font-size:11px;color:#6b7280;margin-bottom:6px;">Can't scan? Enter this code manually:</div>
                    <div style="font-family:monospace;font-size:13px;font-weight:700;color:#1e293b;background:#f3f4f6;border:1px solid #e5e7eb;border-radius:8px;padding:8px 14px;display:inline-block;letter-spacing:2px;">JBSW Y3DP EBQW 62LT</div>
                </div>
                <div style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:10px;padding:12px 14px;">
                    <div style="font-size:12px;color:#0369a1;line-height:1.6;">
                        <strong>Steps:</strong> Open Google Authenticator or Authy → Tap the <strong>+</strong> button → Select <em>Scan QR Code</em> → Scan the code above. Did not find this code in your app? Enter it manually.
                    </div>
                </div>
            </div>

            <!-- ── STEP 2b: SMS — Phone Number ── -->
            <div class="pm-modal-body" id="tfa-step-2-sms" style="display:none;">
                <div style="font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">SMS Verification Setup</div>
                <div style="font-size:12px;color:#6b7280;margin-bottom:18px;">We'll send verification codes to your phone number.</div>
                <div class="pm-form-group">
                    <label class="pm-form-label">Phone Number <span style="color:#ef4444;">*</span></label>
                    <input type="tel" class="pm-form-input" id="tfa-phone" placeholder="+1 (555) 123-4567">
                    <div style="font-size:11px;color:#9ca3af;margin-top:4px;">Standard SMS rates may apply.</div>
                </div>
                <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:10px;padding:12px 14px;margin-top:4px;">
                    <div style="display:flex;align-items:flex-start;gap:8px;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="#d97706" stroke-width="2" style="width:14px;height:14px;flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                        <div style="font-size:11px;font-weight:600;color:#92400e;margin-bottom:3px;">SMS 2FA Limitations</div>
                    </div>
                    <ul style="font-size:11px;color:#b45309;line-height:1.7;padding-left:20px;margin-top:4px;">
                        <li>Requires cellular coverage to receive codes</li>
                        <li>May have delays in code delivery</li>
                        <li>Less secure than authenticator apps</li>
                        <li>Carrier charges may apply</li>
                    </ul>
                </div>
            </div>

            <!-- ── STEP 3: Verify Code ── -->
            <div class="pm-modal-body" id="tfa-step-3" style="display:none;">
                <div style="font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Verify Your Code</div>
                <div style="font-size:12px;color:#6b7280;margin-bottom:18px;" id="tfa-verify-desc">Enter the 6-digit code from your authenticator app to confirm setup.</div>
                <div class="pm-form-group">
                    <label class="pm-form-label">Verification Code <span style="color:#ef4444;">*</span></label>
                    <input type="text" class="pm-form-input" id="tfa-verify-code" placeholder="000000" maxlength="6"
                           style="font-size:22px;font-weight:700;letter-spacing:8px;text-align:center;"
                           oninput="this.value=this.value.replace(/\D/g,'').substring(0,6); tfaCheckCode();">
                    <div id="tfa-code-error" style="font-size:12px;color:#dc2626;margin-top:4px;display:none;">Incorrect code. Please try again.</div>
                    <div id="tfa-code-ok" style="font-size:12px;color:#16a34a;font-weight:500;margin-top:4px;display:none;">
                        ✓ After verification, you'll receive your backup codes. Keep them safe!
                    </div>
                </div>
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 14px;margin-top:4px;">
                    <div style="font-size:11px;color:#166534;line-height:1.6;">The code refreshes every <strong>30 seconds</strong>. If it doesn't work, wait for the next code and try again.</div>
                </div>
            </div>

            <!-- ── STEP 4: Backup Codes ── -->
            <div class="pm-modal-body" id="tfa-step-4" style="display:none;">
                <div style="font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Save Your Backup Codes</div>
                <div style="font-size:12px;color:#6b7280;margin-bottom:16px;">Store these codes somewhere safe. Each code can only be used once.</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:16px;">
                    <div style="font-family:monospace;font-size:12px;font-weight:600;background:#f8fafc;border:1px solid #e5e7eb;border-radius:8px;padding:8px 12px;text-align:center;color:#1e293b;">8A3F-K91P</div>
                    <div style="font-family:monospace;font-size:12px;font-weight:600;background:#f8fafc;border:1px solid #e5e7eb;border-radius:8px;padding:8px 12px;text-align:center;color:#1e293b;">ZL7M-X24Q</div>
                    <div style="font-family:monospace;font-size:12px;font-weight:600;background:#f8fafc;border:1px solid #e5e7eb;border-radius:8px;padding:8px 12px;text-align:center;color:#1e293b;">9D2N-WR5T</div>
                    <div style="font-family:monospace;font-size:12px;font-weight:600;background:#f8fafc;border:1px solid #e5e7eb;border-radius:8px;padding:8px 12px;text-align:center;color:#1e293b;">HQ6B-YC8J</div>
                    <div style="font-family:monospace;font-size:12px;font-weight:600;background:#f8fafc;border:1px solid #e5e7eb;border-radius:8px;padding:8px 12px;text-align:center;color:#1e293b;">4VE1-MP3U</div>
                    <div style="font-family:monospace;font-size:12px;font-weight:600;background:#f8fafc;border:1px solid #e5e7eb;border-radius:8px;padding:8px 12px;text-align:center;color:#1e293b;">T5GA-LN7S</div>
                    <div style="font-family:monospace;font-size:12px;font-weight:600;background:#f8fafc;border:1px solid #e5e7eb;border-radius:8px;padding:8px 12px;text-align:center;color:#1e293b;">KF2O-DR9C</div>
                    <div style="font-family:monospace;font-size:12px;font-weight:600;background:#f8fafc;border:1px solid #e5e7eb;border-radius:8px;padding:8px 12px;text-align:center;color:#1e293b;">XW8H-JB6Z</div>
                </div>
                <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 14px;margin-bottom:12px;">
                    <div style="display:flex;align-items:flex-start;gap:8px;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2" style="width:14px;height:14px;flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                        <div style="font-size:11px;color:#dc2626;line-height:1.6;"><strong>Important:</strong> These codes will NOT be shown again. Copy or download them now. Each code works only once if you lose access to your 2FA device.</div>
                    </div>
                </div>
                <button type="button" onclick="tfaCopyCodes()" style="width:100%;padding:9px;border:1.5px dashed #d1d5db;border-radius:8px;background:#fff;color:#374151;font-size:12px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;display:flex;align-items:center;justify-content:center;gap:6px;" id="tfa-copy-btn">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                    Copy All Backup Codes
                </button>
                <div style="margin-top:10px;">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                        <input type="checkbox" id="tfa-saved-confirm" onchange="tfaCheckSaved()" style="width:15px;height:15px;accent-color:#1e293b;cursor:pointer;">
                        <span style="font-size:12px;color:#374151;font-weight:500;">I have saved my backup codes in a safe location</span>
                    </label>
                </div>
            </div>

            <!-- ── STEP 5: Success ── -->
            <div class="pm-modal-body" id="tfa-step-5" style="display:none;text-align:center;padding:32px 24px;">
                <div style="width:64px;height:64px;background:#f0fdf4;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2.5" style="width:32px;height:32px;"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div style="font-size:17px;font-weight:700;color:#1e293b;margin-bottom:8px;">Two-Factor Authentication Enabled!</div>
                <div style="font-size:13px;color:#6b7280;line-height:1.7;margin-bottom:20px;">Your account is now protected with an extra layer of security. You'll be asked for a verification code each time you log in.</div>
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:14px 16px;text-align:left;">
                    <div style="font-size:12px;color:#166534;line-height:1.7;">
                        <strong>What's next?</strong><br>
                        • Keep your backup codes stored safely<br>
                        • You can manage 2FA settings here anytime<br>
                        • Contact support if you lose access to your device
                    </div>
                </div>
            </div>

            <!-- Footer buttons -->
            <div class="pm-modal-footer" id="tfa-footer">
                <button type="button" class="pm-btn-cancel" id="tfa-btn-back" onclick="tfaBack()" style="display:none;">Back</button>
                <button type="button" class="pm-btn-cancel" id="tfa-btn-cancel" onclick="closeTfaModal()">Cancel</button>
                <button type="button" class="pm-btn-submit" id="tfa-btn-next" onclick="tfaNext()" style="background:#1e293b;min-width:140px;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <span id="tfa-btn-next-label">Continue Setup</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Login Activity Modal -->
    <div class="modal-backdrop" id="login-activity-modal">
        <div class="pm-modal-box" style="max-width:560px;">
            <div class="pm-modal-header">
                <div class="pm-modal-header-left">
                    <div class="pm-modal-header-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:20px;height:20px;color:#1e293b;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <div class="pm-modal-title">Login Activity</div>
                        <div class="pm-modal-subtitle">View your recent login history and active sessions</div>
                    </div>
                </div>
                <button class="pm-modal-close" onclick="closeLoginActivityModal()">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="pm-modal-body">
                <!-- Stats row -->
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px;">
                    <div style="background:#f8fafc;border:1px solid #e5e7eb;border-radius:10px;padding:14px;text-align:center;">
                        <div style="font-size:22px;font-weight:700;color:#1e293b;">12</div>
                        <div style="font-size:11px;color:#6b7280;margin-top:2px;">Total Logins</div>
                    </div>
                    <div style="background:#f8fafc;border:1px solid #e5e7eb;border-radius:10px;padding:14px;text-align:center;">
                        <div style="font-size:22px;font-weight:700;color:#1e293b;">3</div>
                        <div style="font-size:11px;color:#6b7280;margin-top:2px;">This Week</div>
                    </div>
                    <div style="background:#f8fafc;border:1px solid #e5e7eb;border-radius:10px;padding:14px;text-align:center;">
                        <div style="font-size:22px;font-weight:700;color:#16a34a;">0</div>
                        <div style="font-size:11px;color:#6b7280;margin-top:2px;">Suspicious Logins</div>
                    </div>
                </div>
                <!-- Login list -->
                <div style="font-size:13px;font-weight:600;color:#374151;margin-bottom:10px;">Recent Login History</div>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <div style="display:flex;align-items:center;gap:12px;border:1.5px solid #bbf7d0;background:#f0fdf4;border-radius:10px;padding:12px 14px;">
                        <div style="width:36px;height:36px;background:#1e293b;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.8" width="18" height="18"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:13px;font-weight:600;color:#1e293b;">Windows 11 · Chrome</div>
                            <div style="font-size:11px;color:#6b7280;">Manila, Philippines &bull; 192.168.1.1</div>
                        </div>
                        <div style="text-align:right;flex-shrink:0;">
                            <div style="font-size:11px;color:#6b7280;">Today, 12:25 AM</div>
                            <span style="font-size:10px;font-weight:600;background:#dcfce7;color:#16a34a;padding:2px 8px;border-radius:10px;">Current</span>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;border:1px solid #e5e7eb;background:#fff;border-radius:10px;padding:12px 14px;">
                        <div style="width:36px;height:36px;background:#374151;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.8" width="18" height="18"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:13px;font-weight:600;color:#1e293b;">iPhone 15 · Safari</div>
                            <div style="font-size:11px;color:#6b7280;">Manila, Philippines &bull; 192.168.1.5</div>
                        </div>
                        <div style="text-align:right;flex-shrink:0;">
                            <div style="font-size:11px;color:#6b7280;">Yesterday, 8:40 PM</div>
                            <button style="font-size:10px;font-weight:600;background:#fef2f2;color:#dc2626;border:none;padding:2px 8px;border-radius:10px;cursor:pointer;">Revoke</button>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;border:1px solid #e5e7eb;background:#fff;border-radius:10px;padding:12px 14px;">
                        <div style="width:36px;height:36px;background:#374151;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.8" width="18" height="18"><rect x="3" y="4" width="18" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="18" x2="12" y2="21"/></svg>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:13px;font-weight:600;color:#1e293b;">Mac Pro · Firefox</div>
                            <div style="font-size:11px;color:#6b7280;">Quezon City, Philippines &bull; 10.0.0.4</div>
                        </div>
                        <div style="text-align:right;flex-shrink:0;">
                            <div style="font-size:11px;color:#6b7280;">Mar 21, 7:12 PM</div>
                            <button style="font-size:10px;font-weight:600;background:#fef2f2;color:#dc2626;border:none;padding:2px 8px;border-radius:10px;cursor:pointer;">Revoke</button>
                        </div>
                    </div>
                </div>
                <div style="margin-top:14px;padding:12px 14px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;">
                    <div style="display:flex;align-items:flex-start;gap:8px;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2" style="width:14px;height:14px;flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div style="font-size:11px;color:#1d4ed8;line-height:1.6;">If you notice any unfamiliar login activity, immediately change your password and enable 2FA to secure your account.</div>
                    </div>
                </div>
            </div>
            <div class="pm-modal-footer">
                <button type="button" class="pm-btn-cancel" onclick="closeLoginActivityModal()">Close</button>
                <button type="button" class="pm-btn-submit" onclick="closeLoginActivityModal()" style="background:#dc2626;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>Sign Out All Devices</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal-backdrop" id="delete-modal">
        <div class="modal-box">
            <h2>Are you sure you want to delete your account?</h2>
            <p>Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.</p>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="form-group">
                    <input name="password" type="password" class="form-input" placeholder="Enter your password">
                    @if($errors->userDeletion->get('password'))
                        @foreach($errors->userDeletion->get('password') as $msg)
                            <div class="form-error">{{ $msg }}</div>
                        @endforeach
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="document.getElementById('delete-modal').classList.remove('open')">Cancel</button>
                    <button type="submit" class="btn-danger">Delete Account</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function switchTab(name) {
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.acct-nav-item[data-tab]').forEach(a => a.classList.remove('active'));

            const panel = document.getElementById('tab-' + name);
            if (panel) panel.classList.add('active');

            const navItem = document.querySelector('.acct-nav-item[data-tab="' + name + '"]');
            if (navItem) navItem.classList.add('active');

            history.replaceState(null, '', '?tab=' + name);
        }

        function filterOrders(query) {
            const q = query.toLowerCase();
            document.querySelectorAll('.order-card').forEach(function(card) {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(q) ? '' : 'none';
            });
        }

        // Combine first/last name before submit
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function() {
                var fn = form.querySelector('[name="first_name"]');
                var ln = form.querySelector('[name="last_name"]');
                var combined = form.querySelector('#combined-name');
                if (fn && ln && combined) {
                    combined.value = (fn.value + ' ' + ln.value).trim();
                }
            });
        });

        @if($errors->userDeletion->isNotEmpty())
            document.getElementById('delete-modal').classList.add('open');
            switchTab('settings');
        @endif

        /* ── Add Payment Modal JS ── */
        const pmLabels = {
            card:    { btn: 'Add Card',         icon: '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="15" height="15"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>' },
            ewallet: { btn: 'Add E-Wallet',     icon: '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-3.31 0-6 .895-6 2s2.69 2 6 2 6-.895 6-2-2.69-2-6-2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 10v4c0 1.105 2.69 2 6 2s6-.895 6-2v-4"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 14v4c0 1.105 2.69 2 6 2s6-.895 6-2v-4"/></svg>' },
            bank:    { btn: 'Add Bank Account', icon: '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 10v11M12 10v11M16 10v11"/></svg>' },
        };
        let currentPmType = 'card';

        function switchPmType(type) {
            currentPmType = type;
            ['card','ewallet','bank'].forEach(t => {
                document.getElementById('pm-type-' + t).classList.toggle('selected', t === type);
                document.getElementById('pm-form-' + t).style.display = t === type ? '' : 'none';
            });
            const lbl = pmLabels[type];
            document.getElementById('pm-submit-label').textContent = lbl.btn;
            document.getElementById('pm-submit-btn').innerHTML = lbl.icon + '<span id="pm-submit-label">' + lbl.btn + '</span>';
        }

        function handleAddPayment() {
            const type = currentPmType;
            const storeUrl = document.getElementById('pm-store-url').value;
            const csrf    = document.getElementById('pm-csrf').value;

            const body = new URLSearchParams({ _token: csrf, type });

            if (type === 'card') {
                const num  = document.getElementById('pm-card-number').value.trim();
                const name = document.getElementById('pm-card-name').value.trim();
                const exp  = document.getElementById('pm-card-expiry').value.trim();
                const cvv  = document.getElementById('pm-card-cvv').value.trim();
                const ct   = document.getElementById('pm-card-type').value;
                if (!num || !name || !exp || !cvv) { alert('Please fill in all required card fields.'); return; }
                body.append('card_number', num);
                body.append('card_name', name);
                body.append('card_expiry', exp);
                body.append('card_cvv', cvv);
                body.append('card_type', ct);
            } else if (type === 'ewallet') {
                const provider = document.getElementById('pm-ew-provider').value;
                const phone    = document.getElementById('pm-ew-phone').value.trim();
                const ewname   = document.getElementById('pm-ew-name').value.trim();
                if (!provider || !phone || !ewname) { alert('Please fill in all required e-wallet fields.'); return; }
                body.append('ew_provider', provider);
                body.append('ew_phone', phone);
                body.append('ew_name', ewname);
            } else {
                const bname   = document.getElementById('pm-bank-name').value.trim();
                const bacct   = document.getElementById('pm-bank-account').value.trim();
                const bholder = document.getElementById('pm-bank-holder').value.trim();
                const btype   = document.getElementById('pm-bank-type').value;
                if (!bname || !bacct || !bholder) { alert('Please fill in all required bank fields.'); return; }
                body.append('bank_name', bname);
                body.append('bank_account', bacct);
                body.append('bank_holder', bholder);
                body.append('bank_type', btype);
            }

            const btn = document.getElementById('pm-submit-btn');
            btn.disabled = true;

            fetch(storeUrl, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'Content-Type': 'application/x-www-form-urlencoded' },
                body: body.toString()
            })
            .then(r => r.json())
            .then(data => {
                btn.disabled = false;
                if (data.success) {
                    document.getElementById('add-payment-modal').classList.remove('open');
                    window.location.href = '{{ route("account", ["tab" => "payment"]) }}';
                } else {
                    const msg = data.errors ? Object.values(data.errors).flat().join('\n') : 'Failed to add payment method.';
                    alert(msg);
                }
            })
            .catch(() => { btn.disabled = false; alert('An error occurred. Please try again.'); });
        }

        function pmDelete(id) {
            if (!confirm('Remove this payment method?')) return;
            const csrf = document.getElementById('pm-csrf').value;
            fetch('/account/payment-methods/' + id, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'Content-Type': 'application/x-www-form-urlencoded' },
                body: '_token=' + csrf + '&_method=DELETE'
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const row = document.getElementById('pm-row-' + id);
                    if (row) row.remove();
                    const panel = document.getElementById('pm-list-panel');
                    const remaining = panel ? panel.querySelectorAll('.payment-card') : [];
                    if (remaining.length === 0) {
                        const addBtn = panel.querySelector('.add-payment-btn');
                        const emptyMsg = document.createElement('p');
                        emptyMsg.id = 'pm-empty-msg';
                        emptyMsg.style.cssText = 'font-size:13px;color:#6b7280;text-align:center;padding:20px 0;';
                        emptyMsg.textContent = 'No payment methods saved yet.';
                        panel.insertBefore(emptyMsg, addBtn);
                    }
                } else { alert('Failed to remove payment method.'); }
            })
            .catch(() => alert('An error occurred.'));
        }

        function pmSetDefault(id) {
            const csrf = document.getElementById('pm-csrf').value;
            fetch('/account/payment-methods/' + id + '/default', {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'Content-Type': 'application/x-www-form-urlencoded' },
                body: '_token=' + csrf
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) { window.location.reload(); }
                else { alert('Failed to update default.'); }
            })
            .catch(() => alert('An error occurred.'));
        }

        /* Format card number with spaces */
        document.addEventListener('DOMContentLoaded', function() {
            const cardNum = document.getElementById('pm-card-number');
            if (cardNum) {
                cardNum.addEventListener('input', function() {
                    let v = this.value.replace(/\D/g, '').substring(0, 16);
                    this.value = v.replace(/(\d{4})(?=\d)/g, '$1 ');
                });
            }
            const expiry = document.getElementById('pm-card-expiry');
            if (expiry) {
                expiry.addEventListener('input', function() {
                    let v = this.value.replace(/\D/g, '').substring(0, 4);
                    if (v.length >= 3) v = v.substring(0,2) + '/' + v.substring(2);
                    this.value = v;
                });
            }
        });

        /* ── TFA Multi-step Modal ── */
        let tfaMethod = 'app';
        let tfaCurrentStep = 1;

        const tfaAllSteps = ['tfa-step-1','tfa-step-2-app','tfa-step-2-sms','tfa-step-3','tfa-step-4','tfa-step-5'];

        const tfaStepSubtitles = {
            1: 'Secure your account with an additional layer of protection',
            '2-app': 'Scan the QR code with your authenticator app',
            '2-sms': 'Enter your phone number to receive verification codes',
            3: 'Enter the verification code to confirm setup',
            4: 'Save your backup codes before continuing',
            5: '2FA has been successfully enabled on your account'
        };

        function tfaShowStep(stepId) {
            tfaAllSteps.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.display = 'none';
            });
            const target = document.getElementById('tfa-step-' + stepId);
            if (target) target.style.display = '';
            document.getElementById('tfa-subtitle').textContent = tfaStepSubtitles[stepId] || '';
        }

        function openTfaModal() {
            tfaCurrentStep = 1;
            tfaMethod = 'app';
            document.getElementById('tfa-type-app').classList.add('selected');
            document.getElementById('tfa-type-sms').classList.remove('selected');
            tfaShowStep(1);
            tfaUpdateFooter();
            document.getElementById('tfa-modal').classList.add('open');
        }

        function closeTfaModal() {
            document.getElementById('tfa-modal').classList.remove('open');
            // reset
            const codeInput = document.getElementById('tfa-verify-code');
            if (codeInput) codeInput.value = '';
            document.getElementById('tfa-code-error').style.display = 'none';
            document.getElementById('tfa-code-ok').style.display = 'none';
            const cb = document.getElementById('tfa-saved-confirm');
            if (cb) cb.checked = false;
            const copyBtn = document.getElementById('tfa-copy-btn');
            if (copyBtn) copyBtn.innerHTML = '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg> Copy All Backup Codes';
        }

        function selectTfaMethod(method) {
            tfaMethod = method;
            document.getElementById('tfa-type-app').classList.toggle('selected', method === 'app');
            document.getElementById('tfa-type-sms').classList.toggle('selected', method === 'sms');
        }

        function tfaUpdateFooter() {
            const backBtn   = document.getElementById('tfa-btn-back');
            const cancelBtn = document.getElementById('tfa-btn-cancel');
            const nextBtn   = document.getElementById('tfa-btn-next');
            const nextLabel = document.getElementById('tfa-btn-next-label');

            backBtn.style.display   = tfaCurrentStep > 1 ? '' : 'none';
            cancelBtn.style.display = tfaCurrentStep >= 5 ? 'none' : '';
            nextBtn.style.display   = '';

            if (tfaCurrentStep === 1) {
                nextBtn.style.background = '#1e293b';
                nextLabel.textContent = 'Continue Setup';
                nextBtn.disabled = false;
            } else if (tfaCurrentStep === 2) {
                nextBtn.style.background = '#1e293b';
                nextLabel.textContent = tfaMethod === 'sms' ? 'Continue to Verification' : 'Continue to Verify';
                nextBtn.disabled = false;
            } else if (tfaCurrentStep === 3) {
                nextBtn.style.background = '#1e293b';
                nextLabel.textContent = 'Verify & Continue';
                const code = document.getElementById('tfa-verify-code');
                nextBtn.disabled = !code || code.value.length < 6;
            } else if (tfaCurrentStep === 4) {
                nextBtn.style.background = '#16a34a';
                nextLabel.textContent = 'I\'ve Saved My Codes';
                const cb = document.getElementById('tfa-saved-confirm');
                nextBtn.disabled = !cb || !cb.checked;
            } else if (tfaCurrentStep === 5) {
                nextBtn.style.background = '#1e293b';
                nextLabel.textContent = 'Done';
                nextBtn.disabled = false;
            }
        }

        function tfaNext() {
            if (tfaCurrentStep === 1) {
                tfaCurrentStep = 2;
                tfaShowStep(tfaMethod === 'sms' ? '2-sms' : '2-app');
                if (tfaMethod === 'sms') {
                    document.getElementById('tfa-verify-desc').textContent = 'Enter the 6-digit code sent to your phone number.';
                } else {
                    document.getElementById('tfa-verify-desc').textContent = 'Enter the 6-digit code from your authenticator app to confirm setup.';
                }
            } else if (tfaCurrentStep === 2) {
                if (tfaMethod === 'sms') {
                    const phone = document.getElementById('tfa-phone').value.trim();
                    if (!phone) {
                        document.getElementById('tfa-phone').focus();
                        document.getElementById('tfa-phone').style.borderColor = '#dc2626';
                        return;
                    }
                    document.getElementById('tfa-phone').style.borderColor = '';
                }
                tfaCurrentStep = 3;
                tfaShowStep(3);
                const codeInput = document.getElementById('tfa-verify-code');
                if (codeInput) { codeInput.value = ''; codeInput.focus(); }
                document.getElementById('tfa-code-error').style.display = 'none';
                document.getElementById('tfa-code-ok').style.display = 'none';
            } else if (tfaCurrentStep === 3) {
                const code = document.getElementById('tfa-verify-code').value;
                if (code.length < 6) return;
                /* Accept any 6-digit code as valid for demo */
                document.getElementById('tfa-code-error').style.display = 'none';
                tfaCurrentStep = 4;
                tfaShowStep(4);
                document.getElementById('tfa-saved-confirm').checked = false;
            } else if (tfaCurrentStep === 4) {
                const cb = document.getElementById('tfa-saved-confirm');
                if (!cb.checked) return;
                tfaCurrentStep = 5;
                tfaShowStep(5);
            } else if (tfaCurrentStep === 5) {
                /* Mark 2FA as enabled in the UI */
                const enableBtn = document.querySelector('.btn-action-blue');
                if (enableBtn) {
                    enableBtn.innerHTML = '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> 2FA Enabled';
                    enableBtn.style.background = '#f0fdf4';
                    enableBtn.style.color = '#16a34a';
                    enableBtn.style.borderColor = '#bbf7d0';
                    enableBtn.onclick = null;
                }
                closeTfaModal();
                return;
            }
            tfaUpdateFooter();
        }

        function tfaBack() {
            if (tfaCurrentStep === 2) {
                tfaCurrentStep = 1;
                tfaShowStep(1);
            } else if (tfaCurrentStep === 3) {
                tfaCurrentStep = 2;
                tfaShowStep(tfaMethod === 'sms' ? '2-sms' : '2-app');
            } else if (tfaCurrentStep === 4) {
                tfaCurrentStep = 3;
                tfaShowStep(3);
            } else if (tfaCurrentStep === 5) {
                tfaCurrentStep = 4;
                tfaShowStep(4);
            }
            tfaUpdateFooter();
        }

        function tfaCheckCode() {
            const code = document.getElementById('tfa-verify-code').value;
            const okEl  = document.getElementById('tfa-code-ok');
            const errEl = document.getElementById('tfa-code-error');
            if (code.length === 6) {
                okEl.style.display  = '';
                errEl.style.display = 'none';
            } else {
                okEl.style.display  = 'none';
                errEl.style.display = 'none';
            }
            tfaUpdateFooter();
        }

        function tfaCheckSaved() {
            tfaUpdateFooter();
        }

        function tfaCopyCodes() {
            const codes = ['8A3F-K91P','ZL7M-X24Q','9D2N-WR5T','HQ6B-YC8J','4VE1-MP3U','T5GA-LN7S','KF2O-DR9C','XW8H-JB6Z'];
            navigator.clipboard.writeText(codes.join('\n')).then(() => {
                const btn = document.getElementById('tfa-copy-btn');
                btn.innerHTML = '<svg fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Copied!';
                btn.style.borderColor = '#bbf7d0';
                btn.style.color = '#16a34a';
            }).catch(() => {
                const ta = document.createElement('textarea');
                ta.value = codes.join('\n');
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
                const btn = document.getElementById('tfa-copy-btn');
                btn.innerHTML = '<svg fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Copied!';
            });
        }

        function openLoginActivityModal() {
            document.getElementById('login-activity-modal').classList.add('open');
        }
        function closeLoginActivityModal() {
            document.getElementById('login-activity-modal').classList.remove('open');
        }
        /* ── Order Detail Modal ── */
        function openOrderDetail(o) {
            // Header
            document.getElementById('od-title').textContent  = 'Track Your Order';
            document.getElementById('od-sub').textContent    = 'Order ID-' + o.id;
            document.getElementById('od-order-label').textContent = 'Order #' + o.number;

            // Status badge
            const badge = document.getElementById('od-status-badge');
            badge.textContent  = o.status;
            badge.className    = 'order-badge ' + o.statusClass;

            // Tracking number (generated from order id)
            document.getElementById('od-tracking').textContent = 'TRK' + String(o.id).padStart(9, '0');

            // Meta strip
            document.getElementById('od-date').textContent     = o.date;
            document.getElementById('od-shipping').textContent = o.shipping;
            document.getElementById('od-items-count').textContent = (o.items ? o.items.length : 0) + ' Item' + (o.items && o.items.length !== 1 ? 's' : '');

            // Timeline — steps defined, highlight based on status
            const statusOrder = ['pending','processing','shipped','delivered'];
            const statusMeta = {
                pending:    { label: 'Pending',    desc: 'Order received and is being processed.',                  loc: 'Processing Center', time: '10:00 AM' },
                processing: { label: 'Processing', desc: 'Order is being packed and prepared for shipment.',        loc: 'Processing Center', time: '12:00 PM' },
                shipped:    { label: 'Shipped',    desc: 'Order has been shipped and is on its way to the customer.',loc: 'Shipping Center',  time: '08:09 AM' },
                delivered:  { label: 'Delivered',  desc: 'Order has been successfully delivered.',                  loc: 'Delivery Address',  time: '02:30 PM' },
            };
            const currentIdx = statusOrder.indexOf(o.status.toLowerCase());
            const calIcons = {
                done:    '<svg fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>',
                active:  '<svg fill="none" viewBox="0 0 24 24" stroke="#1e293b" stroke-width="2.5" style="width:14px;height:14px;"><circle cx="12" cy="12" r="4" fill="#1e293b"/></svg>',
                pending: '<svg fill="none" viewBox="0 0 24 24" stroke="#d1d5db" stroke-width="2" style="width:14px;height:14px;"><circle cx="12" cy="12" r="4"/></svg>',
            };
            const tlContainer = document.getElementById('od-timeline');
            tlContainer.innerHTML = '';
            const orderDateObj = new Date(o.date);
            statusOrder.forEach((step, idx) => {
                const meta      = statusMeta[step];
                const isDone    = idx < currentIdx || o.status.toLowerCase() === 'delivered';
                const isActive  = idx === currentIdx;
                const isPending = idx > currentIdx;
                const dotClass  = isDone ? 'done' : isActive ? 'active' : 'pending';
                const dotIcon   = isDone ? calIcons.done : isActive ? calIcons.active : calIcons.pending;
                const contentDim = isPending ? ' dim' : '';
                // Compute step date
                const stepDate = new Date(orderDateObj);
                stepDate.setDate(stepDate.getDate() + idx);
                const stepDateStr = stepDate.toISOString().split('T')[0];
                const isLast = idx === statusOrder.length - 1;
                tlContainer.innerHTML += `
                    <div class="timeline-item ${isDone ? 'done' : ''}">
                        ${!isLast ? '<div class="timeline-line"></div>' : ''}
                        <div class="timeline-dot ${dotClass}">${dotIcon}</div>
                        <div class="timeline-content${contentDim}">
                            <div class="tc-title">${meta.label}</div>
                            <div class="tc-desc">${meta.desc}</div>
                            ${!isPending ? `<div class="tc-meta">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>${stepDateStr}
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>${meta.loc} ${meta.time}
                            </div>` : ''}
                        </div>
                    </div>`;
            });

            // Estimated delivery (order date + 7 days)
            const estDate = new Date(orderDateObj);
            estDate.setDate(estDate.getDate() + 7);
            document.getElementById('od-est-date').textContent = estDate.toISOString().split('T')[0];

            // Address
            const fullName = (o.name || '').trim();
            document.getElementById('od-addr-name').textContent = fullName || 'N/A';
            const addrParts = [o.street, o.city, o.state ? o.state + ' ' + (o.zip || '') : o.zip].filter(Boolean);
            document.getElementById('od-addr-line').textContent = addrParts.join(', ') || '—';
            document.getElementById('od-addr-phone-text').textContent = o.phone || '—';
            document.getElementById('od-addr-phone').style.display = o.phone ? '' : 'none';

            // Items
            const itemsList = document.getElementById('od-items-list');
            itemsList.innerHTML = '';
            if (o.items && o.items.length) {
                o.items.forEach(item => {
                    itemsList.innerHTML += `
                        <div class="order-item-row">
                            <div class="order-item-img">
                                <svg fill="none" viewBox="0 0 24 24" stroke="#d1d5db" stroke-width="1" style="width:24px;height:24px;"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9l4-4 4 4 4-4 4 4"/><circle cx="8.5" cy="13.5" r="1.5"/></svg>
                            </div>
                            <div class="order-item-info">
                                <div class="oi-name">${item.name}</div>
                                <div class="oi-qty">Quantity: ${item.qty}</div>
                            </div>
                            <div class="order-item-price">₱${item.subtotal}</div>
                        </div>`;
                });
            } else {
                itemsList.innerHTML = '<div style="font-size:13px;color:#9ca3af;text-align:center;padding:12px;">No items found.</div>';
            }

            // Totals
            document.getElementById('od-subtotal').textContent     = '₱' + o.subtotal;
            document.getElementById('od-shipping-cost').textContent = parseFloat(o.shippingCost) > 0 ? '₱' + o.shippingCost : 'Free';
            document.getElementById('od-tax').textContent          = '₱' + o.tax;
            document.getElementById('od-total').textContent        = '₱' + o.total;

            document.getElementById('order-detail-modal').classList.add('open');
        }

        function wishlistAddToCart(productId, btn) {
            const original = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = 'Adding...';
            fetch('/cart/add/' + productId, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({})
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const badge = document.getElementById('cart-badge');
                    if (badge) { badge.textContent = data.count; badge.style.display = 'flex'; }
                    btn.innerHTML = 'Added!';
                    btn.style.background = '#22a05a';
                    setTimeout(() => { btn.innerHTML = original; btn.style.background = ''; btn.disabled = false; }, 1500);
                } else {
                    btn.innerHTML = original; btn.disabled = false;
                }
            })
            .catch(() => { btn.innerHTML = original; btn.disabled = false; });
        }

        function removeFromWishlist(id) {
            fetch('/wishlist/remove/' + id, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(() => location.reload());
        }
    </script>

</body>
</html>
