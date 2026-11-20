@extends('layouts.app')

@section('title', 'Elite Affiliate Training Center — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'training'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'training'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Filters & Categories Toolbar -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.1rem 1.4rem; margin-bottom: 1.8rem; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                <form method="GET" action="{{ url('/affiliate-training') }}" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <!-- Category Chips -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <span style="font-size: 0.78rem; font-weight: 800; color: #64748b; text-transform: uppercase;">TOPICS:</span>
                        <a href="{{ url('/affiliate-training?category=all&search='.$search) }}" style="font-size: 0.82rem; font-weight: 700; padding: 5px 14px; border-radius: 20px; text-decoration: none; {{ $categoryFilter === 'all' ? 'background: #7c3aed; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                            All Lessons ({{ count($trainings) }})
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ url('/affiliate-training?category='.urlencode($cat).'&search='.$search) }}" style="font-size: 0.82rem; font-weight: 700; padding: 5px 14px; border-radius: 20px; text-decoration: none; {{ $categoryFilter === $cat ? 'background: #7c3aed; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                                {{ $cat }}
                            </a>
                        @endforeach
                    </div>

                    <!-- Search Input -->
                    <div style="display: flex; gap: 8px; flex: 1; max-width: 320px;">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search lessons..." style="width: 100%; padding: 0.55rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none;">
                        <button type="submit" style="background: #0f172a; color: #fff; border: none; padding: 0.55rem 1rem; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.88rem;">Search</button>
                    </div>
                </form>
            </div>

            @if($trainings->isEmpty())
                <!-- Empty State -->
                <div style="text-align: center; padding: 4.5rem 1.5rem; background: #ffffff; border-radius: 20px; border: 1.5px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
                    <div style="width: 80px; height: 80px; margin: 0 auto 1.2rem; border-radius: 50%; background: #f8fafc; border: 2px dashed #cbd5e1; display: flex; align-items: center; justify-content: center; font-size: 2.2rem;">
                        🎓
                    </div>
                    <h3 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0 0 0.5rem;">
                        No Training Lessons Found
                    </h3>
                    <p style="color: #64748b; font-size: 0.92rem; max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.6;">
                        No training masterclasses match your current search. Try resetting filters to explore all training modules.
                    </p>
                    <a href="{{ url('/affiliate-training') }}" style="background: #7c3aed; color: #ffffff; font-weight: 700; padding: 10px 22px; border-radius: 8px; text-decoration: none; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 6px;">
                        <span>View All Lessons</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            @else
                <!-- Active Video Theater (If Active Training Selected) -->
                @if($activeTraining)
                    <div id="videoPlayerTheater" style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 20px; overflow: hidden; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.04);">
                        <!-- 16:9 YouTube Embed Container -->
                        <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; background: #000;">
                            <iframe 
                                src="{{ $activeTraining->embed_url }}" 
                                title="{{ $activeTraining->title }}" 
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen
                            ></iframe>
                        </div>

                        <!-- Video Metadata & Description -->
                        <div style="padding: 1.6rem 1.8rem;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 0.8rem;">
                                <div>
                                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                                        @if(!empty($activeTraining->badge))
                                            <span style="background: rgba(124, 58, 237, 0.12); color: #7c3aed; font-size: 0.75rem; font-weight: 800; padding: 3px 10px; border-radius: 20px;">
                                                {{ $activeTraining->badge }}
                                            </span>
                                        @endif
                                        <span style="background: #f1f5f9; color: #475569; font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 20px;">
                                            {{ $activeTraining->category }}
                                        </span>
                                        @if(!empty($activeTraining->duration))
                                            <span style="color: #64748b; font-size: 0.8rem; font-weight: 600;">
                                                ⏱️ {{ $activeTraining->duration }}
                                            </span>
                                        @endif
                                    </div>
                                    <h3 style="font-size: 1.4rem; font-weight: 900; color: #0f172a; margin: 0; line-height: 1.3;">
                                        {{ $activeTraining->title }}
                                    </h3>
                                </div>
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <a href="{{ $activeTraining->youtube_url }}" target="_blank" style="background: #fee2e2; color: #ef4444; border: 1px solid #fca5a5; padding: 7px 14px; border-radius: 8px; font-weight: 700; font-size: 0.82rem; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                                        <span>Watch on YouTube</span>
                                        <span>↗</span>
                                    </a>
                                </div>
                            </div>

                            @if(!empty($activeTraining->description))
                                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.1rem 1.3rem; margin-top: 1rem;">
                                    <div style="font-weight: 800; font-size: 0.82rem; color: #475569; text-transform: uppercase; margin-bottom: 4px;">
                                        📌 Masterclass Summary &amp; Action Plan
                                    </div>
                                    <p style="margin: 0; font-size: 0.92rem; color: #334155; line-height: 1.6; white-space: pre-line;">
                                        {{ $activeTraining->description }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Training Curriculum Playlist / Grid -->
                <div style="margin-bottom: 1.2rem; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0;">
                        📚 Complete Masterclass Curriculum ({{ count($trainings) }})
                    </h3>
                    <span style="font-size: 0.82rem; color: #64748b;">Click any lesson to watch</span>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                    @foreach($trainings as $item)
                        @php
                            $isPlaying = ($activeTraining && $activeTraining->id === $item->id);
                        @endphp
                        <a href="{{ url('/affiliate-training?watch='.$item->id.'&category='.$categoryFilter.'&search='.$search) }}#videoPlayerTheater" style="text-decoration: none; color: inherit; display: block;">
                            <div style="background: #ffffff; border: 2px solid {{ $isPlaying ? '#7c3aed' : '#e2e8f0' }}; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; height: 100%; box-shadow: {{ $isPlaying ? '0 8px 24px rgba(124, 58, 237, 0.15)' : '0 4px 14px rgba(0,0,0,0.03)' }}; transition: transform 0.2s ease, border-color 0.2s ease;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                                
                                <!-- Card Thumbnail with YouTube Play Badge -->
                                <div style="position: relative; width: 100%; height: 165px; background: #0f172a; overflow: hidden;">
                                    <img src="{{ $item->photo_url }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                    
                                    <!-- Play Overlay -->
                                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(15, 23, 42, 0.7) 0%, transparent 60%); display: flex; align-items: center; justify-content: center;">
                                        <div style="width: 44px; height: 44px; border-radius: 50%; background: rgba(239, 68, 68, 0.95); color: #fff; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 14px rgba(239, 68, 68, 0.5); font-size: 1.1rem; padding-left: 3px;">
                                            ▶
                                        </div>
                                    </div>

                                    <!-- Top Left Badge -->
                                    <div style="position: absolute; top: 10px; left: 10px; z-index: 2; display: flex; gap: 6px;">
                                        @if(!empty($item->badge))
                                            <span style="background: rgba(124, 58, 237, 0.95); backdrop-filter: blur(4px); color: #fff; font-size: 0.7rem; font-weight: 800; padding: 2px 8px; border-radius: 4px;">
                                                {{ $item->badge }}
                                            </span>
                                        @endif
                                        <span style="background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(4px); color: #cbd5e1; font-size: 0.7rem; font-weight: 700; padding: 2px 8px; border-radius: 4px;">
                                            {{ $item->category }}
                                        </span>
                                    </div>

                                    <!-- Bottom Right Duration -->
                                    @if(!empty($item->duration))
                                        <span style="position: absolute; bottom: 8px; right: 8px; background: rgba(0,0,0,0.8); color: #fff; font-size: 0.72rem; font-weight: 700; padding: 2px 6px; border-radius: 4px;">
                                            ⏱️ {{ $item->duration }}
                                        </span>
                                    @endif

                                    <!-- Playing Status Pill -->
                                    @if($isPlaying)
                                        <span style="position: absolute; bottom: 8px; left: 8px; background: #7c3aed; color: #fff; font-size: 0.72rem; font-weight: 800; padding: 2px 8px; border-radius: 4px;">
                                            ● NOW PLAYING
                                        </span>
                                    @endif
                                </div>

                                <!-- Card Body -->
                                <div style="padding: 1.1rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                                    <div>
                                        <h4 style="font-size: 0.98rem; font-weight: 800; color: #0f172a; margin: 0 0 6px; line-height: 1.35;">
                                            {{ $item->title }}
                                        </h4>
                                        <p style="margin: 0; color: #64748b; font-size: 0.82rem; line-height: 1.45; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                            {{ $item->description }}
                                        </p>
                                    </div>

                                    <div style="margin-top: 1rem; padding-top: 0.8rem; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">
                                            👁️ {{ number_format($item->views_count) }} views
                                        </span>
                                        <span style="font-size: 0.82rem; font-weight: 800; color: {{ $isPlaying ? '#7c3aed' : '#05B396' }}; display: flex; align-items: center; gap: 4px;">
                                            <span>{{ $isPlaying ? 'Playing Now' : 'Watch Now' }}</span>
                                            <span>➔</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </main>
    </div>
</div>

@include('portal.styles')
@endsection
