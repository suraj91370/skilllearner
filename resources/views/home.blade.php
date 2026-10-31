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
        <h2 style="font-size: 2.2rem; font-weight: 800; letter-spacing: -0.5px; color:#0A6B5C;">Select Your Learning Track</h2>
        <p style="max-width: 620px; margin: 0 auto; color: var(--text-body);">Every package unlocks premium high-yield skills along with direct access to practical video masterclasses.</p>
    </div>

    <div class="packages-showcase-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
        @php
            $homeMeta = [
                'basic' => ['num' => 1, 'access' => 'Get Access of 3+ Courses', 'prev' => null],
                'growth' => ['num' => 2, 'access' => 'Get Access of 6+ Courses', 'prev' => '+ Full Access of Basic Package (All 3 Courses)'],
                'advance' => ['num' => 3, 'access' => 'Get Access of 9+ Courses', 'prev' => '+ Full Access of Basic & Growth Packages (All 6 Courses)'],
                'premium' => ['num' => 4, 'access' => 'Get Access of 12+ Courses', 'prev' => '+ Full Access of Basic, Growth & Advance Packages (All 9 Courses)'],
                'infinity' => ['num' => 5, 'access' => 'Get Access of 15+ Courses', 'prev' => '+ Full Access of All Previous Packages (Lifetime All Access)'],
            ];
        @endphp

        @foreach ($packages as $pkg)
            @php
                $hMeta = $homeMeta[$pkg['id']] ?? ['num' => $loop->iteration, 'access' => ($pkg['access_badge'] ?? 'Get Access of 3+ Courses'), 'prev' => ($pkg['previous_access'] ?? null)];
            @endphp
            <div class="glass package-card-home" style="padding: 2.2rem 1.8rem; border-radius: var(--radius-lg); display: flex; flex-direction: column; position: relative; transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease; border: 1.5px solid {{ $pkg['border_color'] ?? 'rgba(255,255,255,0.08)' }}; background: {{ $pkg['bg_gradient'] ?? 'var(--bg-card)' }};">
                <div style="text-align: center; margin: 0.5rem 0 1.2rem; display: flex; justify-content: center; align-items: center; min-height: 220px; background: radial-gradient(circle, {{ ($pkg['color'] ?? '#05B396') . '26' }} 0%, transparent 70%); border-radius: 14px;">
                    <img src="{{ asset($pkg['image']) }}" alt="{{ $pkg['name'] }}" style="max-height: 210px; width: auto; object-fit: contain; filter: drop-shadow(0 12px 24px rgba(0, 0, 0, 0.5)); transition: transform 0.3s ease;">
                </div>

                <h3 style="font-size: 1.55rem; font-weight: 800; text-align: center; margin-bottom: 0.4rem; color: #fff;">
                    {{ $hMeta['num'] }}. {{ $pkg['name'] }}
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
                <div style="background: rgba(255, 255, 255, 0.05); border: 1.5px solid {{ $pkg['color'] ?? '#05B396' }}; padding: 0.65rem 0.8rem; border-radius: 8px; text-align: center; margin-bottom: 1.4rem; display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <span>🎯</span>
                    <span style="font-size: 0.95rem; font-weight: 800; color: {{ $pkg['color'] ?? '#05B396' }};">
                        {{ $hMeta['access'] }}
                    </span>
                </div>

                <ul style="list-style: none; margin-bottom: 1.2rem; padding: 0; display: flex; flex-direction: column; gap: 8px;">
                    @foreach ($pkg['courses_included'] as $c)
                        <li style="padding: 0.2rem 0; color: #e2e8f0; font-size: 0.92rem; display: flex; align-items: center; gap: 10px;">
                            <span style="color: {{ $pkg['color'] ?? '#05B396' }}; font-weight: bold; font-size: 1.1rem;">•</span> {{ $c }}
                        </li>
                    @endforeach
                </ul>

                @if(!empty($hMeta['prev']))
                    <div style="margin-bottom: 1.6rem; padding: 0.65rem 0.8rem; background: rgba(255, 255, 255, 0.04); border: 1px dashed {{ $pkg['color'] ?? '#05B396' }}; border-radius: 8px; font-size: 0.82rem; color: #f1f5f9; display: flex; align-items: center; gap: 8px; line-height: 1.35;">
                        <span style="font-size: 1.1rem; flex-shrink: 0;">🎁</span>
                        <span style="font-weight: 700;">{{ $hMeta['prev'] }}</span>
                    </div>
                @else
                    <div style="margin-bottom: 1.6rem; flex-grow: 1;"></div>
                @endif

                <div style="margin-top: auto;">
                    <a href="{{ url('/buy-now?package=' . $pkg['id']) }}" class="btn btn-primary" style="background: {{ $pkg['color'] ?? '#05B396' }}; text-align: center; width: 100%; padding: 0.85rem; font-weight: 800; border-radius: 10px; box-shadow: 0 4px 14px {{ ($pkg['color'] ?? '#05B396') . '40' }}; display: block; text-decoration: none;">
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

