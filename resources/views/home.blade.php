@extends('layouts.app')

@section('title', 'SkillLearner — Build Skill, Build Future')

@section('content')
<!-- Hero Section -->
<section class="hero" style="text-align: center; padding: 5rem 2rem 4rem; max-width: 1150px; margin: 0 auto;">
    <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(5, 179, 150, 0.12); border: 1px solid rgba(5, 179, 150, 0.3); color: #05B396; padding: 6px 18px; border-radius: 50px; font-size: 0.85rem; font-weight: 700; margin-bottom: 1.8rem;">
        <span>★ India's #1 Skill & Affiliate Platform</span>
    </div>
    <h1 class="hero-title" style="color: #0B4F4A;">
        <span class="title-skill" style="color: #0B4F4A;">Build Skill,</span> <br><span class="title-future" style="color: #0A6B5C;">Build Future.</span>
    </h1>
    <p class="hero-subtitle" style="color: #000000; font-weight: 700; font-size: 1.25rem; max-width: 720px; margin: 0 auto 2.5rem;">
        Unlock your potential with SkillLearner. Explore industry-relevant courses, gain practical knowledge, and develop the skills you need to grow professionally and succeed in the digital world.
    </p>
    <div style="display: flex; gap: 1.2rem; justify-content: center; flex-wrap: wrap;">
        <a href="{{ url('/courses') }}" class="btn btn-primary" style="background: #05B396; padding: 1rem 2.2rem; font-size: 1.1rem; font-weight: 800;">Explore Courses ➔</a>
        {{-- <a href="{{ url('/plans') }}" class="btn btn-secondary" style="padding: 1rem 2.2rem; font-size: 1.1rem;">Explore Packages</a> --}}
    </div>

    <div class="hero-image-wrapper" style="margin-top: 3.5rem; display: flex; justify-content: center;">
        <img src="{{ asset('images/skill-tree.png') }}" alt="SkillLearner - Build Skills, Build Future" class="hero-tree-img" style="width: 100%; max-width: 950px; height: auto; border-radius: 18px; object-fit: contain;">
    </div>
</section>

