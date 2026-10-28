@extends('layouts.app')

@section('title', 'Video Masterclasses — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'videos'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'videos'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header Banner -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem;">
                <div>
                    <span style="background: rgba(5, 179, 150, 0.12); color: #05B396; font-size: 0.75rem; font-weight: 800; padding: 3px 10px; border-radius: 20px; display: inline-block; margin-bottom: 0.4rem;">
                        🎓 SKILL MASTERCLASSES &amp; LESSONS
                    </span>
                    <h2 class="welcome-heading" style="font-size: clamp(1.2rem, 4.5vw, 1.6rem); word-break: break-word; overflow-wrap: anywhere; margin-bottom: 0.25rem;">
                        🎥 Video Training &amp; Masterclasses
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        High-definition practical video lessons and expert recorded sessions curated for your success.
                    </p>
                </div>
            </div>

            @if($videos->isEmpty())
                <!-- Empty State (e.g. When Super Admin hides all videos) -->
                <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 3.5rem 2rem; text-align: center; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);">
                    <div style="font-size: 3rem; margin-bottom: 0.8rem;">🔒</div>
                    <h3 style="font-size: 1.3rem; font-weight: 800; color: #0f172a; margin-bottom: 0.4rem;">
                        No Videos Currently Available
                    </h3>
                    <p style="font-size: 0.92rem; color: #64748b; max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.5;">
                        Video masterclasses are currently being updated by the administration or scheduled for future release. Please check back shortly!
                    </p>
                    <a href="{{ url('/my-courses') }}" class="btn btn-primary" style="background: #05B396; font-weight: 700; padding: 0.65rem 1.4rem; border-radius: 8px; text-decoration: none; font-size: 0.88rem;">
                        Go to My Courses ➔
                    </a>
                </div>
            @else
                <!-- Category Filter Pills -->
                @if($categories->isNotEmpty())
                    <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 1.5rem;">
                        <a href="{{ url('/videos') }}" class="filter-pill {{ $currentCategory === 'all' ? 'active' : '' }}" style="text-decoration: none;">
                            All Masterclasses ({{ count($videos) }})
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ url('/videos?category=' . urlencode($cat)) }}" class="filter-pill {{ $currentCategory === $cat ? 'active' : '' }}" style="text-decoration: none;">
                                {{ $cat }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <!-- Active Theater Stage & Playlist Layout -->
                <div style="display: grid; grid-template-columns: 2.2fr 1fr; gap: 1.8rem;" class="video-theater-grid">
                    <!-- Left: Main Video Player -->
                    <div>
                        @if($activeVideo)
                            <div class="player-container" style="position: relative; background: #000; border-radius: 16px; overflow: hidden; aspect-ratio: 16 / 9; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.25); border: 1.5px solid #e2e8f0;">
                                @if($activeVideo->is_iframe)
                                    <iframe id="mainIframePlayer" src="{{ $activeVideo->embed_url }}" style="width: 100%; height: 100%; border: none;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                @else
                                    <video id="mainVideoPlayer" controls poster="{{ $activeVideo->thumbnail_url ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200' }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        <source src="{{ $activeVideo->video_url }}" type="video/mp4">
                                        Your browser does not support HTML5 video.
                                    </video>
                                @endif

                                <!-- Anti-Piracy Floating Watermark (Identity Protection) -->
                                <div id="portalDrmWatermark" style="position: absolute; top: 16px; left: 16px; color: rgba(255, 255, 255, 0.35); font-weight: 800; font-size: 0.82rem; pointer-events: none; text-shadow: 0 0 4px rgba(0, 0, 0, 0.9); z-index: 40; transition: all 2s ease-in-out;">
                                    SKILLLEARNER • {{ session('user.name', 'Student') }} • {{ session('user.affiliate_id', 'SL-USER') }}
                                </div>
                            </div>

                            <!-- Video Information Card -->
                            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.6rem; margin-top: 1.2rem; box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 0.8rem;">
                                    <div>
                                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 0.4rem;">
                                            <span style="background: rgba(5, 179, 150, 0.1); color: #05B396; font-size: 0.74rem; font-weight: 800; padding: 2px 8px; border-radius: 4px;">
                                                {{ $activeVideo->category }}
                                            </span>
                                            @if($activeVideo->badge)
                                                <span style="background: rgba(124, 58, 237, 0.1); color: #7c3aed; font-size: 0.74rem; font-weight: 800; padding: 2px 8px; border-radius: 4px;">
                                                    ⭐ {{ $activeVideo->badge }}
                                                </span>
                                            @endif
                                            <span style="font-size: 0.76rem; color: #64748b;">
                                                ⏱️ {{ $activeVideo->duration ?: '15m' }}
                                            </span>
                                            <span style="font-size: 0.76rem; color: #64748b;">
                                                👁️ {{ number_format($activeVideo->views_count) }} views
                                            </span>
                                        </div>
                                        <h3 id="nowPlayingTitle" style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0 0 0.5rem;">
                                            {{ $activeVideo->title }}
                                        </h3>
                                    </div>
                                    <button onclick="shareVideo('{{ $activeVideo->title }}')" class="btn btn-secondary" style="font-size: 0.82rem; padding: 0.5rem 1rem;">
                                        🔗 Share Link
                                    </button>
                                </div>

                                <p id="nowPlayingDesc" style="color: #64748b; font-size: 0.92rem; line-height: 1.5; margin: 0;">
                                    {{ $activeVideo->description ?: 'Watch this comprehensive masterclass video to sharpen your high-ticket digital skills and scaling strategies.' }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Right: Up Next Playlist (Visible Videos) -->
                    <div>
                        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.3rem; box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02); height: fit-content;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.75rem;">
                                <h4 style="font-size: 1.05rem; font-weight: 800; color: #0f172a; margin: 0;">
                                    Course Videos ({{ count($videos) }})
                                </h4>
                                <span style="font-size: 0.75rem; color: #05B396; font-weight: 700;">
                                    ✓ All Visible
                                </span>
                            </div>

                            <div style="display: flex; flex-direction: column; gap: 0.8rem; max-height: 600px; overflow-y: auto; padding-right: 4px;">
                                @foreach($videos as $vid)
                                    @php
                                        $isPlaying = ($activeVideo && $activeVideo->id === $vid->id);
                                    @endphp
                                    <a href="{{ url('/videos?v=' . $vid->id . ($currentCategory !== 'all' ? '&category=' . urlencode($currentCategory) : '')) }}" 
                                       style="display: flex; gap: 10px; align-items: center; padding: 0.65rem; border-radius: 10px; text-decoration: none; border: 1.5px solid {{ $isPlaying ? '#05B396' : 'transparent' }}; background: {{ $isPlaying ? '#f0fdfa' : '#f8fafc' }}; transition: all 0.2s ease;">
                                        <!-- Mini Thumb -->
                                        <div style="position: relative; width: 72px; height: 46px; border-radius: 6px; overflow: hidden; background: #000; flex-shrink: 0;">
                                            <img src="{{ $vid->thumbnail_url ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=200' }}" alt="{{ $vid->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="{{ $isPlaying ? '#05B396' : '#ffffff' }}">
                                                    <polygon points="6,3 20,12 6,21"></polygon>
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Title & Meta -->
                                        <div style="flex: 1; min-width: 0;">
                                            <div style="font-size: 0.84rem; font-weight: 800; color: {{ $isPlaying ? '#05B396' : '#0f172a' }}; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 2px;">
                                                {{ $vid->title }}
                                            </div>
                                            <div style="font-size: 0.72rem; color: #64748b; display: flex; gap: 6px;">
                                                <span>{{ $vid->duration ?: '15m' }}</span>
                                                <span>•</span>
                                                <span>{{ $vid->category }}</span>
                                            </div>
                                        </div>

                                        @if($isPlaying)
                                            <span style="font-size: 0.7rem; font-weight: 800; color: #05B396; background: rgba(5,179,150,0.15); padding: 2px 6px; border-radius: 4px;">
                                                PLAYING
                                            </span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </main>
    </div>
</div>

@push('styles')
<style>
    @media (max-width: 900px) {
        .video-theater-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Moving DRM Watermark animation
    const wm = document.getElementById('portalDrmWatermark');
    const playerBox = document.querySelector('.player-container');
    if (wm && playerBox) {
        setInterval(() => {
            const maxX = playerBox.clientWidth - wm.clientWidth - 40;
            const maxY = playerBox.clientHeight - wm.clientHeight - 40;
            const randX = Math.max(10, Math.floor(Math.random() * maxX));
            const randY = Math.max(10, Math.floor(Math.random() * maxY));
            wm.style.left = randX + 'px';
            wm.style.top = randY + 'px';
        }, 4000);
    }

    function shareVideo(title) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(window.location.href);
            alert('🔗 Direct video link copied to clipboard!\n"' + title + '"');
        } else {
            alert('Video link: ' + window.location.href);
        }
    }
</script>
@endpush
@endsection
