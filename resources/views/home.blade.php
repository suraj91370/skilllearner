@extends('layouts.app')

@section('title', 'CareerFixx — Learn, Create, Monetize')

@section('content')
<!-- Hero Section -->
<section class="hero" style="text-align: center; padding: 5rem 2rem 4rem; max-width: 1150px; margin: 0 auto;">
    <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(99, 102, 241, 0.12); border: 1px solid rgba(99, 102, 241, 0.3); color: #a5b4fc; padding: 6px 18px; border-radius: 50px; font-size: 0.85rem; font-weight: 700; margin-bottom: 1.8rem;">
        <span>⭐ India's #1 Skill & Affiliate Platform</span>
    </div>
    <h1 style="font-size: 3.8rem; font-weight: 800; line-height: 1.15; letter-spacing: -1.5px; margin-bottom: 1.4rem;">
        Learn, Create, <br><span class="text-gradient">Monetize.</span>
    </h1>
    <p style="color: var(--text-body); font-size: 1.25rem; max-width: 720px; margin: 0 auto 2.5rem;">
        Master AI, Digital Marketing, Video Editing, and High-Ticket Freelancing with practical, project-based video masterclasses while building your passive income stream.
    </p>
    <div style="display: flex; gap: 1.2rem; justify-content: center; flex-wrap: wrap;">
        <a href="{{ url('/plans') }}" class="btn btn-primary" style="padding: 1rem 2.2rem; font-size: 1.1rem;">Explore Packages ➔</a>
        <a href="{{ url('/classroom') }}" class="btn btn-secondary" style="padding: 1rem 2.2rem; font-size: 1.1rem;">Preview Classroom</a>
    </div>

    <div style="display: flex; justify-content: center; gap: 3.5rem; margin-top: 4.5rem; flex-wrap: wrap;">
        <div class="stat-item">
            <h3 style="font-size: 2.2rem; font-weight: 800;">12,500+</h3>
            <p style="color: var(--text-body); font-size: 0.9rem;">Enrolled Students</p>
        </div>
        <div class="stat-item">
            <h3 style="font-size: 2.2rem; font-weight: 800;">₹45 Lakh+</h3>
            <p style="color: var(--text-body); font-size: 0.9rem;">Commissions Paid</p>
        </div>
        <div class="stat-item">
            <h3 style="font-size: 2.2rem; font-weight: 800;">4.9 / 5</h3>
            <p style="color: var(--text-body); font-size: 0.9rem;">Student Rating</p>
        </div>
        <div class="stat-item">
            <h3 style="font-size: 2.2rem; font-weight: 800;">70%</h3>
            <p style="color: var(--text-body); font-size: 0.9rem;">Direct Commission</p>
        </div>
    </div>
</section>

<!-- Packages Showcase -->
<section class="container" id="packages">
    <div style="text-align: center; margin-bottom: 3.5rem;">
        <div style="text-transform: uppercase; letter-spacing: 2.5px; color: var(--primary); font-size: 0.85rem; font-weight: 800; margin-bottom: 0.5rem;">Packages & Tiers</div>
        <h2 style="font-size: 2.4rem; font-weight: 800; letter-spacing: -0.5px;">Select Your Learning Track</h2>
        <p style="color: var(--text-body); max-width: 620px; margin: 0 auto;">Every package unlocks premium high-yield skills along with direct and passive referral commission rights.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(270px, 1fr)); gap: 2rem;">
        @foreach ($packages as $pkg)
            <div class="glass {{ $pkg['featured'] ? 'popular' : '' }}" style="padding: 2rem 1.8rem; border-radius: var(--radius-lg); display: flex; flex-direction: column; position: relative; transition: transform 0.3s ease, border-color 0.3s ease; {{ $pkg['featured'] ? 'border: 2px solid #05B396; background: linear-gradient(180deg, rgba(5, 179, 150, 0.16) 0%, rgba(15, 23, 42, 0.9) 100%);' : '' }}">
                <div style="position: absolute; top: -13px; right: 25px; background: linear-gradient(135deg, #05B396, #0284c7); color: #fff; padding: 4px 14px; border-radius: 20px; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.5px;">
                    {{ $pkg['badge'] }}
                </div>
                
                <div style="text-align: center; margin: 0.5rem 0 1.2rem; display: flex; justify-content: center; align-items: center; min-height: 220px;">
                    <img src="{{ asset($pkg['image']) }}" alt="{{ $pkg['name'] }}" style="max-height: 210px; width: auto; object-fit: contain; filter: drop-shadow(0 12px 24px rgba(0, 0, 0, 0.5)); transition: transform 0.3s ease;">
                </div>

                <h3 style="font-size: 1.5rem; text-align: center; margin-bottom: 0.8rem;">{{ $pkg['name'] }}</h3>

                <ul style="list-style: none; margin-bottom: 2rem; flex-grow: 1;">
                    @foreach ($pkg['courses_included'] as $c)
                        <li style="padding: 0.45rem 0; color: var(--text-body); font-size: 0.92rem; display: flex; align-items: center; gap: 10px;">
                            <span style="color: #05B396; font-weight: bold;">✓</span> {{ $c }}
                        </li>
                    @endforeach
                </ul>

                <a href="{{ url('/register?package=' . urlencode($pkg['name'])) }}" class="btn {{ $pkg['featured'] ? 'btn-primary' : 'btn-secondary' }}" style="text-align: center; width: 100%; padding: 0.85rem; font-weight: 700;">
                    Enroll in {{ $pkg['name'] }}
                </a>
            </div>
        @endforeach
    </div>
</section>

<!-- Course Curriculum -->
<section class="container" style="padding-top: 0;">
    <div style="text-align: center; margin-bottom: 3.5rem;">
        <div style="text-transform: uppercase; letter-spacing: 2.5px; color: var(--primary); font-size: 0.85rem; font-weight: 800; margin-bottom: 0.5rem;">Curriculum</div>
        <h2 style="font-size: 2.4rem; font-weight: 800; letter-spacing: -0.5px;">High-Yield Skill Courses</h2>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.8rem;">
        @foreach ($courses as $c)
            <div class="glass" style="border-radius: var(--radius-md); overflow: hidden; display: flex; flex-direction: column;">
                <div style="height: 160px; background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%); display: flex; align-items: center; justify-content: center; font-size: 3.5rem; position: relative;">
                    <span>{{ $c['icon'] }}</span>
                    <span style="position: absolute; bottom: 10px; right: 10px; background: rgba(0, 0, 0, 0.75); padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; color: #fff;">{{ $c['duration'] }}</span>
                </div>
                <div style="padding: 1.4rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <span style="font-size: 0.75rem; color: #818cf8; font-weight: 700; text-transform: uppercase;">{{ $c['cat'] }}</span>
                        <h4 style="font-size: 1.15rem; margin-top: 0.4rem;">{{ $c['title'] }}</h4>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.4rem; border-top: 1px solid var(--border-glass); padding-top: 0.8rem;">
                        <span style="font-size: 0.85rem; color: var(--text-body);">{{ $c['lessons'] }} Lessons</span>
                        <a href="{{ url('/classroom') }}" class="btn btn-secondary" style="padding: 0.35rem 0.8rem; font-size: 0.85rem;">Watch Demo</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