<!-- Packages Showcase -->
<section class="container" id="packages">
    <div style="text-align: center; margin-bottom: 3.5rem;">
        <div style="text-transform: uppercase; letter-spacing: 2.5px; color: #0B4F4A; font-size: 0.85rem; font-weight: 800; margin-bottom: 0.5rem;">Packages & Tiers</div>
        <h2 style="font-size: 2.0 rem; font-weight: 800; letter-spacing: -0.5px; color:#0A6B5C;">Select Your Learning Track</h2>
        <p style="max-width: 620px; margin: 0 auto;">Every package unlocks premium high-yield skills along with direct and passive referral commission rights.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(270px, 1fr)); gap: 2rem;">
        @foreach ($packages as $pkg)
            <div class="glass" style="padding: 2rem 1.8rem; border-radius: var(--radius-lg); display: flex; flex-direction: column; position: relative; transition: transform 0.3s ease, border-color 0.3s ease; border: 1.5px solid {{ $pkg['border_color'] ?? 'rgba(255,255,255,0.08)' }}; background: {{ $pkg['bg_gradient'] ?? 'var(--bg-card)' }};">
                <div style="text-align: center; margin: 0.5rem 0 1.2rem; display: flex; justify-content: center; align-items: center; min-height: 220px; background: radial-gradient(circle, {{ ($pkg['color'] ?? '#05B396') . '26' }} 0%, transparent 70%); border-radius: 14px;">
                    <img src="{{ asset($pkg['image']) }}" alt="{{ $pkg['name'] }}" style="max-height: 210px; width: auto; object-fit: contain; filter: drop-shadow(0 12px 24px rgba(0, 0, 0, 0.5)); transition: transform 0.3s ease;">
                </div>

                <h3 style="font-size: 1.5rem; text-align: center; margin-bottom: 1.2rem; color: #fff;">{{ $pkg['name'] }}</h3>

                <ul style="list-style: none; margin-bottom: 1.8rem; flex-grow: 1;">
                    @foreach ($pkg['courses_included'] as $c)
                        <li style="padding: 0.45rem 0; color: var(--text-body); font-size: 0.92rem; display: flex; align-items: center; gap: 10px;">
                            <span style="color: {{ $pkg['color'] ?? '#05B396' }}; font-weight: bold;">✓</span> {{ $c }}
                        </li>
                    @endforeach
                </ul>

                <div style="display: flex; flex-direction: column; gap: 0.6rem;">
                    <a href="{{ url('/buy-now?package=' . $pkg['id']) }}" class="btn btn-primary" style="background: {{ $pkg['color'] ?? '#05B396' }}; text-align: center; width: 100%; padding: 0.85rem; font-weight: 800; box-shadow: 0 4px 14px {{ ($pkg['color'] ?? '#05B396') . '40' }};">
                        Buy Now ➔
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Course Curriculum & Descriptions -->
<section class="container" style="padding-top: 0; padding-bottom: 5rem;">
    <div style="text-align: center; margin-bottom: 3.5rem;">
        <div style="text-transform: uppercase; letter-spacing: 2.5px; color: var(--primary); font-size: 0.85rem; font-weight: 800; margin-bottom: 0.5rem;">Curriculum & Syllabuses</div>
        <h2 style="font-size: 2.4rem; font-weight: 800; letter-spacing: -0.5px;">High-Yield Skill Courses</h2>
        <p style="color: var(--text-body); max-width: 600px; margin: 0 auto;">Read full course descriptions, learning modules, and enroll directly with one click.</p>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem;">
        @foreach ($courses as $c)
            <div class="glass" style="border-radius: var(--radius-md); overflow: hidden; display: flex; flex-direction: column; border: 1px solid var(--border-glass);">
                <div style="height: 160px; background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%); display: flex; align-items: center; justify-content: center; font-size: 3.5rem; position: relative;">
                    <span>{{ $c['icon'] }}</span>
                    <span style="position: absolute; bottom: 10px; right: 10px; background: rgba(0, 0, 0, 0.75); padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; color: #fff;">{{ $c['duration'] }}</span>
                    @if(!empty($c['badge']))
                        <span style="position: absolute; top: 10px; left: 10px; background: #05B396; color: #fff; padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 800;">{{ $c['badge'] }}</span>
                    @endif
                </div>
                
                <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <span style="font-size: 0.75rem; color: #05B396; font-weight: 800; text-transform: uppercase;">{{ $c['cat'] }}</span>
                        <h4 style="font-size: 1.2rem; font-weight: 800; margin-top: 0.3rem; margin-bottom: 0.6rem; color: #fff;">{{ $c['title'] }}</h4>
                        <p style="color: var(--text-body); font-size: 0.88rem; line-height: 1.5; margin-bottom: 1rem;">
                            {{ $c['tagline'] }}
                        </p>
                    </div>

                    <div style="border-top: 1px solid var(--border-glass); padding-top: 1rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                            <span style="font-size: 0.85rem; color: var(--text-body);">{{ $c['lessons'] }} Lessons</span>
                            <span style="font-size: 1.15rem; font-weight: 800; color: #05B396;">₹{{ number_format($c['price']) }}</span>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.6rem;">
                            <a href="{{ url('/courses/' . $c['slug']) }}" class="btn btn-secondary" style="padding: 0.55rem 0.6rem; font-size: 0.85rem; font-weight: 700; text-align: center;">
                                Description
                            </a>
                            <a href="{{ url('/buy-now?course=' . $c['slug']) }}" class="btn btn-primary" style="background: #05B396; padding: 0.55rem 0.6rem; font-size: 0.85rem; font-weight: 800; text-align: center;">
                                Buy Now ➔
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div style="text-align: center; margin-top: 3rem;">
        <a href="{{ url('/courses') }}" class="btn btn-secondary" style="padding: 0.9rem 2.2rem; font-size: 1rem; font-weight: 700;">
            View All Courses With Full Syllabuses ➔
        </a>
    </div>
</section>
@endsection
