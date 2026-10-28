@extends('layouts.app')

@section('title', 'Video Option & Show/Hide Management — SkillLearner Super Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-videos'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-videos'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header & Action Row -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(124, 58, 237, 0.12); color: #7c3aed; font-size: 0.75rem; font-weight: 800; padding: 3px 10px; border-radius: 20px; margin-bottom: 0.4rem;">
                        👑 SUPER ADMIN EXCLUSIVE ACCESS
                    </div>
                    <h2 class="welcome-heading" style="font-size: 1.6rem; margin-bottom: 0.25rem;">
                        🎥 Video Option &amp; Show/Hide Control
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Manage masterclass videos, add new training links, and control visibility (Show / Hide) for regular users.
                    </p>
                </div>
                <button type="button" onclick="openAddVideoModal()" style="background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%); color: #ffffff; border: none; padding: 0.75rem 1.4rem; border-radius: 10px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 16px rgba(124, 58, 237, 0.35); font-size: 0.92rem; transition: transform 0.15s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Add New Video</span>
                </button>
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

            <!-- Live Status Toast for AJAX -->
            <div id="liveToast" style="display: none; position: fixed; top: 24px; right: 24px; z-index: 9999; background: #0f172a; color: #ffffff; padding: 1rem 1.4rem; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); font-weight: 700; font-size: 0.9rem; align-items: center; gap: 10px; border-left: 4px solid #05B396; transition: opacity 0.3s ease;">
                <span id="toastIcon">✅</span>
                <span id="toastMsg">Visibility updated successfully.</span>
            </div>

            <!-- Stat Cards Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 1rem; margin-bottom: 1.8rem;">
                <!-- Total Videos -->
                <div class="admin-stat-card">
                    <div class="admin-stat-label">TOTAL VIDEOS IN SYSTEM</div>
                    <div class="admin-stat-val">{{ $counts['total'] }}</div>
                    <div class="admin-stat-sub">Across all video categories</div>
                </div>

                <!-- Visible Videos -->
                <div class="admin-stat-card" style="border-top: 3px solid #05B396;">
                    <div class="admin-stat-label" style="color: #05B396;">👁️ VISIBLE (SHOWN TO USERS)</div>
                    <div class="admin-stat-val" style="color: #05B396;">{{ $counts['visible'] }}</div>
                    <div class="admin-stat-sub">Students can access &amp; watch</div>
                </div>

                <!-- Hidden Videos -->
                <div class="admin-stat-card" style="border-top: 3px solid #f59e0b;">
                    <div class="admin-stat-label" style="color: #d97706;">🙈 HIDDEN FROM USERS</div>
                    <div class="admin-stat-val" style="color: #d97706;">{{ $counts['hidden'] }}</div>
                    <div class="admin-stat-sub">Invisible to regular student accounts</div>
                </div>
            </div>

            <!-- Filters & Search Toolbar -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.2rem; margin-bottom: 1.5rem;">
                <form method="GET" action="{{ url('/admin/videos') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; justify-content: space-between;">
                    <!-- Filter Pills -->
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <a href="{{ url('/admin/videos') }}" class="admin-filter-pill {{ $currentFilter === 'all' ? 'active' : '' }}">
                            All Videos ({{ $counts['total'] }})
                        </a>
                        <a href="{{ url('/admin/videos?filter=visible') }}" class="admin-filter-pill {{ $currentFilter === 'visible' ? 'active' : '' }}" style="{{ $currentFilter === 'visible' ? 'background: #05B396; border-color: #05B396;' : '' }}">
                            👁️ Visible Only ({{ $counts['visible'] }})
                        </a>
                        <a href="{{ url('/admin/videos?filter=hidden') }}" class="admin-filter-pill {{ $currentFilter === 'hidden' ? 'active' : '' }}" style="{{ $currentFilter === 'hidden' ? 'background: #f59e0b; border-color: #f59e0b;' : '' }}">
                            🙈 Hidden Only ({{ $counts['hidden'] }})
                        </a>
                    </div>

                    <!-- Search Input -->
                    <div style="display: flex; gap: 8px; flex: 1; max-width: 340px;">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search title, category, description..." style="width: 100%; padding: 0.55rem 0.9rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none;">
                        <button type="submit" style="background: #7c3aed; color: #fff; border: none; padding: 0.55rem 1rem; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.88rem;">Search</button>
                    </div>
                </form>
            </div>

            <!-- Video Management Table Card -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); overflow: hidden;">
                <div style="padding: 1.2rem 1.6rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.8rem;">
                    <div>
                        <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0;">
                            Platform Videos ({{ count($videos) }})
                        </h3>
                        <span style="font-size: 0.8rem; color: #64748b;">
                            Use the <strong>Show / Hide switch</strong> in each row to immediately enable or disable user visibility.
                        </span>
                    </div>
                    <a href="{{ url('/videos') }}" target="_blank" style="font-size: 0.82rem; font-weight: 700; color: #05B396; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; background: rgba(5,179,150,0.08); border-radius: 6px;">
                        <span>View User Page ↗</span>
                    </a>
                </div>

                @if($videos->isEmpty())
                    <div style="padding: 3.5rem 1.5rem; text-align: center;">
                        <div style="font-size: 2.8rem; margin-bottom: 0.6rem;">🎬</div>
                        <h4 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin-bottom: 0.3rem;">No Videos Found</h4>
                        <p style="font-size: 0.88rem; color: #64748b; margin-bottom: 1.2rem;">No video entries match your current filter criteria.</p>
                        <button type="button" onclick="openAddVideoModal()" style="background: #7c3aed; color: #ffffff; border: none; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.88rem;">
                            + Add First Video
                        </button>
                    </div>
                @else
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                            <thead>
                                <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-size: 0.76rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <th style="padding: 0.85rem 1.4rem;">Video Details</th>
                                    <th style="padding: 0.85rem 1rem;">Category &amp; Meta</th>
                                    <th style="padding: 0.85rem 1rem;">User Visibility (Show / Hide)</th>
                                    <th style="padding: 0.85rem 1rem;">Views</th>
                                    <th style="padding: 0.85rem 1.4rem; text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($videos as $v)
                                    <tr id="video-row-{{ $v->id }}" style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#fbfcfe'" onmouseout="this.style.background='transparent'">
                                        <!-- Video Thumbnail & Title -->
                                        <td style="padding: 1rem 1.4rem;">
                                            <div style="display: flex; gap: 12px; align-items: center;">
                                                <div style="position: relative; width: 88px; height: 52px; border-radius: 8px; overflow: hidden; background: #000; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                                    <img src="{{ $v->thumbnail_url ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=200' }}" alt="{{ $v->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    <button type="button" onclick="previewVideo('{{ addslashes($v->title) }}', '{{ $v->embed_url }}', {{ $v->is_iframe ? 'true' : 'false' }})" style="position: absolute; inset: 0; margin: auto; width: 26px; height: 26px; border-radius: 50%; background: rgba(0,0,0,0.65); border: none; color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: transform 0.15s;" title="Preview Video">
                                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><polygon points="6,3 20,12 6,21"></polygon></svg>
                                                    </button>
                                                </div>
                                                <div>
                                                    <div style="font-weight: 800; color: #0f172a; font-size: 0.95rem; margin-bottom: 2px;">
                                                        {{ $v->title }}
                                                    </div>
                                                    <div style="font-size: 0.78rem; color: #64748b; line-height: 1.35; max-width: 320px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                        {{ $v->description ?: 'No description provided.' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Category & Duration -->
                                        <td style="padding: 1rem 1rem;">
                                            <div style="display: flex; flex-direction: column; gap: 4px; align-items: flex-start;">
                                                <span style="background: rgba(124, 58, 237, 0.08); color: #7c3aed; font-size: 0.74rem; font-weight: 800; padding: 2px 8px; border-radius: 4px;">
                                                    {{ $v->category }}
                                                </span>
                                                <div style="display: flex; align-items: center; gap: 6px; font-size: 0.75rem; color: #64748b;">
                                                    <span>⏱️ {{ $v->duration ?: 'Self-Paced' }}</span>
                                                    @if($v->badge)
                                                        <span>•</span>
                                                        <span style="color: #05B396; font-weight: 700;">{{ $v->badge }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Interactive Show / Hide Toggle Control -->
                                        <td style="padding: 1rem 1rem;">
                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                <!-- The Toggle Button -->
                                                <button type="button" 
                                                        onclick="toggleVideoVisibility({{ $v->id }})" 
                                                        id="toggle-btn-{{ $v->id }}"
                                                        class="video-toggle-switch {{ $v->is_visible ? 'on' : 'off' }}"
                                                        style="position: relative; width: 48px; height: 26px; border-radius: 20px; border: none; cursor: pointer; transition: background-color 0.25s ease; background-color: {{ $v->is_visible ? '#05B396' : '#cbd5e1' }}; padding: 2px;"
                                                        title="Click to toggle Show/Hide">
                                                    <span id="toggle-knob-{{ $v->id }}" style="position: absolute; top: 3px; left: {{ $v->is_visible ? '25px' : '3px' }}; width: 20px; height: 20px; border-radius: 50%; background: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.3); transition: left 0.25s ease;"></span>
                                                </button>

                                                <!-- Status Badge Text -->
                                                <div id="status-badge-{{ $v->id }}">
                                                    @if($v->is_visible)
                                                        <span style="display: inline-flex; align-items: center; gap: 4px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 3px 9px; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">
                                                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #059669;"></span>
                                                            👁️ Shown
                                                        </span>
                                                    @else
                                                        <span style="display: inline-flex; align-items: center; gap: 4px; background: #fef3c7; color: #b45309; border: 1px solid #fde68a; padding: 3px 9px; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">
                                                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #b45309;"></span>
                                                            🙈 Hidden
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Views Count -->
                                        <td style="padding: 1rem 1rem; color: #475569; font-weight: 700;">
                                            {{ number_format($v->views_count) }}
                                        </td>

                                        <!-- Actions -->
                                        <td style="padding: 1rem 1.4rem; text-align: right;">
                                            <div style="display: inline-flex; align-items: center; gap: 6px;">
                                                <!-- Preview Button -->
                                                <button type="button" onclick="previewVideo('{{ addslashes($v->title) }}', '{{ $v->embed_url }}', {{ $v->is_iframe ? 'true' : 'false' }})" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; padding: 5px 9px; border-radius: 6px; cursor: pointer; font-size: 0.78rem; font-weight: 700;" title="Watch Video Preview">
                                                    👁️ Preview
                                                </button>

                                                <!-- Edit Button -->
                                                <button type="button" onclick="openEditVideoModal({{ json_encode($v) }})" style="background: rgba(124,58,237,0.1); border: 1px solid rgba(124,58,237,0.3); color: #7c3aed; padding: 5px 9px; border-radius: 6px; cursor: pointer; font-size: 0.78rem; font-weight: 700;" title="Edit Video">
                                                    ✏️ Edit
                                                </button>

                                                <!-- Delete Button -->
                                                <form method="POST" action="{{ url('/admin/videos/'.$v->id) }}" onsubmit="return confirm('Are you sure you want to delete this video?')" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="background: #fff1f2; border: 1px solid #fecdd3; color: #e11d48; padding: 5px 9px; border-radius: 6px; cursor: pointer; font-size: 0.78rem; font-weight: 700;" title="Delete Video">
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
                @endif
            </div>
        </main>
    </div>
</div>

<!-- ============================================================== -->
<!-- 1. ADD VIDEO MODAL                                             -->
<!-- ============================================================== -->
<div id="addVideoModal" class="modal-backdrop" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); z-index: 9999; backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 1.5rem;">
    <div style="background: #ffffff; border-radius: 18px; max-width: 580px; width: 100%; max-height: 90vh; overflow-y: auto; padding: 2rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: relative;">
        <!-- Modal Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 1rem;">
            <div>
                <span style="font-size: 0.74rem; font-weight: 800; color: #7c3aed; text-transform: uppercase;">SUPER ADMIN OPTION</span>
                <h3 style="font-size: 1.3rem; font-weight: 800; color: #0f172a; margin: 0;">Add New Video</h3>
            </div>
            <button type="button" onclick="closeAddVideoModal()" style="background: none; border: none; font-size: 1.5rem; color: #94a3b8; cursor: pointer;">&times;</button>
        </div>

        <form method="POST" action="{{ url('/admin/videos') }}">
            @csrf
            
            <!-- Video Title -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-size: 0.86rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                    Video Title <span style="color: #e11d48;">*</span>
                </label>
                <input type="text" name="title" required placeholder="e.g. 06. Live Affiliate Closing Masterclass" class="clean-form-input">
            </div>

            <!-- Video URL -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-size: 0.86rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                    Video Stream / Embed URL <span style="color: #e11d48;">*</span>
                </label>
                <input type="url" name="video_url" required placeholder="https://... (MP4 direct link, YouTube URL, or Vimeo)" class="clean-form-input">
                <span style="font-size: 0.74rem; color: #64748b;">Supports direct MP4 links, YouTube (watch/shorts), or Vimeo links.</span>
            </div>

            <!-- Category & Duration Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-size: 0.86rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                        Category
                    </label>
                    <select name="category" class="clean-form-input">
                        <option value="Affiliate Training">Affiliate Training</option>
                        <option value="Organic Growth">Organic Growth</option>
                        <option value="Video Editing & Reels">Video Editing &amp; Reels</option>
                        <option value="Sales Closing">Sales Closing</option>
                        <option value="Pro Masterclass">Pro Masterclass</option>
                        <option value="General Orientation">General Orientation</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 0.86rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                        Duration
                    </label>
                    <input type="text" name="duration" placeholder="e.g. 22m 15s" class="clean-form-input">
                </div>
            </div>

            <!-- Thumbnail URL & Badge -->
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-size: 0.86rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                        Poster / Thumbnail URL (Optional)
                    </label>
                    <input type="url" name="thumbnail_url" placeholder="https://images.unsplash.com/..." class="clean-form-input">
                </div>
                <div>
                    <label style="display: block; font-size: 0.86rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                        Badge Label
                    </label>
                    <input type="text" name="badge" placeholder="e.g. New / Pro" class="clean-form-input">
                </div>
            </div>

            <!-- Description -->
            <div style="margin-bottom: 1.4rem;">
                <label style="display: block; font-size: 0.86rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                    Video Description
                </label>
                <textarea name="description" rows="3" placeholder="Brief synopsis of what users will learn in this video..." class="clean-form-input" style="resize: vertical;"></textarea>
            </div>

            <!-- Initial Visibility Toggle -->
            <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 1rem; margin-bottom: 1.6rem; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div style="font-size: 0.9rem; font-weight: 800; color: #0f172a;">Show to Users Immediately?</div>
                    <div style="font-size: 0.78rem; color: #64748b;">If unchecked, video will be saved as <strong>Hidden</strong> and not visible to students.</div>
                </div>
                <label style="position: relative; display: inline-block; width: 44px; height: 24px; cursor: pointer;">
                    <input type="checkbox" name="is_visible" value="1" checked style="opacity: 0; width: 0; height: 0;" id="add_is_visible_checkbox">
                    <span style="position: absolute; cursor: pointer; inset: 0; background-color: #05B396; transition: .3s; border-radius: 24px;" id="add_toggle_slider"></span>
                </label>
            </div>

            <!-- Modal Action Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeAddVideoModal()" style="background: #f1f5f9; border: none; padding: 0.75rem 1.4rem; border-radius: 8px; font-weight: 700; color: #475569; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" style="background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%); color: #ffffff; border: none; padding: 0.75rem 1.6rem; border-radius: 8px; font-weight: 800; cursor: pointer; box-shadow: 0 4px 14px rgba(124, 58, 237, 0.35);">
                    Save &amp; Create Video ➔
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- 2. EDIT VIDEO MODAL                                            -->
<!-- ============================================================== -->
<div id="editVideoModal" class="modal-backdrop" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); z-index: 9999; backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 1.5rem;">
    <div style="background: #ffffff; border-radius: 18px; max-width: 580px; width: 100%; max-height: 90vh; overflow-y: auto; padding: 2rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: relative;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 1rem;">
            <div>
                <span style="font-size: 0.74rem; font-weight: 800; color: #7c3aed; text-transform: uppercase;">SUPER ADMIN OPTION</span>
                <h3 style="font-size: 1.3rem; font-weight: 800; color: #0f172a; margin: 0;">Edit Video</h3>
            </div>
            <button type="button" onclick="closeEditVideoModal()" style="background: none; border: none; font-size: 1.5rem; color: #94a3b8; cursor: pointer;">&times;</button>
        </div>

        <form id="editVideoForm" method="POST" action="">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-size: 0.86rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Video Title</label>
                <input type="text" id="edit_title" name="title" required class="clean-form-input">
            </div>

            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-size: 0.86rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Video Stream / Embed URL</label>
                <input type="url" id="edit_video_url" name="video_url" required class="clean-form-input">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-size: 0.86rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Category</label>
                    <input type="text" id="edit_category" name="category" class="clean-form-input">
                </div>
                <div>
                    <label style="display: block; font-size: 0.86rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Duration</label>
                    <input type="text" id="edit_duration" name="duration" class="clean-form-input">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-size: 0.86rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Thumbnail URL</label>
                    <input type="url" id="edit_thumbnail_url" name="thumbnail_url" class="clean-form-input">
                </div>
                <div>
                    <label style="display: block; font-size: 0.86rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Badge</label>
                    <input type="text" id="edit_badge" name="badge" class="clean-form-input">
                </div>
            </div>

            <div style="margin-bottom: 1.4rem;">
                <label style="display: block; font-size: 0.86rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Description</label>
                <textarea id="edit_description" name="description" rows="3" class="clean-form-input" style="resize: vertical;"></textarea>
            </div>

            <!-- Edit Visibility Checkbox -->
            <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 1rem; margin-bottom: 1.6rem; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div style="font-size: 0.9rem; font-weight: 800; color: #0f172a;">Show / Hide for Users</div>
                    <div style="font-size: 0.78rem; color: #64748b;">Turn ON to show on student portal, OFF to hide.</div>
                </div>
                <input type="checkbox" id="edit_is_visible" name="is_visible" value="1" style="width: 20px; height: 20px; accent-color: #05B396;">
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeEditVideoModal()" style="background: #f1f5f9; border: none; padding: 0.75rem 1.4rem; border-radius: 8px; font-weight: 700; color: #475569; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" style="background: #05B396; color: #ffffff; border: none; padding: 0.75rem 1.6rem; border-radius: 8px; font-weight: 800; cursor: pointer;">
                    Update Video ➔
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- 3. PREVIEW VIDEO MODAL                                         -->
<!-- ============================================================== -->
<div id="previewVideoModal" class="modal-backdrop" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.85); z-index: 10000; backdrop-filter: blur(6px); align-items: center; justify-content: center; padding: 1.5rem;">
    <div style="background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 18px; max-width: 800px; width: 100%; padding: 1.5rem; box-shadow: 0 25px 50px rgba(0,0,0,0.5); position: relative;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h4 id="previewModalTitle" style="color: #ffffff; font-size: 1.1rem; font-weight: 800; margin: 0;">Video Preview</h4>
            <button type="button" onclick="closePreviewModal()" style="background: none; border: none; color: #ffffff; font-size: 1.8rem; cursor: pointer;">&times;</button>
        </div>

        <div id="videoContainer" style="aspect-ratio: 16 / 9; background: #000; border-radius: 10px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
            <!-- Injected dynamically via JS -->
        </div>
    </div>
