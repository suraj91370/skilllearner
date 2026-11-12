@extends('layouts.app')

@section('title', 'Banners & Homepage Sections — SkillLearner Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-content-homepage'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-content-homepage'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header Banner -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 class="welcome-heading" style="font-size: 1.6rem; margin-bottom: 0.25rem;">
                        🏠 Banners &amp; Homepage Sections
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Customize top marketing banners, hero headlines, CTA buttons, and turn homepage modules on or off.
                    </p>
                </div>
                <div>
                    <a href="{{ url('/') }}" target="_blank" style="background: #ffffff; border: 1.5px solid #cbd5e1; color: #334155; padding: 0.6rem 1.1rem; border-radius: 8px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        <span>🌐 View Live Homepage ↗</span>
                    </a>
                </div>
            </div>

            <!-- Content Management Tabs Navigation -->
            @include('admin.content.tabs', ['tab' => 'homepage'])

            @if(session('success'))
                <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.content.homepage.update') }}">
                @csrf

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;" class="admin-two-col-grid">
                    
                    <!-- Left Column: Hero Banner & Text Content -->
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        
                        <!-- Hero Banner Content -->
                        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.6rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 1.2rem; padding-bottom: 0.8rem; border-bottom: 1px solid #f1f5f9;">
                                <span style="font-size: 1.3rem;">🎯</span>
                                <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0;">Hero Banner &amp; Primary Headlines</h3>
                            </div>

                            <!-- Small Badge / Pill Tag -->
                            <div style="margin-bottom: 1.2rem;">
                                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                                    Hero Badge / Eyebrow Pill Text
                                </label>
                                <input type="text" name="home_hero_tag" value="{{ old('home_hero_tag', $settings['home_hero_tag'] ?? '✨ NO.1 DIGITAL EDUCATION & AFFILIATE PLATFORM IN INDIA') }}" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; font-weight: 600; outline: none;">
                            </div>

                            <!-- Main Headline -->
                            <div style="margin-bottom: 1.2rem;">
                                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                                    Main Hero Headline *
                                </label>
                                <input type="text" name="home_hero_title" value="{{ old('home_hero_title', $settings['home_hero_title'] ?? 'Learn High-Demand Skills. Unlock True Financial Freedom.') }}" required style="width: 100%; padding: 0.7rem 0.95rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 1.05rem; font-weight: 800; color: #0f172a; outline: none;">
                            </div>

                            <!-- Subheadline / Paragraph -->
                            <div style="margin-bottom: 1.2rem;">
                                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                                    Hero Subtitle / Description *
                                </label>
                                <textarea name="home_hero_subtitle" rows="3" required style="width: 100%; padding: 0.7rem 0.95rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem; line-height: 1.5; outline: none;">{{ old('home_hero_subtitle', $settings['home_hero_subtitle'] ?? 'Master modern video editing, performance Meta ads, business automation, and high-converting funnels with India’s top digital mentors.') }}</textarea>
                            </div>

                            <!-- Primary CTA Button (Text & Link) -->
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 1.2rem;">
                                <div>
                                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                                        CTA Button Text *
                                    </label>
                                    <input type="text" name="home_hero_cta_text" value="{{ old('home_hero_cta_text', $settings['home_hero_cta_text'] ?? '🚀 Explore All Packages') }}" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; font-weight: 700; outline: none;">
                                </div>
                                <div>
                                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                                        CTA Button Link / Anchor *
                                    </label>
                                    <input type="text" name="home_hero_cta_link" value="{{ old('home_hero_cta_link', $settings['home_hero_cta_link'] ?? '#packages') }}" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; font-family: monospace; outline: none;">
                                </div>
                            </div>
                        </div>

                        <!-- Top Announcement Ribbon -->
                        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.6rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 1.2rem; padding-bottom: 0.8rem; border-bottom: 1px solid #f1f5f9;">
                                <span style="font-size: 1.3rem;">📢</span>
                                <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0;">Top Announcement Ribbon Bar</h3>
                            </div>

                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                                    Announcement Text
                                </label>
                                <input type="text" name="home_announcement_bar" value="{{ old('home_announcement_bar', $settings['home_announcement_bar'] ?? '🔥 New Flash Sale Live! Get Extra 10% Off with Code: SKILL10') }}" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none;">
                            </div>

                            <label style="display: flex; align-items: center; gap: 8px; font-size: 0.86rem; font-weight: 700; color: #334155; cursor: pointer;">
                                <input type="checkbox" name="home_show_announcement" value="1" {{ ($settings['home_show_announcement'] ?? '1') === '1' ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #05B396;">
                                <span>Show Announcement Bar across top of platform</span>
                            </label>
                        </div>

                    </div>

                    <!-- Right Column: Sections Visibility Toggles -->
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        
                        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.6rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 1.2rem; padding-bottom: 0.8rem; border-bottom: 1px solid #f1f5f9;">
                                <span style="font-size: 1.3rem;">👁️</span>
                                <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0;">Homepage Section Controls</h3>
                            </div>
                            <p style="font-size: 0.82rem; color: #64748b; margin: 0 0 1.2rem;">
                                Check or uncheck sections to instantly show or hide them on the public landing page.
                            </p>

                            <div style="display: flex; flex-direction: column; gap: 12px;">
                                
                                <label style="display: flex; align-items: center; justify-content: space-between; padding: 0.6rem 0.8rem; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0; cursor: pointer;">
                                    <span style="font-size: 0.88rem; font-weight: 700; color: #0f172a;">📦 Packages Grid</span>
                                    <input type="checkbox" name="home_show_packages" value="1" {{ ($settings['home_show_packages'] ?? '1') === '1' ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #05B396;">
                                </label>

                                <label style="display: flex; align-items: center; justify-content: space-between; padding: 0.6rem 0.8rem; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0; cursor: pointer;">
                                    <span style="font-size: 0.88rem; font-weight: 700; color: #0f172a;">🎓 Expert Mentors Showcase</span>
                                    <input type="checkbox" name="home_show_mentors" value="1" {{ ($settings['home_show_mentors'] ?? '1') === '1' ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #05B396;">
                                </label>

                                <label style="display: flex; align-items: center; justify-content: space-between; padding: 0.6rem 0.8rem; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0; cursor: pointer;">
                                    <span style="font-size: 0.88rem; font-weight: 700; color: #0f172a;">💡 Why Choose SkillLearner</span>
                                    <input type="checkbox" name="home_show_why_us" value="1" {{ ($settings['home_show_why_us'] ?? '1') === '1' ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #05B396;">
                                </label>

                                <label style="display: flex; align-items: center; justify-content: space-between; padding: 0.6rem 0.8rem; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0; cursor: pointer;">
                                    <span style="font-size: 0.88rem; font-weight: 700; color: #0f172a;">👔 Founders &amp; Leadership</span>
                                    <input type="checkbox" name="home_show_founders" value="1" {{ ($settings['home_show_founders'] ?? '1') === '1' ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #05B396;">
                                </label>

                                <label style="display: flex; align-items: center; justify-content: space-between; padding: 0.6rem 0.8rem; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0; cursor: pointer;">
                                    <span style="font-size: 0.88rem; font-weight: 700; color: #0f172a;">⭐ Student Testimonials</span>
                                    <input type="checkbox" name="home_show_testimonials" value="1" {{ ($settings['home_show_testimonials'] ?? '1') === '1' ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #05B396;">
                                </label>

                                <label style="display: flex; align-items: center; justify-content: space-between; padding: 0.6rem 0.8rem; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0; cursor: pointer;">
                                    <span style="font-size: 0.88rem; font-weight: 700; color: #0f172a;">❓ Frequently Asked Questions</span>
                                    <input type="checkbox" name="home_show_faq" value="1" {{ ($settings['home_show_faq'] ?? '1') === '1' ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #05B396;">
                                </label>

                                <label style="display: flex; align-items: center; justify-content: space-between; padding: 0.6rem 0.8rem; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0; cursor: pointer;">
                                    <span style="font-size: 0.88rem; font-weight: 700; color: #0f172a;">🚀 Final Join CTA Banner</span>
                                    <input type="checkbox" name="home_show_cta" value="1" {{ ($settings['home_show_cta'] ?? '1') === '1' ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #05B396;">
                                </label>

                            </div>

                            <button type="submit" style="width: 100%; margin-top: 1.5rem; background: #05B396; color: #ffffff; border: none; padding: 0.85rem; border-radius: 10px; font-weight: 800; font-size: 0.95rem; cursor: pointer; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.35);">
                                💾 Save Homepage Settings
                            </button>
                        </div>

                    </div>

                </div>
            </form>

        </main>
    </div>
</div>

@include('portal.styles')
@endsection

