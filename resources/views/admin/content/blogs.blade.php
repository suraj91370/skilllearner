@extends('layouts.app')

@section('title', 'Blog & Platform Announcements — SkillLearner Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-content-blogs'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-content-blogs'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header Banner -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 class="welcome-heading" style="font-size: 1.6rem; margin-bottom: 0.25rem;">
                        📢 Blog &amp; Platform Announcements
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Publish company announcements, training articles, platform release notes, and success stories.
                    </p>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('blogs.index') }}" target="_blank" style="background: #ffffff; border: 1.5px solid #cbd5e1; color: #334155; padding: 0.65rem 1.1rem; border-radius: 8px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        <span>📰 Public Blogs ↗</span>
                    </a>
                    <button type="button" onclick="openAddBlogModal()" style="background: #05B396; color: #ffffff; border: none; padding: 0.65rem 1.3rem; border-radius: 8px; font-weight: 800; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.35);">
                        <span>+ Write New Announcement</span>
                    </button>
                </div>
            </div>

            <!-- Content Management Tabs Navigation -->
            @include('admin.content.tabs', ['tab' => 'blogs'])

            @if(session('success'))
                <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            <!-- Category Filter Pills -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1rem 1.2rem; margin-bottom: 1.5rem; display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ route('admin.content.blogs', ['category' => 'all']) }}" 
                   style="padding: 0.45rem 1rem; border-radius: 20px; font-size: 0.82rem; font-weight: 700; text-decoration: none; {{ $currentCategory === 'all' ? 'background: #05B396; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                    All Posts
                </a>
                <a href="{{ route('admin.content.blogs', ['category' => 'announcement']) }}" 
                   style="padding: 0.45rem 1rem; border-radius: 20px; font-size: 0.82rem; font-weight: 700; text-decoration: none; {{ $currentCategory === 'announcement' ? 'background: #05B396; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                    📢 Official Announcements
                </a>
                <a href="{{ route('admin.content.blogs', ['category' => 'training']) }}" 
                   style="padding: 0.45rem 1rem; border-radius: 20px; font-size: 0.82rem; font-weight: 700; text-decoration: none; {{ $currentCategory === 'training' ? 'background: #05B396; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                    🎯 Training &amp; Guides
                </a>
                <a href="{{ route('admin.content.blogs', ['category' => 'update']) }}" 
                   style="padding: 0.45rem 1rem; border-radius: 20px; font-size: 0.82rem; font-weight: 700; text-decoration: none; {{ $currentCategory === 'update' ? 'background: #05B396; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                    ⚙️ Platform Updates
                </a>
                <a href="{{ route('admin.content.blogs', ['category' => 'success_story']) }}" 
                   style="padding: 0.45rem 1rem; border-radius: 20px; font-size: 0.82rem; font-weight: 700; text-decoration: none; {{ $currentCategory === 'success_story' ? 'background: #05B396; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                    🏆 Student Success Stories
                </a>
            </div>

            <!-- Blogs Data Table -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden;">
                <div style="padding: 1.2rem 1.6rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0;">
                        Articles &amp; Announcements ({{ $blogs->total() }})
                    </h3>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-size: 0.76rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                <th style="padding: 0.85rem 1.4rem;">Post Details</th>
                                <th style="padding: 0.85rem 1rem;">Category</th>
                                <th style="padding: 0.85rem 1rem;">Author &amp; Date</th>
                                <th style="padding: 0.85rem 1rem;">Views</th>
                                <th style="padding: 0.85rem 1rem;">Status</th>
                                <th style="padding: 0.85rem 1.4rem; text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($blogs as $blog)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#fbfcfe'" onmouseout="this.style.background='transparent'">
                                    <!-- Post Info & Thumbnail -->
                                    <td style="padding: 1rem 1.4rem;">
                                        <div style="display: flex; gap: 12px; align-items: center;">
                                            <img src="{{ $blog->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=120&auto=format&fit=crop&q=80' }}" alt="{{ $blog->title }}" style="width: 60px; height: 42px; border-radius: 6px; object-fit: cover; border: 1px solid #e2e8f0;">
                                            <div>
                                                <div style="display: flex; align-items: center; gap: 6px;">
                                                    <a href="{{ route('blogs.show', $blog->slug) }}" target="_blank" style="font-weight: 800; color: #0f172a; font-size: 0.94rem; text-decoration: none;" onmouseover="this.style.color='#05B396'" onmouseout="this.style.color='#0f172a'">
                                                        {{ $blog->title }}
                                                    </a>
                                                    @if($blog->is_pinned)
                                                        <span style="background: rgba(245, 158, 11, 0.15); color: #b45309; font-size: 0.68rem; font-weight: 800; padding: 2px 6px; border-radius: 4px; text-transform: uppercase;">📌 Pinned</span>
                                                    @endif
                                                </div>
                                                <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">
                                                    Slug: <code>{{ $blog->slug }}</code>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Category Badge -->
                                    <td style="padding: 1rem 1rem;">
                                        <span style="background: #f1f5f9; color: #475569; font-size: 0.74rem; font-weight: 700; padding: 3px 8px; border-radius: 6px; text-transform: uppercase;">
                                            {{ str_replace('_', ' ', $blog->category) }}
                                        </span>
                                    </td>

                                    <!-- Author & Date -->
                                    <td style="padding: 1rem 1rem; font-size: 0.8rem; color: #64748b;">
                                        <div style="font-weight: 700; color: #334155;">{{ $blog->author_name }}</div>
                                        <div>{{ $blog->published_at ? $blog->published_at->format('d M, Y') : 'Draft' }}</div>
                                    </td>

                                    <!-- Views Count -->
                                    <td style="padding: 1rem 1rem; font-size: 0.85rem; font-weight: 700; color: #0f172a;">
                                        👁️ {{ number_format($blog->views_count) }}
                                    </td>

                                    <!-- Status Badge -->
                                    <td style="padding: 1rem 1rem;">
                                        @if($blog->is_published)
                                            <span style="background: #f0fdf4; color: #166534; font-size: 0.74rem; font-weight: 800; padding: 3px 8px; border-radius: 6px; border: 1px solid #bbf7d0;">
                                                🟢 Published
                                            </span>
                                        @else
                                            <span style="background: #fffbeb; color: #b45309; font-size: 0.74rem; font-weight: 800; padding: 3px 8px; border-radius: 6px; border: 1px solid #fde68a;">
                                                ⏳ Draft
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Action Buttons -->
                                    <td style="padding: 1rem 1.4rem; text-align: right;">
                                        <div style="display: inline-flex; align-items: center; gap: 6px; justify-content: flex-end;">
                                            <a href="{{ route('blogs.show', $blog->slug) }}" target="_blank" style="background: #f0fdfa; border: 1px solid #a7f3d0; color: #05B396; font-size: 0.74rem; font-weight: 700; padding: 4px 8px; border-radius: 6px; text-decoration: none;">
                                                View ↗
                                            </a>
                                            <button type="button" 
                                                    onclick="openEditBlogModal({{ $blog->id }}, '{{ addslashes($blog->title) }}', '{{ $blog->category }}', '{{ addslashes($blog->thumbnail ?? '') }}', '{{ addslashes($blog->excerpt ?? '') }}', '{{ addslashes($blog->author_name) }}', {{ $blog->is_published ? 1 : 0 }}, {{ $blog->is_pinned ? 1 : 0 }})"
                                                    style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; font-size: 0.74rem; font-weight: 700; padding: 4px 8px; border-radius: 6px; cursor: pointer;">
                                                Edit
                                            </button>
                                            <form method="POST" action="{{ route('admin.content.blogs.delete', $blog->id) }}" onsubmit="return confirm('Delete this post?');" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background: #fff5f5; border: 1px solid #fecaca; color: #dc2626; font-size: 0.74rem; font-weight: 700; padding: 4px 8px; border-radius: 6px; cursor: pointer;">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="padding: 3rem 1.5rem; text-align: center; color: #64748b;">
                                        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📢</div>
                                        <h4 style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.3rem;">No Announcements or Blogs</h4>
                                        <p style="font-size: 0.88rem; margin: 0;">Click "+ Write New Announcement" above to publish your first post.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($blogs->hasPages())
                    <div style="padding: 1.2rem 1.6rem; border-top: 1px solid #f1f5f9; display: flex; justify-content: center;">
                        {{ $blogs->links() }}
                    </div>
                @endif
            </div>

        </main>
    </div>
