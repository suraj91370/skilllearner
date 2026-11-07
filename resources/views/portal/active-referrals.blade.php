@extends('layouts.app')

@section('title', 'Active Referrals — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'active-referrals'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'active-referrals'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            
            <!-- Page Title & Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 style="font-size: 1.75rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.3px;">
                        Active Referrals (Tier-1)
                    </h2>
                    <p style="margin: 4px 0 0; color: #64748b; font-size: 0.95rem;">
                        Aapke direct referral code se join hue sabhi students aur unse hui active earnings yahan display hoti hain.
                    </p>
                </div>

                <div style="display: flex; align-items: center; gap: 10px; background: #ffffff; padding: 6px 14px; border-radius: 12px; border: 1.5px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
                    <span style="font-size: 0.85rem; color: #64748b; font-weight: 600;">Your Code:</span>
                    <strong style="color: #05B396; font-size: 1rem; letter-spacing: 0.5px;">{{ $affiliateId }}</strong>
                    <button type="button" onclick="copyReferralCode('{{ $affiliateId }}', this)" style="background: #00137a; color: #ffffff; border: none; padding: 5px 12px; border-radius: 6px; font-size: 0.78rem; font-weight: 700; cursor: pointer; transition: all 0.2s;">
                        Copy Link
                    </button>
                </div>
            </div>

            <!-- Top Metric Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 1.15rem; margin-bottom: 1.6rem;">
                <!-- Card 1: Total Direct Referrals -->
                <div style="background: #ffffff; border-radius: 14px; padding: 1.3rem 1.4rem; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                            Active Members
                        </div>
                        <div style="font-size: 1.9rem; font-weight: 800; color: #0f172a; line-height: 1;">
                            {{ $totalCount }}
                        </div>
                    </div>
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(5, 179, 150, 0.12); display: flex; align-items: center; justify-content: center; color: #05B396;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                </div>

                <!-- Card 2: Active Commissions -->
                <div style="background: #ffffff; border-radius: 14px; padding: 1.3rem 1.4rem; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                            Direct Active Earning
                        </div>
                        <div style="font-size: 1.9rem; font-weight: 800; color: #05B396; line-height: 1;">
                            ₹{{ number_format($totalActiveCommissions) }}
                        </div>
                    </div>
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(2, 132, 199, 0.12); display: flex; align-items: center; justify-content: center; color: #0284c7;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                </div>

                <!-- Card 3: Tier Type -->
                <div style="background: #ffffff; border-radius: 14px; padding: 1.3rem 1.4rem; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                            Referral Type
                        </div>
                        <div style="font-size: 1.35rem; font-weight: 800; color: #00137a; line-height: 1.2;">
                            Level-1 Direct
                        </div>
                    </div>
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(0, 19, 122, 0.08); display: flex; align-items: center; justify-content: center; color: #00137a;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; box-shadow: 0 1px 4px rgba(0,0,0,0.02); overflow: hidden;">
                
                <!-- Table Search & Filters -->
                <div style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; background: #fafbfc;">
                    <form method="GET" action="{{ url('/active-referrals') }}" style="display: flex; align-items: center; gap: 8px; flex: 1; max-width: 380px;">
                        <div style="position: relative; width: 100%;">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ $search }}" 
                                placeholder="Search by name, email or code..." 
                                style="width: 100%; padding: 8px 12px 8px 34px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;"
                            >
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%);">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                        <button type="submit" style="background: #05B396; color: #ffffff; border: none; padding: 8px 14px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer;">
                            Filter
                        </button>
                        @if(!empty($search))
                            <a href="{{ url('/active-referrals') }}" style="color: #64748b; font-size: 0.85rem; text-decoration: none; padding: 8px;">Clear</a>
                        @endif
                    </form>

                    <div style="font-size: 0.88rem; color: #64748b; font-weight: 600;">
                        Showing {{ count($referrals) }} Direct Referrals
                    </div>
                </div>

                <!-- Table Content -->
                <div class="table-responsive-wrapper" style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.92rem;">
                        <thead>
                            <tr style="border-bottom: 1px solid #e2e8f0; background: #ffffff;">
                                <th style="padding: 14px 20px; font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.4px;">MEMBER</th>
                                <th style="padding: 14px 20px; font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.4px;">AFFILIATE ID</th>
                                <th style="padding: 14px 20px; font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.4px;">PACKAGE</th>
                                <th style="padding: 14px 20px; font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.4px;">DIRECT COMMISSION</th>
                                <th style="padding: 14px 20px; font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.4px;">JOINED DATE</th>
                                <th style="padding: 14px 20px; font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.4px;">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($referrals as $ref)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#fbfcfd'" onmouseout="this.style.background='#ffffff'">
                                    
                                    <!-- Member Info -->
                                    <td style="padding: 14px 20px;">
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #05B396, #00137a); color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; flex-shrink: 0;">
                                                {{ strtoupper(substr($ref['name'], 0, 1)) }}
                                            </div>
                                            <div>
                                                <div style="font-weight: 700; color: #0f172a; font-size: 0.94rem;">
                                                    {{ $ref['name'] }}
                                                </div>
                                                <div style="font-size: 0.8rem; color: #64748b;">
                                                    {{ $ref['email'] ?? ($ref['phone'] ?? 'Direct Referral') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Affiliate Code -->
                                    <td style="padding: 14px 20px;">
                                        <span style="font-family: monospace; font-size: 0.88rem; font-weight: 700; background: #f1f5f9; padding: 4px 10px; border-radius: 6px; color: #0f172a; border: 1px solid #e2e8f0;">
                                            {{ $ref['affiliate_id'] }}
                                        </span>
                                    </td>

                                    <!-- Package Badge -->
                                    <td style="padding: 14px 20px;">
                                        @php
                                            $pkgColor = '#05B396';
                                            $pkgBg = 'rgba(5, 179, 150, 0.1)';
                                            $pkgName = strtolower($ref['active_package']);
                                            if (str_contains($pkgName, 'infinity')) {
                                                $pkgColor = '#8b5cf6';
                                                $pkgBg = 'rgba(139, 92, 246, 0.1)';
                                            } elseif (str_contains($pkgName, 'premium')) {
                                                $pkgColor = '#3b82f6';
                                                $pkgBg = 'rgba(59, 130, 246, 0.1)';
                                            } elseif (str_contains($pkgName, 'growth')) {
                                                $pkgColor = '#f97316';
                                                $pkgBg = 'rgba(249, 115, 22, 0.1)';
                                            }
                                        @endphp
                                        <span style="background: {{ $pkgBg }}; color: {{ $pkgColor }}; font-weight: 700; font-size: 0.82rem; padding: 4px 12px; border-radius: 6px; display: inline-block;">
                                            {{ $ref['active_package'] }}
                                        </span>
                                    </td>

                                    <!-- Commission -->
                                    <td style="padding: 14px 20px;">
                                        <strong style="color: #05B396; font-size: 1rem; font-weight: 800;">
                                            +₹{{ number_format($ref['commission']) }}
                                        </strong>
                                    </td>

                                    <!-- Joined Date -->
                                    <td style="padding: 14px 20px; color: #475569; font-weight: 500;">
                                        {{ $ref['joined_date'] }}
                                    </td>

                                    <!-- Status -->
                                    <td style="padding: 14px 20px;">
                                        <span style="background: #10b981; color: #ffffff; font-weight: 700; font-size: 0.78rem; padding: 3px 12px; border-radius: 6px; display: inline-block;">
                                            {{ $ref['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 3.5rem 1rem; color: #64748b;">
                                        <div style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 6px;">
                                            Abhi koi Direct Referral nahi mila
                                        </div>
                                        <p style="margin: 0 0 1rem; font-size: 0.9rem;">
                                            Apna referral link share karein aur har successful enrollment par active income kamayein!
                                        </p>
                                        <a href="{{ url('/affiliate-link') }}" style="background: #05B396; color: #ffffff; font-weight: 700; padding: 8px 18px; border-radius: 8px; text-decoration: none; font-size: 0.88rem; display: inline-block;">
                                            Get Affiliate Link &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </main>
    </div>
</div>

@include('portal.styles')

@push('scripts')
<script>
    function copyReferralCode(code, btn) {
        const link = "{{ url('/plans') }}?ref=" + encodeURIComponent(code);
        navigator.clipboard.writeText(link).then(() => {
            const original = btn.innerText;
            btn.innerText = 'Copied!';
            btn.style.background = '#05B396';
            setTimeout(() => {
                btn.innerText = original;
                btn.style.background = '#00137a';
            }, 2000);
        });
    }
</script>
@endpush
@endsection

