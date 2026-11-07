@extends('layouts.app')

@section('title', 'Social Community — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'community'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'community'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div class="portal-box-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 2.2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                <div style="margin-bottom: 2rem;">
                    <h3 style="font-size: 1.6rem; color: #0f172a; font-weight: 800; margin: 0; display: flex; align-items: center; gap: 10px;">
                        🌐 Official Social Communities
                    </h3>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem;">
                    <!-- 1. WhatsApp Community -->
                    <div style="padding: 1.8rem 1.4rem; border-radius: 16px; background: #f0fdf4; border: 1.5px solid #bbf7d0; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: space-between; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(22, 163, 74, 0.12)';" onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                        <div style="width: 56px; height: 56px; background: #25d366; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; box-shadow: 0 6px 16px rgba(37, 211, 102, 0.3);">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="#ffffff">
                                <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2zm0 18.15c-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.167 8.167 0 01-1.25-4.38c0-4.51 3.67-8.18 8.18-8.18 2.18 0 4.24.85 5.78 2.4 1.55 1.54 2.4 3.6 2.4 5.78 0 4.52-3.67 8.24-8.22 8.24zm4.49-6.16c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.12-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.38-1.72-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.14.17-.25.25-.41.08-.17.04-.31-.02-.43s-.56-1.34-.76-1.84c-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31-.22.25-.86.84-.86 2.05s.88 2.38 1 2.54c.12.17 1.73 2.64 4.2 3.7.59.25 1.05.4 1.41.51.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.17-.48-.29z"/>
                            </svg>
                        </div>
                        <h4 style="color: #166534; font-weight: 800; font-size: 1.2rem; margin: 0 0 1.2rem 0;">WhatsApp Channel</h4>
                        <a href="https://whatsapp.com/channel/0029VbEHttyHrDZfE7sHaM1f" target="_blank" rel="noopener noreferrer" style="background: #16a34a; color: #ffffff; font-size: 0.92rem; padding: 0.75rem 1.4rem; font-weight: 800; width: 100%; text-align: center; display: block; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25); transition: background 0.15s ease;">
                            Join WhatsApp ➔
                        </a>
                    </div>

                    <!-- 2. Instagram Network -->
                    <div style="padding: 1.8rem 1.4rem; border-radius: 16px; background: #fdf2f8; border: 1.5px solid #fbcfe8; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: space-between; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(219, 39, 119, 0.12)';" onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                        <div style="width: 56px; height: 56px; background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; box-shadow: 0 6px 16px rgba(220, 39, 67, 0.3);">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </div>
                        <h4 style="color: #9d174d; font-weight: 800; font-size: 1.2rem; margin: 0 0 1.2rem 0;">Instagram Official</h4>
                        <a href="https://www.instagram.com/skilllearner_official?utm_source=qr&xtok=MTVwcXZiOGd1cTM3bQ==" target="_blank" rel="noopener noreferrer" style="background: #db2777; color: #ffffff; font-size: 0.92rem; padding: 0.75rem 1.4rem; font-weight: 800; width: 100%; text-align: center; display: block; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 12px rgba(219, 39, 119, 0.25); transition: background 0.15s ease;">
                            Follow on Instagram ➔
                        </a>
                    </div>

                    <!-- 3. YouTube Channel -->
                    <div style="padding: 1.8rem 1.4rem; border-radius: 16px; background: #fef2f2; border: 1.5px solid #fecaca; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: space-between; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(220, 38, 38, 0.12)';" onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                        <div style="width: 56px; height: 56px; background: #ff0000; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; box-shadow: 0 6px 16px rgba(255, 0, 0, 0.3);">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="#ffffff">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </div>
                        <h4 style="color: #991b1b; font-weight: 800; font-size: 1.2rem; margin: 0 0 1.2rem 0;">YouTube Channel</h4>
                        <a href="https://www.youtube.com/@Skilllearner_official" target="_blank" rel="noopener noreferrer" style="background: #dc2626; color: #ffffff; font-size: 0.92rem; padding: 0.75rem 1.4rem; font-weight: 800; width: 100%; text-align: center; display: block; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25); transition: background 0.15s ease;">
                            Subscribe on YouTube ➔
                        </a>
                    </div>

                    <!-- 4. Facebook Community -->
                    <div style="padding: 1.8rem 1.4rem; border-radius: 16px; background: #eff6ff; border: 1.5px solid #bfdbfe; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: space-between; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(37, 99, 235, 0.12)';" onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                        <div style="width: 56px; height: 56px; background: #1877f2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; box-shadow: 0 6px 16px rgba(24, 119, 242, 0.3);">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="#ffffff">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </div>
                        <h4 style="color: #1e40af; font-weight: 800; font-size: 1.2rem; margin: 0 0 1.2rem 0;">Facebook Community</h4>
                        <a href="https://www.facebook.com/share/g/1FFBMXrPmb/" target="_blank" rel="noopener noreferrer" style="background: #2563eb; color: #ffffff; font-size: 0.92rem; padding: 0.75rem 1.4rem; font-weight: 800; width: 100%; text-align: center; display: block; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25); transition: background 0.15s ease;">
                            Join Facebook ➔
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

@include('portal.styles')
@endsection
