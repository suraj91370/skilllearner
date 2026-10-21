@extends('layouts.app')

@section('title', 'Affiliate Link — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'affiliate-link'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'affiliate-link'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div class="portal-box-card" style="max-width: 860px;">
                <h3 style="font-size: 1.5rem; color: #0f172a; font-weight: 800; margin-bottom: 0.5rem;">🔗 Your Unique SkillLearner Referral Link</h3>
                <p style="color: #64748b; font-size: 0.95rem; margin-bottom: 1.8rem;">Every student who enrolls through this link gives you up to 70% direct commission instantly credited to your wallet balance.</p>
                
                <div style="background: #f0fdfa; border: 1.5px solid #a7f3d0; border-radius: 12px; padding: 1.4rem; margin-bottom: 2rem;">
                    <label style="font-size: 0.8rem; color: #05B396; font-weight: 800; text-transform: uppercase; display: block; margin-bottom: 6px;">MASTER SIGNUP &amp; REGISTRATION URL</label>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <input type="text" id="dedicatedRefLink" style="flex: 1; min-width: 260px; padding: 0.85rem 1rem; border: 1.5px solid #a7f3d0; border-radius: 8px; font-size: 0.95rem; font-weight: 700; background: #ffffff; color: #05B396;" value="{{ url('/register') }}?ref={{ session('user.affiliate_id', 'SL-8821') }}" readonly>
                        <button type="button" onclick="copyDedicatedRefLink()" class="btn btn-primary" style="background: #05B396; font-weight: 800; padding: 0.85rem 1.6rem;">Copy Link</button>
                    </div>

                    <div style="display: flex; gap: 10px; margin-top: 1.2rem; flex-wrap: wrap;">
                        <a href="https://api.whatsapp.com/send?text=Learn%20high-ticket%20skills%20and%20monetize%20with%20SkillLearner:%20{{ url('/register') }}?ref={{ session('user.affiliate_id', 'SL-8821') }}" target="_blank" class="btn btn-primary" style="background: #25d366; font-size: 0.85rem; font-weight: 700;">
                            📲 Share on WhatsApp
                        </a>
                        <a href="https://t.me/share/url?url={{ url('/register') }}?ref={{ session('user.affiliate_id', 'SL-8821') }}&text=Master%20Digital%20Skills%20with%20SkillLearner" target="_blank" class="btn btn-primary" style="background: #0088cc; font-size: 0.85rem; font-weight: 700;">
                            ✈️ Share on Telegram
                        </a>
                    </div>
                </div>

                <h4 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin-bottom: 1rem;">Direct Package Checkout Links</h4>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @php
                        $packages = [
                            ['name' => 'Advance Package (Most Popular)', 'id' => 'advance', 'comm' => '₹2,200 Commission'],
                            ['name' => 'Premium Package', 'id' => 'premium', 'comm' => '₹3,500 Commission'],
                            ['name' => 'Infinity Package (All Access)', 'id' => 'infinity', 'comm' => '₹8,500 Commission'],
                            ['name' => 'Basic Package', 'id' => 'basic', 'comm' => '₹1,200 Commission']
                        ];
                    @endphp

                    @foreach ($packages as $pkg)
                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 1rem 1.2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.8rem;">
                            <div>
                                <strong style="color: #0f172a; font-size: 0.95rem;">{{ $pkg['name'] }}</strong>
                                <span style="background: #ecfdf5; color: #059669; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; margin-left: 8px;">{{ $pkg['comm'] }}</span>
                            </div>
                            <div style="display: flex; gap: 8px;">
                                <input type="text" id="link-{{ $pkg['id'] }}" value="{{ url('/buy-now') }}?package={{ $pkg['id'] }}&ref={{ session('user.affiliate_id', 'SL-8821') }}" style="display: none;" readonly>
                                <button type="button" onclick="copySpecificLink('{{ $pkg['id'] }}')" class="btn btn-secondary" style="padding: 0.4rem 0.9rem; font-size: 0.82rem; border: 1px solid #a7f3d0; color: #05B396; font-weight: 700;">Copy Checkout Link</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
</div>

@include('portal.styles')

@push('scripts')
<script>
    function copyDedicatedRefLink() {
        const input = document.getElementById('dedicatedRefLink');
        if (input) {
            input.select();
            navigator.clipboard.writeText(input.value).then(() => {
                alert('✅ Affiliate Referral Link Copied!\n' + input.value);
            });
        }
    }

    function copySpecificLink(pkgId) {
        const input = document.getElementById('link-' + pkgId);
        if (input) {
            navigator.clipboard.writeText(input.value).then(() => {
                alert('✅ Package Checkout Link Copied!\n' + input.value);
            });
        }
    }
</script>
@endpush
@endsection
