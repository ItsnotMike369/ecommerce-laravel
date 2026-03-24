<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/images/shopline-logo.png">`n    <link rel="icon" type="image/png" href="/images/shopline-logo.png">
    <title>Admin Login - ShopLine</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0f172a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            color: #1e293b;
        }

        .top-icon {
            width: 64px; height: 64px;
            background: #1e293b;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 20px;
        }
        .top-icon svg { color: #fff; width: 30px; height: 30px; }

        .page-title {
            font-size: 28px; font-weight: 700;
            color: #fff; margin-bottom: 6px; text-align: center;
        }
        .page-subtitle {
            font-size: 14px; color: #94a3b8;
            margin-bottom: 28px; text-align: center;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            padding: 28px 28px 24px;
            width: 100%; max-width: 420px;
            box-shadow: 0 4px 32px rgba(0,0,0,0.25);
        }

        .card-title { font-size: 17px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .card-sub   { font-size: 13px; color: #64748b; margin-bottom: 22px; }

        .form-group { margin-bottom: 14px; }
        .form-label { display: none; }
        .input-wrap { position: relative; }
        .input-wrap svg.left-icon { display: none; }
        .form-input {
            width: 100%; padding: 14px 18px;
            border: 1.5px solid #dde1e7; border-radius: 12px;
            font-size: 15px; outline: none; color: #1e293b;
            background: #fff; font-family: 'Inter', sans-serif;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-input::placeholder { color: #8a8f9b; font-size: 15px; }
        .form-input:focus { border-color: #b0b8c9; box-shadow: 0 0 0 3px rgba(100,116,139,0.08); background: #fff; }

        .forgot-link {
            display: inline-block; font-size: 13px; color: #475569;
            text-decoration: none; margin-bottom: 18px;
        }
        .forgot-link:hover { text-decoration: underline; }

        .btn-submit {
            width: 100%; padding: 12px;
            background: #1e293b; color: #fff;
            border: none; border-radius: 8px;
            font-size: 15px; font-weight: 600;
            cursor: pointer; font-family: 'Inter', sans-serif;
            transition: background 0.2s; margin-bottom: 18px;
        }
        .btn-submit:hover { background: #334155; }

        .back-link {
            text-align: center; margin-bottom: 18px;
        }
        .back-link a {
            font-size: 13px; color: #475569;
            text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .back-link a:hover { color: #1e293b; }

        .notice {
            border: 1px solid #e5e7eb; border-radius: 8px;
            padding: 12px 14px;
            display: flex; align-items: flex-start; gap: 10px;
            background: #f9fafb;
        }
        .notice svg { color: #6b7280; flex-shrink: 0; margin-top: 1px; width: 15px; height: 15px; }
        .notice p { font-size: 12px; color: #6b7280; line-height: 1.5; }

        .footer-link {
            margin-top: 28px;
            font-size: 13px; color: #64748b;
        }
        .footer-link a { color: #94a3b8; text-decoration: none; }
        .footer-link a:hover { color: #fff; }

        .alert-error {
            background: #fef2f2; border: 1px solid #fecaca;
            color: #991b1b; font-size: 13px;
            padding: 10px 14px; border-radius: 8px;
            margin-bottom: 16px;
        }
        .field-error { font-size: 12px; color: #dc2626; margin-top: 4px; display: block; }
    </style>
</head>
<body>

    <div class="top-icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
        </svg>
    </div>

    <h1 class="page-title">Admin Portal</h1>
    <p class="page-subtitle">Sign in to access the admin dashboard</p>

    <div class="card">
        <h2 class="card-title">Administrator Login</h2>
        <p class="card-sub">Enter your credentials to access the admin panel</p>

        @if ($errors->has('session'))
            <div class="alert-error" style="background:#fef3c7;border-color:#fcd34d;color:#92400e;">
                {{ $errors->first('session') }}
            </div>
        @elseif ($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <div class="form-group">
                <div class="input-wrap">
                    <input class="form-input" type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <div class="input-wrap">
                    <input class="form-input" type="password" name="password" id="admin-password" placeholder="Password" required>
                </div>
            </div>

            <a href="#" class="forgot-link">Forgot password?</a>

            <button type="submit" class="btn-submit">Sign In to Admin Panel</button>
        </form>

        <div class="back-link">
            <a href="{{ route('login') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Customer Login
            </a>
        </div>

        <div class="notice">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p>This is a restricted area. Only authorized administrators can access this portal.</p>
        </div>
    </div>

    <p class="footer-link"><a href="{{ url('/') }}">Return to Homepage</a></p>

</body>
</html>