<!-- Why Choose SkillLearner Section -->
<section style="padding: 5rem 1.5rem 6rem; position: relative; overflow: hidden; background: radial-gradient(circle at 8% 25%, rgba(240, 253, 250, 0.7) 0%, #ffffff 45%, rgba(254, 243, 199, 0.4) 100%); border-top: 1px solid rgba(0,0,0,0.04); border-bottom: 1px solid rgba(0,0,0,0.04); margin-bottom: 2rem;">
    <!-- Ambient Blur Accents -->
    <div style="position: absolute; top: -40px; right: 10%; width: 280px; height: 280px; background: radial-gradient(circle, rgba(11, 79, 74, 0.08) 0%, transparent 70%); filter: blur(50px); pointer-events: none;"></div>
    <div style="position: absolute; bottom: -40px; left: 5%; width: 260px; height: 260px; background: radial-gradient(circle, rgba(245, 158, 11, 0.12) 0%, transparent 70%); filter: blur(40px); pointer-events: none;"></div>

    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0; position: relative; z-index: 2;">
        
        <div class="why-choose-layout" style="display: grid; grid-template-columns: 1.35fr 0.85fr; gap: 3.5rem; align-items: center;">
            
            <!-- Left Column: Header, Subtitle, and 2x2 Grid -->
            <div>
                <h2 style="font-size: clamp(2.1rem, 4.5vw, 3rem); font-weight: 900; letter-spacing: -1px; margin-bottom: 0.8rem; color: #0f172a; line-height: 1.2;">
                    Why Choose <span style="color: #0B4F4A;">Skill</span><span style="color: #0A6B5C;">Learner</span>
                </h2>

                <p style="font-size: 1.05rem; line-height: 1.6; color: #475569; margin-bottom: 2.2rem; max-width: 680px; font-weight: 500;">
                    &ldquo;Your Growth, Our Priority. Learn Smarter, Build Skills and Create a Better Future with SkillLearner.&rdquo;
                </p>

                <!-- 2x2 Feature Cards Grid -->
                <div class="why-choose-cards-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.3rem;">
                    
                    <!-- Card 1: Industry-Relevant Courses -->
                    <div class="why-choose-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 16px; padding: 1.4rem 1.25rem; box-shadow: 0 4px 18px -2px rgba(0, 0, 0, 0.04), 0 2px 6px -1px rgba(0, 0, 0, 0.02); display: flex; gap: 1rem; align-items: flex-start; transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;">
                        <div class="why-icon-badge" style="width: 48px; height: 48px; min-width: 48px; border-radius: 12px; background: rgba(11, 79, 74, 0.08); border: 1px solid rgba(11, 79, 74, 0.2); display: flex; align-items: center; justify-content: center; color: #0B4F4A; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                <line x1="9" y1="7" x2="16" y2="7"></line>
                                <line x1="9" y1="11" x2="14" y2="11"></line>
                            </svg>
                        </div>
                        <div>
                            <h4 style="font-size: 0.92rem; font-weight: 800; color: #0f172a; letter-spacing: 0.3px; text-transform: uppercase; margin-bottom: 0.4rem; line-height: 1.3;">
                                1. Industry-Relevant Courses
                            </h4>
                            <p style="color: #64748b; font-size: 0.85rem; line-height: 1.55; margin: 0; font-weight: 500;">
                                Learn practical and in-demand skills designed to help you stay updated with changing industry requirements.
                            </p>
                        </div>
                    </div>

                    <!-- Card 2: Expert-Led Learning -->
                    <div class="why-choose-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 16px; padding: 1.4rem 1.25rem; box-shadow: 0 4px 18px -2px rgba(0, 0, 0, 0.04), 0 2px 6px -1px rgba(0, 0, 0, 0.02); display: flex; gap: 1rem; align-items: flex-start; transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;">
                        <div class="why-icon-badge" style="width: 48px; height: 48px; min-width: 48px; border-radius: 12px; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.25); display: flex; align-items: center; justify-content: center; color: #D97706; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                                <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 style="font-size: 0.92rem; font-weight: 800; color: #0f172a; letter-spacing: 0.3px; text-transform: uppercase; margin-bottom: 0.4rem; line-height: 1.3;">
                                2. Expert-Led Learning
                            </h4>
                            <p style="color: #64748b; font-size: 0.85rem; line-height: 1.55; margin: 0; font-weight: 500;">
                                Gain knowledge through structured learning content created and guided by experienced educators.
                            </p>
                        </div>
                    </div>

                    <!-- Card 3: Learn Anytime, Anywhere -->
                    <div class="why-choose-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 16px; padding: 1.4rem 1.25rem; box-shadow: 0 4px 18px -2px rgba(0, 0, 0, 0.04), 0 2px 6px -1px rgba(0, 0, 0, 0.02); display: flex; gap: 1rem; align-items: flex-start; transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;">
                        <div class="why-icon-badge" style="width: 48px; height: 48px; min-width: 48px; border-radius: 12px; background: rgba(14, 165, 233, 0.1); border: 1px solid rgba(14, 165, 233, 0.25); display: flex; align-items: center; justify-content: center; color: #0284C7; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <div>
                            <h4 style="font-size: 0.92rem; font-weight: 800; color: #0f172a; letter-spacing: 0.3px; text-transform: uppercase; margin-bottom: 0.4rem; line-height: 1.3;">
                                3. Learn Anytime, Anywhere
                            </h4>
                            <p style="color: #64748b; font-size: 0.85rem; line-height: 1.55; margin: 0; font-weight: 500;">
                                Enjoy the flexibility to access your learning resources at your convenience.
                            </p>
                        </div>
                    </div>

                    <!-- Card 4: Affordable Learning Packages -->
                    <div class="why-choose-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 16px; padding: 1.4rem 1.25rem; box-shadow: 0 4px 18px -2px rgba(0, 0, 0, 0.04), 0 2px 6px -1px rgba(0, 0, 0, 0.02); display: flex; gap: 1rem; align-items: flex-start; transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;">
                        <div class="why-icon-badge" style="width: 48px; height: 48px; min-width: 48px; border-radius: 12px; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.25); display: flex; align-items: center; justify-content: center; color: #059669; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="4" width="20" height="16" rx="3"></rect>
                                <path d="M2 10h20"></path>
                                <circle cx="16" cy="15" r="1.5" fill="currentColor"></circle>
                            </svg>
                        </div>
                        <div>
                            <h4 style="font-size: 0.92rem; font-weight: 800; color: #0f172a; letter-spacing: 0.3px; text-transform: uppercase; margin-bottom: 0.4rem; line-height: 1.3;">
                                4. Affordable Learning Packages
                            </h4>
                            <p style="color: #64748b; font-size: 0.85rem; line-height: 1.55; margin: 0; font-weight: 500;">
                                Choose learning packages that match your goals, interests and budget.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right Column: Professional Feature Image -->
            <div class="why-choose-img-wrapper" style="display: flex; justify-content: center; align-items: center; position: relative;">
                <div style="position: absolute; width: 90%; height: 90%; background: radial-gradient(circle, rgba(245, 158, 11, 0.22) 0%, rgba(11, 79, 74, 0.15) 50%, transparent 75%); filter: blur(35px); pointer-events: none;"></div>
                <img src="{{ asset('images/why-choose-skilllearner.jpg') }}" alt="Why Choose SkillLearner" style="width: 100%; max-width: 440px; height: auto; border-radius: 24px; box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(226, 232, 240, 0.8); position: relative; z-index: 2; object-fit: cover;">
            </div>

        </div>
    </div>
