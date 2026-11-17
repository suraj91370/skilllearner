@extends('layouts.app')

@section('title', 'Affiliate Training Management — SkillLearner Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-training'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-training'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header & Action Row -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(124, 58, 237, 0.12); color: #7c3aed; font-size: 0.75rem; font-weight: 800; padding: 3px 10px; border-radius: 20px; margin-bottom: 0.4rem;">
                        🎓 AFFILIATE CURRICULUM MANAGEMENT
                    </div>
                    <h2 class="welcome-heading" style="font-size: clamp(1.2rem, 4.5vw, 1.6rem); word-break: break-word; overflow-wrap: anywhere; margin-bottom: 0.25rem;">
                        Affiliate Training Masterclasses
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Upload YouTube video links and photos/thumbnails for affiliate training modules. Create, edit, and organize lessons.
                    </p>
                </div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="{{ url('/affiliate-training') }}" target="_blank" style="background: #ffffff; color: #7c3aed; border: 1.5px solid #7c3aed; padding: 0.75rem 1.2rem; border-radius: 10px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 0.9rem; box-shadow: 0 2px 8px rgba(124,58,237,0.12);">
                        <span>View Student Training</span>
                        <span>↗</span>
                    </a>
                    <button type="button" onclick="openAddTrainingModal()" style="background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%); color: #ffffff; border: none; padding: 0.75rem 1.4rem; border-radius: 10px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 16px rgba(124, 58, 237, 0.35); font-size: 0.92rem; transition: transform 0.15s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add Training Lesson</span>
                    </button>
                </div>
            </div>

            <!-- Flash Notifications -->
            @if(session('success'))
                <div id="flashSuccess" style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            <!-- Stat Cards Grid -->
            <div class="admin-stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.8rem;">
                <!-- Total Lessons -->
                <div class="admin-stat-card">
                    <div class="admin-stat-label">TOTAL TRAINING MODULES</div>
                    <div class="admin-stat-val">{{ $counts['total'] }}</div>
                    <div class="admin-stat-sub">Across all step curricula</div>
                </div>

                <!-- Active Lessons -->
                <div class="admin-stat-card" style="border-top: 3px solid #05B396;">
                    <div class="admin-stat-label" style="color: #05B396;">👁️ ACTIVE &amp; VISIBLE</div>
                    <div class="admin-stat-val" style="color: #05B396;">{{ $counts['active'] }}</div>
                    <div class="admin-stat-sub">Students can watch &amp; learn</div>
                </div>

                <!-- Hidden Lessons -->
                <div class="admin-stat-card" style="border-top: 3px solid #f59e0b;">
                    <div class="admin-stat-label" style="color: #d97706;">🙈 HIDDEN MODULES</div>
                    <div class="admin-stat-val" style="color: #d97706;">{{ $counts['hidden'] }}</div>
                    <div class="admin-stat-sub">Drafted or unpublished</div>
                </div>

                <!-- Total Views -->
                <div class="admin-stat-card" style="border-top: 3px solid #7c3aed;">
                    <div class="admin-stat-label" style="color: #7c3aed;">📺 TOTAL STUDENT VIEWS</div>
                    <div class="admin-stat-val" style="color: #7c3aed;">{{ number_format($counts['views']) }}</div>
                    <div class="admin-stat-sub">Cumulative masterclass views</div>
                </div>
            </div>

            <!-- Filters & Search Toolbar -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.2rem; margin-bottom: 1.5rem;">
                <form method="GET" action="{{ url('/admin/affiliate-training') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; justify-content: space-between;">
                    <!-- Filter Pills -->
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <a href="{{ url('/admin/affiliate-training') }}" class="admin-filter-pill {{ $statusFilter === 'all' ? 'active' : '' }}">
                            All Lessons ({{ $counts['total'] }})
                        </a>
                        <a href="{{ url('/admin/affiliate-training?status=active') }}" class="admin-filter-pill {{ $statusFilter === 'active' ? 'active' : '' }}" style="{{ $statusFilter === 'active' ? 'background: #05B396; border-color: #05B396; color: #fff;' : '' }}">
                            Active ({{ $counts['active'] }})
                        </a>
                        <a href="{{ url('/admin/affiliate-training?status=hidden') }}" class="admin-filter-pill {{ $statusFilter === 'hidden' ? 'active' : '' }}" style="{{ $statusFilter === 'hidden' ? 'background: #f59e0b; border-color: #f59e0b; color: #fff;' : '' }}">
                            Hidden ({{ $counts['hidden'] }})
                        </a>
                    </div>

                    <!-- Search Input -->
                    <div style="display: flex; gap: 8px; flex: 1; max-width: 340px;">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search title, category, badge..." style="width: 100%; padding: 0.55rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none;">
                        <button type="submit" style="background: #0f172a; color: #fff; border: none; padding: 0.55rem 1rem; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.88rem;">Search</button>
                    </div>
                </form>
            </div>

            <!-- Trainings Table Card -->
            <div class="admin-table-wrapper" style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); overflow: hidden;">
                <div style="padding: 1.2rem 1.6rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.8rem;">
                    <div>
                        <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0;">
                            Affiliate Curriculum Lessons ({{ $trainings->total() }})
                        </h3>
                        <span style="font-size: 0.8rem; color: #64748b;">
                            Manage YouTube video embeds and photo thumbnails. Use the switch to publish or hide lessons.
                        </span>
                    </div>
                </div>

                @if($trainings->isEmpty())
                    <div style="padding: 3.5rem 1.5rem; text-align: center;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🎓</div>
                        <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0 0 0.5rem;">No Training Lessons Found</h3>
                        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1.2rem;">Add your first affiliate training YouTube video and photo link.</p>
                        <button type="button" onclick="openAddTrainingModal()" style="background: #7c3aed; color: #fff; border: none; padding: 0.65rem 1.3rem; border-radius: 8px; font-weight: 700; cursor: pointer;">
                            + Add Training Lesson
                        </button>
                    </div>
                @else
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.88rem; text-align: left;">
                            <thead>
                                <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-weight: 700;">
                                    <th style="padding: 1rem;">Thumbnail</th>
                                    <th style="padding: 1rem;">Lesson Details</th>
                                    <th style="padding: 1rem;">YouTube Video Link</th>
                                    <th style="padding: 1rem; text-align: center;">Duration</th>
                                    <th style="padding: 1rem; text-align: center;">Views</th>
                                    <th style="padding: 1rem; text-align: center;">Status</th>
                                    <th style="padding: 1rem; text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trainings as $item)
                                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#faf5ff'" onmouseout="this.style.background='transparent'">
                                        <!-- Thumbnail -->
                                        <td style="padding: 1rem; width: 110px;">
                                            <div style="position: relative; width: 95px; height: 56px; border-radius: 8px; overflow: hidden; background: #0f172a; border: 1.5px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.06);">
                                                <img src="{{ $item->photo_url }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.25); display: flex; align-items: center; justify-content: center;">
                                                    <span style="color: #fff; font-size: 1.1rem;">▶</span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Lesson Details -->
                                        <td style="padding: 1rem; min-width: 240px;">
                                            <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                                                @if(!empty($item->badge))
                                                    <span style="background: #f1f5f9; color: #7c3aed; font-size: 0.72rem; font-weight: 800; padding: 2px 7px; border-radius: 4px;">
                                                        {{ $item->badge }}
                                                    </span>
                                                @endif
                                                <span style="background: rgba(5,179,150,0.1); color: #0A6B5C; font-size: 0.72rem; font-weight: 700; padding: 2px 7px; border-radius: 4px;">
                                                    {{ $item->category }}
                                                </span>
                                                @if($item->sort_order > 0)
                                                    <span style="font-size: 0.7rem; color: #94a3b8;">Order: {{ $item->sort_order }}</span>
                                                @endif
                                            </div>
                                            <div style="font-weight: 800; color: #0f172a; font-size: 0.95rem; line-height: 1.35;">{{ $item->title }}</div>
                                            <p style="margin: 4px 0 0; color: #64748b; font-size: 0.8rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">
                                                {{ $item->description }}
                                            </p>
                                        </td>

                                        <!-- YouTube Video Link -->
                                        <td style="padding: 1rem; max-width: 220px;">
                                            <a href="{{ $item->youtube_url }}" target="_blank" style="color: #ef4444; font-weight: 700; text-decoration: none; font-size: 0.82rem; display: inline-flex; align-items: center; gap: 5px; word-break: break-all;">
                                                <span>▶️ Watch on YouTube</span>
                                                <span>↗</span>
                                            </a>
                                            <div style="font-size: 0.72rem; color: #94a3b8; margin-top: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                {{ $item->youtube_url }}
                                            </div>
                                        </td>

                                        <!-- Duration -->
                                        <td style="padding: 1rem; text-align: center; white-space: nowrap;">
                                            <span style="font-weight: 700; color: #475569; font-size: 0.85rem;">
                                                ⏱️ {{ $item->duration ?: 'Video' }}
                                            </span>
                                        </td>

                                        <!-- Views -->
                                        <td style="padding: 1rem; text-align: center; white-space: nowrap;">
                                            <span style="background: #f8fafc; border: 1px solid #e2e8f0; color: #0f172a; font-weight: 800; font-size: 0.85rem; padding: 3px 8px; border-radius: 6px;">
                                                👁️ {{ number_format($item->views_count) }}
                                            </span>
                                        </td>

                                        <!-- Visibility Switch -->
                                        <td style="padding: 1rem; text-align: center;">
                                            <form method="POST" action="{{ route('admin.affiliate-training.toggle-visibility', $item) }}" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" style="background: {{ $item->is_active ? 'rgba(5, 179, 150, 0.12)' : 'rgba(239, 68, 68, 0.12)' }}; border: 1.5px solid {{ $item->is_active ? '#05B396' : '#ef4444' }}; color: {{ $item->is_active ? '#05B396' : '#ef4444' }}; padding: 4px 12px; border-radius: 20px; font-weight: 800; font-size: 0.78rem; cursor: pointer;">
                                                    {{ $item->is_active ? '● Active' : '○ Hidden' }}
                                                </button>
                                            </form>
                                        </td>

                                        <!-- Actions -->
                                        <td style="padding: 1rem; text-align: right; white-space: nowrap;">
                                            <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                                <!-- View on portal -->
                                                <a href="{{ url('/affiliate-training?watch='.$item->id) }}" target="_blank" title="Preview Lesson" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #7c3aed; padding: 6px 10px; border-radius: 8px; font-weight: 700; font-size: 0.8rem; text-decoration: none;">
                                                    👁️
                                                </a>

                                                <!-- Edit button -->
                                                <button type="button" onclick='openEditTrainingModal(@json($item))' title="Edit Lesson" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; padding: 6px 10px; border-radius: 8px; font-weight: 700; font-size: 0.8rem; cursor: pointer;">
                                                    ✏️ Edit
                                                </button>

                                                <!-- Delete button -->
                                                <form method="POST" action="{{ route('admin.affiliate-training.destroy', $item) }}" onsubmit="return confirm('Are you sure you want to delete this training lesson?');" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Delete" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; padding: 6px 10px; border-radius: 8px; font-weight: 700; font-size: 0.8rem; cursor: pointer;">
                                                        🗑️
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($trainings->hasPages())
                        <div style="padding: 1.2rem; border-top: 1px solid #f1f5f9; display: flex; justify-content: center;">
                            {{ $trainings->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </main>
    </div>
</div>

<!-- ========================================== -->
<!-- 1. ADD TRAINING MODAL -->
<!-- ========================================== -->
<div id="addTrainingModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); overflow-y: auto; padding: 1.5rem 1rem;">
    <div style="max-width: 620px; margin: 1rem auto; background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,0.3);">
        <!-- Modal Header -->
        <div style="background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%); color: #ffffff; padding: 1.5rem 1.8rem; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800;">🎓 Add New Training Lesson</h3>
                <p style="margin: 4px 0 0; opacity: 0.85; font-size: 0.85rem;">Upload YouTube video link and photo thumbnail</p>
            </div>
            <button type="button" onclick="closeAddTrainingModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; width: 34px; height: 34px; border-radius: 50%; font-size: 1.3rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.affiliate-training.store') }}" enctype="multipart/form-data" style="padding: 1.8rem;">
            @csrf

            <!-- Title -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Lesson Title *</label>
                <input type="text" name="title" required placeholder="e.g. Step 1: Orientation & 30-Day Growth Roadmap" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
            </div>

            <!-- YouTube Video URL -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                    ▶️ YouTube Video Link *
                </label>
                <input type="text" name="youtube_url" required placeholder="https://www.youtube.com/watch?v=... or https://youtu.be/..." style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                <div style="font-size: 0.72rem; color: #64748b; margin-top: 3px;">Supports standard YouTube links, Shorts, or youtu.be links.</div>
            </div>

            <!-- Photo / Thumbnail Link & Upload -->
            <div style="background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 12px; padding: 1.1rem; margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 800; font-size: 0.85rem; color: #0f172a; margin-bottom: 6px;">
                    🖼️ Photo / Thumbnail (Link or File Upload)
                </label>

                <!-- Photo Link URL -->
                <div style="margin-bottom: 8px;">
                    <input type="url" name="photo" placeholder="Photo Link URL (https://...) Optional" style="width: 100%; padding: 0.55rem 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box; background: #fff;">
                </div>

                <!-- Or Upload File -->
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 0.78rem; font-weight: 700; color: #64748b;">OR UPLOAD:</span>
                    <input type="file" name="photo_file" accept="image/*" style="font-size: 0.82rem; cursor: pointer;">
                </div>
                <div style="font-size: 0.72rem; color: #64748b; margin-top: 4px;">
                    Tip: If left blank, YouTube's official HQ thumbnail will automatically be used!
                </div>
            </div>

            <!-- Category, Badge & Duration Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0.8rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 4px;">Category / Module</label>
                    <input type="text" name="category" placeholder="e.g. Getting Started" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 4px;">Badge / Step Tag</label>
                    <input type="text" name="badge" placeholder="e.g. STEP 1" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 4px;">Duration</label>
                    <input type="text" name="duration" placeholder="e.g. 25 Mins" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Sort Order -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Sort Order (Display sequence)</label>
                <input type="number" name="sort_order" value="0" min="0" style="width: 120px; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box;">
            </div>

            <!-- Description -->
            <div style="margin-bottom: 1.4rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Description &amp; Key Takeaways</label>
                <textarea name="description" rows="3" placeholder="Summary of what the student will learn in this masterclass..." style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box;"></textarea>
            </div>

            <!-- Active Visibility Checkbox -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 0.88rem; color: #0f172a; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" checked style="width: 18px; height: 18px; accent-color: #7c3aed;">
                    <span>Publish immediately (Show on Student / Affiliate Training page)</span>
                </label>
            </div>

            <!-- Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeAddTrainingModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" style="background: #7c3aed; color: #ffffff; border: none; padding: 0.65rem 1.5rem; border-radius: 8px; font-weight: 800; cursor: pointer; box-shadow: 0 4px 12px rgba(124,58,237,0.3);">
                    Save Lesson
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- 2. EDIT TRAINING MODAL -->
<!-- ========================================== -->
<div id="editTrainingModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); overflow-y: auto; padding: 1.5rem 1rem;">
    <div style="max-width: 620px; margin: 1rem auto; background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,0.3);">
        <!-- Modal Header -->
        <div style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); color: #ffffff; padding: 1.5rem 1.8rem; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800;">✏️ Edit Training Lesson</h3>
                <p style="margin: 4px 0 0; opacity: 0.85; font-size: 0.85rem;">Update YouTube video link, photo link or lesson details</p>
            </div>
            <button type="button" onclick="closeEditTrainingModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; width: 34px; height: 34px; border-radius: 50%; font-size: 1.3rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>

        <form id="editTrainingForm" method="POST" action="" enctype="multipart/form-data" style="padding: 1.8rem;">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Lesson Title *</label>
                <input type="text" id="edit_title" name="title" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
            </div>

            <!-- YouTube Video URL -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                    ▶️ YouTube Video Link *
                </label>
                <input type="text" id="edit_youtube_url" name="youtube_url" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
            </div>

            <!-- Photo / Thumbnail Link & Upload -->
            <div style="background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 12px; padding: 1.1rem; margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 800; font-size: 0.85rem; color: #0f172a; margin-bottom: 6px;">
                    🖼️ Photo / Thumbnail (Link or File Upload)
                </label>

                <!-- Current Thumbnail Preview -->
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                    <img id="edit_photo_preview" src="" alt="Thumbnail" style="width: 70px; height: 42px; border-radius: 6px; object-fit: cover; border: 1.5px solid #cbd5e1;">
                    <div style="flex: 1;">
                        <input type="url" id="edit_photo" name="photo" placeholder="Photo Link URL (https://...)" style="width: 100%; padding: 0.55rem 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box; background: #fff;">
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 0.78rem; font-weight: 700; color: #64748b;">OR REPLACE FILE:</span>
                    <input type="file" name="photo_file" accept="image/*" style="font-size: 0.82rem; cursor: pointer;">
                </div>
            </div>

            <!-- Category, Badge & Duration Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0.8rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 4px;">Category / Module</label>
                    <input type="text" id="edit_category" name="category" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 4px;">Badge / Step Tag</label>
                    <input type="text" id="edit_badge" name="badge" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 4px;">Duration</label>
                    <input type="text" id="edit_duration" name="duration" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Sort Order -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Sort Order</label>
                <input type="number" id="edit_sort_order" name="sort_order" min="0" style="width: 120px; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box;">
            </div>

            <!-- Description -->
            <div style="margin-bottom: 1.4rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Description</label>
                <textarea id="edit_description" name="description" rows="3" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box;"></textarea>
            </div>

            <!-- Active Visibility Checkbox -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 0.88rem; color: #0f172a; cursor: pointer;">
                    <input type="checkbox" id="edit_is_active" name="is_active" value="1" style="width: 18px; height: 18px; accent-color: #7c3aed;">
                    <span>Active &amp; Visible to Students</span>
                </label>
            </div>

            <!-- Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeEditTrainingModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" style="background: #7c3aed; color: #ffffff; border: none; padding: 0.65rem 1.5rem; border-radius: 8px; font-weight: 800; cursor: pointer;">
                    Update Lesson
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openAddTrainingModal() {
        document.getElementById('addTrainingModal').style.display = 'block';
    }
    function closeAddTrainingModal() {
        document.getElementById('addTrainingModal').style.display = 'none';
    }

    function openEditTrainingModal(item) {
        const form = document.getElementById('editTrainingForm');
        form.action = '/admin/affiliate-training/' + item.id;

        document.getElementById('edit_title').value = item.title || '';
        document.getElementById('edit_youtube_url').value = item.youtube_url || '';
        document.getElementById('edit_photo').value = item.photo || '';
        document.getElementById('edit_photo_preview').src = item.photo_url || '';
        document.getElementById('edit_category').value = item.category || '';
        document.getElementById('edit_badge').value = item.badge || '';
        document.getElementById('edit_duration').value = item.duration || '';
        document.getElementById('edit_sort_order').value = item.sort_order || 0;
        document.getElementById('edit_description').value = item.description || '';
        document.getElementById('edit_is_active').checked = Boolean(item.is_active);

        document.getElementById('editTrainingModal').style.display = 'block';
    }
    function closeEditTrainingModal() {
        document.getElementById('editTrainingModal').style.display = 'none';
    }
</script>
@endpush
@endsection
