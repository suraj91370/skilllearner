@extends('layouts.app')

@section('title', 'Affiliate Referral Links — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'affiliate-link'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'affiliate-link'])

        <!-- Right Content Area -->
        <main class="portal-content-area" style="display: flex; justify-content: center;">
            <div class="portal-box-card" style="width: 100%; max-width: 820px; padding: 2rem 1.8rem; border-radius: 18px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);">
                
                <h3 style="font-size: 1.45rem; font-weight: 800; color: #0f172a; margin: 0 0 1.8rem;">
                    Affiliate Referral Links
                </h3>

                @php
                    $affId = session('user.affiliate_id', 'SL-8821');
                    $baseUrl = url('/buy-now');

                    $linksList = [
                        [
                            'id' => 'basic',
                            'name' => 'Basic Package',
                            'url' => $baseUrl . '?package=basic&ref=' . urlencode($affId),
                        ],
                        [
                            'id' => 'growth',
                            'name' => 'Growth Package',
                            'url' => $baseUrl . '?package=growth&ref=' . urlencode($affId),
                        ],
                        [
                            'id' => 'advance',
                            'name' => 'Advance Package',
                            'url' => $baseUrl . '?package=advance&ref=' . urlencode($affId),
                        ],
                        [
                            'id' => 'premium',
                            'name' => 'Premium Package',
                            'url' => $baseUrl . '?package=premium&ref=' . urlencode($affId),
                        ],
                        [
                            'id' => 'infinity',
                            'name' => 'Infinity Package',
                            'url' => $baseUrl . '?package=infinity&ref=' . urlencode($affId),
                        ],
                        [
                            'id' => 'all_packages',
                            'name' => 'All Packages Link',
                            'url' => url('/plans') . '?ref=' . urlencode($affId),
                        ],
                    ];
                @endphp

                <!-- Referral Links List (Clean & Minimal, Project Packages Only) -->
                <div style="display: flex; flex-direction: column; gap: 1.35rem;">
                    @foreach ($linksList as $item)
                        <div>
                            <div style="font-size: 0.95rem; font-weight: 700; color: #0f172a; margin-bottom: 8px;">
                                {{ $item['name'] }}
                            </div>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <input type="text" id="linkInput_{{ $item['id'] }}" value="{{ $item['url'] }}" readonly class="clean-link-input">
                                <button type="button" onclick="copyReferralUrl('linkInput_{{ $item['id'] }}', this)" class="clean-copy-btn">
                                    Copy
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </main>
    </div>
</div>

<style>
    .clean-link-input {
        flex: 1;
        background: #eef2f6;
        border: 1.5px solid transparent;
        border-radius: 12px;
        padding: 0.85rem 1.15rem;
        font-size: 0.92rem;
        font-weight: 600;
        color: #334155;
        box-sizing: border-box;
        outline: none;
        transition: all 0.2s ease;
    }
    .clean-link-input:focus {
        background: #ffffff;
        border-color: #05B396;
    }
    .clean-copy-btn {
        background: #181832;
        color: #ffffff;
        font-size: 0.88rem;
        font-weight: 700;
        padding: 0.8rem 1.8rem;
        border-radius: 24px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .clean-copy-btn:hover {
        background: #05B396;
    }
    .clean-copy-btn.copied {
        background: #05B396 !important;
        color: #ffffff !important;
    }
</style>

@push('scripts')
<script>
    function copyReferralUrl(inputId, btn) {
        const input = document.getElementById(inputId);
        if (!input) return;
        input.select();
        navigator.clipboard.writeText(input.value).then(() => {
            const originalText = btn.innerText;
            btn.innerText = 'Copied!';
            btn.classList.add('copied');
            setTimeout(() => {
                btn.innerText = originalText;
                btn.classList.remove('copied');
            }, 2000);
        });
    }
</script>
@endpush

@include('portal.styles')
@endsection
