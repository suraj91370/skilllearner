@extends('layouts.app')

@section('title', 'System Settings — SkillLearner Super Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Navigation Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-settings'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-settings'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header Row -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(124, 58, 237, 0.12); color: #7c3aed; font-size: 0.75rem; font-weight: 800; padding: 3px 10px; border-radius: 20px; margin-bottom: 0.4rem;">
                        👑 SUPER ADMIN SYSTEM CONTROL
                    </div>
                    <h2 class="welcome-heading" style="font-size: 1.6rem; margin-bottom: 0.25rem;">
                        ⚙️ Platform &amp; System Settings
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Manage site branding, SEO metadata, email/SMS notification templates, GST taxation, maintenance mode, and database backups.
                    </p>
                </div>

                @if(($serverInfo['is_maintenance'] ?? false))
                    <div style="background: rgba(239, 68, 68, 0.12); border: 1.5px solid #ef4444; color: #dc2626; padding: 0.6rem 1rem; border-radius: 12px; font-weight: 800; font-size: 0.85rem; display: flex; align-items: center; gap: 8px;">
                        <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background: #ef4444; box-shadow: 0 0 10px #ef4444;"></span>
                        MAINTENANCE MODE IS ACTIVE
                    </div>
                @endif
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ❌ {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.88rem;">
                    <strong>Please review the following errors:</strong>
                    <ul style="margin: 0.4rem 0 0 1.2rem;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Tab Navigation Bar -->
            <div style="display: flex; gap: 0.6rem; border-bottom: 2px solid #e2e8f0; margin-bottom: 1.8rem; overflow-x: auto; padding-bottom: 2px;">
                <a href="{{ route('admin.settings', ['tab' => 'general']) }}" class="settings-tab-btn {{ $currentTab === 'general' ? 'active' : '' }}">
                    🌐 Site &amp; SEO
                </a>
                <a href="{{ route('admin.settings', ['tab' => 'notifications']) }}" class="settings-tab-btn {{ $currentTab === 'notifications' ? 'active' : '' }}">
                    🔔 Notification Templates
                </a>
                <a href="{{ route('admin.settings', ['tab' => 'tax']) }}" class="settings-tab-btn {{ $currentTab === 'tax' ? 'active' : '' }}">
                    🏛️ Tax &amp; GST Invoicing
                </a>
                <a href="{{ route('admin.settings', ['tab' => 'financial']) }}" class="settings-tab-btn {{ $currentTab === 'financial' ? 'active' : '' }}">
                    💰 Commission &amp; Video
                </a>
                <a href="{{ route('admin.settings', ['tab' => 'maintenance']) }}" class="settings-tab-btn {{ $currentTab === 'maintenance' ? 'active' : '' }}">
                    🛡️ Maintenance &amp; Backup
                </a>
            </div>

            <!-- TAB 1: SITE BRANDING, CONTACT INFO & SEO -->
            @if($currentTab === 'general')
                <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 2rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.6rem; flex-wrap: wrap; gap: 1rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 1rem;">
                        <div>
                            <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0 0 0.3rem 0;">
                                Site Identity, Logo, Contact Info &amp; SEO
                            </h3>
                            <p style="font-size: 0.86rem; color: #64748b; margin: 0;">
                                Updates reflect across the Homepage, Navbar, Footer, Browser Title, and Social Meta previews.
                            </p>
                        </div>
                        <a href="{{ url('/') }}" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; background: rgba(5, 179, 150, 0.1); color: #05B396; border: 1px solid rgba(5, 179, 150, 0.3); padding: 0.4rem 0.9rem; border-radius: 8px; font-weight: 700; font-size: 0.82rem; text-decoration: none;">
                            👁️ View Live Website ↗
                        </a>
                    </div>

                    <form method="POST" action="{{ route('admin.settings.general') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Section: Brand Identity -->
                        <h4 style="font-size: 0.95rem; font-weight: 800; color: #7c3aed; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">
                            1. Platform Identity &amp; Logos
                        </h4>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin-bottom: 1.4rem;">
                            <div>
                                <label class="clean-form-label">Site Name <span style="color: #ef4444;">*</span></label>
                                <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'SkillLearner') }}" required class="clean-form-input">
                            </div>
                            <div>
                                <label class="clean-form-label">Platform Tagline / Slogan</label>
                                <input type="text" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline'] ?? "India's No. 1 Digital Education & Affiliate Platform") }}" class="clean-form-input">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin-bottom: 1.8rem; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 1.2rem;">
                            <div>
                                <label class="clean-form-label">Primary Brand Logo (Upload New PNG/SVG/WEBP)</label>
                                <input type="file" name="site_logo" accept="image/*" class="clean-form-input" style="padding: 0.4rem;">
                                <div style="display: flex; align-items: center; gap: 10px; margin-top: 0.6rem;">
                                    <span style="font-size: 0.75rem; color: #64748b;">Current Logo:</span>
                                    <img src="{{ asset($settings['site_logo'] ?? 'images/logo.png') }}" alt="Site Logo" style="height: 32px; max-width: 140px; object-fit: contain; background: #ffffff; padding: 3px 8px; border-radius: 6px; border: 1px solid #e2e8f0;">
                                </div>
                            </div>
                            <div>
                                <label class="clean-form-label">Browser Favicon Icon (Upload .ico / .png)</label>
                                <input type="file" name="site_favicon" accept=".ico,.png,.svg" class="clean-form-input" style="padding: 0.4rem;">
                                <div style="display: flex; align-items: center; gap: 10px; margin-top: 0.6rem;">
                                    <span style="font-size: 0.75rem; color: #64748b;">Current Favicon:</span>
                                    <img src="{{ asset($settings['site_favicon'] ?? 'favicon.png') }}" alt="Favicon" style="width: 24px; height: 24px; object-fit: contain; background: #ffffff; padding: 2px; border-radius: 4px; border: 1px solid #e2e8f0;">
                                </div>
                            </div>
                        </div>

                        <!-- Section: Official Contact Information -->
                        <h4 style="font-size: 0.95rem; font-weight: 800; color: #7c3aed; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">
                            2. Official Contact Information (Footer &amp; Support)
                        </h4>

                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.2rem; margin-bottom: 1.3rem;">
                            <div>
                                <label class="clean-form-label">Support Email Address</label>
                                <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? 'support@skilllearner.org') }}" class="clean-form-input">
                            </div>
                            <div>
                                <label class="clean-form-label">Support Call / Helpline Number</label>
                                <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '+91 83183 73108') }}" class="clean-form-input">
                            </div>
                            <div>
                                <label class="clean-form-label">WhatsApp Support Number</label>
                                <input type="text" name="contact_whatsapp" value="{{ old('contact_whatsapp', $settings['contact_whatsapp'] ?? '+91 83183 73108') }}" placeholder="+91..." class="clean-form-input">
                            </div>
                        </div>

                        <div style="margin-bottom: 1.8rem;">
                            <label class="clean-form-label">Official Registered / Physical Office Address</label>
                            <input type="text" name="contact_address" value="{{ old('contact_address', $settings['contact_address'] ?? 'Mumbai, Maharashtra, India') }}" class="clean-form-input">
                        </div>

                        <!-- Section: Social Media Community Links -->
                        <h4 style="font-size: 0.95rem; font-weight: 800; color: #7c3aed; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">
                            3. Official Social Channels
                        </h4>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin-bottom: 1.8rem;">
                            <div>
                                <label class="clean-form-label">📸 Instagram URL</label>
                                <input type="url" name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram'] ?? 'https://instagram.com/skilllearner') }}" placeholder="https://instagram.com/..." class="clean-form-input">
                            </div>
                            <div>
                                <label class="clean-form-label">▶️ YouTube Channel URL</label>
                                <input type="url" name="social_youtube" value="{{ old('social_youtube', $settings['social_youtube'] ?? 'https://youtube.com/@skilllearner') }}" placeholder="https://youtube.com/..." class="clean-form-input">
                            </div>
                            <div>
                                <label class="clean-form-label">✈️ Telegram Channel / Community</label>
                                <input type="url" name="social_telegram" value="{{ old('social_telegram', $settings['social_telegram'] ?? 'https://t.me/skilllearner') }}" placeholder="https://t.me/..." class="clean-form-input">
                            </div>
                            <div>
                                <label class="clean-form-label">💼 LinkedIn Page URL</label>
                                <input type="url" name="social_linkedin" value="{{ old('social_linkedin', $settings['social_linkedin'] ?? '') }}" placeholder="https://linkedin.com/..." class="clean-form-input">
                            </div>
                        </div>

                        <!-- Section: SEO Metadata & Analytics -->
                        <h4 style="font-size: 0.95rem; font-weight: 800; color: #7c3aed; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">
                            4. SEO Optimization &amp; Analytics Tracking
                        </h4>

                        <div style="margin-bottom: 1.2rem;">
                            <label class="clean-form-label">SEO Meta Title</label>
                            <input type="text" name="seo_meta_title" value="{{ old('seo_meta_title', $settings['seo_meta_title'] ?? 'SkillLearner | Learn High-Income Skills & Build Your Digital Career') }}" class="clean-form-input">
                            <span style="font-size: 0.74rem; color: #64748b;">Recommended length: 50-60 characters for maximum search ranking impact.</span>
                        </div>

                        <div style="margin-bottom: 1.2rem;">
                            <label class="clean-form-label">SEO Meta Description</label>
                            <textarea name="seo_meta_description" rows="2" class="clean-form-input" style="resize: vertical;">{{ old('seo_meta_description', $settings['seo_meta_description'] ?? "SkillLearner is India's leading digital education and affiliate platform empowering youth with practical high-income skills.") }}</textarea>
                        </div>

                        <div style="margin-bottom: 1.3rem;">
                            <label class="clean-form-label">SEO Meta Keywords</label>
                            <input type="text" name="seo_meta_keywords" value="{{ old('seo_meta_keywords', $settings['seo_meta_keywords'] ?? 'affiliate marketing, digital courses, online education, career growth, skilllearner') }}" class="clean-form-input">
                            <span style="font-size: 0.74rem; color: #64748b;">Separate keywords with commas.</span>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin-bottom: 1.3rem;">
                            <div>
                                <label class="clean-form-label">Google Analytics 4 (Measurement ID)</label>
                                <input type="text" name="google_analytics_id" value="{{ old('google_analytics_id', $settings['google_analytics_id'] ?? '') }}" placeholder="G-XXXXXXXXXX" class="clean-form-input" style="font-family: monospace;">
                                <span style="font-size: 0.72rem; color: #64748b;">Automatically embeds gtag.js tracking in site head.</span>
                            </div>
                            <div>
                                <label class="clean-form-label">Meta / Facebook Pixel ID</label>
                                <input type="text" name="meta_pixel_id" value="{{ old('meta_pixel_id', $settings['meta_pixel_id'] ?? '') }}" placeholder="123456789012345" class="clean-form-input" style="font-family: monospace;">
                                <span style="font-size: 0.72rem; color: #64748b;">Automatically tracks PageViews for ad campaigns.</span>
                            </div>
                        </div>

                        <div style="margin-bottom: 1.8rem;">
                            <label class="clean-form-label">Custom Header Scripts (GTM, Live Chat, Verification Tags)</label>
                            <textarea name="header_scripts" rows="3" class="clean-form-input" placeholder="<script>...</script>" style="font-family: monospace; font-size: 0.82rem; resize: vertical;">{{ old('header_scripts', $settings['header_scripts'] ?? '') }}</textarea>
                            <span style="font-size: 0.72rem; color: #64748b;">Rendered safely inside the <code>&lt;head&gt;</code> element across all student pages.</span>
                        </div>

                        <button type="submit" class="btn-primary-action">
                            Save Site Branding &amp; SEO 💾
                        </button>
                    </form>
                </div>
            @endif

            <!-- TAB 2: NOTIFICATION TEMPLATES (EMAIL & SMS) -->
            @if($currentTab === 'notifications')
                <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 2rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.6rem; flex-wrap: wrap; gap: 1rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 1rem;">
                        <div>
                            <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0 0 0.3rem 0;">
                                Email &amp; SMS Notification Message Templates
                            </h3>
                            <p style="font-size: 0.86rem; color: #64748b; margin: 0;">
                                Customize automated transactional alerts for account creation, payments, affiliate earnings, and password resets.
                            </p>
                        </div>
                        <a href="{{ url('/admin/send-test-email') }}" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; background: rgba(124, 58, 237, 0.1); color: #7c3aed; border: 1px solid rgba(124, 58, 237, 0.3); padding: 0.4rem 0.9rem; border-radius: 8px; font-weight: 700; font-size: 0.82rem; text-decoration: none;">
                            ✉️ Interactive Email Tester ↗
                        </a>
                    </div>

                    <form method="POST" action="{{ route('admin.settings.notifications') }}">
                        @csrf

                        <!-- Notification Delivery Channels -->
                        <h4 style="font-size: 0.95rem; font-weight: 800; color: #7c3aed; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">
                            1. Delivery Channels Configuration
                        </h4>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin-bottom: 1.4rem;">
                            <div>
                                <label class="clean-form-label">System Sender Name</label>
                                <input type="text" name="mail_from_name" value="{{ old('mail_from_name', $settings['mail_from_name'] ?? 'SkillLearner Support') }}" required class="clean-form-input">
                            </div>
                            <div>
                                <label class="clean-form-label">System Sender Email Address</label>
                                <input type="email" name="mail_from_address" value="{{ old('mail_from_address', $settings['mail_from_address'] ?? 'support@skilllearner.org') }}" required class="clean-form-input">
                            </div>
                        </div>

                        <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 1.2rem; margin-bottom: 1.8rem;">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 0.8rem;">
                                <input type="checkbox" name="sms_enabled" value="1" id="smsEnabledToggle" {{ old('sms_enabled', ($settings['sms_enabled'] ?? '0') === '1') ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #05B396; cursor: pointer;">
                                <label for="smsEnabledToggle" style="font-size: 0.88rem; font-weight: 800; color: #0f172a; cursor: pointer;">
                                    Enable SMS / WhatsApp Gateway Dispatch
                                </label>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 2fr 1fr; gap: 1rem;">
                                <div>
                                    <label class="clean-form-label">SMS Provider</label>
                                    <select name="sms_provider" class="clean-form-input">
                                        <option value="Fast2SMS" {{ ($settings['sms_provider'] ?? '') === 'Fast2SMS' ? 'selected' : '' }}>Fast2SMS (India)</option>
                                        <option value="MSG91" {{ ($settings['sms_provider'] ?? '') === 'MSG91' ? 'selected' : '' }}>MSG91 (DLT Approved)</option>
                                        <option value="Twilio" {{ ($settings['sms_provider'] ?? '') === 'Twilio' ? 'selected' : '' }}>Twilio / WhatsApp API</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="clean-form-label">API Authorization Key / Token</label>
                                    <input type="password" name="sms_api_key" value="{{ old('sms_api_key', $settings['sms_api_key'] ?? '') }}" placeholder="Enter Gateway API Key" class="clean-form-input">
                                </div>
                                <div>
                                    <label class="clean-form-label">DLT / Sender ID</label>
                                    <input type="text" name="sms_sender_id" value="{{ old('sms_sender_id', $settings['sms_sender_id'] ?? 'SKLLRN') }}" placeholder="e.g. SKLLRN" class="clean-form-input">
                                </div>
                            </div>
                        </div>

                        <!-- Placeholders Guide Box -->
                        <div style="background: rgba(124, 58, 237, 0.05); border: 1.5px solid rgba(124, 58, 237, 0.25); border-radius: 12px; padding: 1rem 1.4rem; margin-bottom: 1.8rem;">
                            <div style="font-size: 0.82rem; font-weight: 800; color: #7c3aed; margin-bottom: 0.35rem;">
                                📌 Dynamic Placeholders Available in Templates:
                            </div>
                            <div style="font-size: 0.8rem; color: #475569; display: flex; flex-wrap: wrap; gap: 10px;">
                                <code>{name}</code> — Student/Affiliate Name &bull;
                                <code>{email}</code> — Email Address &bull;
                                <code>{package}</code> — Package Enrolled &bull;
                                <code>{amount}</code> — Paid / Commission Amount &bull;
                                <code>{order_id}</code> — Order Number &bull;
                                <code>{buyer_name}</code> — Referral Student Name &bull;
                                <code>{affiliate_id}</code> — Affiliate Code &bull;
                                <code>{login_url}</code> — Portal Link &bull;
                                <code>{reset_url}</code> — Password Reset Link
                            </div>
                        </div>

                        <!-- Templates Subsections -->
                        <!-- 1. Welcome & Activation -->
                        <div class="template-card">
                            <div class="template-header">
                                <span style="font-size: 1.2rem;">🎉</span>
                                <div>
                                    <h4 style="font-size: 0.96rem; font-weight: 800; color: #0f172a; margin: 0;">1. Welcome &amp; Account Activation Notification</h4>
                                    <span style="font-size: 0.74rem; color: #64748b;">Triggered immediately after user registers or payment is marked paid</span>
                                </div>
                            </div>
                            <div style="margin-bottom: 0.8rem;">
                                <label class="clean-form-label">Email Subject</label>
                                <input type="text" name="template_welcome_subject" value="{{ old('template_welcome_subject', $settings['template_welcome_subject'] ?? '') }}" class="clean-form-input">
                            </div>
                            <div style="display: grid; grid-template-columns: 3fr 2fr; gap: 1rem;">
                                <div>
                                    <label class="clean-form-label">Email Message Body (Markdown / Text)</label>
                                    <textarea name="template_welcome_email" rows="4" class="clean-form-input" style="resize: vertical;">{{ old('template_welcome_email', $settings['template_welcome_email'] ?? '') }}</textarea>
                                </div>
                                <div>
                                    <label class="clean-form-label">SMS / WhatsApp Message Text</label>
                                    <textarea name="template_welcome_sms" rows="4" class="clean-form-input" style="resize: vertical;">{{ old('template_welcome_sms', $settings['template_welcome_sms'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Order Confirmation -->
                        <div class="template-card">
                            <div class="template-header">
                                <span style="font-size: 1.2rem;">🧾</span>
                                <div>
                                    <h4 style="font-size: 0.96rem; font-weight: 800; color: #0f172a; margin: 0;">2. Order Confirmation &amp; Payment Success Notification</h4>
                                    <span style="font-size: 0.74rem; color: #64748b;">Dispatched when an order completes successfully via Cashfree or Manual Verification</span>
                                </div>
                            </div>
                            <div style="margin-bottom: 0.8rem;">
                                <label class="clean-form-label">Email Subject</label>
                                <input type="text" name="template_order_subject" value="{{ old('template_order_subject', $settings['template_order_subject'] ?? '') }}" class="clean-form-input">
                            </div>
                            <div style="display: grid; grid-template-columns: 3fr 2fr; gap: 1rem;">
                                <div>
                                    <label class="clean-form-label">Email Message Body</label>
                                    <textarea name="template_order_email" rows="4" class="clean-form-input" style="resize: vertical;">{{ old('template_order_email', $settings['template_order_email'] ?? '') }}</textarea>
                                </div>
                                <div>
                                    <label class="clean-form-label">SMS / WhatsApp Message Text</label>
                                    <textarea name="template_order_sms" rows="4" class="clean-form-input" style="resize: vertical;">{{ old('template_order_sms', $settings['template_order_sms'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Active Referral Commission -->
                        <div class="template-card">
                            <div class="template-header">
                                <span style="font-size: 1.2rem;">💰</span>
                                <div>
                                    <h4 style="font-size: 0.96rem; font-weight: 800; color: #0f172a; margin: 0;">3. Active Direct Referral Commission Alert</h4>
                                    <span style="font-size: 0.74rem; color: #64748b;">Sent to affiliate sponsor when their direct link produces an enrollment</span>
                                </div>
                            </div>
                            <div style="margin-bottom: 0.8rem;">
                                <label class="clean-form-label">Email Subject</label>
                                <input type="text" name="template_active_referral_subject" value="{{ old('template_active_referral_subject', $settings['template_active_referral_subject'] ?? '') }}" class="clean-form-input">
                            </div>
                            <div style="display: grid; grid-template-columns: 3fr 2fr; gap: 1rem;">
                                <div>
                                    <label class="clean-form-label">Email Message Body</label>
                                    <textarea name="template_active_referral_email" rows="4" class="clean-form-input" style="resize: vertical;">{{ old('template_active_referral_email', $settings['template_active_referral_email'] ?? '') }}</textarea>
                                </div>
                                <div>
                                    <label class="clean-form-label">SMS / WhatsApp Message Text</label>
                                    <textarea name="template_active_referral_sms" rows="4" class="clean-form-input" style="resize: vertical;">{{ old('template_active_referral_sms', $settings['template_active_referral_sms'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Passive Referral Commission -->
                        <div class="template-card">
                            <div class="template-header">
                                <span style="font-size: 1.2rem;">✨</span>
                                <div>
                                    <h4 style="font-size: 0.96rem; font-weight: 800; color: #0f172a; margin: 0;">4. Tier-2 Passive Commission Alert</h4>
                                    <span style="font-size: 0.74rem; color: #64748b;">Sent to secondary sponsor when their team member produces an enrollment</span>
                                </div>
                            </div>
                            <div style="margin-bottom: 0.8rem;">
                                <label class="clean-form-label">Email Subject</label>
                                <input type="text" name="template_passive_referral_subject" value="{{ old('template_passive_referral_subject', $settings['template_passive_referral_subject'] ?? '') }}" class="clean-form-input">
                            </div>
                            <div style="display: grid; grid-template-columns: 3fr 2fr; gap: 1rem;">
                                <div>
                                    <label class="clean-form-label">Email Message Body</label>
                                    <textarea name="template_passive_referral_email" rows="4" class="clean-form-input" style="resize: vertical;">{{ old('template_passive_referral_email', $settings['template_passive_referral_email'] ?? '') }}</textarea>
                                </div>
                                <div>
                                    <label class="clean-form-label">SMS / WhatsApp Message Text</label>
                                    <textarea name="template_passive_referral_sms" rows="4" class="clean-form-input" style="resize: vertical;">{{ old('template_passive_referral_sms', $settings['template_passive_referral_sms'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Password Reset -->
                        <div class="template-card">
                            <div class="template-header">
                                <span style="font-size: 1.2rem;">🔑</span>
                                <div>
                                    <h4 style="font-size: 0.96rem; font-weight: 800; color: #0f172a; margin: 0;">5. Password Reset Instructions Notification</h4>
                                    <span style="font-size: 0.74rem; color: #64748b;">Dispatched when a student requests a password recovery link</span>
                                </div>
                            </div>
                            <div style="margin-bottom: 0.8rem;">
                                <label class="clean-form-label">Email Subject</label>
                                <input type="text" name="template_password_reset_subject" value="{{ old('template_password_reset_subject', $settings['template_password_reset_subject'] ?? '') }}" class="clean-form-input">
                            </div>
                            <div style="display: grid; grid-template-columns: 3fr 2fr; gap: 1rem;">
                                <div>
                                    <label class="clean-form-label">Email Message Body</label>
                                    <textarea name="template_password_reset_email" rows="4" class="clean-form-input" style="resize: vertical;">{{ old('template_password_reset_email', $settings['template_password_reset_email'] ?? '') }}</textarea>
                                </div>
                                <div>
                                    <label class="clean-form-label">SMS / WhatsApp Message Text</label>
                                    <textarea name="template_password_reset_sms" rows="4" class="clean-form-input" style="resize: vertical;">{{ old('template_password_reset_sms', $settings['template_password_reset_sms'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- 6. KYC Status -->
                        <div class="template-card">
                            <div class="template-header">
                                <span style="font-size: 1.2rem;">📄</span>
                                <div>
                                    <h4 style="font-size: 0.96rem; font-weight: 800; color: #0f172a; margin: 0;">6. KYC Document Verification Status Notification</h4>
                                    <span style="font-size: 0.74rem; color: #64748b;">Dispatched when staff approves or rejects student bank/KYC records</span>
                                </div>
                            </div>
                            <div style="margin-bottom: 0.8rem;">
                                <label class="clean-form-label">Email Subject</label>
                                <input type="text" name="template_kyc_subject" value="{{ old('template_kyc_subject', $settings['template_kyc_subject'] ?? '') }}" class="clean-form-input">
                            </div>
                            <div style="display: grid; grid-template-columns: 3fr 2fr; gap: 1rem;">
                                <div>
                                    <label class="clean-form-label">Email Message Body</label>
                                    <textarea name="template_kyc_email" rows="4" class="clean-form-input" style="resize: vertical;">{{ old('template_kyc_email', $settings['template_kyc_email'] ?? '') }}</textarea>
                                </div>
                                <div>
                                    <label class="clean-form-label">SMS / WhatsApp Message Text</label>
                                    <textarea name="template_kyc_sms" rows="4" class="clean-form-input" style="resize: vertical;">{{ old('template_kyc_sms', $settings['template_kyc_sms'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-primary-action">
                            Save Notification Templates 💾
                        </button>
                    </form>
                </div>
            @endif

            <!-- TAB 3: TAX SETTINGS (GST & INVOICING) -->
            @if($currentTab === 'tax')
                <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 2rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.6rem; flex-wrap: wrap; gap: 1rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 1rem;">
                        <div>
                            <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0 0 0.3rem 0;">
                                GST Tax &amp; Official Invoicing Rules
                            </h3>
                            <p style="font-size: 0.86rem; color: #64748b; margin: 0;">
                                Automatically compute CGST/SGST breakdowns and generate compliant digital tax invoices for course enrollments.
                            </p>
                        </div>
                        <a href="{{ url('/admin/orders') }}" style="display: inline-flex; align-items: center; gap: 6px; background: rgba(5, 179, 150, 0.1); color: #05B396; border: 1px solid rgba(5, 179, 150, 0.3); padding: 0.4rem 0.9rem; border-radius: 8px; font-weight: 700; font-size: 0.82rem; text-decoration: none;">
                            🧾 View Orders &amp; Tax Invoices ↗
                        </a>
                    </div>

                    <form method="POST" action="{{ route('admin.settings.tax') }}">
                        @csrf

                        <!-- Enable / Disable Toggle -->
                        <div style="background: rgba(5, 179, 150, 0.06); border: 1.5px solid rgba(5, 179, 150, 0.35); border-radius: 14px; padding: 1.2rem; margin-bottom: 1.6rem;">
                            <label style="display: flex; align-items: center; gap: 10px; font-size: 0.95rem; font-weight: 800; color: #0f172a; cursor: pointer;">
                                <input type="checkbox" name="tax_enabled" value="1" {{ old('tax_enabled', ($settings['tax_enabled'] ?? '1') === '1') ? 'checked' : '' }} style="width: 20px; height: 20px; accent-color: #05B396; cursor: pointer;">
                                <span>Enable Automated GST Tax Breakdown on Orders &amp; Customer Invoices</span>
                            </label>
                            <span style="font-size: 0.78rem; color: #64748b; display: block; margin-top: 4px; margin-left: 30px;">
                                When enabled, customer invoices will calculate taxable value and 50/50 CGST &amp; SGST breakdown automatically.
                            </span>
                        </div>

                        <!-- Business Registration Details -->
                        <h4 style="font-size: 0.95rem; font-weight: 800; color: #7c3aed; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">
                            1. Company Legal &amp; GST Entity Details
                        </h4>

                        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.2rem; margin-bottom: 1.3rem;">
                            <div>
                                <label class="clean-form-label">Company Legal Entity Name <span style="color: #ef4444;">*</span></label>
                                <input type="text" name="tax_company_name" value="{{ old('tax_company_name', $settings['tax_company_name'] ?? 'SkillLearner EdTech Private Limited') }}" required class="clean-form-input">
                                <span style="font-size: 0.72rem; color: #64748b;">Printed as "Sold By / Service Provider" on all customer tax invoices.</span>
                            </div>
                            <div>
                                <label class="clean-form-label">GST Tax Rate (%) <span style="color: #ef4444;">*</span></label>
                                <input type="number" step="0.5" name="tax_rate" value="{{ old('tax_rate', $settings['tax_rate'] ?? 18) }}" required class="clean-form-input">
                                <span style="font-size: 0.72rem; color: #64748b;">Standard 18.0% for Online Digital Education &amp; Training.</span>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.2rem; margin-bottom: 1.3rem;">
                            <div>
                                <label class="clean-form-label">GSTIN / Registration Number</label>
                                <input type="text" name="tax_gstin" value="{{ old('tax_gstin', $settings['tax_gstin'] ?? '07AABCS1429B1Z2') }}" placeholder="07AABCS1429B1Z2" class="clean-form-input" style="font-family: monospace; font-weight: 700;">
                            </div>
                            <div>
                                <label class="clean-form-label">Services Accounting Code (SAC)</label>
                                <input type="text" name="tax_sac_code" value="{{ old('tax_sac_code', $settings['tax_sac_code'] ?? '999293') }}" placeholder="999293" class="clean-form-input" style="font-family: monospace;">
                                <span style="font-size: 0.72rem; color: #64748b;">SAC 999293: Commercial training &amp; coaching services.</span>
                            </div>
                            <div>
                                <label class="clean-form-label">Tax Invoice Number Prefix</label>
                                <input type="text" name="tax_invoice_prefix" value="{{ old('tax_invoice_prefix', $settings['tax_invoice_prefix'] ?? 'INV-SKL-') }}" placeholder="INV-SKL-" class="clean-form-input" style="font-family: monospace;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.2rem; margin-bottom: 1.3rem;">
                            <div>
                                <label class="clean-form-label">Registered Business Address (Seller Address)</label>
                                <input type="text" name="tax_registered_address" value="{{ old('tax_registered_address', $settings['tax_registered_address'] ?? 'Tower B, Sector 62, Noida, Gautam Buddha Nagar, UP - 201301') }}" class="clean-form-input">
                            </div>
                            <div>
                                <label class="clean-form-label">State / Place of Supply</label>
                                <input type="text" name="tax_state_code" value="{{ old('tax_state_code', $settings['tax_state_code'] ?? '09 - Uttar Pradesh') }}" class="clean-form-input">
                            </div>
                        </div>

                        <div style="margin-bottom: 1.8rem;">
                            <label class="clean-form-label">Invoice Terms &amp; Conditions (Printed in Footer)</label>
                            <textarea name="tax_invoice_terms" rows="2" class="clean-form-input" style="resize: vertical;">{{ old('tax_invoice_terms', $settings['tax_invoice_terms'] ?? '1. Computer generated tax invoice, no physical signature required. 2. Educational digital course once activated is non-refundable per terms.') }}</textarea>
                        </div>

                        <button type="submit" class="btn-primary-action">
                            Save Tax &amp; GST Configuration 💾
                        </button>
                    </form>
                </div>
            @endif

            <!-- TAB 4: FINANCIAL RULES & LOGIN VIDEO -->
            @if($currentTab === 'financial')
                <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 2rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);">
                    <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0 0 0.3rem 0;">
                        Platform Commission Percentages &amp; Login Welcome Video
                    </h3>
                    <p style="font-size: 0.86rem; color: #64748b; margin: 0 0 1.6rem 0;">
                        Manage affiliate tier distributions and the popup welcome guide presented to students upon login.
                    </p>

                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf

                        <div style="margin-bottom: 1.3rem;">
                            <label class="clean-form-label">Platform Brand Name</label>
                            <input type="text" name="platform_name" value="{{ old('platform_name', $settings['platform_name'] ?? 'SkillLearner EdTech') }}" required class="clean-form-input">
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.3rem;">
                            <div>
                                <label class="clean-form-label">Tier-1 Direct Commission (%)</label>
                                <input type="number" step="0.5" name="tier1_commission" value="{{ old('tier1_commission', $settings['tier1_commission'] ?? 70) }}" required class="clean-form-input">
                                <span style="font-size: 0.72rem; color: #64748b;">Paid directly to sponsor affiliate</span>
                            </div>
                            <div>
                                <label class="clean-form-label">Tier-2 Passive Commission (%)</label>
                                <input type="number" step="0.5" name="tier2_commission" value="{{ old('tier2_commission', $settings['tier2_commission'] ?? 10) }}" required class="clean-form-input">
                                <span style="font-size: 0.72rem; color: #64748b;">Paid to secondary upline</span>
                            </div>
                        </div>

                        <div style="margin-bottom: 1.6rem;">
                            <label class="clean-form-label">Minimum Withdrawal Threshold (₹)</label>
                            <input type="number" name="min_payout_amount" value="{{ old('min_payout_amount', $settings['min_payout_amount'] ?? 1000) }}" required class="clean-form-input">
                            <span style="font-size: 0.72rem; color: #64748b;">Minimum wallet balance required to request payout</span>
                        </div>

                        <!-- Login Welcome Video Popup Settings -->
                        <div style="background: linear-gradient(135deg, rgba(5, 179, 150, 0.05) 0%, rgba(79, 70, 229, 0.05) 100%); border: 1.5px solid rgba(5, 179, 150, 0.35); border-radius: 14px; padding: 1.4rem; margin-bottom: 1.6rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem; flex-wrap: wrap; gap: 0.6rem;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-size: 1.3rem;">🎬</span>
                                    <div>
                                        <h4 style="font-size: 1rem; font-weight: 800; color: #0f172a; margin: 0;">
                                            User Login Welcome Video Popup
                                        </h4>
                                        <span style="font-size: 0.76rem; color: #64748b;">Pops up for users immediately after successful login</span>
                                    </div>
                                </div>
                                <button type="button" onclick="previewAdminVideo()" style="background: rgba(5, 179, 150, 0.12); color: #05B396; border: 1.5px solid #05B396; padding: 0.35rem 0.85rem; border-radius: 6px; font-weight: 700; font-size: 0.8rem; cursor: pointer;">
                                    👁️ Test Preview
                                </button>
                            </div>

                            <div style="margin-bottom: 1rem;">
                                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.86rem; font-weight: 700; color: #334155; cursor: pointer;">
                                    <input type="checkbox" name="login_video_enabled" value="1" {{ old('login_video_enabled', ($settings['login_video_enabled'] ?? '1') === '1' ? '1' : '0') == '1' ? 'checked' : '' }} style="width: 17px; height: 17px; accent-color: #05B396; cursor: pointer;">
                                    <span>Enable Welcome Video Popup after user login</span>
                                </label>
                            </div>

                            <div style="margin-bottom: 1rem;">
                                <label class="clean-form-label">Video Link (YouTube / Vimeo / MP4)</label>
                                <input type="url" name="login_video_url" id="adminLoginVideoUrl" value="{{ old('login_video_url', $settings['login_video_url'] ?? 'https://www.youtube.com/watch?v=kJQP7kiw5Fk') }}" placeholder="https://www.youtube.com/watch?v=..." class="clean-form-input" style="font-family: monospace; font-size: 0.88rem;">
                            </div>

                            <div style="margin-bottom: 1rem;">
                                <label class="clean-form-label">Popup Title / Heading</label>
                                <input type="text" name="login_video_title" id="adminLoginVideoTitle" value="{{ old('login_video_title', $settings['login_video_title'] ?? 'Welcome to SkillLearner! Watch This First') }}" class="clean-form-input">
                            </div>

                            <div>
                                <label class="clean-form-label">Short Description / Subtitle</label>
                                <textarea name="login_video_description" id="adminLoginVideoDesc" rows="2" class="clean-form-input" style="resize: vertical;">{{ old('login_video_description', $settings['login_video_description'] ?? 'Get started with your courses, explore your affiliate dashboard, and maximize your learning journey.') }}</textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn-primary-action">
                            Save Commission &amp; Video Rules 💾
                        </button>
                    </form>
                </div>
            @endif

            <!-- TAB 5: BACKUP & MAINTENANCE MODE -->
            @if($currentTab === 'maintenance')
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.8rem;" class="settings-grid">
                    <!-- Maintenance Mode Controller -->
                    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 1.8rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.2rem; flex-wrap: wrap; gap: 0.6rem;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-size: 1.5rem;">🚧</span>
                                <div>
                                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0;">
                                        Maintenance Mode Control
                                    </h3>
                                    <span style="font-size: 0.76rem; color: #64748b;">Lock public access during upgrades</span>
                                </div>
                            </div>

                            @if(($settings['maintenance_mode'] ?? '0') === '1')
                                <span style="background: rgba(239, 68, 68, 0.12); color: #dc2626; font-size: 0.72rem; font-weight: 800; padding: 4px 10px; border-radius: 20px;">
                                    🔴 ACTIVE
                                </span>
                            @else
                                <span style="background: rgba(16, 185, 129, 0.12); color: #10b981; font-size: 0.72rem; font-weight: 800; padding: 4px 10px; border-radius: 20px;">
                                    🟢 LIVE (OFF)
                                </span>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('admin.settings.maintenance') }}">
                            @csrf

                            <div style="background: {{ ($settings['maintenance_mode'] ?? '0') === '1' ? 'rgba(239, 68, 68, 0.05)' : 'rgba(16, 185, 129, 0.05)' }}; border: 1.5px solid {{ ($settings['maintenance_mode'] ?? '0') === '1' ? '#ef4444' : '#10b981' }}; border-radius: 12px; padding: 1rem; margin-bottom: 1.2rem;">
                                <label style="display: flex; align-items: center; gap: 10px; font-size: 0.92rem; font-weight: 800; color: #0f172a; cursor: pointer;">
                                    <input type="checkbox" name="maintenance_mode" value="1" {{ old('maintenance_mode', ($settings['maintenance_mode'] ?? '0') === '1') ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #ef4444; cursor: pointer;">
                                    <span>Activate Maintenance Mode (Show Upgrade Screen)</span>
                                </label>
                                <span style="font-size: 0.74rem; color: #64748b; display: block; margin-top: 4px; margin-left: 28px;">
                                    Super Admins always remain logged in and can browse freely.
                                </span>
                            </div>

                            <div style="margin-bottom: 1rem;">
                                <label class="clean-form-label">Maintenance Heading / Title</label>
                                <input type="text" name="maintenance_title" value="{{ old('maintenance_title', $settings['maintenance_title'] ?? 'Scheduled Platform Maintenance in Progress') }}" required class="clean-form-input">
                            </div>

                            <div style="margin-bottom: 1rem;">
                                <label class="clean-form-label">Public Message</label>
                                <textarea name="maintenance_message" rows="3" required class="clean-form-input" style="resize: vertical;">{{ old('maintenance_message', $settings['maintenance_message'] ?? 'We are upgrading our platform infrastructure to deliver a faster and smoother learning experience. We will be back online shortly!') }}</textarea>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem; margin-bottom: 1.4rem;">
                                <div>
                                    <label class="clean-form-label">Secret Bypass Key</label>
                                    <input type="text" name="maintenance_bypass_key" value="{{ old('maintenance_bypass_key', $settings['maintenance_bypass_key'] ?? 'skl-admin-bypass') }}" required class="clean-form-input" style="font-family: monospace;">
                                </div>
                                <div>
                                    <label class="clean-form-label">Expected Uptime</label>
                                    <input type="text" name="maintenance_end_time" value="{{ old('maintenance_end_time', $settings['maintenance_end_time'] ?? 'Shortly') }}" placeholder="e.g. 2 Hours" class="clean-form-input">
                                </div>
                            </div>

                            <div style="font-size: 0.75rem; color: #64748b; margin-bottom: 1.2rem; background: #f8fafc; padding: 0.6rem 0.8rem; border-radius: 8px;">
                                🔑 <strong>Secret Bypass Link:</strong> <code>{{ url('/?bypass=' . ($settings['maintenance_bypass_key'] ?? 'skl-admin-bypass')) }}</code>
                            </div>

                            <div style="display: flex; gap: 0.8rem;">
                                <button type="submit" class="btn-primary-action" style="flex: 1;">
                                    Update Maintenance Mode 💾
                                </button>
                                <a href="{{ url('/?bypass=' . ($settings['maintenance_bypass_key'] ?? 'skl-admin-bypass')) }}" target="_blank" style="display: inline-flex; align-items: center; background: #f1f5f9; color: #334155; padding: 0.75rem 1rem; border-radius: 8px; font-weight: 700; font-size: 0.84rem; text-decoration: none;">
                                    👁️ Preview
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Database Backup Creator -->
                    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 1.8rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); display: flex; flex-direction: column;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-size: 1.5rem;">💾</span>
                                <div>
                                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0;">
                                        Database &amp; Data Backup
                                    </h3>
                                    <span style="font-size: 0.76rem; color: #64748b;">Instant SQL snapshot of all tables</span>
                                </div>
                            </div>
                            <span style="background: rgba(124, 58, 237, 0.1); color: #7c3aed; font-size: 0.75rem; font-weight: 800; padding: 3px 10px; border-radius: 20px;">
                                {{ count($backups) }} Backups Saved
                            </span>
                        </div>

                        <p style="font-size: 0.84rem; color: #64748b; line-height: 1.5; margin-bottom: 1.2rem;">
                            Generates a complete standalone SQL dump with all users, commissions, orders, packages, course enrollments, and platform settings. Stored securely in <code>storage/app/backups/</code>.
                        </p>

                        <form method="POST" action="{{ route('admin.settings.backup.create') }}" style="margin-bottom: 1.6rem;">
                            @csrf
                            <button type="submit" style="width: 100%; background: linear-gradient(135deg, #05B396 0%, #048873 100%); color: #ffffff; border: none; padding: 0.9rem 1.4rem; border-radius: 10px; font-weight: 800; font-size: 0.95rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 15px rgba(5, 179, 150, 0.35);">
                                <span>⚡ Generate Instant Database Backup</span>
                            </button>
                        </form>

                        <!-- System Cache Utility -->
                        <div style="border-top: 1px solid #f1f5f9; padding-top: 1.2rem; margin-top: auto;">
                            <h4 style="font-size: 0.92rem; font-weight: 800; color: #0f172a; margin: 0 0 0.4rem 0;">
                                ⚡ System Performance &amp; Cache Utility
                            </h4>
                            <p style="font-size: 0.78rem; color: #64748b; margin: 0 0 0.8rem 0;">
                                Flush compiled views, configuration cache, and application memory to apply instant updates.
                            </p>
                            <form method="POST" action="{{ route('admin.settings.clear-cache') }}">
                                @csrf
                                <button type="submit" style="background: rgba(124, 58, 237, 0.08); border: 1.5px solid #7c3aed; color: #7c3aed; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 800; font-size: 0.82rem; cursor: pointer;">
                                    Clear Application Cache &amp; Re-optimize 🚀
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Backup Files History Table -->
                <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 1.8rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); margin-bottom: 1.8rem;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0 0 1.2rem 0;">
                        Saved Database Backups
                    </h3>

                    @if(empty($backups))
                        <div style="text-align: center; padding: 2.5rem 1rem; color: #94a3b8;">
                            <div style="font-size: 2.2rem; margin-bottom: 0.5rem;">📂</div>
                            <div style="font-weight: 700; font-size: 0.95rem; color: #475569;">No database backups created yet</div>
                            <div style="font-size: 0.82rem; margin-top: 4px;">Click the "Generate Instant Database Backup" button above to create your first snapshot.</div>
                        </div>
                    @else
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; font-size: 0.88rem;">
                                <thead>
                                    <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; text-align: left; color: #475569;">
                                        <th style="padding: 0.8rem 1rem; font-weight: 800;">File Name</th>
                                        <th style="padding: 0.8rem 1rem; font-weight: 800;">Size</th>
                                        <th style="padding: 0.8rem 1rem; font-weight: 800;">Created At</th>
                                        <th style="padding: 0.8rem 1rem; font-weight: 800; text-align: right;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($backups as $b)
                                        <tr style="border-bottom: 1px solid #f1f5f9;">
                                            <td style="padding: 0.85rem 1rem; font-family: monospace; font-weight: 700; color: #0f172a;">
                                                📦 {{ $b['filename'] }}
                                            </td>
                                            <td style="padding: 0.85rem 1rem; color: #64748b; font-weight: 600;">
                                                {{ $b['size'] }}
                                            </td>
                                            <td style="padding: 0.85rem 1rem; color: #64748b;">
                                                {{ $b['created_at'] }}
                                            </td>
                                            <td style="padding: 0.85rem 1rem; text-align: right;">
                                                <div style="display: inline-flex; gap: 8px;">
                                                    <a href="{{ route('admin.settings.backup.download', $b['filename']) }}" style="background: rgba(5, 179, 150, 0.1); color: #05B396; border: 1px solid #05B396; padding: 0.35rem 0.75rem; border-radius: 6px; font-weight: 700; font-size: 0.78rem; text-decoration: none;">
                                                        ⬇️ Download
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.settings.backup.delete', $b['filename']) }}" onsubmit="return confirm('Are you sure you want to permanently delete this backup file?');" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" style="background: rgba(239, 68, 68, 0.1); color: #dc2626; border: 1px solid #ef4444; padding: 0.35rem 0.75rem; border-radius: 6px; font-weight: 700; font-size: 0.78rem; cursor: pointer;">
                                                            🗑️ Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- Server Environment Diagnostics -->
                <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 1.8rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0 0 1.2rem 0;">
                        🖥️ Server &amp; Environment Diagnostics
                    </h3>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                        <div class="diag-card">
                            <span class="diag-label">PHP Engine</span>
                            <span class="diag-val">PHP {{ $serverInfo['php_version'] }}</span>
                        </div>
                        <div class="diag-card">
                            <span class="diag-label">Laravel Framework</span>
                            <span class="diag-val">v{{ $serverInfo['laravel_version'] }}</span>
                        </div>
                        <div class="diag-card">
                            <span class="diag-label">Database Connection</span>
                            <span class="diag-val">{{ strtoupper($serverInfo['database_driver']) }} ({{ $serverInfo['database_name'] }})</span>
                        </div>
                        <div class="diag-card">
                            <span class="diag-label">Memory Limit</span>
                            <span class="diag-val">{{ $serverInfo['memory_limit'] }}</span>
                        </div>
                        <div class="diag-card">
                            <span class="diag-label">Max Upload / Post</span>
                            <span class="diag-val">{{ $serverInfo['max_upload'] }} / {{ $serverInfo['post_max_size'] }}</span>
                        </div>
                        <div class="diag-card">
                            <span class="diag-label">Server Software</span>
                            <span class="diag-val">{{ Str::limit($serverInfo['server_software'], 25) }}</span>
                        </div>
                    </div>
                </div>
            @endif

        </main>
    </div>
</div>

@include('portal.styles')

@push('styles')
<style>
    .clean-form-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 0.35rem;
    }

    .clean-form-input {
        width: 100%;
        padding: 0.65rem 0.9rem;
        border: 1.5px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.9rem;
        color: #0f172a;
        background: #ffffff;
        box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .clean-form-input:focus {
        outline: none;
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.15);
    }

    .settings-tab-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.65rem 1.2rem;
        font-size: 0.9rem;
        font-weight: 700;
        color: #64748b;
        text-decoration: none;
        border-bottom: 3px solid transparent;
        transition: color 0.2s, border-color 0.2s;
        white-space: nowrap;
    }

    .settings-tab-btn:hover {
        color: #7c3aed;
    }

    .settings-tab-btn.active {
        color: #7c3aed;
        border-bottom-color: #7c3aed;
    }

    .btn-primary-action {
        background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%);
        color: #ffffff;
        border: none;
        padding: 0.85rem 1.8rem;
        border-radius: 8px;
        font-weight: 800;
        font-size: 0.95rem;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(124, 58, 237, 0.3);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-primary-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(124, 58, 237, 0.4);
    }

    .template-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.2rem;
        margin-bottom: 1.4rem;
    }

    .template-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 0.8rem;
    }

    .diag-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.9rem 1.1rem;
    }

    .diag-label {
        display: block;
        font-size: 0.72rem;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 3px;
    }

    .diag-val {
        display: block;
        font-size: 0.92rem;
        font-weight: 800;
        color: #0f172a;
        word-break: break-all;
    }

    @media (max-width: 900px) {
        .settings-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function formatAdminEmbedUrl(url) {
        if (!url) return '';
        url = url.trim();
        const ytMatch = url.match(/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|v\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
        if (ytMatch) {
            return `https://www.youtube.com/embed/${ytMatch[1]}?autoplay=1&rel=0&modestbranding=1&playsinline=1`;
        }
        const vmMatch = url.match(/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/|)(\d+)/);
        if (vmMatch) {
            return `https://player.vimeo.com/video/${vmMatch[1]}?autoplay=1`;
        }
        return url;
    }

    function previewAdminVideo() {
        const urlInput = document.getElementById('adminLoginVideoUrl');
        const titleInput = document.getElementById('adminLoginVideoTitle');
        const descInput = document.getElementById('adminLoginVideoDesc');

        const rawUrl = urlInput ? urlInput.value : '';
        const embedUrl = formatAdminEmbedUrl(rawUrl);

        if (!embedUrl) {
            alert('Please enter a valid video URL first (e.g. YouTube link).');
            return;
        }

        const modalTitle = document.getElementById('loginVideoModalTitle');
        const modalSub = document.querySelector('.login-video-subtitle');
        if (modalTitle && titleInput && titleInput.value) modalTitle.innerText = titleInput.value;
        if (modalSub && descInput && descInput.value) modalSub.innerText = descInput.value;

        if (typeof window.openLoginVideoModal === 'function') {
            window.openLoginVideoModal(embedUrl);
        } else {
            alert('Modal player loaded. Direct embed link: ' + embedUrl);
        }
    }
</script>
@endpush
@endsection
