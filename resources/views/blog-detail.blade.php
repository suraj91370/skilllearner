@extends('layouts.app')

@section('title', $blog->title . ' — SkillLearner Blog')

@section('content')
<section class="container" style="max-width: 900px; padding: 3.5rem 1.5rem 6rem;">
    <!-- Breadcrumb -->
    <div style="margin-bottom: 2rem; font-size: 0.85rem; color: #64748b; display: flex; align-items: center; gap: 8px;">
        <a href="{{ url('/') }}" style="color: #64748b; text-decoration: none;">Home</a>
        <span>/</span>
        <a href="{{ route('blogs.index') }}" style="color: #64748b; text-decoration: none;">Blog &amp; Announcements</a>
        <span>/</span>
        <span style="color: #05B396; font-weight: 700;">{{ Str::limit($blog->title, 40) }}</span>
    </div>

    <!-- Article Header -->
    <div style="margin-bottom: 2.5rem;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 1rem;">
            <span style="background: rgba(5, 179, 150, 0.12); color: #05B396; font-size: 0.78rem; font-weight: 800; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;">
                {{ str_replace('_', ' ', $blog->category) }}
            </span>
            <span style="color: #64748b; font-size: 0.85rem;">{{ $blog->published_at ? $blog->published_at->format('F d, Y') : '' }}</span>
            <span style="color: #cbd5e1;">&bull;</span>
            <span style="color: #64748b; font-size: 0.85rem;">👁️ {{ number_format($blog->views_count) }} views</span>
        </div>

        <h1 style="font-size: clamp(2rem, 4.5vw, 2.9rem); font-weight: 900; color: #0f172a; line-height: 1.25; letter-spacing: -1px; margin-bottom: 1.2rem;">
            {{ $blog->title }}
        </h1>

        <div style="display: flex; align-items: center; gap: 12px; padding: 1rem 0; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9;">
            <div style="width: 44px; height: 44px; border-radius: 50%; background: #05B396; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem;">
                {{ strtoupper(substr($blog->author_name, 0, 1)) }}
            </div>
            <div>
                <div style="font-weight: 800; color: #0f172a; font-size: 0.95rem;">{{ $blog->author_name }}</div>
                <div style="font-size: 0.78rem; color: #64748b;">SkillLearner Official Publisher</div>
            </div>
        </div>
    </div>

    <!-- Hero Image -->
    @if($blog->thumbnail)
        <div style="border-radius: 20px; overflow: hidden; margin-bottom: 2.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.06); max-height: 480px; width: 100%;">
            <img src="{{ $blog->thumbnail }}" alt="{{ $blog->title }}" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
    @endif

    <!-- Article Content -->
    <div class="blog-article-content" style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 20px; padding: 2.5rem 2.8rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03); font-size: 1.05rem; line-height: 1.8; color: #334155;">
        {!! $blog->content !!}
    </div>

    <!-- Share & Navigation -->
    <div style="margin-top: 3rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <a href="{{ route('blogs.index') }}" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; font-size: 0.9rem; font-weight: 700; padding: 0.7rem 1.4rem; border-radius: 8px; text-decoration: none;">
            ← Back to All Announcements
        </a>
        <div style="display: flex; gap: 8px;">
            <a href="https://api.whatsapp.com/send?text={{ urlencode($blog->title . ' ' . request()->url()) }}" target="_blank" style="background: #25d366; color: #fff; font-size: 0.88rem; font-weight: 700; padding: 0.7rem 1.2rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <span>Share on WhatsApp 💬</span>
            </a>
        </div>
    </div>
</section>

@push('styles')
<style>
    .blog-article-content h2 {
        font-size: 1.6rem;
        font-weight: 900;
        color: #0f172a;
        margin: 2rem 0 1rem;
        letter-spacing: -0.5px;
    }
    .blog-article-content h3 {
        font-size: 1.3rem;
        font-weight: 800;
        color: #0f172a;
        margin: 1.8rem 0 0.8rem;
    }
    .blog-article-content p {
        margin-bottom: 1.4rem;
    }
    .blog-article-content ul, .blog-article-content ol {
        margin: 0 0 1.5rem 1.8rem;
        padding: 0;
    }
    .blog-article-content li {
        margin-bottom: 0.6rem;
    }
    .blog-article-content strong {
        color: #0f172a;
    }
</style>
@endpush
@endsection