</div>

@include('portal.styles')

@push('styles')
<style>
    .clean-form-input {
        width: 100%;
        padding: 0.65rem 0.9rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.9rem;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
    }
    .clean-form-input:focus {
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.15);
    }
    .modal-backdrop.active {
        display: flex !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // 1. AJAX Show / Hide Toggle Function
    function toggleVideoVisibility(videoId) {
        const btn = document.getElementById('toggle-btn-' + videoId);
        const knob = document.getElementById('toggle-knob-' + videoId);
        const badgeContainer = document.getElementById('status-badge-' + videoId);

        // Optimistic UI feedback
        btn.style.opacity = '0.6';
        btn.disabled = true;

        fetch('{{ url("/admin/videos") }}/' + videoId + '/toggle-visibility', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            btn.style.opacity = '1';
            btn.disabled = false;

            if (data.success) {
                if (data.is_visible) {
                    btn.style.backgroundColor = '#05B396';
                    knob.style.left = '25px';
                    badgeContainer.innerHTML = `
                        <span style="display: inline-flex; align-items: center; gap: 4px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 3px 9px; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">
                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #059669;"></span>
                            👁️ Shown
                        </span>`;
                } else {
                    btn.style.backgroundColor = '#cbd5e1';
                    knob.style.left = '3px';
                    badgeContainer.innerHTML = `
                        <span style="display: inline-flex; align-items: center; gap: 4px; background: #fef3c7; color: #b45309; border: 1px solid #fde68a; padding: 3px 9px; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">
                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #b45309;"></span>
                            🙈 Hidden
                        </span>`;
                }
                showLiveToast(data.message, '✅');
            } else {
                showLiveToast('Could not toggle visibility.', '⚠️');
            }
        })
        .catch(err => {
            btn.style.opacity = '1';
            btn.disabled = false;
            showLiveToast('Network error while toggling video.', '❌');
            console.error(err);
        });
    }

    // Live Toast Feedback
    function showLiveToast(msg, icon) {
        const toast = document.getElementById('liveToast');
        document.getElementById('toastMsg').innerText = msg;
        document.getElementById('toastIcon').innerText = icon || '✅';
        toast.style.display = 'flex';
        toast.style.opacity = '1';
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => { toast.style.display = 'none'; }, 300);
        }, 3200);
    }

    // Modal Control: Add Video
    function openAddVideoModal() {
        document.getElementById('addVideoModal').classList.add('active');
    }
    function closeAddVideoModal() {
        document.getElementById('addVideoModal').classList.remove('active');
    }

    // Modal Control: Edit Video
    function openEditVideoModal(video) {
        const form = document.getElementById('editVideoForm');
        form.action = '{{ url("/admin/videos") }}/' + video.id;

        document.getElementById('edit_title').value = video.title || '';
        document.getElementById('edit_video_url').value = video.video_url || '';
        document.getElementById('edit_category').value = video.category || '';
        document.getElementById('edit_duration').value = video.duration || '';
        document.getElementById('edit_thumbnail_url').value = video.thumbnail_url || '';
        document.getElementById('edit_badge').value = video.badge || '';
        document.getElementById('edit_description').value = video.description || '';
        document.getElementById('edit_is_visible').checked = Boolean(video.is_visible);

        document.getElementById('editVideoModal').classList.add('active');
    }
    function closeEditVideoModal() {
        document.getElementById('editVideoModal').classList.remove('active');
    }

    // Modal Control: Preview Video
    function previewVideo(title, url, isIframe) {
        document.getElementById('previewModalTitle').innerText = title;
        const container = document.getElementById('videoContainer');
        if (isIframe) {
            container.innerHTML = `<iframe src="${url}" style="width: 100%; height: 100%; border: none;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
        } else {
            container.innerHTML = `<video controls autoplay style="width: 100%; height: 100%;"><source src="${url}" type="video/mp4">Your browser does not support video.</video>`;
        }
        document.getElementById('previewVideoModal').classList.add('active');
    }
    function closePreviewModal() {
        const container = document.getElementById('videoContainer');
        container.innerHTML = '';
        document.getElementById('previewVideoModal').classList.remove('active');
    }

    // Close modals on clicking backdrop
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-backdrop')) {
            e.target.classList.remove('active');
            const container = document.getElementById('videoContainer');
            if (container) container.innerHTML = '';
        }
    });
</script>
@endpush
@endsection
