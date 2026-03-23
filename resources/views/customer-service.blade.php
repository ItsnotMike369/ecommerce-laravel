<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Customer Service - ShopLine</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body { font-family: 'Inter', sans-serif; background: #f9f9fb; color: #1a1a2e; min-height: 100vh; display: flex; flex-direction: column; }



            /* ── Page Hero ── */
            .page-hero { background: #1a2340; padding: 48px 32px; text-align: center; color: #fff; }
            .page-hero h1 { font-size: 32px; font-weight: 700; margin-bottom: 10px; }
            .page-hero p { font-size: 15px; color: rgba(255,255,255,0.7); }

            /* ── Tab nav ── */
            .tab-nav { background: #fff; border-bottom: 1px solid #e8e8e8; padding: 0 32px; display: flex; gap: 0; max-width: 100%; }
            .tab-nav-inner { max-width: 860px; margin: 0 auto; width: 100%; display: flex; gap: 0; }
            .tab-btn { font-size: 14px; font-weight: 500; color: #666; text-decoration: none; padding: 16px 20px; border-bottom: 2px solid transparent; transition: color 0.15s, border-color 0.15s; cursor: pointer; background: none; border-top: none; border-left: none; border-right: none; font-family: 'Inter', sans-serif; }
            .tab-btn:hover { color: #1a1a2e; }
            .tab-btn.active { color: #1a1a2e; border-bottom-color: #1a1a2e; font-weight: 600; }

            /* ── Content wrapper ── */
            .content-wrap { flex: 1; padding: 48px 32px; }
            .content-inner { max-width: 860px; margin: 0 auto; }

            /* ── Tab panels ── */
            .tab-panel { display: none; }
            .tab-panel.active { display: block; }

            /* ── Contact Us ── */
            .contact-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 40px; }
            .contact-card { background: #fff; border: 1px solid #e8e8e8; border-radius: 12px; padding: 28px 16px; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 10px; }
            .contact-icon { width: 56px; height: 56px; background: #1a2340; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
            .contact-icon svg { width: 24px; height: 24px; color: #fff; }
            .contact-card h3 { font-size: 15px; font-weight: 600; color: #1a1a2e; }
            .contact-card p { font-size: 13px; color: #888; line-height: 1.6; }
            .contact-card .highlight { font-size: 13px; font-weight: 600; color: #1a1a2e; }

            .message-box { background: #fff; border: 1px solid #e8e8e8; border-radius: 12px; padding: 32px; }
            .message-box h2 { font-size: 20px; font-weight: 700; color: #1a1a2e; margin-bottom: 24px; }
            .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
            .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
            .form-group label { font-size: 13px; font-weight: 500; color: #444; }
            .form-group input, .form-group textarea, .form-group select { padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; color: #1a1a2e; outline: none; background: #fff; transition: border-color 0.15s; }
            .form-group input:focus, .form-group textarea:focus { border-color: #aaa; }
            .form-group textarea { resize: vertical; min-height: 120px; }
            .btn-send { width: 100%; padding: 14px; background: #1a2340; color: #fff; font-size: 14px; font-weight: 600; border: none; border-radius: 8px; cursor: pointer; font-family: 'Inter', sans-serif; transition: background 0.15s; margin-top: 8px; }
            .btn-send:hover { background: #2d3a5e; }

            /* ── Shipping Info ── */
            .section-header-cs { text-align: center; margin-bottom: 36px; }
            .section-icon { width: 64px; height: 64px; margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; }
            .section-icon svg { width: 56px; height: 56px; color: #1a1a2e; }
            .section-header-cs h2 { font-size: 26px; font-weight: 700; color: #1a1a2e; margin-bottom: 8px; }
            .section-header-cs p { font-size: 14px; color: #888; }

            .shipping-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }
            .info-card { background: #fff; border: 1px solid #e8e8e8; border-radius: 12px; padding: 24px; }
            .info-card-icon { width: 36px; height: 36px; margin-bottom: 12px; }
            .info-card-icon svg { width: 36px; height: 36px; color: #1a1a2e; }
            .info-card h3 { font-size: 16px; font-weight: 700; color: #1a1a2e; margin-bottom: 14px; }
            .rate-row { display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: #555; margin-bottom: 8px; }
            .rate-row:last-of-type { margin-bottom: 0; }
            .rate-row span:last-child { font-weight: 600; color: #1a1a2e; }
            .free-shipping-badge { display: inline-block; margin-top: 16px; padding: 10px 18px; background: #1a2340; color: #fff; font-size: 13px; font-weight: 600; border-radius: 8px; }
            .delivery-area { margin-bottom: 12px; }
            .delivery-area h4 { font-size: 13px; font-weight: 600; color: #1a1a2e; margin-bottom: 6px; }
            .delivery-area ul { list-style: disc; padding-left: 18px; }
            .delivery-area ul li { font-size: 13px; color: #555; margin-bottom: 4px; }

            .process-card { background: #fff; border: 1px solid #e8e8e8; border-radius: 12px; padding: 28px; }
            .process-card h3 { font-size: 16px; font-weight: 700; color: #1a1a2e; margin-bottom: 20px; }
            .process-step { display: flex; align-items: flex-start; gap: 16px; margin-bottom: 20px; }
            .process-step:last-child { margin-bottom: 0; }
            .step-num { width: 32px; height: 32px; background: #1a2340; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; flex-shrink: 0; }
            .step-text h4 { font-size: 14px; font-weight: 600; color: #1a1a2e; margin-bottom: 3px; }
            .step-text p { font-size: 13px; color: #888; }

            /* ── Returns ── */
            .policy-card { background: #fff; border: 1px solid #e8e8e8; border-radius: 12px; padding: 24px; margin-bottom: 20px; }
            .policy-card h3 { font-size: 16px; font-weight: 700; color: #1a1a2e; margin-bottom: 12px; }
            .policy-card p { font-size: 13px; color: #555; margin-bottom: 10px; }
            .check-list { list-style: none; }
            .check-list li { font-size: 13px; color: #555; margin-bottom: 6px; display: flex; align-items: flex-start; gap: 8px; }
            .check-list li::before { content: '✓'; color: #1a2340; font-weight: 700; flex-shrink: 0; margin-top: 1px; }
            .returns-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
            .bullet-list { list-style: disc; padding-left: 18px; }
            .bullet-list li { font-size: 13px; color: #555; margin-bottom: 6px; }

            /* ── FAQ ── */
            .faq-list { display: flex; flex-direction: column; gap: 0; margin-bottom: 32px; border: 1px solid #e8e8e8; border-radius: 12px; overflow: hidden; background: #fff; }
            .faq-item { border-bottom: 1px solid #e8e8e8; }
            .faq-item:last-child { border-bottom: none; }
            .faq-question { width: 100%; text-align: left; padding: 18px 20px; background: none; border: none; font-size: 14px; font-weight: 600; color: #1a1a2e; font-family: 'Inter', sans-serif; cursor: pointer; display: flex; align-items: center; justify-content: space-between; gap: 12px; transition: background 0.15s; }
            .faq-question:hover { background: #f9f9fb; }
            .faq-question .faq-icon { width: 20px; height: 20px; flex-shrink: 0; color: #888; transition: transform 0.2s; }
            .faq-answer { padding: 0 20px; max-height: 0; overflow: hidden; transition: max-height 0.3s ease, padding 0.3s ease; }
            .faq-answer.open { max-height: 200px; padding: 0 20px 16px; }
            .faq-answer p { font-size: 13px; color: #666; line-height: 1.7; }
            .faq-item.open .faq-icon { transform: rotate(180deg); }

            .still-questions { background: #1a2340; border-radius: 12px; padding: 40px 32px; text-align: center; color: #fff; }
            .still-questions h3 { font-size: 22px; font-weight: 700; margin-bottom: 10px; }
            .still-questions p { font-size: 14px; color: rgba(255,255,255,0.7); margin-bottom: 24px; }
            .btn-contact-support { display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; background: #fff; color: #1a2340; font-size: 14px; font-weight: 600; border-radius: 8px; text-decoration: none; border: none; cursor: pointer; font-family: 'Inter', sans-serif; transition: background 0.15s; }
            .btn-contact-support:hover { background: #f0f0f0; }

            /* ── Footer ── */
            footer { background: #1a2340; color: #ccc; padding: 56px 32px 28px; margin-top: auto; }
            .footer-grid { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr 1.5fr 2fr; gap: 48px; margin-bottom: 48px; }
            .footer-brand h3 { color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 10px; }
            .footer-brand p { font-size: 13px; line-height: 1.7; color: #aaa; margin-bottom: 16px; }
            .footer-socials { display: flex; gap: 12px; }
            .footer-socials a { color: #aaa; text-decoration: none; display: flex; align-items: center; transition: color 0.15s; }
            .footer-socials a:hover { color: #fff; }
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

        @include('layouts._navbar')

        <!-- Page Hero -->
        <div class="page-hero">
            <h1>Customer Service</h1>
            <p>We're here to help! Find answers to your questions and get in touch with our team.</p>
        </div>

        <!-- Tab Navigation -->
        <div class="tab-nav">
            <div class="tab-nav-inner">
                <button class="tab-btn active" data-tab="contact">Contact Us</button>
                <button class="tab-btn" data-tab="shipping">Shipping Info</button>
                <button class="tab-btn" data-tab="returns">Returns</button>
                <button class="tab-btn" data-tab="faq">FAQ</button>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrap">
            <div class="content-inner">

                <!-- Contact Us Panel -->
                <div class="tab-panel active" id="tab-contact">
                    <h2 style="font-size:24px;font-weight:700;color:#1a1a2e;text-align:center;margin-bottom:8px;">Get In Touch</h2>
                    <p style="text-align:center;font-size:14px;color:#888;margin-bottom:32px;">Have a question or need assistance? Our customer service team is ready to help you.</p>

                    <div class="contact-grid">
                        <div class="contact-card">
                            <div class="contact-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.042 11.042 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <h3>Call Us</h3>
                            <p class="highlight">+63 (2) 8123-4567</p>
                            <p>Mon-Sat: 8AM - 6PM</p>
                        </div>
                        <div class="contact-card">
                            <div class="contact-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z"/></svg>
                            </div>
                            <h3>Email Us</h3>
                            <p class="highlight">support@eshop.ph</p>
                            <p>Response within 24 hours</p>
                        </div>
                        <div class="contact-card">
                            <div class="contact-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            </div>
                            <h3>Live Chat</h3>
                            <p class="highlight">Chat with our team</p>
                            <p>Available 9AM - 6PM</p>
                        </div>
                        <div class="contact-card">
                            <div class="contact-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 0 1-2.827 0l-4.244-4.243a8 8 0 1 1 11.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/></svg>
                            </div>
                            <h3>Visit Us</h3>
                            <p class="highlight">123 Commerce St., Makati City</p>
                            <p>Metro Manila, Philippines</p>
                        </div>
                    </div>

                    <div class="message-box">
                        <h2>Send us a message</h2>
                        <div class="form-row">
                            <div class="form-group" style="margin-bottom:0;">
                                <label>First Name</label>
                                <input type="text" placeholder="John">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label>Last Name</label>
                                <input type="text" placeholder="Doe">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:16px;">
                            <label>Email</label>
                            <input type="email" placeholder="john.doe@example.com">
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" placeholder="How can we help?">
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea placeholder="Your message..."></textarea>
                        </div>
                        <button class="btn-send">Send Message</button>
                    </div>
                </div>

                <!-- Shipping Info Panel -->
                <div class="tab-panel" id="tab-shipping">
                    <div class="section-header-cs">
                        <div class="section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="1" y="3" width="15" height="13" rx="1" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8h4l3 5v4h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5" stroke-width="2"/><circle cx="18.5" cy="18.5" r="2.5" stroke-width="2"/></svg>
                        </div>
                        <h2>Shipping Information</h2>
                        <p>We offer flexible shipping options to get your order to you quickly and safely.</p>
                    </div>

                    <div class="shipping-cards">
                        <div class="info-card">
                            <div class="info-card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zm-9 5H4m5 0h.01"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19H5a2 2 0 0 1-2-2v-1m16 3h-4m4 0a2 2 0 0 0 2-2v-1"/></svg>
                            </div>
                            <h3>Shipping Rates</h3>
                            <div class="rate-row"><span>Metro Manila (Standard)</span><span>₱80</span></div>
                            <div class="rate-row"><span>Metro Manila (Express)</span><span>₱150</span></div>
                            <div class="rate-row"><span>Provincial (Standard)</span><span>₱120</span></div>
                            <div class="rate-row"><span>Provincial (Express)</span><span>₱250</span></div>
                            <div class="free-shipping-badge">FREE shipping on orders over ₱1,500!</div>
                        </div>
                        <div class="info-card">
                            <div class="info-card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"/></svg>
                            </div>
                            <h3>Delivery Times</h3>
                            <div class="delivery-area">
                                <h4>Metro Manila</h4>
                                <ul class="bullet-list">
                                    <li>Standard: 3-7 business days</li>
                                    <li>Express: 1-3 business days</li>
                                </ul>
                            </div>
                            <div class="delivery-area" style="margin-top:14px;">
                                <h4>Provincial Areas</h4>
                                <ul class="bullet-list">
                                    <li>Standard: 7-14 business days</li>
                                    <li>Express: 3-7 business days</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="process-card">
                        <h3>Shipping Process</h3>
                        <div class="process-step">
                            <div class="step-num">1</div>
                            <div class="step-text">
                                <h4>Order Confirmation</h4>
                                <p>You'll receive an email confirmation once your order is placed.</p>
                            </div>
                        </div>
                        <div class="process-step">
                            <div class="step-num">2</div>
                            <div class="step-text">
                                <h4>Processing</h4>
                                <p>We'll process and pack your order within 1-2 business days.</p>
                            </div>
                        </div>
                        <div class="process-step">
                            <div class="step-num">3</div>
                            <div class="step-text">
                                <h4>Shipment</h4>
                                <p>Your order ships and you'll receive a tracking number via email.</p>
                            </div>
                        </div>
                        <div class="process-step">
                            <div class="step-num">4</div>
                            <div class="step-text">
                                <h4>Delivery</h4>
                                <p>Your package arrives at your doorstep. Enjoy your purchase!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Returns Panel -->
                <div class="tab-panel" id="tab-returns">
                    <div class="section-header-cs">
                        <div class="section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 0 0 4.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 0 1-15.357-2m15.357 2H15"/></svg>
                        </div>
                        <h2>Returns &amp; Refunds</h2>
                        <p>We want you to be completely satisfied with your purchase. If you're not happy, we're here to help.</p>
                    </div>

                    <div class="policy-card">
                        <h3>30-Day Return Policy</h3>
                        <p>We offer a 30-day return policy on most items. To be eligible for a return, your item must be:</p>
                        <ul class="check-list">
                            <li>Unused and in the same condition that you received it</li>
                            <li>In the original packaging with all tags attached</li>
                            <li>Accompanied by a receipt or proof of purchase</li>
                        </ul>
                    </div>

                    <div class="returns-grid">
                        <div class="info-card">
                            <div class="info-card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <h3>Refund Process</h3>
                            <ul class="bullet-list">
                                <li>Refunds processed within 7-10 business days</li>
                                <li>Original payment method will be credited</li>
                                <li>Email notification upon refund approval</li>
                                <li>Shipping costs are non-refundable</li>
                            </ul>
                        </div>
                        <div class="info-card">
                            <div class="info-card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zm-9 5H4m5 0h.01"/></svg>
                            </div>
                            <h3>Return Shipping</h3>
                            <ul class="bullet-list">
                                <li>FREE return shipping for defective items</li>
                                <li>Customer pays return shipping for change of mind</li>
                                <li>Use trackable shipping method</li>
                                <li>Keep tracking number for your records</li>
                            </ul>
                        </div>
                    </div>

                    <div class="process-card">
                        <h3>How to Return an Item</h3>
                        <div class="process-step">
                            <div class="step-num">1</div>
                            <div class="step-text">
                                <h4>Contact Us</h4>
                                <p>Email support@eshop.ph with your order number and reason for return.</p>
                            </div>
                        </div>
                        <div class="process-step">
                            <div class="step-num">2</div>
                            <div class="step-text">
                                <h4>Get Authorization</h4>
                                <p>We'll review your request and provide a return authorization number.</p>
                            </div>
                        </div>
                        <div class="process-step">
                            <div class="step-num">3</div>
                            <div class="step-text">
                                <h4>Pack &amp; Ship</h4>
                                <p>Securely pack the item with the authorization number and ship it back to us.</p>
                            </div>
                        </div>
                        <div class="process-step">
                            <div class="step-num">4</div>
                            <div class="step-text">
                                <h4>Receive Refund</h4>
                                <p>Once we receive and inspect your return, we'll process your refund.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Panel -->
                <div class="tab-panel" id="tab-faq">
                    <div class="section-header-cs">
                        <div class="section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>
                        </div>
                        <h2>Frequently Asked Questions</h2>
                        <p>Find quick answers to common questions about orders, shipping, and more.</p>
                    </div>

                    <div class="faq-list">
                        <div class="faq-item">
                            <button class="faq-question">
                                How do I track my order?
                                <svg class="faq-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="faq-answer">
                                <p>You can track your order by logging into your account and visiting the "My Orders" section. You will receive a tracking number via email once your order ships.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <button class="faq-question">
                                What payment methods do you accept?
                                <svg class="faq-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="faq-answer">
                                <p>We accept Cash on Delivery (COD), E-wallet payments (GCash, PayMaya), and Online Banking transfers.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <button class="faq-question">
                                How long does shipping take?
                                <svg class="faq-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="faq-answer">
                                <p>Standard shipping takes 3-7 business days for Metro Manila and 7-14 business days for provincial areas. Express shipping is available for faster delivery.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <button class="faq-question">
                                Can I cancel or modify my order?
                                <svg class="faq-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="faq-answer">
                                <p>Orders can be cancelled or modified within 24 hours of placement. Please contact our customer service team immediately if you need to make changes.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <button class="faq-question">
                                What is your return policy?
                                <svg class="faq-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="faq-answer">
                                <p>We offer a 30-day return policy for most items. Products must be unused, in original packaging, and with all tags attached. Return shipping costs may apply.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <button class="faq-question">
                                Do you offer warranty on products?
                                <svg class="faq-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="faq-answer">
                                <p>Yes, all electronics come with a manufacturer warranty ranging from 6 months to 2 years. Please check individual product pages for specific warranty details.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <button class="faq-question">
                                How do I create an account?
                                <svg class="faq-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="faq-answer">
                                <p>Click on the user icon in the header and select "Register". Fill in your details to create an account and enjoy benefits like order tracking and faster checkout.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <button class="faq-question">
                                Is my payment information secure?
                                <svg class="faq-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="faq-answer">
                                <p>Yes, we use industry-standard encryption to protect your payment information. We never store your full credit card details on our servers.</p>
                            </div>
                        </div>
                    </div>

                    <div class="still-questions">
                        <h3>Still have questions?</h3>
                        <p>Can't find the answer you're looking for? Our customer service team is here to help.</p>
                        <button class="btn-contact-support" onclick="switchTab('contact')">Contact Support</button>
                    </div>
                </div>

            </div>
        </div>

        @include('layouts._footer')

        <script>
            const initialTab = '{{ request("tab", "contact") }}';

            function switchTab(tabName) {
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    btn.classList.toggle('active', btn.dataset.tab === tabName);
                });
                document.querySelectorAll('.tab-panel').forEach(panel => {
                    panel.classList.toggle('active', panel.id === 'tab-' + tabName);
                });
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    switchTab(this.dataset.tab);
                });
            });

            document.querySelectorAll('.faq-question').forEach(btn => {
                btn.addEventListener('click', function () {
                    const item = this.closest('.faq-item');
                    const answer = item.querySelector('.faq-answer');
                    const isOpen = item.classList.contains('open');
                    document.querySelectorAll('.faq-item').forEach(i => {
                        i.classList.remove('open');
                        i.querySelector('.faq-answer').classList.remove('open');
                    });
                    if (!isOpen) {
                        item.classList.add('open');
                        answer.classList.add('open');
                    }
                });
            });

            switchTab(initialTab);
        </script>
    </body>
</html>