</div>

{{-- MODAL: ADD BLOG / ANNOUNCEMENT --}}
<div id="addBlogModal" style="display: none; position: fixed; inset: 0; z-index: 99999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #ffffff; border-radius: 16px; max-width: 620px; width: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden; max-height: 90vh; display: flex; flex-direction: column;">
        <div style="background: #0f172a; padding: 1.2rem 1.5rem; color: #fff; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0;">
            <div style="font-size: 1.05rem; font-weight: 800;">+ Write New Article / Announcement</div>
            <button type="button" onclick="closeAddBlogModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; border-radius: 50%; width: 28px; height: 28px; cursor: pointer;">✕</button>
        </div>

        <form method="POST" action="{{ route('admin.content.blogs.store') }}" style="padding: 1.5rem; overflow-y: auto;">
            @csrf
            
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Post Title *</label>
                <input type="text" name="title" required placeholder="e.g. SkillLearner 2.0 Launch: Instant Payments & New Classroom" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; font-weight: 700; outline: none;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Category *</label>
                    <select name="category" required style="width: 100%; padding: 0.65rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none; background: #fff;">
                        <option value="announcement">📢 Announcement</option>
                        <option value="training">🎯 Training &amp; Guide</option>
                        <option value="update">⚙️ Platform Update</option>
                        <option value="success_story">🏆 Success Story</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Author Name</label>
                    <input type="text" name="author_name" value="SkillLearner Editorial" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none;">
                </div>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Thumbnail Image URL</label>
                <input type="text" name="thumbnail" placeholder="https://images.unsplash.com/..." style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; outline: none;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Short Excerpt / Summary</label>
                <textarea name="excerpt" rows="2" placeholder="Brief 1-2 sentence preview shown on card grids..." style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; outline: none;"></textarea>
            </div>

            <div style="margin-bottom: 1.1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Full Content (Supports HTML) *</label>
                <textarea name="content" rows="6" required placeholder="Write your full article here. HTML tags like <h2>, <p>, <ul>, <li>, <strong> are supported..." style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; line-height: 1.5; outline: none; font-family: monospace;"></textarea>
            </div>

            <div style="display: flex; gap: 16px; margin-bottom: 1.4rem;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 700; color: #334155; cursor: pointer;">
                    <input type="checkbox" name="is_published" value="1" checked style="width: 18px; height: 18px; accent-color: #05B396;">
                    <span>Publish Immediately</span>
                </label>
                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 700; color: #334155; cursor: pointer;">
                    <input type="checkbox" name="is_pinned" value="1" style="width: 18px; height: 18px; accent-color: #f59e0b;">
                    <span>Pin to Top of Blog</span>
                </label>
            </div>

            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                <button type="button" onclick="closeAddBlogModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">Cancel</button>
                <button type="submit" style="background: #05B396; color: #fff; border: none; padding: 0.65rem 1.4rem; border-radius: 8px; font-weight: 800; cursor: pointer;">Publish Post</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: EDIT BLOG / ANNOUNCEMENT --}}
