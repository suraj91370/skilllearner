@extends('layouts.app')

@section('title', 'Packages & Courses — SkillLearner')

@section('content')
<!-- Courses Hero Section -->
<section style="background: linear-gradient(180deg, rgba(5, 179, 150, 0.12) 0%, rgba(7, 10, 18, 0) 100%); padding: 4.5rem 1.5rem 3rem; text-align: center;">
    <div class="container" style="max-width: 950px; padding: 0; margin: 0 auto;">
        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(5, 179, 150, 0.12); border: 1px solid rgba(5, 179, 150, 0.35); color: #05B396; padding: 6px 18px; border-radius: 50px; font-size: 0.82rem; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1.4rem;">
            <span>🎓 High-Income Skill Packages</span>
        </div>
        <h1 style="font-size: clamp(2.2rem, 5vw, 3.4rem); font-weight: 800; line-height: 1.2; letter-spacing: -1px; margin-bottom: 1.2rem;">
            Explore Our <span class="text-gradient">Packages</span>
        </h1>
        <p style="font-size: 1.12rem; max-width: 780px; margin: 0 auto; line-height: 1.6; color: var(--text-body);">
            Unlock your potential with SkillLearner. Explore industry-relevant courses, gain practical knowledge, and develop the skills you need to grow professionally and succeed in the digital world.
        </p>
    </div>
</section>

