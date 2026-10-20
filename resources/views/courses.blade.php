@extends('layouts.app')

@section('title', 'All Courses & High-Yield Skills — Skillleaner')

@section('content')
<!-- Courses Hero Section -->
<section style="background: linear-gradient(180deg, rgba(5, 179, 150, 0.12) 0%, rgba(7, 10, 18, 0) 100%); padding: 4.5rem 2rem 3rem; text-align: center;">
    <div class="container" style="max-width: 950px; padding: 0; margin: 0 auto;">
        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(5, 179, 150, 0.12); border: 1px solid rgba(5, 179, 150, 0.35); color: #05B396; padding: 6px 18px; border-radius: 50px; font-size: 0.82rem; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1.4rem;">
            <span>🎓 2026 High-Income Skill Masterclasses</span>
        </div>
        <h1 style="font-size: 3.2rem; font-weight: 800; line-height: 1.2; letter-spacing: -1px; margin-bottom: 1.2rem;">
            Explore Courses with <br><span class="text-gradient">Detailed Descriptions & Syllabuses</span>
        </h1>
        <p style="color: var(--text-body); font-size: 1.15rem; max-width: 700px; margin: 0 auto 2.2rem; line-height: 1.6;">
            Learn practical, high-income skills directly from industry experts. Every course includes step-by-step video training, downloadable blueprints, and lifetime mentor support.
        </p>

        <!-- Category Filters -->
        <div style="display: flex; gap: 0.75rem; justify-content: center; flex-wrap: wrap; margin-top: 1rem;">
            <button onclick="filterCourses('all')" class="cat-pill active" id="pill-all">All Courses ({{ count($courses) }})</button>
            <button onclick="filterCourses('Affiliate Business')" class="cat-pill" id="pill-Affiliate-Business">Affiliate Business</button>
            <button onclick="filterCourses('Artificial Intelligence')" class="cat-pill" id="pill-Artificial-Intelligence">AI & Automation</button>
            <button onclick="filterCourses('Video & Media')" class="cat-pill" id="pill-Video--Media">Video Editing</button>
            <button onclick="filterCourses('Performance Marketing')" class="cat-pill" id="pill-Performance-Marketing">Meta Ads</button>
            <button onclick="filterCourses('Web Design')" class="cat-pill" id="pill-Web-Design">Web Design</button>
            <button onclick="filterCourses('Social Media')" class="cat-pill" id="pill-Social-Media">Personal Branding</button>
        </div>
    </div>
</section>

