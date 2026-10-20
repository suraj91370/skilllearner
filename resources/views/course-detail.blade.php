@extends('layouts.app')

@section('title', $course['title'] . ' — Course Description & Syllabus')

@section('content')
<!-- Breadcrumbs & Course Header -->
<section style="background: linear-gradient(180deg, rgba(5, 179, 150, 0.14) 0%, rgba(7, 10, 18, 0) 100%); padding: 3.5rem 2rem 2rem;">
    <div class="container" style="padding-top: 0; padding-bottom: 0;">
        
        <!-- Breadcrumb -->
        <div style="font-size: 0.88rem; color: #94a3b8; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px;">
            <a href="{{ url('/') }}" style="color: #94a3b8; text-decoration: none;">Home</a>
            <span>›</span>
            <a href="{{ url('/courses') }}" style="color: #94a3b8; text-decoration: none;">Courses</a>
            <span>›</span>
            <span style="color: #05B396; font-weight: 700;">{{ $course['title'] }}</span>
        </div>

        <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 1rem; flex-wrap: wrap;">
            <span style="background: rgba(5, 179, 150, 0.15); border: 1px solid rgba(5, 179, 150, 0.4); color: #05B396; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase;">
                {{ $course['cat'] }}
            </span>
            @if(!empty($course['badge']))
                <span style="background: linear-gradient(135deg, #05B396, #0284c7); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">
                    {{ $course['badge'] }}
                </span>
            @endif
            <span style="color: #fbbf24; font-size: 0.9rem; font-weight: 700;">
                ★ 4.9 <span style="color: #94a3b8; font-weight: 400;">(1,480+ Reviews)</span>
            </span>
            <span style="color: #94a3b8; font-size: 0.88rem;">• 8,920+ Students Enrolled</span>
        </div>

        <h1 style="font-size: 2.8rem; font-weight: 800; line-height: 1.25; margin-bottom: 1rem; color: #ffffff;">
            {{ $course['title'] }}
        </h1>

        <p style="color: var(--text-body); font-size: 1.2rem; max-width: 820px; line-height: 1.6; margin-bottom: 1.8rem;">
            {{ $course['tagline'] }}
        </p>

        <div style="display: flex; align-items: center; gap: 12px; font-size: 0.92rem; color: #cbd5e1;">
            <span style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; background: #05B396; color: #fff; font-weight: 800;">👨‍🏫</span>
            <span>Course Creator: <strong style="color: #fff;">{{ $course['instructor'] }}</strong></span>
        </div>

    </div>
</section>

