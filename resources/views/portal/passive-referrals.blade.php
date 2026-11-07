@extends('layouts.app')

@section('title', 'Passive Referrals — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'passive-referrals'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'passive-referrals'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            
            <!-- Page Title & Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 style="font-size: 1.75rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.3px;">
                        Passive Referrals (Tier-2)
                    </h2>
                    <p style="margin: 4px 0 0; color: #64748b; font-size: 0.95rem;">
                        Aapke direct referral members ne aage jinhe refer kiya hai, unki details aur unse aane wali passive earnings yahan dikhti hain.
                    </p>
                </div>

                <div style="display: flex; align-items: center; gap: 10px; background: #ffffff; padding: 6px 14px; border-radius: 12px; border: 1.5px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
                    <span style="font-size: 0.85rem; color: #64748b; font-weight: 600;">Your Code:</span>
                    <strong style="color: #05B396; font-size: 1rem; letter-spacing: 0.5px;">{{ $affiliateId }}</strong>
                </div>
            </div>

            <!-- Top Metric Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 1.15rem; margin-bottom: 1.6rem;">
                <!-- Card 1: Total Passive Members -->
                <div style="background: #ffffff; border-radius: 14px; padding: 1.3rem 1.4rem; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                            Passive Members (Tier-2)
                        </div>
                        <div style="font-size: 1.9rem; font-weight: 800; color: #0f172a; line-height: 1;">
                            {{ $totalCount }}
                        </div>
                    </div>
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(236, 72, 153, 0.12); display: flex; align-items: center; justify-content: center; color: #db2777;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                        </svg>
                    </div>
                </div>

                <!-- Card 2: Total Passive Commissions -->
                <div style="background: #ffffff; border-radius: 14px; padding: 1.3rem 1.4rem; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                            Total Passive Earning
                        </div>
                        <div style="font-size: 1.9rem; font-weight: 800; color: #db2777; line-height: 1;">
                            ₹{{ number_format($totalPassiveCommissions) }}
                        </div>
                    </div>
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(219, 39, 119, 0.12); display: flex; align-items: center; justify-content: center; color: #db2777;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                </div>

                <!-- Card 3: Model Explanation -->
                <div style="background: #ffffff; border-radius: 14px; padding: 1.3rem 1.4rem; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                            Commission Source
                        </div>
                        <div style="font-size: 1.35rem; font-weight: 800; color: #00137a; line-height: 1.2;">
                            Level-2 Indirect
                        </div>
                    </div>
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(0, 19, 122, 0.08); display: flex; align-items: center; justify-content: center; color: #00137a;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="18" cy="5" r="3"></circle>
                            <circle cx="6" cy="12" r="3"></circle>
                            <circle cx="18" cy="19" r="3"></circle>
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; box-shadow: 0 1px 4px rgba(0,0,0,0.02); overflow: hidden;">
                
                <!-- Table Search & Filters -->
                <div style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; background: #fafbfc;">
                    <form method="GET" action="{{ url('/passive-referrals') }}" style="display: flex; align-items: center; gap: 8px; flex: 1; max-width: 380px;">
                        <div style="position: relative; width: 100%;">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ $search }}" 
                                placeholder="Search by member or sponsor..." 
                                style="width: 100%; padding: 8px 12px 8px 34px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;"
                            >
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%);">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                        <button type="submit" style="background: #db2777; color: #ffffff; border: none; padding: 8px 14px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer;">
                            Filter
                        </button>
                        @if(!empty($search))
                            <a href="{{ url('/passive-referrals') }}" style="color: #64748b; font-size: 0.85rem; text-decoration: none; padding: 8px;">Clear</a>
                        @endif
                    </form>

                    <div style="font-size: 0.88rem; color: #64748b; font-weight: 600;">
                        Showing {{ count($referrals) }} Passive Team Referrals
                    </div>
                </div>

                <!-- Table Content -->
                <div class="table-responsive-wrapper" style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.92rem;">
                        <thead>
                            <tr style="border-bottom: 1px solid #e2e8f0; background: #ffffff;">
                                <th style="padding: 14px 20px; font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.4px;">PASSIVE MEMBER</th>
                                <th style="padding: 14px 20px; font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.4px;">REFERRED BY (DIRECT SPONSOR)</th>
                                <th style="padding: 14px 20px; font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.4px;">MEMBER ID</th>
                                <th style="padding: 14px 20px; font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.4px;">PACKAGE</th>
                                <th style="padding: 14px 20px; font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.4px;">PASSIVE INCOME</th>
                                <th style="padding: 14px 20px; font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.4px;">JOINED DATE</th>
                                <th style="padding: 14px 20px; font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.4px;">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($referrals as $ref)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#fbfcfd'" onmouseout="this.style.background='#ffffff'">
                                    
                                    <!-- Passive Member Info -->
                                    <td style="padding: 14px 20px;">
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #ec4899, #db2777); color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; flex-shrink: 0;">
                                                {{ strtoupper(substr($ref['name'], 0, 1)) }}
                                            </div>
                                            <div>
                                                <div style="font-weight: 700; color: #0f172a; font-size: 0.94rem;">
                                                    {{ $ref['name'] }}
                                                </div>
                                                <div style="font-size: 0.8rem; color: #64748b;">
                                                    Tier-2 Team Student
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Referred By (Direct Sponsor) -->
                                    <td style="padding: 14px 20px;">
                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#05B396" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                                            <span style="font-weight: 700; color: #00137a; font-size: 0.9rem;">
                                                {{ $ref['referred_by'] }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Member Affiliate Code -->
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

                                    <!-- Passive Income -->
                                    <td style="padding: 14px 20px;">
                                        <strong style="color: #db2777; font-size: 1rem; font-weight: 800;">
                                            +₹{{ number_format($ref['passive_income']) }}
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
                                    <td colspan="7" style="text-align: center; padding: 3.5rem 1rem; color: #64748b;">
                                        <div style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 6px;">
                                            Abhi koi Passive Referral nahi mila
                                        </div>
                                        <p style="margin: 0; font-size: 0.9rem;">
                                            Jab aapke direct team members aage kisi ko refer karenge, unki sales automatically yahan show hongi aur aapko passive commission milega!
                                        </p>
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
@endsection

