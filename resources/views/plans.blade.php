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
        @php
            $plansMeta = [
                'basic' => ['num' => 1, 'access' => 'Get Access of 3+ Courses', 'prev' => null],
                'growth' => ['num' => 2, 'access' => 'Get Access of 6+ Courses', 'prev' => '+ Full Access of Basic Package (All 3 Courses)'],
                'advance' => ['num' => 3, 'access' => 'Get Access of 9+ Courses', 'prev' => '+ Full Access of Basic & Growth Packages (All 6 Courses)'],
                'premium' => ['num' => 4, 'access' => 'Get Access of 12+ Courses', 'prev' => '+ Full Access of Basic, Growth & Advance Packages (All 9 Courses)'],
                'infinity' => ['num' => 5, 'access' => 'Get Access of 15+ Courses', 'prev' => '+ Full Access of All Previous Packages (Lifetime All Access)'],
            ];
        @endphp

        @foreach ($packages as $pkg)
            @php
                $pMeta = $plansMeta[$pkg['id']] ?? ['num' => $loop->iteration, 'access' => ($pkg['access_badge'] ?? 'Get Access of 3+ Courses'), 'prev' => ($pkg['previous_access'] ?? null)];
            @endphp
            <div id="{{ $pkg['id'] }}" class="glass" style="padding: 2.2rem 1.8rem; border-radius: var(--radius-lg); display: flex; flex-direction: column; position: relative; transition: transform 0.3s ease, border-color 0.3s ease; border: 1.5px solid {{ $pkg['border_color'] ?? 'rgba(255,255,255,0.08)' }}; background: {{ $pkg['bg_gradient'] ?? 'var(--bg-card)' }};">
                <div style="text-align: center; margin: 0.5rem 0 1.2rem; display: flex; justify-content: center; align-items: center; min-height: 230px; background: radial-gradient(circle, {{ ($pkg['color'] ?? '#05B396') . '26' }} 0%, transparent 70%); border-radius: 14px;">
                    <img src="{{ asset($pkg['image']) }}" alt="{{ $pkg['name'] }}" style="max-height: 220px; width: auto; object-fit: contain; filter: drop-shadow(0 12px 24px rgba(0, 0, 0, 0.5)); transition: transform 0.3s ease;">
                </div>

                <h3 style="font-size: 1.55rem; font-weight: 800; text-align: center; margin-bottom: 0.4rem; color: #fff;">
                    {{ $pMeta['num'] }}. {{ $pkg['name'] }}
                </h3>

                <div style="text-align: center; margin-bottom: 1rem;">
                    <div style="display: inline-flex; align-items: baseline; gap: 8px;">
                        <span style="font-size: 1.85rem; font-weight: 900; color: #ffffff;">₹{{ number_format($pkg['price']) }}</span>
                        @if(!empty($pkg['old_price']))
                            <span style="font-size: 0.95rem; text-decoration: line-through; color: #64748b; font-weight: 600;">₹{{ number_format($pkg['old_price']) }}</span>
                        @endif
                    </div>
                </div>

                <!-- Access Badge -->
                <div style="background: rgba(255, 255, 255, 0.05); border: 1.5px solid {{ $pkg['color'] ?? '#05B396' }}; padding: 0.65rem 0.8rem; border-radius: 8px; text-align: center; margin-bottom: 1.2rem; display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <span>🎯</span>
                    <span style="font-size: 0.95rem; font-weight: 800; color: {{ $pkg['color'] ?? '#05B396' }};">
                        {{ $pMeta['access'] }}
                    </span>
                </div>

                <ul style="list-style: none; margin-bottom: 1.2rem; padding: 0; display: flex; flex-direction: column; gap: 8px;">
                    @foreach ($pkg['courses_included'] as $c)
                        <li style="padding: 0.2rem 0; color: #e2e8f0; font-size: 0.92rem; display: flex; align-items: center; gap: 10px;">
                            <span style="color: {{ $pkg['color'] ?? '#05B396' }}; font-weight: bold; font-size: 1.1rem;">•</span> {{ $c }}
                        </li>
                    @endforeach
                </ul>

                @if(!empty($pMeta['prev']))
                    <div style="margin-bottom: 1.6rem; padding: 0.65rem 0.8rem; background: rgba(255, 255, 255, 0.04); border: 1px dashed {{ $pkg['color'] ?? '#05B396' }}; border-radius: 8px; font-size: 0.82rem; color: #f1f5f9; display: flex; align-items: center; gap: 8px; line-height: 1.35;">
                        <span style="font-size: 1.1rem; flex-shrink: 0;">🎁</span>
                        <span style="font-weight: 700;">{{ $pMeta['prev'] }}</span>
                    </div>
                @else
                    <div style="margin-bottom: 1.6rem; flex-grow: 1;"></div>
                @endif

                <!-- Action Buttons: Buy Now & Register -->
                <div style="display: flex; flex-direction: column; gap: 0.65rem; margin-top: auto;">
                    <a href="{{ url('/buy-now?package=' . $pkg['id']) }}" class="btn btn-primary" style="background: {{ $pkg['color'] ?? '#05B396' }}; text-align: center; width: 100%; padding: 0.9rem; font-size: 1.02rem; font-weight: 800; border-radius: 10px; box-shadow: 0 4px 18px {{ ($pkg['color'] ?? '#05B396') . '40' }}; text-decoration: none;">
                        Buy Now ➔
                    </a>
                </div>

            </div>
        @endforeach
    </div>