<!-- Course Details & Sticky Buy Card -->
<section class="container" style="padding-top: 2rem; padding-bottom: 5rem;">
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2.5rem; align-items: start;">
        
        <!-- Left: Course Description, Syllabus, Outcomes -->
        <div>
            
            <!-- 1. Detailed Description -->
            <div class="glass" style="padding: 2.2rem; border-radius: var(--radius-lg); margin-bottom: 2rem;">
                <h2 style="font-size: 1.6rem; font-weight: 800; margin-bottom: 1rem; display: flex; align-items: center; gap: 10px;">
                    <span>📖</span> Course Description & Overview
                </h2>
                <div style="color: #cbd5e1; font-size: 1.02rem; line-height: 1.75; display: flex; flex-direction: column; gap: 1rem;">
                    <p>{{ $course['desc'] }}</p>
                    <p>Designed specifically for 2026, this course cuts through theoretical fluff to give you immediately actionable workflows. Whether you want to earn full-time freelance income, build a digital business, or create an additional stream of passive income, each lesson provides real case studies, exact scripts, and copy-paste templates.</p>
                </div>
            </div>

            <!-- 2. What You Will Learn -->
            <div class="glass" style="padding: 2.2rem; border-radius: var(--radius-lg); margin-bottom: 2rem;">
                <h2 style="font-size: 1.6rem; font-weight: 800; margin-bottom: 1.2rem; display: flex; align-items: center; gap: 10px;">
                    <span>🎯</span> What You Will Master
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
                    @foreach($course['what_you_learn'] as $item)
                        <div style="display: flex; align-items: flex-start; gap: 10px; background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-glass); border-radius: 8px; padding: 0.9rem;">
                            <span style="color: #05B396; font-size: 1.1rem; font-weight: bold; flex-shrink: 0;">✓</span>
                            <span style="color: #f1f5f9; font-size: 0.95rem; line-height: 1.5;">{{ $item }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 3. Course Curriculum & Modules -->
            <div class="glass" style="padding: 2.2rem; border-radius: var(--radius-lg); margin-bottom: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.4rem; flex-wrap: wrap; gap: 0.8rem;">
                    <h2 style="font-size: 1.6rem; font-weight: 800; display: flex; align-items: center; gap: 10px; margin: 0;">
                        <span>📚</span> Detailed Course Curriculum
                    </h2>
                    <span style="color: #05B396; font-size: 0.9rem; font-weight: 700;">
                        {{ count($course['modules']) }} Modules • {{ $course['lessons'] }} Lessons • {{ $course['duration'] }} Total
                    </span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($course['modules'] as $idx => $mod)
                        <div style="border: 1px solid var(--border-glass); border-radius: 10px; overflow: hidden; background: rgba(15, 23, 42, 0.6);">
                            <div style="padding: 1.1rem 1.4rem; background: rgba(255, 255, 255, 0.04); display: flex; justify-content: space-between; align-items: center; font-weight: 700; color: #f8fafc; font-size: 1.05rem;">
                                <span>{{ $mod['title'] }}</span>
                                <span style="font-size: 0.82rem; color: #94a3b8; font-weight: 600;">{{ count($mod['lessons']) }} Lessons</span>
                            </div>
                            <div style="padding: 0.8rem 1.4rem;">
                                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px;">
                                    @foreach($mod['lessons'] as $lIdx => $lesson)
                                        <li style="padding: 0.5rem 0; border-bottom: 1px solid rgba(255, 255, 255, 0.03); color: #cbd5e1; font-size: 0.92rem; display: flex; justify-content: space-between; align-items: center;">
                                            <span style="display: flex; align-items: center; gap: 10px;">
                                                <span style="color: #05B396;">▶</span>
                                                <span>{{ $lesson }}</span>
                                            </span>
                                            <span style="font-size: 0.78rem; color: #64748b; background: rgba(255,255,255,0.05); padding: 2px 8px; border-radius: 4px;">Video + Resources</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 4. Prerequisites & Who It Is For -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                <div class="glass" style="padding: 1.8rem; border-radius: var(--radius-lg);">
                    <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 0.8rem; color: #fff;">
                        📋 Course Requirements
                    </h3>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px;">
                        @foreach($course['requirements'] as $req)
                            <li style="font-size: 0.9rem; color: #cbd5e1; display: flex; align-items: flex-start; gap: 8px;">
                                <span style="color: #05B396;">•</span> {{ $req }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="glass" style="padding: 1.8rem; border-radius: var(--radius-lg);">
                    <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 0.8rem; color: #fff;">
                        🏆 Digital Certification
                    </h3>
                    <p style="font-size: 0.9rem; color: #cbd5e1; line-height: 1.5; margin-bottom: 0.8rem;">
                        Upon completing all video modules and quizzes, you will receive an official, verifiable digital certificate of completion with your unique student ID.
                    </p>
                    <span style="display: inline-block; background: rgba(5, 179, 150, 0.15); color: #05B396; font-weight: 700; font-size: 0.82rem; padding: 4px 10px; border-radius: 4px;">
                        ISO & Skillleaner Certified
                    </span>
                </div>
            </div>

        </div>

        <!-- Right: Sticky Buy Now Card -->
        <div style="position: sticky; top: 100px;">
            <div class="glass" style="padding: 2.2rem; border-radius: var(--radius-lg); border: 2px solid #05B396; box-shadow: 0 15px 45px rgba(5, 179, 150, 0.15);">
                
                <!-- Visual Icon Header -->
                <div style="height: 150px; background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 4.5rem; margin-bottom: 1.5rem; border: 1px solid var(--border-glass);">
                    {{ $course['icon'] }}
                </div>

                <!-- Price Box -->
                <div style="margin-bottom: 1.4rem;">
                    <div style="display: flex; align-items: baseline; gap: 10px;">
                        <span style="font-size: 2.4rem; font-weight: 800; color: #ffffff;">₹{{ number_format($course['price']) }}</span>
                        <span style="font-size: 1.15rem; text-decoration: line-through; color: #64748b;">₹{{ number_format($course['old_price']) }}</span>
                        <span style="background: rgba(239, 68, 68, 0.18); color: #ef4444; font-size: 0.8rem; font-weight: 800; padding: 3px 8px; border-radius: 4px;">
                            SAVE 62%
                        </span>
                    </div>
                    <p style="font-size: 0.82rem; color: #05B396; font-weight: 700; margin-top: 4px;">
                        ⚡ Limited Offer: Lifetime Access + Updates Included
                    </p>
                </div>

                <!-- Buy Now Primary Button -->
                <a href="{{ url('/buy-now?course=' . $course['slug']) }}" class="btn btn-primary" style="width: 100%; padding: 1rem 1.4rem; font-size: 1.12rem; font-weight: 800; background: #05B396; border-radius: 10px; margin-bottom: 1.2rem; text-align: center; box-shadow: 0 6px 20px rgba(5, 179, 150, 0.4);">
                    Buy Now ➔
                </a>

                <!-- Package Bundle Upsell -->
                <div style="background: rgba(255, 255, 255, 0.04); border: 1px dashed rgba(5, 179, 150, 0.45); border-radius: 10px; padding: 1rem; margin-bottom: 1.5rem; text-align: center;">
                    <div style="font-size: 0.78rem; font-weight: 800; text-transform: uppercase; color: #05B396; margin-bottom: 4px;">💡 Better Value Bundle</div>
                    <p style="font-size: 0.85rem; color: #e2e8f0; margin-bottom: 8px;">
                        This course is included in the <strong>{{ $course['package'] }}</strong> with multiple other masterclasses!
                    </p>
                    <a href="{{ url('/buy-now?package=' . strtolower(str_replace(' Package', '', $course['package']))) }}" style="color: #05B396; font-weight: 800; font-size: 0.88rem; text-decoration: underline;">
                        Upgrade to {{ $course['package'] }} Bundle ➔
                    </a>
                </div>

                <!-- Course Inclusions List -->
                <div style="border-top: 1px solid var(--border-glass); padding-top: 1.2rem;">
                    <h4 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 0.8rem; color: #f8fafc;">This Course Includes:</h4>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 9px; font-size: 0.88rem; color: #cbd5e1;">
                        <li style="display: flex; align-items: center; gap: 8px;">
                            <span style="color: #05B396;">✓</span> {{ $course['lessons'] }} High-Def Video Lessons
                        </li>
                        <li style="display: flex; align-items: center; gap: 8px;">
                            <span style="color: #05B396;">✓</span> {{ $course['duration'] }} Total Video Runtime
                        </li>
                        <li style="display: flex; align-items: center; gap: 8px;">
                            <span style="color: #05B396;">✓</span> Action Checklists & PDF Templates
                        </li>
                        <li style="display: flex; align-items: center; gap: 8px;">
                            <span style="color: #05B396;">✓</span> Verified Certificate of Completion
                        </li>
                        <li style="display: flex; align-items: center; gap: 8px;">
                            <span style="color: #05B396;">✓</span> Access on Mobile, Tablet & PC
                        </li>
                        <li style="display: flex; align-items: center; gap: 8px;">
                            <span style="color: #05B396;">✓</span> 100% Secure Checkout Guarantee
                        </li>
                    </ul>
                </div>

            </div>
        </div>

    </div>
</section>

@push('styles')
<style>
    @media (max-width: 900px) {
        section .container > div[style*="grid-template-columns: 2fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush
@endsection
