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
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h3 style="font-size: 1.6rem; color: #0f172a; font-weight: 800; margin: 0; display: flex; align-items: center; gap: 10px;">
                            🌐 Official Social Communities
                        </h3>
                        <p style="color: #64748b; font-size: 0.95rem; margin: 0.35rem 0 0 0;">
                            Connect, learn, and grow with thousands of affiliates and experts across official channels.
                        </p>
                    </div>

                    @if(auth()->check() && (auth()->user()->role === 'super_admin' || auth()->user()->role === 'admin'))
                        <a href="{{ route('admin.social-communities') }}" style="display: inline-flex; align-items: center; gap: 6px; background: #f1f5f9; color: #334155; font-size: 0.85rem; font-weight: 700; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; border: 1px solid #cbd5e1; transition: background 0.15s ease;">
                            ⚙️ Manage Links in Admin
                        </a>
                    @endif
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem;">
                    @forelse($communities as $community)
                        <div style="position: relative; padding: 2rem 1.5rem; border-radius: 16px; background: {{ $community->card_bg_style }}; border: 1.5px solid {{ $community->border_style }}; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: space-between; transition: transform 0.2s, box-shadow 0.2s;" 
                             onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 28px {{ $community->hover_shadow_style }}';" 
                             onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                            
                            @if($community->badge)
                                <div style="position: absolute; top: 12px; right: 12px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; padding: 2px 8px; border-radius: 9999px; background: rgba(255, 255, 255, 0.9); color: {{ $community->title_color_style }}; border: 1px solid {{ $community->border_style }}; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
                                    {{ $community->badge }}
                                </div>
                            @endif

                            <div style="width: 58px; height: 58px; background: {{ $community->icon_bg_style }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1.1rem; box-shadow: 0 6px 16px rgba(0,0,0,0.15);">
                                {!! $community->icon_svg !!}
                            </div>

                            <div style="margin-bottom: 1.3rem;">
                                <h4 style="color: {{ $community->title_color_style }}; font-weight: 800; font-size: 1.22rem; margin: 0 0 0.4rem 0;">
                                    {{ $community->title }}
                                </h4>
                                @if($community->subtitle)
                                    <p style="color: #64748b; font-size: 0.85rem; margin: 0; line-height: 1.4;">
                                        {{ $community->subtitle }}
                                    </p>
                                @endif
                            </div>

                            <a href="{{ $community->url }}" target="_blank" rel="noopener noreferrer" 
                               style="background: {{ $community->button_bg_style }}; color: #ffffff; font-size: 0.92rem; padding: 0.75rem 1.4rem; font-weight: 800; width: 100%; text-align: center; display: block; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 14px rgba(0,0,0,0.15); transition: opacity 0.15s ease;"
                               onmouseover="this.style.opacity='0.92';"
                               onmouseout="this.style.opacity='1';">
                                {{ $community->button_text ?? 'Join Now ➔' }}
                            </a>
                        </div>
                    @empty
                        <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem; background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 16px;">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">🌐</div>
                            <h4 style="font-size: 1.2rem; font-weight: 700; color: #1e293b; margin: 0 0 0.5rem 0;">No Social Communities Added Yet</h4>
                            <p style="color: #64748b; font-size: 0.95rem; margin: 0 0 1.5rem 0;">Our official community links will be posted here soon.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>
</div>

@include('portal.styles')
@endsection
