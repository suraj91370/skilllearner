@extends('layouts.app')

@section('title', 'Leaderboard — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'leaderboard'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'leaderboard'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 style="font-size: 1.85rem; font-weight: 800; color: #0f172a; margin: 0 0 0.35rem;">Leaderboard</h2>
                    <p style="color: #64748b; font-size: 0.92rem; margin: 0;">Top performing affiliate creators ranked by verified earnings.</p>
                </div>
                <a href="{{ url('/team-leaderboard') }}" class="btn" style="display: inline-flex; align-items: center; gap: 6px; background: rgba(5, 179, 150, 0.12); border: 1.5px solid #05B396; color: #05B396; font-weight: 700; padding: 0.6rem 1.2rem; border-radius: 10px; text-decoration: none; font-size: 0.88rem; transition: all 0.2s;" onmouseover="this.style.background='#05B396'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(5, 179, 150, 0.12)'; this.style.color='#05B396';">
                    <span>👥</span>
                    <span>View Team Leaderboard ➔</span>
                </a>
            </div>

            <!-- Dual Leaderboard Grid (7 Days & 30 Days Matching Screenshot) -->
            <div class="leaderboard-dual-grid">

                <!-- 1. 7 DAYS LEADERBOARD -->
                <div class="leaderboard-podium-card">
                    <h3 class="leaderboard-podium-title">7 DAYS LEADERBOARD</h3>

                    <!-- Top 3 Podium (2nd, 1st, 3rd) -->
                    <div class="podium-stage-wrap">
                        <!-- 2nd Place -->
                        <div class="podium-col rank-2nd">
                            <div class="crown-wrapper">
                                <svg class="crown-icon crown-silver" viewBox="0 0 54 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <linearGradient id="silverGrad7" x1="0" y1="0" x2="1" y2="1">
                                            <stop offset="0%" stop-color="#e2e8f0"/>
                                            <stop offset="50%" stop-color="#cbd5e1"/>
                                            <stop offset="100%" stop-color="#94a3b8"/>
                                        </linearGradient>
                                    </defs>
                                    <path d="M5 34 L12 12 L22 23 L27 6 L32 23 L42 12 L49 34 Z" fill="url(#silverGrad7)"/>
                                    <rect x="3" y="33" width="48" height="6" rx="3" fill="url(#silverGrad7)"/>
                                    <circle cx="27" cy="6" r="3" fill="#ffffff" stroke="#94a3b8" stroke-width="1"/>
                                    <circle cx="12" cy="12" r="2.5" fill="#ffffff" stroke="#94a3b8" stroke-width="1"/>
                                    <circle cx="42" cy="12" r="2.5" fill="#ffffff" stroke="#94a3b8" stroke-width="1"/>
                                    <circle cx="17" cy="36" r="1.8" fill="#0284c7"/>
                                    <circle cx="27" cy="36" r="2" fill="#0284c7"/>
                                    <circle cx="37" cy="36" r="1.8" fill="#0284c7"/>
                                </svg>
                            </div>
                            <div class="podium-avatar-wrap">
                                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=160&auto=format&fit=crop&q=80" alt="Akanksha" class="podium-avatar-img">
                                <span class="podium-rank-pill">2nd</span>
                            </div>
                            <span class="podium-name-pill" title="Akanksha">Akanksha</span>
                            <div class="podium-amount">₹12340</div>
                        </div>

                        <!-- 1st Place (Center - Elevated Champion) -->
                        <div class="podium-col rank-1st">
                            <div class="crown-wrapper">
                                <svg class="crown-icon crown-gold" viewBox="0 0 64 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <linearGradient id="goldGrad7" x1="0" y1="0" x2="1" y2="1">
                                            <stop offset="0%" stop-color="#ffe259"/>
                                            <stop offset="50%" stop-color="#ffa751"/>
                                            <stop offset="100%" stop-color="#d47a16"/>
                                        </linearGradient>
                                        <filter id="crownGlow7" x="-20%" y="-20%" width="140%" height="140%">
                                            <feDropShadow dx="0" dy="2" stdDeviation="3" flood-color="#ffa751" flood-opacity="0.5"/>
                                        </filter>
                                    </defs>
                                    <path d="M6 38 L14 14 L26 26 L32 6 L38 26 L50 14 L58 38 Z" fill="url(#goldGrad7)" filter="url(#crownGlow7)"/>
                                    <rect x="4" y="37" width="56" height="7" rx="3.5" fill="url(#goldGrad7)"/>
                                    <circle cx="32" cy="6" r="3.5" fill="#ffffff" stroke="#eab308" stroke-width="1"/>
                                    <circle cx="14" cy="14" r="3" fill="#ffffff" stroke="#eab308" stroke-width="1"/>
                                    <circle cx="50" cy="14" r="3" fill="#ffffff" stroke="#eab308" stroke-width="1"/>
                                    <circle cx="20" cy="40.5" r="2" fill="#ef4444"/>
                                    <circle cx="32" cy="40.5" r="2.5" fill="#3b82f6"/>
                                    <circle cx="44" cy="40.5" r="2" fill="#ef4444"/>
                                </svg>
                            </div>
                            <div class="podium-avatar-wrap">
                                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=160&auto=format&fit=crop&q=80" alt="Shivani" class="podium-avatar-img">
                                <span class="podium-rank-pill">1st</span>
                            </div>
                            <span class="podium-name-pill" title="Shivani">Shivani</span>
                            <div class="podium-amount">₹22400</div>
                        </div>

                        <!-- 3rd Place -->
                        <div class="podium-col rank-3rd">
                            <div class="crown-wrapper">
                                <svg class="crown-icon crown-bronze" viewBox="0 0 54 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <linearGradient id="bronzeGrad7" x1="0" y1="0" x2="1" y2="1">
                                            <stop offset="0%" stop-color="#f5d0fe"/>
                                            <stop offset="50%" stop-color="#d8b4fe"/>
                                            <stop offset="100%" stop-color="#c084fc"/>
                                        </linearGradient>
                                    </defs>
                                    <path d="M5 34 L12 12 L22 23 L27 6 L32 23 L42 12 L49 34 Z" fill="url(#bronzeGrad7)"/>
                                    <rect x="3" y="33" width="48" height="6" rx="3" fill="url(#bronzeGrad7)"/>
                                    <circle cx="27" cy="6" r="3" fill="#ffffff" stroke="#c084fc" stroke-width="1"/>
                                    <circle cx="12" cy="12" r="2.5" fill="#ffffff" stroke="#c084fc" stroke-width="1"/>
                                    <circle cx="42" cy="12" r="2.5" fill="#ffffff" stroke="#c084fc" stroke-width="1"/>
                                    <circle cx="17" cy="36" r="1.8" fill="#9333ea"/>
                                    <circle cx="27" cy="36" r="2" fill="#9333ea"/>
                                    <circle cx="37" cy="36" r="1.8" fill="#9333ea"/>
                                </svg>
                            </div>
                            <div class="podium-avatar-wrap">
                                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?w=160&auto=format&fit=crop&q=80" alt="Neha" class="podium-avatar-img">
                                <span class="podium-rank-pill">3rd</span>
                            </div>
                            <span class="podium-name-pill" title="Neha">Neha</span>
                            <div class="podium-amount">₹6700</div>
                        </div>
                    </div>

                    <!-- Rank Rows (4, 5, etc.) -->
                    <div class="podium-rows-list">
                        <!-- Rank 4 -->
                        <div class="podium-row-card">
                            <div class="podium-row-left">
                                <span class="podium-row-rank-num">4</span>
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80" alt="VISHU" class="podium-row-avatar">
                                <span class="podium-row-name">VISHU (Blaze Leader)</span>
                            </div>
                            <div class="podium-row-amount">₹ 5680</div>
                        </div>

                        <!-- Rank 5 -->
                        <div class="podium-row-card">
                            <div class="podium-row-left">
                                <span class="podium-row-rank-num">5</span>
                                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80" alt="Prince" class="podium-row-avatar">
                                <span class="podium-row-name">Prince</span>
                            </div>
                            <div class="podium-row-amount">₹ 3920</div>
                        </div>
                    </div>
                </div>

                <!-- 2. 30 DAYS LEADERBOARD -->
                <div class="leaderboard-podium-card">
                    <h3 class="leaderboard-podium-title">30 DAYS LEADERBOARD</h3>

                    <!-- Top 3 Podium (2nd, 1st, 3rd) -->
                    <div class="podium-stage-wrap">
                        <!-- 2nd Place -->
                        <div class="podium-col rank-2nd">
                            <div class="crown-wrapper">
                                <svg class="crown-icon crown-silver" viewBox="0 0 54 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <linearGradient id="silverGrad30" x1="0" y1="0" x2="1" y2="1">
                                            <stop offset="0%" stop-color="#e2e8f0"/>
                                            <stop offset="50%" stop-color="#cbd5e1"/>
                                            <stop offset="100%" stop-color="#94a3b8"/>
                                        </linearGradient>
                                    </defs>
                                    <path d="M5 34 L12 12 L22 23 L27 6 L32 23 L42 12 L49 34 Z" fill="url(#silverGrad30)"/>
                                    <rect x="3" y="33" width="48" height="6" rx="3" fill="url(#silverGrad30)"/>
                                    <circle cx="27" cy="6" r="3" fill="#ffffff" stroke="#94a3b8" stroke-width="1"/>
                                    <circle cx="12" cy="12" r="2.5" fill="#ffffff" stroke="#94a3b8" stroke-width="1"/>
                                    <circle cx="42" cy="12" r="2.5" fill="#ffffff" stroke="#94a3b8" stroke-width="1"/>
                                    <circle cx="17" cy="36" r="1.8" fill="#0284c7"/>
                                    <circle cx="27" cy="36" r="2" fill="#0284c7"/>
                                    <circle cx="37" cy="36" r="1.8" fill="#0284c7"/>
                                </svg>
                            </div>
                            <div class="podium-avatar-wrap">
                                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=160&auto=format&fit=crop&q=80" alt="Akanksha" class="podium-avatar-img">
                                <span class="podium-rank-pill">2nd</span>
                            </div>
                            <span class="podium-name-pill" title="Akanksha">Akanksha</span>
                            <div class="podium-amount">₹37333</div>
                        </div>

                        <!-- 1st Place (Center - Elevated Champion) -->
                        <div class="podium-col rank-1st">
                            <div class="crown-wrapper">
                                <svg class="crown-icon crown-gold" viewBox="0 0 64 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <linearGradient id="goldGrad30" x1="0" y1="0" x2="1" y2="1">
                                            <stop offset="0%" stop-color="#ffe259"/>
                                            <stop offset="50%" stop-color="#ffa751"/>
                                            <stop offset="100%" stop-color="#d47a16"/>
                                        </linearGradient>
                                        <filter id="crownGlow30" x="-20%" y="-20%" width="140%" height="140%">
                                            <feDropShadow dx="0" dy="2" stdDeviation="3" flood-color="#ffa751" flood-opacity="0.5"/>
                                        </filter>
                                    </defs>
                                    <path d="M6 38 L14 14 L26 26 L32 6 L38 26 L50 14 L58 38 Z" fill="url(#goldGrad30)" filter="url(#crownGlow30)"/>
                                    <rect x="4" y="37" width="56" height="7" rx="3.5" fill="url(#goldGrad30)"/>
                                    <circle cx="32" cy="6" r="3.5" fill="#ffffff" stroke="#eab308" stroke-width="1"/>
                                    <circle cx="14" cy="14" r="3" fill="#ffffff" stroke="#eab308" stroke-width="1"/>
                                    <circle cx="50" cy="14" r="3" fill="#ffffff" stroke="#eab308" stroke-width="1"/>
                                    <circle cx="20" cy="40.5" r="2" fill="#ef4444"/>
                                    <circle cx="32" cy="40.5" r="2.5" fill="#3b82f6"/>
                                    <circle cx="44" cy="40.5" r="2" fill="#ef4444"/>
                                </svg>
                            </div>
                            <div class="podium-avatar-wrap">
                                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=160&auto=format&fit=crop&q=80" alt="Shivani" class="podium-avatar-img">
                                <span class="podium-rank-pill">1st</span>
                            </div>
                            <span class="podium-name-pill" title="Shivani">Shivani</span>
                            <div class="podium-amount">₹47766</div>
                        </div>

                        <!-- 3rd Place -->
                        <div class="podium-col rank-3rd">
                            <div class="crown-wrapper">
                                <svg class="crown-icon crown-bronze" viewBox="0 0 54 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <linearGradient id="bronzeGrad30" x1="0" y1="0" x2="1" y2="1">
                                            <stop offset="0%" stop-color="#f5d0fe"/>
                                            <stop offset="50%" stop-color="#d8b4fe"/>
                                            <stop offset="100%" stop-color="#c084fc"/>
                                        </linearGradient>
                                    </defs>
                                    <path d="M5 34 L12 12 L22 23 L27 6 L32 23 L42 12 L49 34 Z" fill="url(#bronzeGrad30)"/>
                                    <rect x="3" y="33" width="48" height="6" rx="3" fill="url(#bronzeGrad30)"/>
                                    <circle cx="27" cy="6" r="3" fill="#ffffff" stroke="#c084fc" stroke-width="1"/>
                                    <circle cx="12" cy="12" r="2.5" fill="#ffffff" stroke="#c084fc" stroke-width="1"/>
                                    <circle cx="42" cy="12" r="2.5" fill="#ffffff" stroke="#c084fc" stroke-width="1"/>
                                    <circle cx="17" cy="36" r="1.8" fill="#9333ea"/>
                                    <circle cx="27" cy="36" r="2" fill="#9333ea"/>
                                    <circle cx="37" cy="36" r="1.8" fill="#9333ea"/>
                                </svg>
                            </div>
                            <div class="podium-avatar-wrap">
                                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?w=160&auto=format&fit=crop&q=80" alt="Neha" class="podium-avatar-img">
                                <span class="podium-rank-pill">3rd</span>
                            </div>
                            <span class="podium-name-pill" title="Neha">Neha</span>
                            <div class="podium-amount">₹20246</div>
                        </div>
                    </div>

                    <!-- Rank Rows (4, 5, etc.) -->
                    <div class="podium-rows-list">
                        <!-- Rank 4 -->
                        <div class="podium-row-card">
                            <div class="podium-row-left">
                                <span class="podium-row-rank-num">4</span>
                                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80" alt="Prince" class="podium-row-avatar">
                                <span class="podium-row-name">Prince</span>
                            </div>
                            <div class="podium-row-amount">₹ 14667</div>
                        </div>

                        <!-- Rank 5 -->
                        <div class="podium-row-card">
                            <div class="podium-row-left">
                                <span class="podium-row-rank-num">5</span>
                                <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=100&auto=format&fit=crop&q=80" alt="Neha" class="podium-row-avatar">
                                <span class="podium-row-name">Neha</span>
                            </div>
                            <div class="podium-row-amount">₹ 12030</div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

@include('portal.styles')
@endsection