<!-- Courses Grid Section -->
<section class="container" style="padding-top: 2rem; padding-bottom: 4rem;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 2.2rem;" id="coursesGrid">
        @foreach ($courses as $c)
            <div class="glass course-card" data-category="{{ $c['cat'] }}" style="border-radius: var(--radius-lg); overflow: hidden; display: flex; flex-direction: column; position: relative; transition: transform 0.3s ease, border-color 0.3s ease; border: 1px solid var(--border-glass);">
                
                <!-- Card Header Visual -->
                <div style="height: 190px; background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; border-bottom: 1px solid var(--border-glass);">
                    <div style="font-size: 4.8rem; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.4)); transition: transform 0.3s ease;">
                        {{ $c['icon'] }}
                    </div>
                    
                    @if (!empty($c['badge']))
                        <span style="position: absolute; top: 14px; left: 16px; background: linear-gradient(135deg, #05B396, #0284c7); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.5px;">
                            {{ $c['badge'] }}
                        </span>
                    @endif

                    <span style="position: absolute; bottom: 12px; right: 14px; background: rgba(0, 0, 0, 0.75); backdrop-filter: blur(8px); padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 700; color: #fff; display: flex; align-items: center; gap: 6px;">
                        <span>⏱</span> {{ $c['duration'] }} • {{ $c['lessons'] }} Lessons
                    </span>
                </div>

                <!-- Card Body -->
                <div style="padding: 1.8rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.6rem;">
                            <span style="font-size: 0.75rem; color: #05B396; font-weight: 800; text-transform: uppercase; letter-spacing: 0.8px;">
                                {{ $c['cat'] }}
                            </span>
                            <span style="font-size: 0.82rem; color: #fbbf24; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                                ★ 4.9 <span style="color: var(--text-body); font-weight: 400;">(1.4k)</span>
                            </span>
                        </div>

                        <h3 style="font-size: 1.32rem; font-weight: 800; line-height: 1.35; margin-bottom: 0.8rem; color: #f8fafc;">
                            {{ $c['title'] }}
                        </h3>

                        <p style="color: var(--text-body); font-size: 0.92rem; line-height: 1.55; margin-bottom: 1.2rem;">
                            {{ $c['tagline'] }}
                        </p>

                        <!-- Key Outcomes / Inclusions Preview -->
                        <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-glass); border-radius: 8px; padding: 0.9rem; margin-bottom: 1.4rem;">
                            <div style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #94a3b8; letter-spacing: 0.5px; margin-bottom: 0.5rem;">What's Covered:</div>
                            <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 6px;">
                                @foreach(array_slice($c['what_you_learn'], 0, 2) as $outcome)
                                    <li style="font-size: 0.85rem; color: #cbd5e1; display: flex; align-items: flex-start; gap: 8px;">
                                        <span style="color: #05B396; font-weight: bold;">✓</span>
                                        <span>{{ $outcome }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Price & Action Buttons -->
                    <div style="border-top: 1px solid var(--border-glass); padding-top: 1.2rem;">
                        <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 1rem;">
                            <div>
                                <span style="font-size: 1.45rem; font-weight: 800; color: #ffffff;">₹{{ number_format($c['price']) }}</span>
                                <span style="font-size: 0.9rem; text-decoration: line-through; color: #64748b; margin-left: 6px;">₹{{ number_format($c['old_price']) }}</span>
                            </div>
                            <span style="background: rgba(5, 179, 150, 0.15); color: #05B396; padding: 3px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 800;">
                                INCLUDED IN {{ strtoupper(str_replace(' Package', '', $c['package'])) }}
                            </span>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                            <a href="{{ url('/courses/' . $c['slug']) }}" class="btn btn-secondary" style="padding: 0.7rem 0.5rem; font-size: 0.88rem; font-weight: 700; text-align: center;">
                                Description & Syllabus
                            </a>
                            <a href="{{ url('/buy-now?course=' . $c['slug']) }}" class="btn btn-primary" style="background: #05B396; padding: 0.7rem 0.5rem; font-size: 0.88rem; font-weight: 800; text-align: center; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.35);">
                                Buy Now ➔
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        @endforeach
    </div>

    <!-- Package Bundle Callout Banner -->
    <div class="glass" style="margin-top: 4rem; padding: 3rem 2.5rem; border-radius: var(--radius-lg); text-align: center; border: 2px solid rgba(5, 179, 150, 0.35); background: linear-gradient(180deg, rgba(5, 179, 150, 0.12) 0%, rgba(15, 23, 42, 0.85) 100%);">
        <h3 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.8rem;">Want Access to All Courses at Once?</h3>
        <p style="color: var(--text-body); max-width: 650px; margin: 0 auto 1.8rem; font-size: 1.05rem;">
            Save up to 85% by getting full bundle packages! Unlock all video lessons, lifetime updates, and start earning up to 70% direct affiliate commission.
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ url('/plans') }}" class="btn btn-primary" style="background: #05B396; padding: 0.85rem 2rem; font-size: 1.05rem; font-weight: 800;">
                View All Package Bundles ➔
            </a>
            <a href="{{ url('/buy-now?package=advance') }}" class="btn btn-secondary" style="padding: 0.85rem 2rem; font-size: 1.05rem; font-weight: 700;">
                Buy Advance Package (Most Popular) 💳
            </a>
        </div>
    </div>
</section>

@push('styles')
<style>
    .cat-pill {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-glass);
        color: var(--text-body);
        padding: 8px 18px;
        border-radius: 30px;
        font-size: 0.88rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .cat-pill:hover, .cat-pill.active {
        background: #05B396;
        color: #ffffff;
        border-color: #05B396;
        box-shadow: 0 4px 15px rgba(5, 179, 150, 0.3);
    }
    .course-card:hover {
        transform: translateY(-6px);
        border-color: rgba(5, 179, 150, 0.45);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.45);
    }
</style>
@endpush

@push('scripts')
<script>
    function filterCourses(cat) {
        document.querySelectorAll('.cat-pill').forEach(btn => btn.classList.remove('active'));
        const activeBtn = document.getElementById('pill-' + cat.replace(/\s+/g, '-').replace('&', ''));
        if (activeBtn) activeBtn.classList.add('active');

        const cards = document.querySelectorAll('.course-card');
        cards.forEach(card => {
            if (cat === 'all' || card.getAttribute('data-category') === cat) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
@endpush
@endsection
