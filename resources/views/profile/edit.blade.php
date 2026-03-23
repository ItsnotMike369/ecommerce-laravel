<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile - ShopLine</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
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

        .content { padding: 28px; flex: 1; max-width: 860px; }
        .page-title { font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .page-sub { font-size: 13px; color: #64748b; margin-bottom: 28px; }

        .panel { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 28px; margin-bottom: 20px; }
        .panel-title { font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .panel-sub { font-size: 13px; color: #64748b; margin-bottom: 22px; }

        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px; }
        .form-input {
            width: 100%; padding: 9px 12px; border: 1px solid #d1d5db;
            border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif;
            color: #1e293b; background: #fff; outline: none; transition: border-color 0.15s;
        }
        .form-input:focus { border-color: #1e3a5f; box-shadow: 0 0 0 3px rgba(30,58,95,0.08); }
        .form-error { font-size: 12px; color: #dc2626; margin-top: 4px; }

        .btn-primary {
            padding: 10px 22px; background: #1e3a5f; color: #fff;
            border: none; border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; font-family: 'Inter', sans-serif; transition: background 0.15s;
        }
        .btn-primary:hover { background: #16304f; }
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
        .saved-msg { font-size: 13px; color: #16a34a; font-weight: 500; margin-left: 12px; }

        /* Modal */
        .modal-backdrop {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.4); z-index: 100;
            align-items: center; justify-content: center;
        }
        .modal-backdrop.open { display: flex; }
        .modal-box {
            background: #fff; border-radius: 12px; padding: 28px;
            width: 100%; max-width: 440px; box-shadow: 0 8px 32px rgba(0,0,0,0.15);
        }
        .modal-box h2 { font-size: 17px; font-weight: 700; color: #1e293b; margin-bottom: 8px; }
        .modal-box p { font-size: 13px; color: #64748b; margin-bottom: 18px; line-height: 1.6; }
        .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
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
            <a href="{{ route('dashboard') }}" class="nav-item">
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
            <a href="{{ route('profile.edit') }}" class="nav-item active">
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
            <span class="topbar-left">My Profile</span>
            <div class="topbar-user">
                <div class="info">
                    <div class="name">{{ Auth::user()->name }}</div>
                    <div class="role">{{ Auth::user()->email }}</div>
                </div>
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            </div>
        </header>

        <div class="content">
            <h1 class="page-title">My Profile</h1>
            <p class="page-sub">Manage your personal information and account security.</p>

            <!-- Profile Information -->
            <div class="panel">
                <div class="panel-title">Profile Information</div>
                <div class="panel-sub">Update your account's profile information and email address.</div>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="form-group">
                        <label class="form-label" for="name">Name</label>
                        <input id="name" name="name" type="text" class="form-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                        @if($errors->get('name'))
                            @foreach($errors->get('name') as $msg)
                                <div class="form-error">{{ $msg }}</div>
                            @endforeach
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input id="email" name="email" type="email" class="form-input" value="{{ old('email', $user->email) }}" required autocomplete="username">
                        @if($errors->get('email'))
                            @foreach($errors->get('email') as $msg)
                                <div class="form-error">{{ $msg }}</div>
                            @endforeach
                        @endif
                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <p style="font-size:12px;color:#64748b;margin-top:6px;">
                                Your email address is unverified.
                                <button form="send-verification" style="background:none;border:none;color:#1e3a5f;font-size:12px;cursor:pointer;text-decoration:underline;font-family:'Inter',sans-serif;">Re-send verification email</button>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <p style="font-size:12px;color:#16a34a;margin-top:4px;">A new verification link has been sent to your email.</p>
                            @endif
                        @endif
                    </div>

                    <div style="display:flex;align-items:center;">
                        <button type="submit" class="btn-primary">Save Changes</button>
                        @if (session('status') === 'profile-updated')
                            <span class="saved-msg">Saved successfully.</span>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Update Password -->
            <div class="panel">
                <div class="panel-title">Update Password</div>
                <div class="panel-sub">Ensure your account is using a long, random password to stay secure.</div>

                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label class="form-label" for="update_password_current_password">Current Password</label>
                        <input id="update_password_current_password" name="current_password" type="password" class="form-input" autocomplete="current-password">
                        @if($errors->updatePassword->get('current_password'))
                            @foreach($errors->updatePassword->get('current_password') as $msg)
                                <div class="form-error">{{ $msg }}</div>
                            @endforeach
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="update_password_password">New Password</label>
                        <input id="update_password_password" name="password" type="password" class="form-input" autocomplete="new-password">
                        @if($errors->updatePassword->get('password'))
                            @foreach($errors->updatePassword->get('password') as $msg)
                                <div class="form-error">{{ $msg }}</div>
                            @endforeach
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="update_password_password_confirmation">Confirm Password</label>
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-input" autocomplete="new-password">
                        @if($errors->updatePassword->get('password_confirmation'))
                            @foreach($errors->updatePassword->get('password_confirmation') as $msg)
                                <div class="form-error">{{ $msg }}</div>
                            @endforeach
                        @endif
                    </div>

                    <div style="display:flex;align-items:center;">
                        <button type="submit" class="btn-primary">Update Password</button>
                        @if (session('status') === 'password-updated')
                            <span class="saved-msg">Password updated.</span>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Delete Account -->
            <div class="panel">
                <div class="panel-title">Delete Account</div>
                <div class="panel-sub">Once your account is deleted, all of its resources and data will be permanently deleted. Please download any data you wish to retain before proceeding.</div>
                <button type="button" class="btn-danger" onclick="document.getElementById('delete-modal').classList.add('open')">Delete Account</button>
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
                    <label class="form-label sr-only" for="del-password">Password</label>
                    <input id="del-password" name="password" type="password" class="form-input" placeholder="Enter your password">
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
        @if($errors->userDeletion->isNotEmpty())
            document.getElementById('delete-modal').classList.add('open');
        @endif
    </script>

</body>
</html>