</section>

<!-- Our Founders Section -->
<section style="padding: 5.5rem 1.5rem; position: relative; overflow: hidden; background: radial-gradient(circle at 90% 15%, rgba(254, 243, 199, 0.45) 0%, #ffffff 40%, rgba(240, 253, 250, 0.6) 100%); border-top: 1px solid rgba(0,0,0,0.04); border-bottom: 1px solid rgba(0,0,0,0.04); margin-bottom: 2rem;">
    <!-- Ambient Glow Accents -->
    <div style="position: absolute; top: -50px; left: 10%; width: 280px; height: 280px; background: radial-gradient(circle, rgba(11, 79, 74, 0.1) 0%, transparent 70%); filter: blur(50px); pointer-events: none;"></div>
    <div style="position: absolute; bottom: -50px; right: 5%; width: 260px; height: 260px; background: radial-gradient(circle, rgba(245, 158, 11, 0.12) 0%, transparent 70%); filter: blur(40px); pointer-events: none;"></div>

    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0; position: relative; z-index: 2;">
        
        <div style="text-align: center; margin-bottom: 3.5rem;">
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(11, 79, 74, 0.08); border: 1px solid rgba(11, 79, 74, 0.25); color: #0B4F4A; padding: 6px 18px; border-radius: 50px; font-size: 0.82rem; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 1rem;">
                <span>✨ VISIONARY LEADERSHIP</span>
            </div>
            <h2 style="font-size: clamp(2.2rem, 4.5vw, 3rem); font-weight: 900; letter-spacing: -1px; margin-bottom: 0.8rem; color: #0f172a; line-height: 1.2;">
                Meet Our <span style="color: #0B4F4A;">Founder</span> &amp; <span style="color: #0A6B5C;">Co-Founder</span>
            </h2>
            <p style="font-size: 1.05rem; line-height: 1.6; color: #64748b; max-width: 680px; margin: 0 auto; font-weight: 500;">
                Dedicated to transforming digital education across India through practical mastery, high-demand skills, and sustainable career growth.
            </p>
        </div>

        <!-- 2 Founders Side-by-Side Grid -->
        <div class="founders-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2.5rem;">
            
            <!-- Founder Card (Image 2) -->
            <div class="founder-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 24px; overflow: hidden; box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.06), 0 5px 15px rgba(0, 0, 0, 0.02); transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease; display: flex; flex-direction: column;">
                <div style="width: 100%; height: 380px; position: relative; overflow: hidden; background: #0f172a;">
                    <img src="{{ asset('images/founder.jpg') }}" alt="SkillLearner Founder & CEO" style="width: 100%; height: 100%; object-fit: cover; object-position: center 25%; transition: transform 0.4s ease;">
                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(15, 23, 42, 0.5) 0%, transparent 40%);"></div>
                    
                    <span style="position: absolute; top: 16px; left: 16px; background: rgba(11, 79, 74, 0.95); backdrop-filter: blur(8px); color: #fff; padding: 5px 14px; border-radius: 50px; font-size: 0.78rem; font-weight: 800; letter-spacing: 0.8px; text-transform: uppercase; border: 1px solid rgba(255, 255, 255, 0.2);">
                        ★ FOUNDER &amp; CEO
                    </span>
                    <span style="position: absolute; bottom: 16px; right: 16px; background: rgba(245, 158, 11, 0.95); color: #000; font-size: 0.72rem; font-weight: 800; padding: 4px 12px; border-radius: 50px;">
                        OFFICIAL
                    </span>
                </div>

                <div style="padding: 2rem 1.8rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="color: #0B4F4A; font-size: 0.82rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.35rem;">
                            LEADERSHIP &amp; VISION
                        </div>
                        <h3 style="font-size: 1.7rem; font-weight: 900; color: #0f172a; margin-bottom: 0.25rem;">
                            Founder &amp; CEO
                        </h3>
                        <div style="font-size: 0.95rem; font-weight: 700; color: #0A6B5C; margin-bottom: 1.1rem;">
                            SkillLearner EdTech
                        </div>
                        <p style="color: #64748b; font-size: 0.92rem; line-height: 1.6; margin-bottom: 1.2rem;">
                            Spearheading SkillLearner’s core mission to deliver high-yield, project-based video masterclasses and create actionable pathways to financial independence for every learner.
                        </p>
                        
                        <blockquote style="margin: 0; padding: 0.9rem 1.1rem; background: #f8fafc; border-left: 3px solid #0B4F4A; border-radius: 0 10px 10px 0; font-size: 0.88rem; line-height: 1.55; color: #334155; font-style: italic;">
                            &ldquo;Our vision is simple: no student should be left behind in the digital age. By learning practical, high-income skills directly from industry mentors, anyone can unlock true financial freedom.&rdquo;
                        </blockquote>
                    </div>

                    <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 1.5rem; padding-top: 1.2rem; border-top: 1px solid #f1f5f9;">
                        <span style="background: rgba(11, 79, 74, 0.08); color: #0B4F4A; padding: 4px 12px; border-radius: 50px; font-size: 0.78rem; font-weight: 700;">★ 1,000+ Students Mentored</span>
                        <span style="background: rgba(245, 158, 11, 0.1); color: #D97706; padding: 4px 12px; border-radius: 50px; font-size: 0.78rem; font-weight: 700;">★ 100% Practical Focus</span>
                    </div>
                </div>
            </div>

            <!-- Co-Founder Card (Image 1) -->
            <div class="founder-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 24px; overflow: hidden; box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.06), 0 5px 15px rgba(0, 0, 0, 0.02); transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease; display: flex; flex-direction: column;">
                <div style="width: 100%; height: 380px; position: relative; overflow: hidden; background: #0f172a;">
                    <img src="{{ asset('images/co-founder.jpg') }}" alt="SkillLearner Co-Founder" style="width: 100%; height: 100%; object-fit: cover; object-position: center 20%; transition: transform 0.4s ease;">
                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(15, 23, 42, 0.5) 0%, transparent 40%);"></div>
                    
                    <span style="position: absolute; top: 16px; left: 16px; background: rgba(217, 119, 6, 0.95); backdrop-filter: blur(8px); color: #fff; padding: 5px 14px; border-radius: 50px; font-size: 0.78rem; font-weight: 800; letter-spacing: 0.8px; text-transform: uppercase; border: 1px solid rgba(255, 255, 255, 0.2);">
                        ★ CO-FOUNDER
                    </span>
                    <span style="position: absolute; bottom: 16px; right: 16px; background: rgba(11, 79, 74, 0.95); color: #fff; font-size: 0.72rem; font-weight: 800; padding: 4px 12px; border-radius: 50px;">
                        LEADERSHIP
                    </span>
                </div>

                <div style="padding: 2rem 1.8rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="color: #D97706; font-size: 0.82rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.35rem;">
                            GROWTH &amp; OPERATIONS
                        </div>
                        <h3 style="font-size: 1.7rem; font-weight: 900; color: #0f172a; margin-bottom: 0.25rem;">
                            Co-Founder
                        </h3>
                        <div style="font-size: 0.95rem; font-weight: 700; color: #0A6B5C; margin-bottom: 1.1rem;">
                            SkillLearner EdTech
                        </div>
                        <p style="color: #64748b; font-size: 0.92rem; line-height: 1.6; margin-bottom: 1.2rem;">
                            Directing platform operations, interactive mentorship frameworks, and community growth initiatives that enable affiliates and learners to scale their personal brands.
                        </p>
                        
                        <blockquote style="margin: 0; padding: 0.9rem 1.1rem; background: #f8fafc; border-left: 3px solid #D97706; border-radius: 0 10px 10px 0; font-size: 0.88rem; line-height: 1.55; color: #334155; font-style: italic;">
                            &ldquo;We focus on real implementation—guiding our community step-by-step from beginner knowledge to high-yield digital monetization and consistent daily growth.&rdquo;
                        </blockquote>
                    </div>

                    <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 1.5rem; padding-top: 1.2rem; border-top: 1px solid #f1f5f9;">
                        <span style="background: rgba(10, 107, 92, 0.08); color: #0A6B5C; padding: 4px 12px; border-radius: 50px; font-size: 0.78rem; font-weight: 700;">★ Scalable Systems</span>
                        <span style="background: rgba(2, 132, 199, 0.1); color: #0284C7; padding: 4px 12px; border-radius: 50px; font-size: 0.78rem; font-weight: 700;">★ Active Mentorship</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Platform Impact Metrics Bar -->
        <div class="founders-metrics-bar" style="margin-top: 3.5rem; background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 20px; padding: 2rem 2.5rem; display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.8rem; text-align: center; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04);">
            <div>
                <div style="font-size: 2.1rem; font-weight: 900; color: #0B4F4A; line-height: 1.1;">1,000+</div>
                <div style="font-size: 0.88rem; color: #64748b; font-weight: 600; margin-top: 4px;">Enrolled Learners</div>
            </div>
            <div>
                <div style="font-size: 2.1rem; font-weight: 900; color: #0A6B5C; line-height: 1.1;">16+</div>
                <div style="font-size: 0.88rem; color: #64748b; font-weight: 600; margin-top: 4px;">Industry Masterclasses</div>
            </div>
            <div>
                <div style="font-size: 2.1rem; font-weight: 900; color: #D97706; line-height: 1.1;">500+</div>
                <div style="font-size: 0.88rem; color: #64748b; font-weight: 600; margin-top: 4px;">Live Trainings Hosted</div>
            </div>
            <div>
                <div style="font-size: 2.1rem; font-weight: 900; color: #0284C7; line-height: 1.1;">25+</div>
                <div style="font-size: 0.88rem; color: #64748b; font-weight: 600; margin-top: 4px;">Dedicated Mentors</div>
            </div>
        </div>

    </div>
