@extends('layouts.app')

@section('title', 'Webinars & Meeting Links Management — SkillLearner Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-webinars'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-webinars'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header & Action Row -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(2, 132, 199, 0.12); color: #0284c7; font-size: 0.75rem; font-weight: 800; padding: 3px 10px; border-radius: 20px; margin-bottom: 0.4rem;">
                        📹 LIVE WORKSHOPS &amp; WEBINARS
                    </div>
                    <h2 class="welcome-heading" style="font-size: clamp(1.2rem, 4.5vw, 1.6rem); word-break: break-word; overflow-wrap: anywhere; margin-bottom: 0.25rem;">
                        Webinars &amp; Meeting Links
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Upload promotional posters, configure Zoom/Google Meet links, set speaker details, and manage upcoming schedules for students.
                    </p>
                </div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="{{ route('portal.webinars') }}" target="_blank" style="background: #ffffff; color: #0284c7; border: 1.5px solid #0284c7; padding: 0.75rem 1.2rem; border-radius: 10px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 0.9rem; box-shadow: 0 2px 8px rgba(2,132,199,0.12);">
                        <span>View Student Webinars</span>
                        <span>↗</span>
                    </a>
                    <button type="button" onclick="openAddWebinarModal()" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #ffffff; border: none; padding: 0.75rem 1.4rem; border-radius: 10px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 16px rgba(2, 132, 199, 0.35); font-size: 0.92rem; transition: transform 0.15s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add Live Webinar</span>
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

            @if($errors->any())
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem;">
                    <strong>Validation errors:</strong>
                    <ul style="margin: 0.5rem 0 0 1.2rem; padding: 0;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Stat Cards Grid -->
            <div class="admin-stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.8rem;">
                <!-- Total Webinars -->
                <div class="admin-stat-card">
                    <div class="admin-stat-label">TOTAL WEBINARS</div>
                    <div class="admin-stat-val">{{ $counts['total'] }}</div>
                    <div class="admin-stat-sub">Scheduled masterclasses</div>
                </div>

                <!-- Active Webinars -->
                <div class="admin-stat-card" style="border-top: 3px solid #0284c7;">
                    <div class="admin-stat-label" style="color: #0284c7;">👁️ ACTIVE &amp; LIVE</div>
                    <div class="admin-stat-val" style="color: #0284c7;">{{ $counts['active'] }}</div>
                    <div class="admin-stat-sub">Shown on /webinars</div>
                </div>

                <!-- Hidden Webinars -->
                <div class="admin-stat-card" style="border-top: 3px solid #f59e0b;">
                    <div class="admin-stat-label" style="color: #d97706;">🙈 HIDDEN / DRAFTS</div>
                    <div class="admin-stat-val" style="color: #d97706;">{{ $counts['hidden'] }}</div>
                    <div class="admin-stat-sub">Unpublished sessions</div>
                </div>

                <!-- Downloads -->
                <div class="admin-stat-card" style="border-top: 3px solid #05B396;">
                    <div class="admin-stat-label" style="color: #05B396;">📥 POSTER DOWNLOADS</div>
                    <div class="admin-stat-val" style="color: #05B396;">{{ $counts['downloads'] }}</div>
                    <div class="admin-stat-sub">Saved by affiliates to invite leads</div>
                </div>
            </div>

            <!-- Filters & Search Bar -->
            <div class="portal-box-card" style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; padding: 1.2rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="{{ route('admin.webinars', ['platform' => 'all', 'status' => request('status'), 'search' => request('search')]) }}" 
                       style="padding: 0.45rem 0.9rem; border-radius: 8px; font-size: 0.82rem; font-weight: 700; text-decoration: none; {{ $platformFilter === 'all' ? 'background: #0284c7; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                        All Platforms ({{ $counts['total'] }})
                    </a>
                    <a href="{{ route('admin.webinars', ['platform' => 'zoom', 'status' => request('status'), 'search' => request('search')]) }}" 
                       style="padding: 0.45rem 0.9rem; border-radius: 8px; font-size: 0.82rem; font-weight: 700; text-decoration: none; {{ $platformFilter === 'zoom' ? 'background: #0284c7; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                        Zoom
                    </a>
                    <a href="{{ route('admin.webinars', ['platform' => 'google_meet', 'status' => request('status'), 'search' => request('search')]) }}" 
                       style="padding: 0.45rem 0.9rem; border-radius: 8px; font-size: 0.82rem; font-weight: 700; text-decoration: none; {{ $platformFilter === 'google_meet' ? 'background: #0284c7; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                        Google Meet
                    </a>
                    <a href="{{ route('admin.webinars', ['platform' => 'youtube_live', 'status' => request('status'), 'search' => request('search')]) }}" 
                       style="padding: 0.45rem 0.9rem; border-radius: 8px; font-size: 0.82rem; font-weight: 700; text-decoration: none; {{ $platformFilter === 'youtube_live' ? 'background: #0284c7; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                        YouTube Live
                    </a>
                </div>

                <form method="GET" action="{{ route('admin.webinars') }}" style="display: flex; gap: 6px; flex: 1; max-width: 340px;">
                    @if(request('platform'))
                        <input type="hidden" name="platform" value="{{ request('platform') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search webinar, speaker, link..." style="flex: 1; padding: 0.45rem 0.85rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem;">
                    <button type="submit" style="background: #334155; color: #fff; border: none; padding: 0.45rem 0.9rem; border-radius: 8px; font-weight: 700; font-size: 0.82rem; cursor: pointer;">
                        Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.webinars', request()->except('search')) }}" style="display: flex; align-items: center; justify-content: center; padding: 0.45rem 0.7rem; background: #e2e8f0; border-radius: 8px; color: #475569; text-decoration: none; font-size: 0.85rem;">✕</a>
                    @endif
                </form>
            </div>

            <!-- Table Card -->
            <div class="portal-box-card" style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 800; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                <th style="padding: 0.9rem 1.1rem; width: 60px;">Order</th>
                                <th style="padding: 0.9rem 1.1rem;">Poster</th>
                                <th style="padding: 0.9rem 1.1rem;">Webinar Title &amp; Speaker</th>
                                <th style="padding: 0.9rem 1.1rem;">Meeting Link</th>
                                <th style="padding: 0.9rem 1.1rem;">Date &amp; Platform</th>
                                <th style="padding: 0.9rem 1.1rem; text-align: center;">Downloads</th>
                                <th style="padding: 0.9rem 1.1rem; text-align: center;">Status</th>
                                <th style="padding: 0.9rem 1.1rem; text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($webinars as $item)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#fbfcfe'" onmouseout="this.style.background='transparent'">
                                    <!-- Order -->
                                    <td style="padding: 1rem 1.1rem; font-weight: 800; color: #94a3b8;">
                                        #{{ $item->sort_order }}
                                    </td>

                                    <!-- Poster -->
                                    <td style="padding: 1rem 1.1rem;">
                                        <a href="{{ $item->poster_image }}" target="_blank" rel="noopener noreferrer" style="display: block; width: 80px; height: 48px; border-radius: 8px; overflow: hidden; border: 1px solid #cbd5e1; background: #0f172a;" title="Click to view full poster">
                                            <img src="{{ $item->poster_image }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        </a>
                                    </td>

                                    <!-- Title & Speaker -->
                                    <td style="padding: 1rem 1.1rem; max-width: 260px;">
                                        <div style="font-weight: 800; color: #0f172a; font-size: 0.95rem; margin-bottom: 2px;">
                                            {{ $item->title }}
                                        </div>
                                        @if($item->badge)
                                            <span style="font-size: 0.68rem; font-weight: 800; text-transform: uppercase; background: #fee2e2; color: #b91c1c; padding: 2px 7px; border-radius: 4px;">
                                                {{ $item->badge }}
                                            </span>
                                        @endif
                                        @if($item->speaker)
                                            <div style="font-size: 0.8rem; color: #0284c7; font-weight: 700; margin-top: 4px;">
                                                🎤 {{ $item->speaker }} @if($item->speaker_role) <span style="color: #64748b; font-weight: 500;">({{ $item->speaker_role }})</span> @endif
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Meeting Link -->
                                    <td style="padding: 1rem 1.1rem; max-width: 220px;">
                                        <a href="{{ $item->meeting_link }}" target="_blank" rel="noopener noreferrer" style="color: #0284c7; text-decoration: none; font-size: 0.82rem; font-weight: 700; word-break: break-all; display: inline-flex; align-items: center; gap: 4px;" title="Test Meeting Link">
                                            <span>🔗 Join Meeting Link</span>
                                            <span>↗</span>
                                        </a>
                                        <div style="font-size: 0.72rem; color: #94a3b8; margin-top: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                            {{ $item->meeting_link }}
                                        </div>
                                    </td>

                                    <!-- Date & Platform -->
                                    <td style="padding: 1rem 1.1rem; font-size: 0.82rem;">
                                        <div style="font-weight: 800; color: #0f172a;">
                                            {{ $item->formatted_date }}
                                        </div>
                                        @if($item->webinar_time)
                                            <div style="color: #64748b; font-weight: 600; margin-top: 2px;">
                                                ⏰ {{ $item->webinar_time }}
                                            </div>
                                        @endif
                                        <div style="margin-top: 4px;">
                                            <span style="font-size: 0.68rem; font-weight: 800; background: #f1f5f9; color: #334155; padding: 2px 6px; border-radius: 4px;">
                                                {{ $item->platform_name }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Downloads -->
                                    <td style="padding: 1rem 1.1rem; text-align: center; font-weight: 800; color: #05B396;">
                                        {{ $item->download_count }}
                                    </td>

                                    <!-- Status Toggle -->
                                    <td style="padding: 1rem 1.1rem; text-align: center;">
                                        <form method="POST" action="{{ route('admin.webinars.toggle-status', $item) }}" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" title="Click to toggle visibility" style="cursor: pointer; border: none; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; display: inline-flex; align-items: center; gap: 4px; {{ $item->is_active ? 'background: #dcfce7; color: #15803d;' : 'background: #fee2e2; color: #b91c1c;' }}">
                                                <span style="width: 7px; height: 7px; border-radius: 50%; background: currentColor;"></span>
                                                <span>{{ $item->is_active ? 'Active' : 'Hidden' }}</span>
                                            </button>
                                        </form>
                                    </td>

                                    <!-- Actions -->
                                    <td style="padding: 1rem 1.1rem; text-align: right;">
                                        <div style="display: flex; gap: 6px; justify-content: flex-end; align-items: center;">
                                            <!-- Download Poster Button -->
                                            <a href="{{ route('portal.webinars.download', $item) }}" title="Download Poster" style="background: #eff6ff; color: #0284c7; border: 1px solid #bfdbfe; padding: 5px 9px; border-radius: 6px; font-size: 0.78rem; text-decoration: none; display: inline-flex; align-items: center;">
                                                📥
                                            </a>

                                            <!-- Edit Button -->
                                            <button type="button" onclick='openEditWebinarModal(@json($item))' style="background: #f1f5f9; color: #1e293b; border: 1px solid #cbd5e1; padding: 5px 12px; border-radius: 6px; font-weight: 700; font-size: 0.78rem; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                                ✏️ Edit
                                            </button>

                                            <!-- Delete Button -->
                                            <form method="POST" action="{{ route('admin.webinars.destroy', $item) }}" onsubmit="return confirm('Are you sure you want to delete webinar \'{{ addslashes($item->title) }}\'?');" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; padding: 5px 9px; border-radius: 6px; font-weight: 700; font-size: 0.78rem; cursor: pointer;">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="padding: 3.5rem 1rem; text-align: center; color: #64748b;">
                                        <div style="font-size: 2.2rem; margin-bottom: 0.5rem;">📹</div>
                                        <div style="font-weight: 700; font-size: 1.1rem; color: #1e293b;">No Live Webinars Found</div>
                                        <p style="font-size: 0.85rem; margin-top: 4px;">Click the "Add Live Webinar" button above to schedule a live masterclass.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($webinars->hasPages())
                    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
                        {{ $webinars->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

<!-- Add Webinar Modal -->
<div id="addWebinarModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 99999; overflow-y: auto; padding: 1.5rem;">
    <div style="background: #ffffff; max-width: 660px; margin: 2rem auto; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden;">
        <div style="background: #0284c7; color: #ffffff; padding: 1.2rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-weight: 800; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                <span>📹 Add New Live Webinar / Masterclass</span>
            </div>
            <button type="button" onclick="closeAddWebinarModal()" style="background: transparent; border: none; color: #ffffff; font-size: 1.4rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.webinars.store') }}" enctype="multipart/form-data" style="padding: 1.5rem;">
            @csrf

            <!-- Title -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                    Webinar Title *
                </label>
                <input type="text" name="title" required placeholder="e.g. 6-Figure Affiliate Mastery Blueprint & Live Q&A" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
            </div>

            <!-- Speaker Name & Role -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Speaker Name
                    </label>
                    <input type="text" name="speaker" placeholder="e.g. Rahul Sharma" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Speaker Role / Title
                    </label>
                    <input type="text" name="speaker_role" placeholder="e.g. 7-Figure Affiliate Mentor" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Meeting Link & Platform Grid -->
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        🔗 Live Meeting Link (Zoom / Meet / YouTube URL) *
                    </label>
                    <input type="url" name="meeting_link" required placeholder="https://zoom.us/j/... or https://meet.google.com/..." style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Platform *
                    </label>
                    <select name="platform" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box; background: #fff;">
                        <option value="zoom">Zoom</option>
                        <option value="google_meet">Google Meet</option>
                        <option value="youtube_live">YouTube Live</option>
                        <option value="other">Other Link</option>
                    </select>
                </div>
            </div>

            <!-- Poster File Upload & URL -->
            <div style="background: #f0f9ff; border: 1.5px dashed #0284c7; border-radius: 12px; padding: 1.1rem; margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 800; font-size: 0.85rem; color: #0f172a; margin-bottom: 6px;">
                    🖼️ Webinar Poster Upload (File Upload or External URL)
                </label>
                <div style="margin-bottom: 8px;">
                    <input type="file" name="poster" accept="image/*" style="font-size: 0.85rem; cursor: pointer;">
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 0.78rem; font-weight: 700; color: #64748b;">OR POSTER URL:</span>
                    <input type="url" name="poster_url" placeholder="https://... (image URL)" style="flex: 1; padding: 0.5rem 0.8rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.85rem; background: #fff;">
                </div>
                <span style="font-size: 0.75rem; color: #64748b; margin-top: 4px; display: block;">Affiliates can download this poster directly from student portal to share with their leads.</span>
            </div>

            <!-- Date, Time & Badge Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0.8rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 4px;">Webinar Date</label>
                    <input type="date" name="webinar_date" value="{{ date('Y-m-d') }}" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 4px;">Time</label>
                    <input type="text" name="webinar_time" value="8:00 PM IST" placeholder="e.g. 8:00 PM IST" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 4px;">Badge</label>
                    <input type="text" name="badge" placeholder="e.g. TODAY LIVE" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Sort Order & Description -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Sort Order</label>
                <input type="number" name="sort_order" min="0" value="{{ $counts['total'] + 1 }}" style="width: 120px; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 1.3rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Webinar Description</label>
                <textarea name="description" rows="3" placeholder="What topics will be covered? Who should attend? Live Q&A details..." style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box;"></textarea>
            </div>

            <!-- Active Checkbox -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 0.88rem; color: #0f172a; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" checked style="width: 18px; height: 18px; accent-color: #0284c7;">
                    <span>Active &amp; Visible to Students Immediately</span>
                </label>
            </div>

            <!-- Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeAddWebinarModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" style="background: #0284c7; color: #ffffff; border: none; padding: 0.65rem 1.5rem; border-radius: 8px; font-weight: 800; cursor: pointer; box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);">
                    Create Live Webinar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Webinar Modal -->
<div id="editWebinarModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 99999; overflow-y: auto; padding: 1.5rem;">
    <div style="background: #ffffff; max-width: 660px; margin: 2rem auto; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden;">
        <div style="background: #0f172a; color: #ffffff; padding: 1.2rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-weight: 800; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                <span>✏️ Edit Live Webinar &amp; Meeting Link</span>
            </div>
            <button type="button" onclick="closeEditWebinarModal()" style="background: transparent; border: none; color: #ffffff; font-size: 1.4rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <form id="editWebinarForm" method="POST" action="" enctype="multipart/form-data" style="padding: 1.5rem;">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                    Webinar Title *
                </label>
                <input type="text" id="edit_title" name="title" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
            </div>

            <!-- Speaker Name & Role -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Speaker Name
                    </label>
                    <input type="text" id="edit_speaker" name="speaker" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Speaker Role / Title
                    </label>
                    <input type="text" id="edit_speaker_role" name="speaker_role" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Meeting Link & Platform Grid -->
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        🔗 Live Meeting Link (Zoom / Meet / YouTube URL) *
                    </label>
                    <input type="url" id="edit_meeting_link" name="meeting_link" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Platform *
                    </label>
                    <select id="edit_platform" name="platform" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box; background: #fff;">
                        <option value="zoom">Zoom</option>
                        <option value="google_meet">Google Meet</option>
                        <option value="youtube_live">YouTube Live</option>
                        <option value="other">Other Link</option>
                    </select>
                </div>
            </div>

            <!-- Current Poster Preview & Replace -->
            <div style="background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 12px; padding: 1.1rem; margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 800; font-size: 0.85rem; color: #0f172a; margin-bottom: 6px;">
                    🖼️ Poster (Upload New or Update URL)
                </label>
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                    <img id="edit_poster_preview" src="" alt="Poster" style="width: 80px; height: 48px; border-radius: 6px; object-fit: cover; border: 1.5px solid #cbd5e1; background: #0f172a;">
                    <div style="flex: 1;">
                        <input type="url" id="edit_poster_url" name="poster_url" placeholder="Poster Image URL (https://...)" style="width: 100%; padding: 0.55rem 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box; background: #fff;">
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 0.78rem; font-weight: 700; color: #64748b;">OR REPLACE FILE:</span>
                    <input type="file" name="poster" accept="image/*" style="font-size: 0.82rem; cursor: pointer;">
                </div>
            </div>

            <!-- Date, Time & Badge Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0.8rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 4px;">Webinar Date</label>
                    <input type="date" id="edit_webinar_date" name="webinar_date" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 4px;">Time</label>
                    <input type="text" id="edit_webinar_time" name="webinar_time" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 4px;">Badge</label>
                    <input type="text" id="edit_badge" name="badge" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Sort Order & Description -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Sort Order</label>
                <input type="number" id="edit_sort_order" name="sort_order" min="0" style="width: 120px; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 1.3rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Webinar Description</label>
                <textarea id="edit_description" name="description" rows="3" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box;"></textarea>
            </div>

            <!-- Active Checkbox -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 0.88rem; color: #0f172a; cursor: pointer;">
                    <input type="checkbox" id="edit_is_active" name="is_active" value="1" style="width: 18px; height: 18px; accent-color: #0284c7;">
                    <span>Active &amp; Visible to Students</span>
                </label>
            </div>

            <!-- Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeEditWebinarModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" style="background: #0f172a; color: #ffffff; border: none; padding: 0.65rem 1.5rem; border-radius: 8px; font-weight: 800; cursor: pointer;">
                    Update Live Webinar
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openAddWebinarModal() {
        document.getElementById('addWebinarModal').style.display = 'block';
    }
    function closeAddWebinarModal() {
        document.getElementById('addWebinarModal').style.display = 'none';
    }

    function openEditWebinarModal(item) {
        const form = document.getElementById('editWebinarForm');
        form.action = '/admin/webinars/' + item.id;

        document.getElementById('edit_title').value = item.title || '';
        document.getElementById('edit_speaker').value = item.speaker || '';
        document.getElementById('edit_speaker_role').value = item.speaker_role || '';
        document.getElementById('edit_meeting_link').value = item.meeting_link || '';
        document.getElementById('edit_platform').value = item.platform || 'zoom';
        document.getElementById('edit_poster_preview').src = item.poster_image || '';
        document.getElementById('edit_poster_url').value = item.poster_url || '';
        document.getElementById('edit_webinar_time').value = item.webinar_time || '';
        document.getElementById('edit_badge').value = item.badge || '';
        document.getElementById('edit_sort_order').value = item.sort_order || 0;
        document.getElementById('edit_description').value = item.description || '';
        document.getElementById('edit_is_active').checked = Boolean(item.is_active);

        if (item.webinar_date) {
            const dateStr = item.webinar_date.split('T')[0] || item.webinar_date.split(' ')[0];
            document.getElementById('edit_webinar_date').value = dateStr;
        } else {
            document.getElementById('edit_webinar_date').value = '';
        }

        document.getElementById('editWebinarModal').style.display = 'block';
    }
    function closeEditWebinarModal() {
        document.getElementById('editWebinarModal').style.display = 'none';
    }

    setTimeout(() => {
        const flash = document.getElementById('flashSuccess');
        if (flash) flash.style.display = 'none';
    }, 5000);
</script>
@endpush
@endsection
