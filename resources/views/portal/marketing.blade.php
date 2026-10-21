@extends('layouts.app')

@section('title', 'Marketing Tool — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'marketing'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'marketing'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div class="portal-box-card">
                <div style="margin-bottom: 2rem;">
                    <h3 style="font-size: 1.5rem; color: #0f172a; font-weight: 800;">🎨 Official Affiliate Marketing Kit</h3>
                    <p style="color: #64748b; font-size: 0.95rem;">Download ready-made high-converting graphics, reels templates, WhatsApp status swipes, and sales flyers.</p>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                    <!-- 1. Instagram Story Posters -->
                    <div style="border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.4rem; background: #ffffff;">
                        <span style="font-size: 0.75rem; color: #05B396; font-weight: 800; text-transform: uppercase;">DESIGN ASSETS</span>
                        <h4 style="font-size: 1.15rem; color: #0f172a; margin: 6px 0 8px; font-weight: 800;">Instagram Story Banners (50+ Designs)</h4>
                        <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 1.2rem;">Editable Canva templates sized for 9:16 Instagram Stories &amp; WhatsApp status.</p>
                        <button type="button" onclick="alert('Downloading Story Banners Pack (ZIP)...')" class="btn btn-secondary" style="width: 100%; border: 1px solid #a7f3d0; color: #05B396; font-weight: 700;">
                            📥 Download Banners (.ZIP)
                        </button>
                    </div>

                    <!-- 2. WhatsApp DM Scripts -->
                    <div style="border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.4rem; background: #ffffff;">
                        <span style="font-size: 0.75rem; color: #16a34a; font-weight: 800; text-transform: uppercase;">CLOSING SCRIPTS</span>
                        <h4 style="font-size: 1.15rem; color: #0f172a; margin: 6px 0 8px; font-weight: 800;">WhatsApp Lead Closing Swipe File</h4>
                        <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 1.2rem;">Proven text messages, voice-note talking points, and daily status sequences.</p>
                        <button type="button" onclick="alert('Downloading WhatsApp Scripts (PDF)...')" class="btn btn-secondary" style="width: 100%; border: 1px solid #bbf7d0; color: #16a34a; font-weight: 700;">
                            📥 Download Scripts (.PDF)
                        </button>
                    </div>

                    <!-- 3. Reel Hooks & Audio Lists -->
                    <div style="border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.4rem; background: #ffffff;">
                        <span style="font-size: 0.75rem; color: #0284c7; font-weight: 800; text-transform: uppercase;">VIRAL CONTENT</span>
                        <h4 style="font-size: 1.15rem; color: #0f172a; margin: 6px 0 8px; font-weight: 800;">100 Viral Reel Hooks &amp; Trending Sounds</h4>
                        <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 1.2rem;">Tested 3-second attention-grabbing headlines for educational faceless reels.</p>
                        <button type="button" onclick="alert('Downloading Reel Hooks Pack (PDF)...')" class="btn btn-secondary" style="width: 100%; border: 1px solid #bae6fd; color: #0284c7; font-weight: 700;">
                            📥 Download Hooks (.PDF)
                        </button>
                    </div>

                    <!-- 4. Payout Proofs & Social Proof -->
                    <div style="border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.4rem; background: #ffffff;">
                        <span style="font-size: 0.75rem; color: #d97706; font-weight: 800; text-transform: uppercase;">SOCIAL PROOF</span>
                        <h4 style="font-size: 1.15rem; color: #0f172a; margin: 6px 0 8px; font-weight: 800;">Official Payout Proofs &amp; Testimonials</h4>
                        <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 1.2rem;">Verified bank transfer screenshots and student video reviews to post as stories.</p>
                        <button type="button" onclick="alert('Downloading Social Proof Media (ZIP)...')" class="btn btn-secondary" style="width: 100%; border: 1px solid #fde68a; color: #d97706; font-weight: 700;">
                            📥 Download Proofs (.ZIP)
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

@include('portal.styles')
@endsection
