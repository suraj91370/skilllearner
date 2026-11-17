@extends('layouts.app')

@section('title', 'Official Affiliate Marketing Kit & Creatives — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'marketing'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'marketing'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header Banner -->
            <div class="portal-box-card" style="background: linear-gradient(135deg, #0f172a 0%, #0A6B5C 100%); color: #ffffff; padding: 2rem 2.2rem; border-radius: 20px; margin-bottom: 1.8rem; box-shadow: 0 10px 30px rgba(10, 107, 92, 0.2); position: relative; overflow: hidden;">
                <div style="position: absolute; right: -20px; top: -30px; font-size: 8rem; opacity: 0.08; pointer-events: none;">🚀</div>
                <div style="position: relative; z-index: 2; max-width: 720px;">
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(5, 179, 150, 0.25); border: 1px solid rgba(5, 179, 150, 0.4); color: #2dd4bf; font-size: 0.78rem; font-weight: 800; padding: 4px 12px; border-radius: 50px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.8rem;">
                        <span>🎨 AFFILIATE GROWTH SUITE</span>
                    </div>
                    <h2 style="font-size: clamp(1.5rem, 3.5vw, 2.2rem); font-weight: 900; margin: 0 0 0.5rem; letter-spacing: -0.5px; line-height: 1.25;">
                        Official Marketing Kit &amp; Viral Creatives
                    </h2>
                    <p style="font-size: 0.98rem; opacity: 0.9; line-height: 1.6; margin: 0 0 1.2rem; color: #e2e8f0;">
                        Download high-converting 9:16 short videos, reels, WhatsApp story flyers, and HD promotional posters. Copy ready-made captions and post directly on Instagram, YouTube Shorts, and WhatsApp to maximize your affiliate commissions!
                    </p>
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap; font-size: 0.85rem; font-weight: 700;">
                        <div style="display: flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.12); padding: 5px 12px; border-radius: 8px;">
                            <span>🎥 {{ $counts['video'] }} Short Videos &amp; Reels</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.12); padding: 5px 12px; border-radius: 8px;">
                            <span>🖼️ {{ $counts['photo'] }} HD Posters &amp; Banners</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters & Search Toolbar -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.2rem 1.4rem; margin-bottom: 1.8rem; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                <form method="GET" action="{{ url('/marketing-tool') }}" style="display: flex; flex-direction: column; gap: 1rem;">
                    <!-- Top Row: Type Pills & Search -->
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                        <!-- Type Filter Pills -->
                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            <a href="{{ url('/marketing-tool?type=all&category='.$categoryFilter) }}" class="admin-filter-pill {{ $typeFilter === 'all' ? 'active' : '' }}" style="{{ $typeFilter === 'all' ? 'background: #0f172a; border-color: #0f172a; color: #fff;' : '' }}">
                                All Assets ({{ $counts['all'] }})
                            </a>
                            <a href="{{ url('/marketing-tool?type=video&category='.$categoryFilter) }}" class="admin-filter-pill {{ $typeFilter === 'video' ? 'active' : '' }}" style="{{ $typeFilter === 'video' ? 'background: #7c3aed; border-color: #7c3aed; color: #fff;' : '' }}">
                                🎥 Short Videos &amp; Reels ({{ $counts['video'] }})
                            </a>
                            <a href="{{ url('/marketing-tool?type=photo&category='.$categoryFilter) }}" class="admin-filter-pill {{ $typeFilter === 'photo' ? 'active' : '' }}" style="{{ $typeFilter === 'photo' ? 'background: #05B396; border-color: #05B396; color: #fff;' : '' }}">
                                🖼️ Photos &amp; Posters ({{ $counts['photo'] }})
                            </a>
                        </div>

                        <!-- Search Box -->
                        <div style="display: flex; gap: 8px; flex: 1; max-width: 320px;">
                            <input type="text" name="search" value="{{ $search }}" placeholder="Search marketing assets..." style="width: 100%; padding: 0.55rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none;">
                            <input type="hidden" name="type" value="{{ $typeFilter }}">
                            <input type="hidden" name="category" value="{{ $categoryFilter }}">
                            <button type="submit" style="background: #05B396; color: #fff; border: none; padding: 0.55rem 1rem; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.88rem;">Search</button>
                        </div>
                    </div>

                    <!-- Bottom Row: Category Chips (if any exist) -->
                    @if($categories->count() > 0)
                        <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap; padding-top: 0.8rem; border-top: 1px dashed #e2e8f0;">
                            <span style="font-size: 0.78rem; font-weight: 800; color: #64748b; text-transform: uppercase; margin-right: 4px;">CATEGORY:</span>
                            <a href="{{ url('/marketing-tool?type='.$typeFilter.'&category=all&search='.$search) }}" style="font-size: 0.8rem; font-weight: 700; padding: 4px 12px; border-radius: 20px; text-decoration: none; {{ $categoryFilter === 'all' ? 'background: #05B396; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                                All Categories
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ url('/marketing-tool?type='.$typeFilter.'&category='.urlencode($cat).'&search='.$search) }}" style="font-size: 0.8rem; font-weight: 700; padding: 4px 12px; border-radius: 20px; text-decoration: none; {{ $categoryFilter === $cat ? 'background: #05B396; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                                    {{ $cat }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </form>
            </div>

            <!-- Marketing Assets Grid -->
            @if($tools->isEmpty())
                <div style="text-align: center; padding: 4.5rem 1.5rem; background: #ffffff; border-radius: 20px; border: 1.5px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
                    <div style="width: 80px; height: 80px; margin: 0 auto 1.2rem; border-radius: 50%; background: #f8fafc; border: 2px dashed #cbd5e1; display: flex; align-items: center; justify-content: center; font-size: 2.2rem;">
                        🎨
                    </div>
                    <h3 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0 0 0.5rem;">
                        No Marketing Assets Found
                    </h3>
                    <p style="color: #64748b; font-size: 0.92rem; max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.6;">
                        No promotional tools match your current filter. Try resetting your search or view all assets.
                    </p>
                    <a href="{{ url('/marketing-tool') }}" style="background: #05B396; color: #ffffff; font-weight: 700; padding: 10px 22px; border-radius: 8px; text-decoration: none; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 6px;">
                        <span>View All Assets</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            @else
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap: 1.8rem; margin-bottom: 2rem;">
                    @foreach ($tools as $tool)
                        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 6px 20px rgba(0,0,0,0.03); transition: transform 0.2s ease, box-shadow 0.2s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.03)';">
                            
                            <!-- Media Preview Header -->
                            <div>
                                @if($tool->type === 'video')
                                    <!-- Video Player Reel Container -->
                                    <div style="position: relative; width: 100%; height: 320px; background: #090d16; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                        <video 
                                            controls 
                                            playsinline 
                                            preload="metadata" 
                                            poster="{{ $tool->thumb_url }}" 
                                            style="width: 100%; height: 100%; object-fit: contain; outline: none;"
                                        >
                                            <source src="{{ $tool->asset_url }}" type="video/mp4">
                                            Your browser does not support HTML5 video.
                                        </video>
                                        
                                        <!-- Top Reel Badge -->
                                        <div style="position: absolute; top: 10px; left: 10px; pointer-events: none; z-index: 2; display: flex; gap: 6px;">
                                            <span style="background: rgba(124, 58, 237, 0.9); backdrop-filter: blur(4px); color: #fff; font-size: 0.72rem; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
                                                🎥 REEL
                                            </span>
                                            <span style="background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(4px); color: #cbd5e1; font-size: 0.72rem; font-weight: 700; padding: 3px 8px; border-radius: 6px;">
                                                {{ $tool->category }}
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <!-- Photo / Poster Image Container -->
                                    <div style="position: relative; width: 100%; height: 260px; background: #f8fafc; overflow: hidden;">
                                        <img src="{{ $tool->asset_url ?: $tool->thumb_url }}" alt="{{ $tool->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                                        
                                        <!-- Top Photo Badge -->
                                        <div style="position: absolute; top: 10px; left: 10px; z-index: 2; display: flex; gap: 6px;">
                                            <span style="background: rgba(5, 179, 150, 0.95); backdrop-filter: blur(4px); color: #fff; font-size: 0.72rem; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
                                                🖼️ POSTER
                                            </span>
                                            <span style="background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(4px); color: #cbd5e1; font-size: 0.72rem; font-weight: 700; padding: 3px 8px; border-radius: 6px;">
                                                {{ $tool->category }}
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                <!-- Body Details -->
                                <div style="padding: 1.3rem 1.4rem 0.8rem;">
                                    <h4 style="font-size: 1.05rem; font-weight: 800; color: #0f172a; margin: 0 0 8px; line-height: 1.4;">
                                        {{ $tool->title }}
                                    </h4>

                                    @if(!empty($tool->description))
                                        <!-- Caption Box with Copy Button -->
                                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 0.85rem; margin-top: 10px; position: relative;">
                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                                <span style="font-size: 0.72rem; font-weight: 800; color: #64748b; text-transform: uppercase;">
                                                    📝 Social Media Caption
                                                </span>
                                                <button type="button" onclick="copyCaption(this, `{{ addslashes($tool->description) }}`)" style="background: #ffffff; border: 1px solid #cbd5e1; color: #0f172a; font-size: 0.72rem; font-weight: 800; padding: 2px 8px; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                                    <span>📋 Copy</span>
                                                </button>
                                            </div>
                                            <p style="margin: 0; font-size: 0.8rem; color: #475569; line-height: 1.45; white-space: pre-line; max-height: 70px; overflow-y: auto;">{{ $tool->description }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Card Footer: 1-Click Download Button -->
                            <div style="padding: 1rem 1.4rem 1.3rem; border-top: 1px solid #f1f5f9; display: flex; flex-direction: column; gap: 8px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.78rem; color: #94a3b8; font-weight: 600;">
                                    <span>📥 {{ number_format($tool->download_count) }} downloads</span>
                                    <span>{{ strtoupper($tool->type) }}</span>
                                </div>

                                <a href="{{ route('portal.marketing.download', $tool) }}" style="background: {{ $tool->type === 'video' ? 'linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%)' : 'linear-gradient(135deg, #05B396 0%, #0A6B5C 100%)' }}; color: #ffffff; padding: 0.7rem 1rem; border-radius: 10px; font-weight: 800; font-size: 0.88rem; text-decoration: none; text-align: center; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px {{ $tool->type === 'video' ? 'rgba(124, 58, 237, 0.3)' : 'rgba(5, 179, 150, 0.25)' }}; transition: all 0.2s ease;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                    <span>Download {{ $tool->type === 'video' ? 'Short Video / Reel' : 'HD Photo / Poster' }}</span>
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($tools->hasPages())
                    <div style="display: flex; justify-content: center; margin-top: 2rem;">
                        {{ $tools->links() }}
                    </div>
                @endif
            @endif
        </main>
    </div>
</div>

<!-- Copy Feedback Toast -->
<div id="copyToast" style="display: none; position: fixed; bottom: 24px; right: 24px; z-index: 9999; background: #0f172a; color: #ffffff; padding: 0.85rem 1.4rem; border-radius: 10px; font-weight: 700; font-size: 0.88rem; border-left: 4px solid #05B396; box-shadow: 0 10px 30px rgba(0,0,0,0.3); align-items: center; gap: 8px;">
    <span>✅</span>
    <span>Caption copied to clipboard! Ready to paste.</span>
</div>

@push('scripts')
<script>
    function copyCaption(btn, text) {
        if (!navigator.clipboard) {
            const el = document.createElement('textarea');
            el.value = text;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
        } else {
            navigator.clipboard.writeText(text);
        }

        const originalText = btn.innerHTML;
        btn.innerHTML = '<span>✅ Copied!</span>';
        btn.style.background = '#05B396';
        btn.style.color = '#fff';
        btn.style.borderColor = '#05B396';

        const toast = document.getElementById('copyToast');
        if (toast) {
            toast.style.display = 'flex';
            setTimeout(() => {
                toast.style.display = 'none';
            }, 3000);
        }

        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.style.background = '#ffffff';
            btn.style.color = '#0f172a';
            btn.style.borderColor = '#cbd5e1';
        }, 2000);
    }
</script>
@endpush

@include('portal.styles')
@endsection
