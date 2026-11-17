@extends('layouts.app')

@section('title', 'Social Communities Management — SkillLearner Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-communities'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-communities'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header & Action Row -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(37, 99, 235, 0.1); color: #2563eb; font-size: 0.75rem; font-weight: 800; padding: 3px 10px; border-radius: 20px; margin-bottom: 0.4rem;">
                        🌐 COMMUNITY CHANNELS MANAGEMENT
                    </div>
                    <h2 class="welcome-heading" style="font-size: clamp(1.2rem, 4.5vw, 1.6rem); word-break: break-word; overflow-wrap: anywhere; margin-bottom: 0.25rem;">
                        Social Communities &amp; Links
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Add, edit, and organize social community channels (WhatsApp, Instagram, YouTube, Telegram, Discord, etc.) displayed to all students.
                    </p>
                </div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="{{ route('portal.community') }}" target="_blank" style="background: #ffffff; color: #2563eb; border: 1.5px solid #2563eb; padding: 0.75rem 1.2rem; border-radius: 10px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 0.9rem; box-shadow: 0 2px 8px rgba(37,99,235,0.12);">
                        <span>View Portal Community</span>
                        <span>↗</span>
                    </a>
                    <button type="button" onclick="openAddCommunityModal()" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: #ffffff; border: none; padding: 0.75rem 1.4rem; border-radius: 10px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 16px rgba(37, 99, 235, 0.35); font-size: 0.92rem; transition: transform 0.15s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add New Social Link</span>
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
                <!-- Total Channels -->
                <div class="admin-stat-card">
                    <div class="admin-stat-label">TOTAL COMMUNITY CHANNELS</div>
                    <div class="admin-stat-val">{{ $totalCount }}</div>
                    <div class="admin-stat-sub">Across all platforms</div>
                </div>

                <!-- Active Channels -->
                <div class="admin-stat-card" style="border-top: 3px solid #05B396;">
                    <div class="admin-stat-label" style="color: #05B396;">👁️ ACTIVE &amp; VISIBLE</div>
                    <div class="admin-stat-val" style="color: #05B396;">{{ $activeCount }}</div>
                    <div class="admin-stat-sub">Shown on /social-community</div>
                </div>

                <!-- Hidden Channels -->
                <div class="admin-stat-card" style="border-top: 3px solid #f59e0b;">
                    <div class="admin-stat-label" style="color: #d97706;">🙈 HIDDEN CHANNELS</div>
                    <div class="admin-stat-val" style="color: #d97706;">{{ $inactiveCount }}</div>
                    <div class="admin-stat-sub">Hidden from student portal</div>
                </div>
            </div>

            <!-- Platform Filters & Search Bar -->
            <div class="portal-box-card" style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; padding: 1.2rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="{{ route('admin.social-communities', array_merge(request()->except('platform', 'page'), ['platform' => 'all'])) }}" 
                       style="padding: 0.45rem 0.9rem; border-radius: 8px; font-size: 0.82rem; font-weight: 700; text-decoration: none; {{ $platformFilter === 'all' ? 'background: #2563eb; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                        All Channels ({{ $totalCount }})
                    </a>
                    @foreach(['whatsapp' => 'WhatsApp', 'instagram' => 'Instagram', 'youtube' => 'YouTube', 'facebook' => 'Facebook', 'telegram' => 'Telegram', 'discord' => 'Discord'] as $platKey => $platLabel)
                        <a href="{{ route('admin.social-communities', array_merge(request()->except('platform', 'page'), ['platform' => $platKey])) }}" 
                           style="padding: 0.45rem 0.9rem; border-radius: 8px; font-size: 0.82rem; font-weight: 700; text-decoration: none; {{ $platformFilter === $platKey ? 'background: #2563eb; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                            {{ $platLabel }}
                        </a>
                    @endforeach
                </div>

                <form method="GET" action="{{ route('admin.social-communities') }}" style="display: flex; gap: 6px; flex: 1; max-width: 320px;">
                    @if(request('platform'))
                        <input type="hidden" name="platform" value="{{ request('platform') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title, url, platform..." style="flex: 1; padding: 0.45rem 0.85rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem;">
                    <button type="submit" style="background: #334155; color: #fff; border: none; padding: 0.45rem 0.9rem; border-radius: 8px; font-weight: 700; font-size: 0.82rem; cursor: pointer;">
                        Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.social-communities', request()->except('search')) }}" style="display: flex; align-items: center; justify-content: center; padding: 0.45rem 0.7rem; background: #e2e8f0; border-radius: 8px; color: #475569; text-decoration: none; font-size: 0.85rem;">✕</a>
                    @endif
                </form>
            </div>

            <!-- Channels Table Card -->
            <div class="portal-box-card" style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 800; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                <th style="padding: 0.9rem 1.1rem; width: 60px;">Order</th>
                                <th style="padding: 0.9rem 1.1rem;">Channel &amp; Platform</th>
                                <th style="padding: 0.9rem 1.1rem;">Destination URL</th>
                                <th style="padding: 0.9rem 1.1rem;">Button Text &amp; Badge</th>
                                <th style="padding: 0.9rem 1.1rem; text-align: center;">Status</th>
                                <th style="padding: 0.9rem 1.1rem; text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($communities as $channel)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#fbfcfe'" onmouseout="this.style.background='transparent'">
                                    <!-- Order -->
                                    <td style="padding: 1rem 1.1rem; font-weight: 800; color: #94a3b8; font-size: 0.9rem;">
                                        #{{ $channel->sort_order }}
                                    </td>

                                    <!-- Channel & Platform -->
                                    <td style="padding: 1rem 1.1rem;">
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <div style="width: 44px; height: 44px; border-radius: 50%; background: {{ $channel->icon_bg_style }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.12);">
                                                {!! $channel->icon_svg !!}
                                            </div>
                                            <div>
                                                <div style="font-weight: 800; color: #0f172a; font-size: 0.95rem; display: flex; align-items: center; gap: 6px;">
                                                    <span>{{ $channel->title }}</span>
                                                    <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; padding: 1px 6px; border-radius: 4px; background: #f1f5f9; color: #475569;">
                                                        {{ $channel->platform }}
                                                    </span>
                                                </div>
                                                @if($channel->subtitle)
                                                    <div style="font-size: 0.8rem; color: #64748b; margin-top: 2px;">
                                                        {{ $channel->subtitle }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <!-- URL -->
                                    <td style="padding: 1rem 1.1rem; max-width: 280px;">
                                        <a href="{{ $channel->url }}" target="_blank" rel="noopener noreferrer" style="color: #2563eb; text-decoration: none; font-size: 0.82rem; font-weight: 600; word-break: break-all; display: inline-flex; align-items: center; gap: 4px;">
                                            <span style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $channel->url }}</span>
                                            <span>↗</span>
                                        </a>
                                    </td>

                                    <!-- Button Text & Badge -->
                                    <td style="padding: 1rem 1.1rem;">
                                        <div style="display: inline-block; padding: 4px 10px; border-radius: 6px; background: {{ $channel->button_bg_style }}; color: #ffffff; font-size: 0.78rem; font-weight: 800;">
                                            {{ $channel->button_text }}
                                        </div>
                                        @if($channel->badge)
                                            <div style="margin-top: 4px;">
                                                <span style="font-size: 0.68rem; font-weight: 800; text-transform: uppercase; background: #e0f2fe; color: #0369a1; padding: 2px 7px; border-radius: 9999px;">
                                                    🏷️ {{ $channel->badge }}
                                                </span>
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Status Toggle -->
                                    <td style="padding: 1rem 1.1rem; text-align: center;">
                                        <form method="POST" action="{{ route('admin.social-communities.toggle-visibility', $channel) }}" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" title="Click to toggle visibility" style="cursor: pointer; border: none; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; display: inline-flex; align-items: center; gap: 4px; transition: transform 0.1s ease; {{ $channel->is_active ? 'background: #dcfce7; color: #15803d;' : 'background: #fee2e2; color: #b91c1c;' }}">
                                                <span style="width: 7px; height: 7px; border-radius: 50%; background: currentColor;"></span>
                                                <span>{{ $channel->is_active ? 'Active' : 'Hidden' }}</span>
                                            </button>
                                        </form>
                                    </td>

                                    <!-- Actions -->
                                    <td style="padding: 1rem 1.1rem; text-align: right;">
                                        <div style="display: flex; gap: 6px; justify-content: flex-end; align-items: center;">
                                            <!-- Edit Button -->
                                            <button type="button" onclick='openEditCommunityModal(@json($channel))' style="background: #f1f5f9; color: #1e293b; border: 1px solid #cbd5e1; padding: 5px 12px; border-radius: 6px; font-weight: 700; font-size: 0.78rem; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; transition: background 0.15s ease;">
                                                ✏️ Edit
                                            </button>

                                            <!-- Delete Button -->
                                            <form method="POST" action="{{ route('admin.social-communities.destroy', $channel) }}" onsubmit="return confirm('Are you sure you want to delete \'{{ addslashes($channel->title) }}\'?');" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; padding: 5px 10px; border-radius: 6px; font-weight: 700; font-size: 0.78rem; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="padding: 3.5rem 1rem; text-align: center; color: #64748b;">
                                        <div style="font-size: 2.2rem; margin-bottom: 0.5rem;">🌐</div>
                                        <div style="font-weight: 700; font-size: 1.1rem; color: #1e293b;">No Community Links Found</div>
                                        <p style="font-size: 0.85rem; margin-top: 4px;">Click the "Add New Social Link" button above to create one.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($communities->hasPages())
                    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
                        {{ $communities->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

<!-- Add Community Modal -->
<div id="addCommunityModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 99999; overflow-y: auto; padding: 1.5rem;">
    <div style="background: #ffffff; max-width: 620px; margin: 2rem auto; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden;">
        <div style="background: #2563eb; color: #ffffff; padding: 1.2rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-weight: 800; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                <span>🌐 Add New Social Community Link</span>
            </div>
            <button type="button" onclick="closeAddCommunityModal()" style="background: transparent; border: none; color: #ffffff; font-size: 1.4rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.social-communities.store') }}" style="padding: 1.5rem;">
            @csrf

            <!-- Platform Selector -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                    Select Platform *
                </label>
                <select id="add_platform" name="platform" required onchange="handlePlatformChange(this, 'add')" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box; background: #fff;">
                    <option value="whatsapp">WhatsApp (Channel / Group)</option>
                    <option value="instagram">Instagram</option>
                    <option value="youtube">YouTube</option>
                    <option value="facebook">Facebook</option>
                    <option value="telegram">Telegram</option>
                    <option value="discord">Discord</option>
                    <option value="twitter">X / Twitter</option>
                    <option value="linkedin">LinkedIn</option>
                    <option value="other">Other / Custom</option>
                </select>
            </div>

            <!-- Title & Subtitle Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Title *
                    </label>
                    <input type="text" id="add_title" name="title" required value="WhatsApp Channel" placeholder="e.g. WhatsApp Channel" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Subtitle / Tagline
                    </label>
                    <input type="text" id="add_subtitle" name="subtitle" placeholder="e.g. Instant Updates & Alerts" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Destination URL -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                    🔗 Social / Community Link URL *
                </label>
                <input type="url" id="add_url" name="url" required placeholder="https://whatsapp.com/channel/... or https://t.me/..." style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
            </div>

            <!-- Button Text & Badge Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Button Text
                    </label>
                    <input type="text" id="add_button_text" name="button_text" value="Join WhatsApp ➔" placeholder="e.g. Join WhatsApp ➔" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Badge / Pill Tag
                    </label>
                    <input type="text" id="add_badge" name="badge" placeholder="e.g. OFFICIAL, COMMUNITY" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Sort Order & Custom Color -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.4rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Sort Order
                    </label>
                    <input type="number" name="sort_order" min="0" value="{{ $totalCount + 1 }}" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Custom Accent Color (Optional)
                    </label>
                    <input type="text" id="add_color" name="color" placeholder="Hex color e.g. #25d366" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Active Visibility Checkbox -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 0.88rem; color: #0f172a; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" checked style="width: 18px; height: 18px; accent-color: #2563eb;">
                    <span>Active &amp; Visible to Students Immediately</span>
                </label>
            </div>

            <!-- Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeAddCommunityModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" style="background: #2563eb; color: #ffffff; border: none; padding: 0.65rem 1.5rem; border-radius: 8px; font-weight: 800; cursor: pointer; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);">
                    Create Community Link
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Community Modal -->
<div id="editCommunityModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 99999; overflow-y: auto; padding: 1.5rem;">
    <div style="background: #ffffff; max-width: 620px; margin: 2rem auto; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden;">
        <div style="background: #0f172a; color: #ffffff; padding: 1.2rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-weight: 800; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                <span>✏️ Edit Social Community Link</span>
            </div>
            <button type="button" onclick="closeEditCommunityModal()" style="background: transparent; border: none; color: #ffffff; font-size: 1.4rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <form id="editCommunityForm" method="POST" action="" style="padding: 1.5rem;">
            @csrf
            @method('PUT')

            <!-- Platform Selector -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                    Select Platform *
                </label>
                <select id="edit_platform" name="platform" required onchange="handlePlatformChange(this, 'edit')" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box; background: #fff;">
                    <option value="whatsapp">WhatsApp (Channel / Group)</option>
                    <option value="instagram">Instagram</option>
                    <option value="youtube">YouTube</option>
                    <option value="facebook">Facebook</option>
                    <option value="telegram">Telegram</option>
                    <option value="discord">Discord</option>
                    <option value="twitter">X / Twitter</option>
                    <option value="linkedin">LinkedIn</option>
                    <option value="other">Other / Custom</option>
                </select>
            </div>

            <!-- Title & Subtitle Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Title *
                    </label>
                    <input type="text" id="edit_title" name="title" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Subtitle / Tagline
                    </label>
                    <input type="text" id="edit_subtitle" name="subtitle" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Destination URL -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                    🔗 Social / Community Link URL *
                </label>
                <input type="url" id="edit_url" name="url" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
            </div>

            <!-- Button Text & Badge Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Button Text
                    </label>
                    <input type="text" id="edit_button_text" name="button_text" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Badge / Pill Tag
                    </label>
                    <input type="text" id="edit_badge" name="badge" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Sort Order & Custom Color -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.4rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Sort Order
                    </label>
                    <input type="number" id="edit_sort_order" name="sort_order" min="0" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Custom Accent Color (Optional)
                    </label>
                    <input type="text" id="edit_color" name="color" placeholder="Hex color e.g. #25d366" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Active Visibility Checkbox -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 0.88rem; color: #0f172a; cursor: pointer;">
                    <input type="checkbox" id="edit_is_active" name="is_active" value="1" style="width: 18px; height: 18px; accent-color: #2563eb;">
                    <span>Active &amp; Visible to Students</span>
                </label>
            </div>

            <!-- Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeEditCommunityModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" style="background: #0f172a; color: #ffffff; border: none; padding: 0.65rem 1.5rem; border-radius: 8px; font-weight: 800; cursor: pointer;">
                    Update Community Link
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const platformPresets = @json($presets);

    function handlePlatformChange(selectElem, prefix) {
        const plat = selectElem.value;
        const preset = platformPresets[plat] || platformPresets['other'];

        const titleInput = document.getElementById(prefix + '_title');
        const buttonInput = document.getElementById(prefix + '_button_text');

        if (titleInput && (!titleInput.value || Object.values(platformPresets).some(p => p.title_default === titleInput.value))) {
            titleInput.value = preset.title_default;
        }

        if (buttonInput && (!buttonInput.value || Object.values(platformPresets).some(p => p.button_default === buttonInput.value))) {
            buttonInput.value = preset.button_default;
        }
    }

    function openAddCommunityModal() {
        document.getElementById('addCommunityModal').style.display = 'block';
    }
    function closeAddCommunityModal() {
        document.getElementById('addCommunityModal').style.display = 'none';
    }

    function openEditCommunityModal(item) {
        const form = document.getElementById('editCommunityForm');
        form.action = '/admin/social-communities/' + item.id;

        document.getElementById('edit_platform').value = item.platform || 'other';
        document.getElementById('edit_title').value = item.title || '';
        document.getElementById('edit_subtitle').value = item.subtitle || '';
        document.getElementById('edit_url').value = item.url || '';
        document.getElementById('edit_button_text').value = item.button_text || '';
        document.getElementById('edit_badge').value = item.badge || '';
        document.getElementById('edit_sort_order').value = item.sort_order || 0;
        document.getElementById('edit_color').value = item.color || '';
        document.getElementById('edit_is_active').checked = Boolean(item.is_active);

        document.getElementById('editCommunityModal').style.display = 'block';
    }
    function closeEditCommunityModal() {
        document.getElementById('editCommunityModal').style.display = 'none';
    }

    // Dismiss flash alert
    setTimeout(() => {
        const flash = document.getElementById('flashSuccess');
        if (flash) flash.style.display = 'none';
    }, 5000);
</script>
@endpush
@endsection
