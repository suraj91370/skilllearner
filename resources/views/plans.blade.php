@extends('layouts.app')

@section('title', 'Packages & Plans — SkillLearner')

@section('content')
<section class="container" style="padding-top: 3rem; padding-bottom: 4rem;">
    <div style="text-align: center; margin-bottom: 2.5rem;">
        <div style="text-transform: uppercase; letter-spacing: 2.5px; color: #05B396; font-size: 0.85rem; font-weight: 800; margin-bottom: 0.5rem;">SKILLLEARNER PACKAGES</div>
        <h2 style="font-size: 2.6rem; font-weight: 800; letter-spacing: -0.5px;">All Course Bundles & Tracks</h2>
        <p style="color: var(--text-body); max-width: 620px; margin: 0 auto 1.5rem;">
            Choose your desired bundle to gain lifetime access to masterclasses, action blueprints, and community mentorship.
        </p>
        <a href="{{ url('/courses') }}" style="display: inline-flex; align-items: center; gap: 6px; color: #05B396; font-weight: 700; text-decoration: none; font-size: 0.95rem;">
            <span>📖 Want to explore individual course descriptions & syllabuses?</span>
            <strong style="text-decoration: underline;">Browse Courses ➔</strong>
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(290px, 1fr)); gap: 2rem;">
        @foreach ($packages as $pkg)
            <div id="{{ $pkg['id'] }}" class="glass" style="padding: 2.2rem 1.8rem; border-radius: var(--radius-lg); display: flex; flex-direction: column; position: relative; transition: transform 0.3s ease, border-color 0.3s ease; {{ $pkg['featured'] ? 'border: 2px solid #05B396; background: linear-gradient(180deg, rgba(5, 179, 150, 0.16) 0%, rgba(15, 23, 42, 0.9) 100%);' : '' }}">
                @if (!empty($pkg['badge']))
                    <div style="position: absolute; top: -13px; right: 25px; background: linear-gradient(135deg, #05B396, #0284c7); color: #fff; padding: 4px 14px; border-radius: 20px; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.5px;">
                        {{ $pkg['badge'] }}
                    </div>
                @endif

                <div style="text-align: center; margin: 0.5rem 0 1.2rem; display: flex; justify-content: center; align-items: center; min-height: 230px;">
                    <img src="{{ asset($pkg['image']) }}" alt="{{ $pkg['name'] }}" style="max-height: 220px; width: auto; object-fit: contain; filter: drop-shadow(0 12px 24px rgba(0, 0, 0, 0.5)); transition: transform 0.3s ease;">
                </div>

                <h3 style="font-size: 1.55rem; text-align: center; margin-bottom: 0.4rem; color: #fff;">{{ $pkg['name'] }}</h3>

                <!-- Price Display -->
                <div style="text-align: center; margin-bottom: 1.2rem;">
                    <span style="font-size: 2rem; font-weight: 800; color: #05B396;">₹{{ number_format($pkg['price']) }}</span>
                    <span style="font-size: 1.05rem; text-decoration: line-through; color: #64748b; margin-left: 6px;">₹{{ number_format($pkg['old_price']) }}</span>
                </div>

                <p style="color: var(--text-body); font-size: 0.88rem; text-align: center; margin-bottom: 1.4rem; line-height: 1.5;">
                    {{ $pkg['desc'] }}
                </p>

                <ul style="list-style: none; margin-bottom: 2rem; flex-grow: 1;">
                    @foreach ($pkg['courses_included'] as $c)
                        <li style="padding: 0.45rem 0; color: var(--text-body); font-size: 0.92rem; display: flex; align-items: center; gap: 10px;">
                            <span style="color: #05B396; font-weight: bold;">✓</span> {{ $c }}
                        </li>
                    @endforeach
                </ul>

                <!-- Action Buttons: Buy Now & Register -->
                <div style="display: flex; flex-direction: column; gap: 0.65rem;">
                    <a href="{{ url('/buy-now?package=' . $pkg['id']) }}" class="btn btn-primary" style="background: #05B396; text-align: center; width: 100%; padding: 0.9rem; font-size: 1.02rem; font-weight: 800; box-shadow: 0 4px 18px rgba(5, 179, 150, 0.35);">
                        Buy Now ➔
                    </a>
                    <a href="{{ url('/courses') }}" class="btn btn-secondary" style="text-align: center; width: 100%; padding: 0.65rem; font-size: 0.88rem; font-weight: 600;">
                        View Course Descriptions
                    </a>
                </div>

            </div>
        @endforeach
    </div>
</section>
@endsection
