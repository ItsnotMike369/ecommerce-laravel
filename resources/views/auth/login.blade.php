<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login - ShopLine</title>
        <link rel="icon" type="image/png" href="/images/shopline-logo.png">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body { font-family: 'Inter', sans-serif; background: #f5f5f5; color: #1a1a2e; min-height: 100vh; display: flex; flex-direction: column; }

            /* ── Navbar ── */
            .navbar { background: #fff; border-bottom: 1px solid #e8e8e8; padding: 0 32px; height: 64px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; }
            .navbar-brand { display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 18px; color: #1a1a2e; text-decoration: none; flex-shrink: 0; }
            .navbar-brand svg { width: 36px; height: 36px; }
            .navbar-search { flex: 1; max-width: 500px; margin: 0 32px; position: relative; }
            .navbar-search input { width: 100%; padding: 9px 16px 9px 42px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: #f8f8f8; outline: none; color: #555; font-family: 'Inter', sans-serif; }
            .navbar-search input:focus { border-color: #aaa; background: #fff; }
            .navbar-search .search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #aaa; width: 16px; height: 16px; pointer-events: none; }
            .navbar-actions { display: flex; align-items: center; gap: 22px; flex-shrink: 0; }
            .navbar-actions a { color: #555; text-decoration: none; display: flex; align-items: center; }
            .navbar-actions a:hover { color: #1a1a2e; }

            /* ── Nav links ── */
            .nav-links { background: #fff; border-bottom: 1px solid #e8e8e8; padding: 0 32px; display: flex; gap: 32px; }
            .nav-links a { font-size: 14px; color: #444; text-decoration: none; padding: 13px 0; display: inline-block; border-bottom: 2px solid transparent; transition: color 0.15s, border-color 0.15s; }
            .nav-links a:hover, .nav-links a.active { color: #1a1a2e; border-bottom-color: #1a1a2e; }

            /* ── Main ── */
            .main-content { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 48px 16px; }

            /* ── Auth card ── */
            .auth-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 20px rgba(0,0,0,0.08); padding: 36px 36px 28px; width: 100%; max-width: 460px; }
            .auth-title { text-align: center; font-size: 24px; font-weight: 700; margin-bottom: 6px; color: #1a1a2e; }
            .auth-subtitle { text-align: center; font-size: 14px; color: #888; margin-bottom: 24px; }

            /* ── Tabs ── */
            .auth-tabs { display: flex; background: #f0f0f0; border-radius: 10px; padding: 4px; margin-bottom: 24px; }
            .auth-tab { flex: 1; text-align: center; padding: 8px; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; border: none; background: transparent; color: #666; transition: all 0.2s; text-decoration: none; display: block; }
            .auth-tab.active { background: #fff; color: #1a1a2e; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }

            /* ── Form ── */
            .form-group { margin-bottom: 14px; }
            .form-label { display: none; }
            .form-input-wrap { position: relative; }
            .form-input-wrap svg { display: none; }
            .form-input { width: 100%; padding: 14px 18px; border: 1.5px solid #dde1e7; border-radius: 12px; font-size: 15px; outline: none; color: #1a1a2e; background: #fff; transition: border-color 0.2s, box-shadow 0.2s; font-family: 'Inter', sans-serif; }
            .form-input::placeholder { color: #8a8f9b; font-size: 15px; }
            .form-input:focus { border-color: #b0b8c9; box-shadow: 0 0 0 3px rgba(100,116,139,0.08); background: #fff; }

            /* ── Footer row of form ── */
            .form-footer { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
            .remember-me { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #555; cursor: pointer; }
            .remember-me input { width: 14px; height: 14px; cursor: pointer; }
            .forgot-link { font-size: 13px; color: #555; text-decoration: none; }
            .forgot-link:hover { text-decoration: underline; color: #1a1a2e; }

            /* ── Buttons ── */
            .btn-primary { width: 100%; padding: 12px; background: #1a1a2e; color: #fff; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; transition: background 0.2s; margin-bottom: 20px; font-family: 'Inter', sans-serif; }
            .btn-primary:hover { background: #2d2d4e; }

            /* ── Divider ── */
            .or-divider { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
            .or-divider::before, .or-divider::after { content: ''; flex: 1; height: 1px; background: #e8e8e8; }
            .or-divider span { font-size: 13px; color: #aaa; white-space: nowrap; }

            /* ── Social buttons ── */
            .social-buttons { display: flex; gap: 12px; margin-bottom: 20px; }
            .btn-social { flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 10px; border: 1px solid #e0e0e0; border-radius: 8px; background: #fff; font-size: 14px; font-weight: 500; color: #444; cursor: pointer; text-decoration: none; transition: border-color 0.2s, background 0.2s; font-family: 'Inter', sans-serif; }
            .btn-social:hover { border-color: #bbb; background: #fafafa; }

            /* ── Admin link ── */
            .admin-link { background: #f9f9fb; border-top: 1px solid #f0f0f0; margin: 0 -36px -28px; border-radius: 0 0 16px 16px; padding: 16px; text-align: center; }
            .admin-link a { font-size: 13px; color: #888; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
            .admin-link a:hover { color: #555; }

            /* ── Alert ── */
            .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; font-size: 13px; padding: 10px 14px; border-radius: 8px; margin-bottom: 16px; }
            .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; font-size: 12px; padding: 6px 0 2px; }

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

        <!-- Navbar -->
        <nav class="navbar">
            <a href="{{ url('/') }}" class="navbar-brand">
                <img src="{{ asset('images/shopline-logo.png') }}" alt="ShopLine" style="height:40px;width:auto;">
                ShopLine
            </a>
            <div class="navbar-search">
                <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" placeholder="Search for products...">
            </div>
            <div class="navbar-actions">
                <a href="{{ route('login') }}" title="Account">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7z"/>
                    </svg>
                </a>
                <a href="#" title="Cart">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h11M10 19a1 1 0 1 0 2 0 1 1 0 0 0-2 0zm7 0a1 1 0 1 0 2 0 1 1 0 0 0-2 0z"/>
                    </svg>
                </a>
            </div>
        </nav>

        <!-- Nav links -->
        <div class="nav-links">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ route('shop') }}">Shop</a>
            <a href="{{ route('shop', ['category' => 'Electronics']) }}">Electronics</a>
            <a href="{{ route('shop', ['category' => 'Clothing']) }}">Clothing</a>
            <a href="{{ route('shop', ['category' => 'Home & Garden']) }}">Home &amp; Garden</a>
            <a href="{{ route('shop', ['category' => 'Sports & Outdoors']) }}">Sports</a>
        </div>

        <!-- Main -->
        <div class="main-content">
            <div class="auth-card">
                <h1 class="auth-title">Welcome</h1>
                <p class="auth-subtitle">Sign in to your account or create a new one</p>

                <!-- Tabs -->
                <div class="auth-tabs">
                    <a href="{{ route('login') }}" class="auth-tab active">Login</a>
                    <a href="{{ route('register') }}" class="auth-tab">Register</a>
                </div>

                @if (session('status'))
                    <div class="alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <div class="form-input-wrap">
                            <input class="form-input" type="text" name="login_id" placeholder="Email or mobile number" value="{{ old('login_id') }}" required autofocus autocomplete="username">
                        </div>
                        @error('login_id')<div class="alert-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <div class="form-input-wrap">
                            <input class="form-input" type="password" name="password" id="login-password" placeholder="Password" required>
                        </div>
                        @error('password')<div class="alert-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-footer">
                        <label class="remember-me">
                            <input type="checkbox" name="remember">
                            Remember me
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                        @endif
                    </div>
                    <button type="submit" class="btn-primary">Sign In</button>
                </form>

                <div class="or-divider"><span>Or continue with</span></div>
                <div class="social-buttons">
                    <a href="{{ route('auth.google') }}" class="btn-social">
                        <svg width="18" height="18" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                        Google
                    </a>
                    <a href="{{ route('auth.facebook') }}" class="btn-social">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.93-1.956 1.886v2.268h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/></svg>
                        Facebook
                    </a>
                </div>

                <div class="admin-link">
                    <a href="{{ route('admin.login') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="3" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                        Admin Login
                    </a>
                </div>
            </div>
        </div>

        @include('layouts._footer')

    </body>
</html>
