<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>About Us - ShopLine</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body { font-family: 'Inter', sans-serif; background: #fff; color: #1a1a2e; min-height: 100vh; display: flex; flex-direction: column; }

            /* ── Hero ── */
            .about-hero { background: #1a2340; padding: 72px 32px; color: #fff; text-align: center; }
            .about-hero h1 { font-size: 38px; font-weight: 700; margin-bottom: 14px; }
            .about-hero p { font-size: 15px; color: rgba(255,255,255,0.75); max-width: 480px; margin: 0 auto; line-height: 1.6; }

            /* ── Sections ── */
            .about-section { padding: 64px 32px; }
            .about-section-inner { max-width: 1100px; margin: 0 auto; }

            /* ── Mission ── */
            .mission-section { background: #fff; text-align: center; }
            .mission-section h2 { font-size: 28px; font-weight: 700; color: #1a1a2e; margin-bottom: 20px; }
            .mission-section p { font-size: 15px; color: #555; max-width: 680px; margin: 0 auto; line-height: 1.8; }

            /* ── Why Choose Us ── */
            .why-section { background: #f9f9fb; text-align: center; }
            .why-section h2 { font-size: 28px; font-weight: 700; color: #1a1a2e; margin-bottom: 40px; }
            .why-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 28px; }
            .why-card { display: flex; flex-direction: column; align-items: center; text-align: center; gap: 14px; }
            .why-icon { width: 64px; height: 64px; background: #1a2340; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
            .why-icon svg { width: 28px; height: 28px; color: #fff; }
            .why-card h3 { font-size: 16px; font-weight: 700; color: #1a1a2e; }
            .why-card p { font-size: 13px; color: #777; line-height: 1.6; }

            /* ── Stats ── */
            .stats-section { background: #fff; }
            .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; text-align: center; }
            .stat-item {}
            .stat-item .stat-number { font-size: 48px; font-weight: 700; color: #1a1a2e; line-height: 1; margin-bottom: 8px; }
            .stat-item .stat-label { font-size: 14px; color: #888; }

            /* ── CTA ── */
            .cta-section { background: #1a2340; color: #fff; padding: 72px 32px; text-align: center; }
            .cta-section h2 { font-size: 28px; font-weight: 700; margin-bottom: 12px; }
            .cta-section p { font-size: 15px; color: rgba(255,255,255,0.75); margin-bottom: 32px; }
            .btn-cta { display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px; background: #fff; color: #1a1a2e; font-size: 14px; font-weight: 600; border-radius: 8px; text-decoration: none; transition: background 0.15s; }
            .btn-cta:hover { background: #f0f0f0; }

            /* ── Footer ── */
            footer { background: #111827; color: #9ca3af; padding: 48px 32px 0; margin-top: auto; }
            .footer-grid { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 40px; padding-bottom: 40px; border-bottom: 1px solid #1f2937; }
            .footer-brand h3 { font-size: 18px; font-weight: 700; color: #fff; margin-bottom: 10px; }
            .footer-brand p { font-size: 13px; line-height: 1.6; margin-bottom: 16px; }
            .footer-socials { display: flex; gap: 10px; }
            .footer-socials a { width: 32px; height: 32px; background: #1f2937; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #9ca3af; text-decoration: none; transition: background 0.15s, color 0.15s; }
            .footer-socials a:hover { background: #374151; color: #fff; }
            .footer-col h4 { font-size: 14px; font-weight: 600; color: #fff; margin-bottom: 14px; }
            .footer-col ul { list-style: none; }
            .footer-col ul li { margin-bottom: 8px; }
            .footer-col ul li a { font-size: 13px; color: #9ca3af; text-decoration: none; transition: color 0.15s; }
            .footer-col ul li a:hover { color: #fff; }
            .newsletter-form { display: flex; align-items: center; gap: 10px; background: #1f2937; border-radius: 8px; padding: 10px 14px; }
            .newsletter-form svg { width: 16px; height: 16px; color: #6b7280; flex-shrink: 0; }
            .newsletter-form input { background: transparent; border: none; outline: none; font-size: 13px; color: #9ca3af; flex: 1; font-family: 'Inter', sans-serif; }
            .newsletter-form input::placeholder { color: #6b7280; }
            .footer-bottom { max-width: 1100px; margin: 0 auto; padding: 20px 0; text-align: center; font-size: 13px; }
        </style>
    </head>
    <body>

        @include('layouts._navbar')

        <!-- Hero -->
        <section class="about-hero">
            <h1>About Our Store</h1>
            <p>Your trusted destination for quality products and exceptional service</p>
        </section>

        <!-- Mission -->
        <section class="about-section mission-section">
            <div class="about-section-inner">
                <h2>Our Mission</h2>
                <p>We're dedicated to providing our customers with the best shopping experience possible. From carefully curated products to seamless checkout, we ensure every step of your journey with us is exceptional. Our commitment to quality, affordability, and customer satisfaction sets us apart.</p>
            </div>
        </section>

        <!-- Why Choose Us -->
        <section class="about-section why-section">
            <div class="about-section-inner">
                <h2>Why Choose Us</h2>
                <div class="why-grid">
                    <div class="why-card">
                        <div class="why-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>
                        </div>
                        <h3>Quality Products</h3>
                        <p>We source only the best products from trusted brands and suppliers</p>
                    </div>
                    <div class="why-card">
                        <div class="why-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2h5M12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"/></svg>
                        </div>
                        <h3>Customer First</h3>
                        <p>Your satisfaction is our top priority with 24/7 customer support</p>
                    </div>
                    <div class="why-card">
                        <div class="why-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8 5-8-5m16 0v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7m16 0l-8-5-8 5"/></svg>
                        </div>
                        <h3>Fast Delivery</h3>
                        <p>Quick and reliable shipping to get your products to you on time</p>
                    </div>
                    <div class="why-card">
                        <div class="why-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 0 1 6.364 0L12 7.636l1.318-1.318a4.5 4.5 0 1 1 6.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 0 1 0-6.364z"/></svg>
                        </div>
                        <h3>Built with Care</h3>
                        <p>Every detail is thoughtfully designed for the best experience</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats -->
        <section class="about-section stats-section">
            <div class="about-section-inner">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">10,000+</div>
                        <div class="stat-label">Happy Customers</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">5,000+</div>
                        <div class="stat-label">Products Available</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">99%</div>
                        <div class="stat-label">Satisfaction Rate</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="cta-section">
            <h2>Ready to Experience the Difference?</h2>
            <p>Join our community of satisfied shoppers today</p>
            <a href="{{ route('shop') }}" class="btn-cta">
                Start Shopping
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </section>

        <!-- Footer -->
        <footer>
            <div class="footer-grid">
                <div class="footer-brand">
                    <h3>E-Commerce</h3>
                    <p>Your one-stop shop for quality products at great prices.</p>
                    <div class="footer-socials">
                        <a href="#" title="Facebook">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.93-1.956 1.886v2.268h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/></svg>
                        </a>
                        <a href="#" title="Twitter">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 0 1-2.825.775 4.958 4.958 0 0 0 2.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 0 0-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 0 0-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 0 1-2.228-.616v.06a4.923 4.923 0 0 0 3.946 4.827 4.996 4.996 0 0 1-2.212.085 4.936 4.936 0 0 0 4.604 3.417 9.867 9.867 0 0 1-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 0 0 7.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0 0 24 4.59z"/></svg>
                        </a>
                        <a href="#" title="Instagram">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" title="YouTube">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/></svg>
                        </a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ route('shop') }}">Shop</a></li>
                        <li><a href="{{ route('cart') }}">Cart</a></li>
                        <li><a href="#">My Account</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Customer Service</h4>
                    <ul>
                        <li><a href="{{ route('customer-service', ['tab' => 'contact']) }}">Contact Us</a></li>
                        <li><a href="{{ route('customer-service', ['tab' => 'shipping']) }}">Shipping Info</a></li>
                        <li><a href="{{ route('customer-service', ['tab' => 'returns']) }}">Returns</a></li>
                        <li><a href="{{ route('customer-service', ['tab' => 'faq']) }}">FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Newsletter</h4>
                    <p style="font-size:13px;color:#6b7280;margin-bottom:12px;">Subscribe to get special offers and updates.</p>
                    <div class="newsletter-form">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z"/></svg>
                        <input type="email" placeholder="Your email">
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} E-Commerce. All rights reserved.</p>
            </div>
        </footer>

    </body>
</html>
