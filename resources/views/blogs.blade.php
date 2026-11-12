@extends('layouts.app')

@section('title', 'Blog & Platform Announcements — SkillLearner')

@section('content')
<section class="container" style="max-width: 1200px; padding: 3.5rem 1.5rem 6rem;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 3.5rem;">
        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(5, 179, 150, 0.1); border: 1px solid rgba(5, 179, 150, 0.3); color: #05B396; padding: 6px 18px; border-radius: 50px; font-size: 0.82rem; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 1rem;">
            <span>📢 SKILLLEARNER UPDATES &amp; INSIGHTS</span>
        </div>
        <h1 style="font-size: clamp(2rem, 4vw, 2.8rem); font-weight: 900; color: #0f172a; letter-spacing: -1px; margin-bottom: 0.8rem;">
            Platform Blog &amp; Announcements
        </h1>
        <p style="font-size: 1.05rem; color: #64748b; max-width: 650px; margin: 0 auto; line-height: 1.6;">
            Stay updated with official platform announcements, digital marketing strategies, release notes, and student success stories.
        </p>
    </div>

    <!-- Category Filter Tabs -->
    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-bottom: 3rem;">
        <a href="{{ route('blogs.index', ['category' => 'all']) }}" 
           style="padding: 0.55rem 1.2rem; border-radius: 50px; font-size: 0.88rem; font-weight: 700; text-decoration: none; transition: all 0.2s; {{ $currentCategory === 'all' ? 'background: #05B396; color: #fff; box-shadow: 0 4px 14px rgba(5,179,150,0.35);' : 'background: #ffffff; border: 1.5px solid #e2e8f0; color: #475569;' }}">
            All Posts
        </a>
        <a href="{{ route('blogs.index', ['category' => 'announcement']) }}" 
           style="padding: 0.55rem 1.2rem; border-radius: 50px; font-size: 0.88rem; font-weight: 700; text-decoration: none; transition: all 0.2s; {{ $currentCategory === 'announcement' ? 'background: #05B396; color: #fff; box-shadow: 0 4px 14px rgba(5,179,150,0.35);' : 'background: #ffffff; border: 1.5px solid #e2e8f0; color: #475569;' }}">
            📢 Announcements
        </a>
        <a href="{{ route('blogs.index', ['category' => 'training']) }}" 
           style="padding: 0.55rem 1.2rem; border-radius: 50px; font-size: 0.88rem; font-weight: 700; text-decoration: none; transition: all 0.2s; {{ $currentCategory === 'training' ? 'background: #05B396; color: #fff; box-shadow: 0 4px 14px rgba(5,179,150,0.35);' : 'background: #ffffff; border: 1.5px solid #e2e8f0; color: #475569;' }}">
            🎯 Training &amp; Guides
        </a>
        <a href="{{ route('blogs.index', ['category' => 'update']) }}" 
           style="padding: 0.55rem 1.2rem; border-radius: 50px; font-size: 0.88rem; font-weight: 700; text-decoration: none; transition: all 0.2s; {{ $currentCategory === 'update' ? 'background: #05B396; color: #fff; box-shadow: 0 4px 14px rgba(5,179,150,0.35);' : 'background: #ffffff; border: 1.5px solid #e2e8f0; color: #475569;' }}">
            ⚙️ Updates
        </a>
        <a href="{{ route('blogs.index', ['category' => 'success_story']) }}" 
           style="padding: 0.55rem 1.2rem; border-radius: 50px; font-size: 0.88rem; font-weight: 700; text-decoration: none; transition: all 0.2s; {{ $currentCategory === 'success_story' ? 'background: #05B396; color: #fff; box-shadow: 0 4px 14px rgba(5,179,150,0.35);' : 'background: #ffffff; border: 1.5px solid #e2e8f0; color: #475569;' }}">
            🏆 Success Stories
        </a>
    </div>

    <!-- Pinned / Featured Hero Post (If on first page or all) -->
    @if($pinned && $blogs->currentPage() === 1 && $currentCategory === 'all')
        <div style="background: #ffffff; border: 1.5px solid #a7f3d0; border-radius: 24px; overflow: hidden; box-shadow: 0 15px 35px rgba(5, 179, 150, 0.08); margin-bottom: 3.5rem; display: grid; grid-template-columns: 1.2fr 1fr;" class="admin-two-col-grid">
            <div style="height: 380px; position: relative; overflow: hidden; background: #0f172a;">
                <img src="{{ $pinned->thumbnail }}" alt="{{ $pinned->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                <div style="position: absolute; top: 18px; left: 18px; background: #f59e0b; color: #fff; font-size: 0.75rem; font-weight: 800; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;">
                    📌 FEATURED ANNOUNCEMENT
                </div>
            </div>
            <div style="padding: 2.5rem; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 0.78rem; color: #05B396; font-weight: 800; text-transform: uppercase; margin-bottom: 0.6rem;">
                        <span>{{ str_replace('_', ' ', $pinned->category) }}</span>
                        <span>&bull;</span>
                        <span style="color: #64748b;">{{ $pinned->published_at ? $pinned->published_at->format('M d, Y') : '' }}</span>
                    </div>
                    <h2 style="font-size: 1.7rem; font-weight: 900; color: #0f172a; margin-bottom: 1rem; line-height: 1.3;">
                        <a href="{{ route('blogs.show', $pinned->slug) }}" style="color: inherit; text-decoration: none;">
                            {{ $pinned->title }}
                        </a>
                    </h2>
                    <p style="font-size: 0.95rem; color: #64748b; line-height: 1.6; margin-bottom: 1.5rem;">
                        {{ $pinned->excerpt }}
                    </p>
                </div>
                <div>
                    <a href="{{ route('blogs.show', $pinned->slug) }}" style="background: #05B396; color: #fff; font-weight: 800; font-size: 0.95rem; padding: 0.75rem 1.6rem; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.35);">
                        <span>Read Full Announcement ➔</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Posts Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 2rem;">
        @forelse($blogs as $blog)
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.03); transition: transform 0.25s, box-shadow 0.25s; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.03)';">
                <!-- Thumbnail -->
                <div style="height: 200px; width: 100%; position: relative; overflow: hidden; background: #0f172a;">
                    <img src="{{ $blog->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=80' }}" alt="{{ $blog->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    <span style="position: absolute; top: 12px; left: 12px; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(4px); color: #fff; font-size: 0.72rem; font-weight: 800; padding: 3px 10px; border-radius: 6px; text-transform: uppercase;">
                        {{ str_replace('_', ' ', $blog->category) }}
                    </span>
                </div>

                <!-- Content -->
                <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="font-size: 0.78rem; color: #64748b; margin-bottom: 0.5rem; display: flex; gap: 8px;">
                            <span>{{ $blog->published_at ? $blog->published_at->format('M d, Y') : '' }}</span>
                            <span>&bull;</span>
                            <span>👁️ {{ $blog->views_count }} views</span>
                        </div>
                        <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin-bottom: 0.6rem; line-height: 1.4;">
                            <a href="{{ route('blogs.show', $blog->slug) }}" style="color: inherit; text-decoration: none;" onmouseover="this.style.color='#05B396'" onmouseout="this.style.color='#0f172a'">
                                {{ $blog->title }}
                            </a>
                        </h3>
                        <p style="font-size: 0.88rem; color: #64748b; line-height: 1.5; margin: 0 0 1rem;">
                            {{ Str::limit($blog->excerpt, 120) }}
                        </p>
                    </div>

                    <div style="border-top: 1px solid #f1f5f9; padding-top: 0.8rem; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.8rem; font-weight: 700; color: #334155;">{{ $blog->author_name }}</span>
                        <a href="{{ route('blogs.show', $blog->slug) }}" style="color: #05B396; font-size: 0.85rem; font-weight: 800; text-decoration: none;">
                            Read More ➔
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 4rem 1.5rem; text-align: center; color: #64748b;">
                <div style="font-size: 2.8rem; margin-bottom: 0.5rem;">📢</div>
                <h4 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin-bottom: 0.4rem;">No Posts Found</h4>
                <p style="font-size: 0.95rem; margin: 0;">Stay tuned! New announcements and training articles will be posted soon.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($blogs->hasPages())
        <div style="margin-top: 3.5rem; display: flex; justify-content: center;">
            {{ $blogs->links() }}
        </div>
    @endif
</section>
@endsection