</section>

<!-- Our Expert Team Section -->
<section style="padding: 5.5rem 1.5rem 6.5rem; position: relative; overflow: hidden; background: radial-gradient(circle at 10% 20%, rgba(240, 253, 250, 0.6) 0%, #ffffff 50%, rgba(243, 232, 255, 0.4) 100%); border-bottom: 1px solid rgba(0,0,0,0.04); margin-bottom: 2rem;">
    <!-- Ambient Accents -->
    <div style="position: absolute; top: -40px; right: 15%; width: 260px; height: 260px; background: radial-gradient(circle, rgba(14, 165, 233, 0.1) 0%, transparent 70%); filter: blur(50px); pointer-events: none;"></div>

    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0; position: relative; z-index: 2;">
        
        <div style="text-align: center; margin-bottom: 3.5rem;">
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(10, 107, 92, 0.08); border: 1px solid rgba(10, 107, 92, 0.25); color: #0A6B5C; padding: 6px 18px; border-radius: 50px; font-size: 0.82rem; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 1rem;">
                <span>👥 MENTORSHIP &amp; MASTERY</span>
            </div>
            <h2 style="font-size: clamp(2.2rem, 4.5vw, 3rem); font-weight: 900; letter-spacing: -1px; margin-bottom: 0.8rem; color: #0f172a; line-height: 1.2;">
                Our Expert <span style="color: #0B4F4A;">Team</span> &amp; <span style="color: #0A6B5C;">Mentors</span>
            </h2>
            <p style="font-size: 1.05rem; line-height: 1.6; color: #64748b; max-width: 650px; margin: 0 auto; font-weight: 500;">
                Learn directly from experienced practitioners committed to practical skill mastery, strategic monetization, and real-world results.
            </p>
        </div>

        <!-- 2 Expert Team Cards Grid -->
        <div class="expert-team-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2.2rem; max-width: 820px; margin: 0 auto;">
            
            <!-- Expert Mentor 1 -->
            <div class="team-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 22px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02); transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease; display: flex; flex-direction: column;">
                <div style="width: 100%; height: 320px; position: relative; overflow: hidden; background: #0f172a;">
                    <img src="{{ asset('images/mentor-1.jpg') }}" alt="SkillLearner Expert Mentor" style="width: 100%; height: 100%; object-fit: cover; object-position: center 20%; transition: transform 0.4s ease;">
                </div>
                <div style="padding: 1.6rem 1.4rem; text-align: center; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <h4 style="font-size: 1.3rem; font-weight: 800; color: #0f172a; margin-bottom: 0.25rem;">Expert Mentor</h4>
                        <div style="font-size: 0.85rem; font-weight: 700; color: #0A6B5C; margin-bottom: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">SkillLearner EdTech</div>
                        <p style="color: #64748b; font-size: 0.88rem; line-height: 1.55; margin: 0;">Dedicated mentor offering practical guidance, hands-on masterclasses, and career coaching to help learners achieve measurable digital growth.</p>
                    </div>
                    <div style="margin-top: 1.4rem; padding-top: 1rem; border-top: 1px solid #f1f5f9; display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
                        <span style="background: rgba(11, 79, 74, 0.08); color: #0B4F4A; padding: 4px 12px; border-radius: 50px; font-size: 0.78rem; font-weight: 700;">★ Expert Guidance</span>
                        <span style="background: rgba(10, 107, 92, 0.08); color: #0A6B5C; padding: 4px 12px; border-radius: 50px; font-size: 0.78rem; font-weight: 700;">★ 100% Practical Support</span>
                    </div>
                </div>
            </div>

            <!-- Expert Mentor 2 -->
            <div class="team-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 22px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02); transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease; display: flex; flex-direction: column;">
                <div style="width: 100%; height: 320px; position: relative; overflow: hidden; background: #0f172a;">
                    <img src="{{ asset('images/mentor-2.jpg') }}" alt="SkillLearner Expert Mentor" style="width: 100%; height: 100%; object-fit: cover; object-position: center 20%; transition: transform 0.4s ease;">
                </div>
                <div style="padding: 1.6rem 1.4rem; text-align: center; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <h4 style="font-size: 1.3rem; font-weight: 800; color: #0f172a; margin-bottom: 0.25rem;">Expert Mentor</h4>
                        <div style="font-size: 0.85rem; font-weight: 700; color: #0A6B5C; margin-bottom: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">SkillLearner EdTech</div>
                        <p style="color: #64748b; font-size: 0.88rem; line-height: 1.55; margin: 0;">Empowering students with actionable digital skills, real-time problem solving, and proven strategies to succeed in competitive markets.</p>
                    </div>
                    <div style="margin-top: 1.4rem; padding-top: 1rem; border-top: 1px solid #f1f5f9; display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
                        <span style="background: rgba(217, 119, 6, 0.1); color: #D97706; padding: 4px 12px; border-radius: 50px; font-size: 0.78rem; font-weight: 700;">★ Strategic Coaching</span>
                        <span style="background: rgba(2, 132, 199, 0.1); color: #0284C7; padding: 4px 12px; border-radius: 50px; font-size: 0.78rem; font-weight: 700;">★ Community Growth</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@push('styles')