<!-- Packages Grid Section -->
<section class="container" style="padding-top: 1rem; padding-bottom: 5rem;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2.2rem;" id="packagesGrid">
        @php
            $packageMeta = [
                'basic' => [
                    'num' => 1,
                    'heading' => 'BASIC PACKAGE COURSES',
                    'access_badge' => 'Get Access of 3+ Courses',
                    'prev_access' => null,
                ],
                'growth' => [
                    'num' => 2,
                    'heading' => 'GROWTH PACKAGE COURSES',
                    'access_badge' => 'Get Access of 6+ Courses',
                    'prev_access' => '+ Full Access of Basic Package (All 3 Courses)',
                ],
                'advance' => [
                    'num' => 3,
                    'heading' => 'ADVANCE PACKAGE COURSES',
                    'access_badge' => 'Get Access of 9+ Courses',
                    'prev_access' => '+ Full Access of Basic & Growth Packages (All 6 Courses)',
                ],
                'premium' => [
                    'num' => 4,
                    'heading' => 'PREMIUM PACKAGE COURSES',
                    'access_badge' => 'Get Access of 12+ Courses',
                    'prev_access' => '+ Full Access of Basic, Growth & Advance Packages (All 9 Courses)',
                ],
                'infinity' => [
                    'num' => 5,
                    'heading' => 'INFINITY PACKAGE COURSES',
                    'access_badge' => 'Get Access of 15+ Courses (All Access)',
                    'prev_access' => '+ Full Access of All Previous Packages (Lifetime All-Access Pass)',
                ],
            ];
        @endphp

        @foreach ($packages as $pkg)
            @php
                $meta = $packageMeta[$pkg['id']] ?? [
                    'num' => $loop->iteration,
                    'heading' => strtoupper($pkg['name']) . ' COURSES',
                    'access_badge' => 'Get Access of 3+ Courses',
                    'prev_access' => null,
                ];
            @endphp
            <div id="{{ $pkg['id'] }}" class="package-course-card" style="border-radius: var(--radius-lg); overflow: hidden; display: flex; flex-direction: column; position: relative; transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease; border: 1.5px solid {{ $pkg['border_color'] ?? 'rgba(255,255,255,0.08)' }}; background: {{ $pkg['bg_gradient'] ?? 'var(--bg-card)' }}; padding: 2.2rem 1.8rem;">
                
                <!-- Package 3D Box Image Container -->
                <div style="text-align: center; margin: 0.5rem 0 1.5rem; display: flex; justify-content: center; align-items: center; min-height: 240px; background: radial-gradient(circle, {{ ($pkg['color'] ?? '#05B396') . '26' }} 0%, transparent 70%); border-radius: 16px; position: relative;">
                    <img src="{{ asset($pkg['image']) }}" alt="{{ $pkg['name'] }}" style="max-height: 230px; width: auto; max-width: 90%; object-fit: contain; filter: drop-shadow(0 14px 28px rgba(0, 0, 0, 0.6)); transition: transform 0.3s ease;">
                </div>

                <!-- Package Number & Name -->
                <h3 style="font-size: 1.65rem; font-weight: 800; text-align: center; margin-bottom: 0.5rem; color: #ffffff; letter-spacing: -0.5px;">
                    {{ $meta['num'] }}. {{ $pkg['name'] }}
                </h3>

                <!-- Price Box -->
                <div style="text-align: center; margin-bottom: 1.1rem;">
                    <div style="display: inline-flex; align-items: baseline; gap: 8px;">
                        <span style="font-size: 2rem; font-weight: 900; color: #ffffff;">₹{{ number_format($pkg['price']) }}</span>
                        @if(!empty($pkg['old_price']))
                            <span style="font-size: 1.05rem; text-decoration: line-through; color: #64748b; font-weight: 600;">₹{{ number_format($pkg['old_price']) }}</span>
                        @endif
                    </div>
                </div>

                <!-- Access Highlight Badge (e.g. Get Access of 3+ Courses) -->
                <div style="background: rgba(255, 255, 255, 0.05); border: 1.5px solid {{ $pkg['color'] ?? '#05B396' }}; color: #ffffff; padding: 0.75rem 1rem; border-radius: 10px; text-align: center; margin-bottom: 1.6rem; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <span style="font-size: 1.15rem;">🎯</span>
                    <span style="font-size: 1.05rem; font-weight: 900; letter-spacing: 0.3px; color: {{ $pkg['color'] ?? '#05B396' }};">
                        {{ $meta['access_badge'] }}
                    </span>
                </div>

                <!-- Courses Included Section -->
                <div style="background: rgba(0, 0, 0, 0.28); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; padding: 1.3rem; margin-bottom: 1.8rem; flex-grow: 1;">
                    <div style="font-size: 0.78rem; font-weight: 800; text-transform: uppercase; color: {{ $pkg['color'] ?? '#05B396' }}; letter-spacing: 0.8px; margin-bottom: 0.9rem; display: flex; align-items: center; gap: 6px;">
                        <span>📚</span>
                        <span>{{ $meta['heading'] }}</span>
                    </div>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px;">
                        @foreach ($pkg['courses_included'] as $course)
                            <li style="font-size: 0.94rem; color: #e2e8f0; display: flex; align-items: center; gap: 10px; line-height: 1.4;">
                                <span style="color: {{ $pkg['color'] ?? '#05B396' }}; font-weight: 900; font-size: 1.15rem; line-height: 1;">•</span>
                                <span>{{ $course }}</span>
                            </li>
                        @endforeach
                    </ul>

                    @if(!empty($meta['prev_access']))
                        <div style="margin-top: 1.1rem; padding: 0.75rem 0.9rem; background: rgba(255, 255, 255, 0.04); border: 1px dashed {{ $pkg['color'] ?? '#05B396' }}; border-radius: 8px; font-size: 0.85rem; color: #f1f5f9; display: flex; align-items: center; gap: 8px; line-height: 1.4;">
                            <span style="font-size: 1.15rem; flex-shrink: 0;">🎁</span>
                            <span style="font-weight: 700;">{{ $meta['prev_access'] }}</span>
                        </div>
                    @endif
                </div>

                <!-- Action Button -->
                <div style="margin-top: auto;">
                    <a href="{{ url('/buy-now?package=' . $pkg['id']) }}" class="btn btn-primary" style="background: {{ $pkg['color'] ?? '#05B396' }}; text-align: center; width: 100%; padding: 0.95rem; font-size: 1.05rem; font-weight: 800; border-radius: 12px; box-shadow: 0 4px 18px {{ ($pkg['color'] ?? '#05B396') . '45' }}; display: block; text-decoration: none;">
                        Buy Now ➔
                    </a>
                </div>

            </div>
        @endforeach
    </div>
</section>

@push('styles')
<style>
    .package-course-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.55);
    }
    .package-course-card:hover img {
        transform: scale(1.04);
    }
    @media (max-width: 768px) {
        #packagesGrid {
            grid-template-columns: 1fr !important;
            gap: 1.8rem !important;
        }
        .package-course-card {
            padding: 1.8rem 1.4rem !important;
        }
    }
</style>
@endpush
@endsection
