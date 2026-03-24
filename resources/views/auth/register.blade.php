<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register - ShopLine</title>
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
            .form-row { display: flex; gap: 10px; }
            .form-row .form-group { flex: 1; }
            .section-label { display: flex; align-items: center; gap: 5px; font-size: 13px; font-weight: 600; color: #1a1a2e; margin-bottom: 8px; }
            .section-label .help-icon { display: inline-flex; align-items: center; justify-content: center; width: 16px; height: 16px; border: 1.5px solid #888; border-radius: 50%; font-size: 10px; color: #888; cursor: default; flex-shrink: 0; }
            .form-label { display: block; font-size: 13px; font-weight: 600; color: #1a1a2e; margin-bottom: 8px; }
            .form-input-wrap { position: relative; }
            .form-input { width: 100%; padding: 14px 18px; border: 1.5px solid #dde1e7; border-radius: 12px; font-size: 15px; outline: none; color: #1a1a2e; background: #fff; transition: border-color 0.2s, box-shadow 0.2s; font-family: 'Inter', sans-serif; }
            .form-input::placeholder { color: #8a8f9b; }
            .form-input:focus { border-color: #b0b8c9; box-shadow: 0 0 0 3px rgba(100,116,139,0.08); }
            .form-select { width: 100%; padding: 14px 36px 14px 18px; border: 1.5px solid #dde1e7; border-radius: 12px; font-size: 15px; outline: none; color: #8a8f9b; background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23888' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 14px center; appearance: none; -webkit-appearance: none; transition: border-color 0.2s; font-family: 'Inter', sans-serif; cursor: pointer; }
            .form-select:focus { border-color: #b0b8c9; box-shadow: 0 0 0 3px rgba(100,116,139,0.08); outline: none; color: #1a1a2e; }
            .form-select.selected { color: #1a1a2e; }
            .field-note { font-size: 12px; color: #555; margin-top: 6px; line-height: 1.5; }

            /* ── Terms ── */
            .terms-check { display: flex; align-items: flex-start; gap: 8px; font-size: 13px; color: #555; margin-bottom: 20px; }
            .terms-check input { margin-top: 2px; width: 14px; height: 14px; flex-shrink: 0; cursor: pointer; }
            .terms-check a { color: #3b82f6; text-decoration: none; }
            .terms-check a:hover { text-decoration: underline; }

            /* ── Buttons ── */
            .btn-primary { width: 100%; padding: 12px; background: #1a1a2e; color: #fff; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; transition: background 0.2s; margin-bottom: 0; font-family: 'Inter', sans-serif; }
            .btn-primary:hover { background: #2d2d4e; }

            /* ── Admin link ── */
            .admin-link { background: #f9f9fb; border-top: 1px solid #f0f0f0; margin: 20px -36px -28px; border-radius: 0 0 16px 16px; padding: 16px; text-align: center; }
            .admin-link a { font-size: 13px; color: #888; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
            .admin-link a:hover { color: #555; }

            /* ── Alert ── */
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
                    <a href="{{ route('login') }}" class="auth-tab">Login</a>
                    <a href="{{ route('register') }}" class="auth-tab active">Register</a>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Name --}}
                    <div class="form-group">
                        <div class="section-label">Name</div>
                        <div class="form-row">
                            <div>
                                <input class="form-input" type="text" name="first_name" placeholder="First name" value="{{ old('first_name') }}" required autofocus>
                                @error('first_name')<div class="alert-error">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <input class="form-input" type="text" name="last_name" placeholder="Last name" value="{{ old('last_name') }}" required>
                                @error('last_name')<div class="alert-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Birthday --}}
                    <div class="form-group">
                        <div class="section-label">
                            Birthday
                            <span class="help-icon" title="Providing your birthday helps make sure you get the right experience.">?</span>
                        </div>
                        <div class="form-row">
                            <select class="form-select" name="birth_month" id="birth_month" onchange="this.classList.add('selected')">
                                <option value="" disabled selected>Month</option>
                                <option value="1" {{ old('birth_month')=='1'?'selected':'' }}>January</option>
                                <option value="2" {{ old('birth_month')=='2'?'selected':'' }}>February</option>
                                <option value="3" {{ old('birth_month')=='3'?'selected':'' }}>March</option>
                                <option value="4" {{ old('birth_month')=='4'?'selected':'' }}>April</option>
                                <option value="5" {{ old('birth_month')=='5'?'selected':'' }}>May</option>
                                <option value="6" {{ old('birth_month')=='6'?'selected':'' }}>June</option>
                                <option value="7" {{ old('birth_month')=='7'?'selected':'' }}>July</option>
                                <option value="8" {{ old('birth_month')=='8'?'selected':'' }}>August</option>
                                <option value="9" {{ old('birth_month')=='9'?'selected':'' }}>September</option>
                                <option value="10" {{ old('birth_month')=='10'?'selected':'' }}>October</option>
                                <option value="11" {{ old('birth_month')=='11'?'selected':'' }}>November</option>
                                <option value="12" {{ old('birth_month')=='12'?'selected':'' }}>December</option>
                            </select>
                            <select class="form-select" name="birth_day" id="birth_day" onchange="this.classList.add('selected')">
                                <option value="" disabled selected>Day</option>
                                @for ($d = 1; $d <= 31; $d++)
                                    <option value="{{ $d }}" {{ old('birth_day')==$d?'selected':'' }}>{{ $d }}</option>
                                @endfor
                            </select>
                            <select class="form-select" name="birth_year" id="birth_year" onchange="this.classList.add('selected')">
                                <option value="" disabled selected>Year</option>
                                @for ($y = date('Y'); $y >= 1900; $y--)
                                    <option value="{{ $y }}" {{ old('birth_year')==$y?'selected':'' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    {{-- Gender --}}
                    <div class="form-group">
                        <div class="section-label">
                            Gender
                            <span class="help-icon" title="You can change who can see your gender on your profile.">?</span>
                        </div>
                        <select class="form-select" name="gender" onchange="this.classList.add('selected')">
                            <option value="" disabled selected>Select your gender</option>
                            <option value="female" {{ old('gender')=='female'?'selected':'' }}>Female</option>
                            <option value="male" {{ old('gender')=='male'?'selected':'' }}>Male</option>
                            <option value="other" {{ old('gender')=='other'?'selected':'' }}>Other</option>
                        </select>
                    </div>

                    {{-- Mobile number or email --}}
                    <div class="form-group">
                        <div class="section-label">Mobile number or email</div>
                        <input class="form-input" type="text" name="login_id" placeholder="Mobile number or email" value="{{ old('login_id') }}" required autocomplete="username">
                        @error('login_id')<div class="alert-error">{{ $message }}</div>@enderror
                        <p class="field-note">You may receive notifications from us.</p>
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <div class="section-label">Password</div>
                        <input class="form-input" type="password" name="password" placeholder="Password" required>
                        @error('password')<div class="alert-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <input class="form-input" type="password" name="password_confirmation" placeholder="Confirm password" required>
                        @error('password_confirmation')<div class="alert-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="terms-check">
                        <input type="checkbox" name="terms" id="terms" required>
                        <label for="terms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
                    </div>

                    <button type="submit" class="btn-primary">Create Account</button>
                </form>

                <div class="admin-link">
                    <a href="{{ route('login') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="3" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                        Admin Login
                    </a>
                </div>
            </div>
        </div>

        @include('layouts._footer')

    </body>
</html>
