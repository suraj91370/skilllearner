@extends('layouts.app')

@section('title', 'Classroom & Video LMS — CareerFixx')

@section('content')
<section class="container">
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <span style="background: rgba(99, 102, 241, 0.2); color: #818cf8; padding: 4px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: 700;">LMS CLASSROOM</span>
            <h2 id="activeLessonTitle" style="font-size: 1.8rem; margin-top: 0.4rem;">01. Introduction to High-Ticket Affiliate Funnels</h2>
        </div>
        <button onclick="alert('🏆 Certificate Generated! \nIssued to: {{ session('user.name', 'Suraj Sharma') }}\nCourse: Affiliate Mastery\nStatus: 100% Completed')" class="btn btn-secondary">
            📜 Claim Course Certificate
        </button>
    </div>

    <div style="display: grid; grid-template-columns: 2.2fr 1fr; gap: 2rem;">
        <div>
            <!-- Video Container with Moving Anti-Piracy Watermark -->
            <div class="player-container" style="position: relative; background: #000; border-radius: var(--radius-md); overflow: hidden; aspect-ratio: 16 / 9; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6); border: 1px solid var(--border-glass);">
                <video id="videoPlayer" controls poster="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200&q=80" style="width: 100%; height: 100%; object-fit: cover;">
                    <source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4" type="video/mp4">
                </video>
                <!-- Dynamic Moving DRM Watermark -->
                <div id="drmWatermark" class="floating-watermark" style="position: absolute; top: 20px; left: 20px; color: rgba(255, 255, 255, 0.25); font-weight: 700; font-size: 0.95rem; pointer-events: none; text-shadow: 0 0 4px rgba(0, 0, 0, 0.9); z-index: 50; transition: all 1.8s ease-in-out;">
                    CFX • {{ session('user.email', 'suraj@example.com') }} • {{ session('user.phone', '+91 98765 43210') }}
                </div>
            </div>

            <div class="glass" style="margin-top: 1.5rem; padding: 1.8rem; border-radius: var(--radius-md);">
                <h4 style="margin-bottom: 0.6rem;">Lesson Overview & Resources</h4>
                <p style="color: var(--text-body); font-size: 0.95rem; margin-bottom: 1rem;">Learn the exact system used by top affiliates to close ₹20,000+ per week directly from organic social media traffic without paid ads.</p>
                <button onclick="alert('Download started: Affiliate_Blueprint_PDF.zip')" class="btn btn-secondary" style="font-size: 0.85rem;">
                    📥 Download Lesson PDF & Scripts
                </button>
            </div>
        </div>

        <!-- Playlist (Visible Videos Only) -->
        <div class="glass" style="padding: 1.4rem; border-radius: var(--radius-md); height: fit-content;">
            <h4 style="margin-bottom: 1rem; font-size: 1.05rem;">
                Course Lessons @if(isset($videos)) ({{ count($videos) }} Available) @endif
            </h4>
            <div style="display: flex; flex-direction: column; gap: 0.6rem;">
                @if(isset($videos) && count($videos) > 0)
                    @foreach($videos as $v)
                        <button onclick="changeLesson('{{ addslashes($v->title) }}', '{{ $v->video_url }}')" class="btn btn-secondary" style="text-align: left; justify-content: flex-start; font-size: 0.85rem; display: flex; align-items: center; justify-content: space-between;">
                            <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 220px;">
                                ▶ {{ $v->title }}
                            </span>
                            <span style="font-size: 0.72rem; color: #94a3b8; font-weight: 600;">{{ $v->duration }}</span>
                        </button>
                    @endforeach
                @else
                    <button onclick="changeLesson('01. Introduction to High-Ticket Affiliate Funnels', 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4')" class="btn btn-secondary" style="text-align: left; justify-content: flex-start; font-size: 0.85rem;">
                        ▶ 01. High-Ticket Funnel Intro
                    </button>
                    <button onclick="changeLesson('02. Setting Up an Instagram Bio That Converts', 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4')" class="btn btn-secondary" style="text-align: left; justify-content: flex-start; font-size: 0.85rem;">
                        ▶ 02. Instagram Bio Optimization
                    </button>
                    <button onclick="changeLesson('03. The 30-Second Reel Script Formula', 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4')" class="btn btn-secondary" style="text-align: left; justify-content: flex-start; font-size: 0.85rem;">
                        ▶ 03. Viral 30-Sec Reel Script
                    </button>
                    <button onclick="changeLesson('04. WhatsApp DM Closing Scripts for Beginners', 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4')" class="btn btn-secondary" style="text-align: left; justify-content: flex-start; font-size: 0.85rem;">
                        ▶ 04. DM Closing Scripts
                    </button>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function changeLesson(title, url) {
        document.getElementById('activeLessonTitle').innerText = title;
        const video = document.getElementById('videoPlayer');
        video.src = url;
        video.play();
    }

    // Moving watermark animation (Gumlet DRM simulation)
    const watermark = document.getElementById('drmWatermark');
    const container = document.querySelector('.player-container');
    if (watermark && container) {
        setInterval(() => {
            const maxX = container.clientWidth - watermark.clientWidth - 40;
            const maxY = container.clientHeight - watermark.clientHeight - 40;
            const randX = Math.max(10, Math.floor(Math.random() * maxX));
            const randY = Math.max(10, Math.floor(Math.random() * maxY));
            watermark.style.left = randX + 'px';
            watermark.style.top = randY + 'px';
        }, 4000);
    }
</script>
@endpush