</section>

<!-- Why SkillLearner Section -->
<section style="padding: 4.5rem 1.5rem 5rem; position: relative; overflow: hidden; background: radial-gradient(circle at 10% 20%, rgba(253, 242, 248, 0.7) 0%, rgba(255, 255, 255, 0.98) 50%, rgba(243, 232, 255, 0.7) 100%); border-top: 1px solid rgba(0,0,0,0.04); border-bottom: 1px solid rgba(0,0,0,0.04); margin: 1rem 0 3.5rem;">
    <!-- Ambient Blur Accents -->
    <div style="position: absolute; top: -50px; left: -50px; width: 260px; height: 260px; background: radial-gradient(circle, rgba(253, 230, 138, 0.35) 0%, transparent 70%); filter: blur(40px); pointer-events: none;"></div>
    <div style="position: absolute; bottom: -50px; right: -50px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(216, 180, 254, 0.4) 0%, transparent 70%); filter: blur(50px); pointer-events: none;"></div>

    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0; position: relative; z-index: 2;">
        <h2 style="font-size: clamp(2.2rem, 5vw, 3rem); font-weight: 900; text-align: center; margin-bottom: 3.5rem; letter-spacing: -1px; color: #0f172a;">
            Why <span style="color: #0B4F4A;">SKILL</span><span style="color: #0A6B5C;">LEARNER</span>
        </h2>

        <div class="why-sl-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.8rem;">
            
            <!-- Card 1: Learners & counting -->
            <div class="why-sl-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 18px; padding: 2.5rem 1.5rem 2.2rem; text-align: center; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                <div style="width: 72px; height: 72px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="24" cy="24" r="23" fill="#F5F3FF"/>
                        <path d="M24 10L11 17L24 23L37 17L24 10Z" fill="#3B1E78"/>
                        <path d="M16 19.5V26.5C16 29.5 19.5 31.5 24 31.5C28.5 31.5 32 29.5 32 26.5V19.5" fill="#581C87"/>
                        <path d="M35 18V27.5C35 28 34.5 28.5 34 28.5C33.5 28.5 33 28 33 27.5V18.5" stroke="#EC4899" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="24" cy="25" r="4.5" fill="#FBCFE8"/>
                        <path d="M16 38C16 33 19.5 32 24 32C28.5 32 32 33 32 38" fill="#6B21A8"/>
                        <polygon points="24,32 25.5,35 24,38 22.5,35" fill="#9333EA"/>
                    </svg>
                </div>
                <h3 style="font-size: 2.3rem; font-weight: 900; color: #0f172a; margin-bottom: 0.35rem; letter-spacing: -0.5px; line-height: 1.2;">1,000+</h3>
                <p style="color: #64748b; font-size: 0.95rem; font-weight: 600; margin: 0;">Learners &amp; counting</p>
            </div>

            <!-- Card 2: Courses -->
            <div class="why-sl-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 18px; padding: 2.5rem 1.5rem 2.2rem; text-align: center; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                <div style="width: 72px; height: 72px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="24" cy="24" r="23" fill="#FDF2F8"/>
                        <rect x="12" y="32" width="24" height="5" rx="2" fill="#7C3AED"/>
                        <rect x="14" y="33" width="3" height="3" fill="#DDD6FE"/>
                        <rect x="13" y="27" width="22" height="5" rx="2" fill="#EC4899"/>
                        <rect x="15" y="28" width="3" height="3" fill="#FCE7F3"/>
                        <path d="M24 13L11 19.5L24 25.5L37 19.5L24 13Z" fill="#3B1E78"/>
                        <path d="M16 22V26.5C16 28.5 19.5 30 24 30C28.5 30 32 28.5 32 26.5V22" fill="#581C87"/>
                        <path d="M35 20.5V27.5C35 28 34.5 28.5 34 28.5C33.5 28.5 33 28 33 27.5V21" stroke="#F472B6" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 style="font-size: 2.3rem; font-weight: 900; color: #0f172a; margin-bottom: 0.35rem; letter-spacing: -0.5px; line-height: 1.2;">16+</h3>
                <p style="color: #64748b; font-size: 0.95rem; font-weight: 600; margin: 0;">Courses</p>
            </div>

            <!-- Card 3: Live Trainings -->
            <div class="why-sl-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 18px; padding: 2.5rem 1.5rem 2.2rem; text-align: center; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                <div style="width: 72px; height: 72px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="24" cy="24" r="23" fill="#F5F3FF"/>
                        <rect x="11" y="11" width="26" height="20" rx="3.5" fill="#6D28D9"/>
                        <rect x="13" y="13" width="22" height="16" rx="2" fill="#1E1B4B"/>
                        <circle cx="21" cy="21" r="5" fill="#EC4899"/>
                        <polygon points="19.5,18.5 24,21 19.5,23.5" fill="#FFFFFF"/>
                        <rect x="28" y="16" width="5" height="2" rx="1" fill="#A78BFA"/>
                        <rect x="28" y="20" width="5" height="2" rx="1" fill="#A78BFA"/>
                        <rect x="28" y="24" width="5" height="2" rx="1" fill="#A78BFA"/>
                        <path d="M22 31H26V35H22V31Z" fill="#581C87"/>
                        <rect x="17" y="34.5" width="14" height="2.5" rx="1.25" fill="#3B1E78"/>
                    </svg>
                </div>
                <h3 style="font-size: 2.3rem; font-weight: 900; color: #0f172a; margin-bottom: 0.35rem; letter-spacing: -0.5px; line-height: 1.2;">500+</h3>
                <p style="color: #64748b; font-size: 0.95rem; font-weight: 600; margin: 0;">Live Trainings</p>
            </div>

            <!-- Card 4: Trainers -->
            <div class="why-sl-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 18px; padding: 2.5rem 1.5rem 2.2rem; text-align: center; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                <div style="width: 72px; height: 72px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="24" cy="24" r="23" fill="#FDF2F8"/>
                        <circle cx="24" cy="14" r="3.5" fill="#FBCFE8"/>
                        <path d="M19 21C19 18.5 21 18 24 18C27 18 29 18.5 29 21" fill="#6B21A8"/>
                        <rect x="18" y="21" width="12" height="2" rx="1" fill="#9333EA"/>
                        <circle cx="16" cy="26" r="3" fill="#FBCFE8"/>
                        <path d="M12 32C12 30 13.5 29.5 16 29.5C18.5 29.5 20 30 20 32" fill="#7C3AED"/>
                        <rect x="12" y="32" width="8" height="2" rx="0.5" fill="#A855F7"/>
                        <circle cx="32" cy="26" r="3" fill="#FBCFE8"/>
                        <path d="M28 32C28 30 29.5 29.5 32 29.5C34.5 29.5 36 30 36 32" fill="#7C3AED"/>
                        <rect x="28" y="32" width="8" height="2" rx="0.5" fill="#A855F7"/>
                        <rect x="13" y="34" width="6" height="3" rx="0.5" fill="#DDD6FE"/>
                        <rect x="29" y="34" width="6" height="3" rx="0.5" fill="#DDD6FE"/>
                    </svg>
                </div>
                <h3 style="font-size: 2.3rem; font-weight: 900; color: #0f172a; margin-bottom: 0.35rem; letter-spacing: -0.5px; line-height: 1.2;">25+</h3>
                <p style="color: #64748b; font-size: 0.95rem; font-weight: 600; margin: 0;">Trainers</p>
            </div>

        </div>
    </div>
</section>
@endsection