<div id="editBlogModal" style="display: none; position: fixed; inset: 0; z-index: 99999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #ffffff; border-radius: 16px; max-width: 620px; width: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden; max-height: 90vh; display: flex; flex-direction: column;">
        <div style="background: #0f172a; padding: 1.2rem 1.5rem; color: #fff; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0;">
            <div style="font-size: 1.05rem; font-weight: 800;">Edit Article / Announcement</div>
            <button type="button" onclick="closeEditBlogModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; border-radius: 50%; width: 28px; height: 28px; cursor: pointer;">✕</button>
        </div>

        <form id="editBlogForm" method="POST" action="" style="padding: 1.5rem; overflow-y: auto;">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Post Title *</label>
                <input type="text" name="title" id="editBlogTitle" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; font-weight: 700; outline: none;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Category *</label>
                    <select name="category" id="editBlogCategory" required style="width: 100%; padding: 0.65rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none; background: #fff;">
                        <option value="announcement">📢 Announcement</option>
                        <option value="training">🎯 Training &amp; Guide</option>
                        <option value="update">⚙️ Platform Update</option>
                        <option value="success_story">🏆 Success Story</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Author Name</label>
                    <input type="text" name="author_name" id="editBlogAuthor" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none;">
                </div>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Thumbnail Image URL</label>
                <input type="text" name="thumbnail" id="editBlogThumbnail" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; outline: none;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Short Excerpt / Summary</label>
                <textarea name="excerpt" id="editBlogExcerpt" rows="2" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; outline: none;"></textarea>
            </div>

            <div style="margin-bottom: 1.1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Full Content (Supports HTML) *</label>
                <textarea name="content" id="editBlogContent" rows="6" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; line-height: 1.5; outline: none; font-family: monospace;"></textarea>
            </div>

            <div style="display: flex; gap: 16px; margin-bottom: 1.4rem;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 700; color: #334155; cursor: pointer;">
                    <input type="checkbox" name="is_published" id="editBlogPublished" value="1" style="width: 18px; height: 18px; accent-color: #05B396;">
                    <span>Published</span>
                </label>
                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 700; color: #334155; cursor: pointer;">
                    <input type="checkbox" name="is_pinned" id="editBlogPinned" value="1" style="width: 18px; height: 18px; accent-color: #f59e0b;">
                    <span>Pinned to Top</span>
                </label>
            </div>

            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                <button type="button" onclick="closeEditBlogModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">Cancel</button>
                <button type="submit" style="background: #05B396; color: #fff; border: none; padding: 0.65rem 1.4rem; border-radius: 8px; font-weight: 800; cursor: pointer;">Update Post</button>
            </div>
        </form>
    </div>
</div>

@include('portal.styles')

@push('scripts')
<script>
    function openAddBlogModal() {
        document.getElementById('addBlogModal').style.display = 'flex';
    }

    function closeAddBlogModal() {
        document.getElementById('addBlogModal').style.display = 'none';
    }

    function openEditBlogModal(id, title, category, thumbnail, excerpt, author, isPublished, isPinned) {
        document.getElementById('editBlogForm').action = '/admin/content/blogs/' + id;
        document.getElementById('editBlogTitle').value = title;
        document.getElementById('editBlogCategory').value = category;
        document.getElementById('editBlogThumbnail').value = thumbnail;
        document.getElementById('editBlogExcerpt').value = excerpt;
        document.getElementById('editBlogAuthor').value = author;
        document.getElementById('editBlogPublished').checked = (isPublished == 1);
        document.getElementById('editBlogPinned').checked = (isPinned == 1);
        
        // Fetch content if needed or placeholder
        document.getElementById('editBlogContent').value = excerpt;
        document.getElementById('editBlogModal').style.display = 'flex';
    }

    function closeEditBlogModal() {
        document.getElementById('editBlogModal').style.display = 'none';
    }
</script>
@endpush
@endsection