<style>
    .why-choose-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 28px -4px rgba(11, 79, 74, 0.12), 0 4px 10px -2px rgba(0, 0, 0, 0.04) !important;
        border-color: rgba(11, 79, 74, 0.35) !important;
    }
    .founder-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 25px 45px -8px rgba(11, 79, 74, 0.16) !important;
        border-color: rgba(11, 79, 74, 0.35) !important;
    }
    .founder-card:hover img {
        transform: scale(1.04);
    }
    .team-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 35px -8px rgba(11, 79, 74, 0.15) !important;
        border-color: rgba(11, 79, 74, 0.35) !important;
    }
    .team-card:hover img {
        transform: scale(1.04);
    }

    /* Tablet breakpoint (<= 992px) */
    @media (max-width: 992px) {
        .why-choose-layout {
            grid-template-columns: 1fr !important;
            gap: 2.5rem !important;
        }
        .why-choose-img-wrapper {
            order: -1;
            max-width: 380px;
            margin: 0 auto;
        }
        .why-sl-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 1.2rem !important;
        }
    }

    /* Mobile & Small Tablet (<= 768px): All sections stack 1 ke niche 1 */
    @media (max-width: 768px) {
        .packages-showcase-grid {
            grid-template-columns: 1fr !important;
            gap: 1.5rem !important;
        }
        .why-sl-grid {
            grid-template-columns: 1fr !important;
            gap: 1.2rem !important;
        }
        .why-choose-cards-grid {
            grid-template-columns: 1fr !important;
            gap: 1rem !important;
        }
        .founders-grid {
            grid-template-columns: 1fr !important;
            gap: 2rem !important;
            max-width: 100% !important;
            margin: 0 auto;
        }
        .founders-metrics-bar {
            grid-template-columns: 1fr !important;
            gap: 1.4rem !important;
            padding: 1.5rem 1.2rem !important;
        }
        .expert-team-grid {
            grid-template-columns: 1fr !important;
            gap: 2rem !important;
            max-width: 100% !important;
            margin: 0 auto;
        }
        .founder-card div[style*="height: 380px"] {
            height: 320px !important;
        }
        .team-card div[style*="height: 320px"] {
            height: 300px !important;
        }
    }
</style>
@endpush
@endsection
