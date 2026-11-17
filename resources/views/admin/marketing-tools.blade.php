@extends('layouts.app')

@section('title', 'Marketing Tools Management — SkillLearner Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-marketing'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-marketing'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header & Action Row -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(5, 179, 150, 0.12); color: #05B396; font-size: 0.75rem; font-weight: 800; padding: 3px 10px; border-radius: 20px; margin-bottom: 0.4rem;">
                        🎨 AFFILIATE MARKETING ASSETS CONTROL
                    </div>
                    <h2 class="welcome-heading" style="font-size: clamp(1.2rem, 4.5vw, 1.6rem); word-break: break-word; overflow-wrap: anywhere; margin-bottom: 0.25rem;">
                        Marketing Tools &amp; Creative Assets
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Upload short videos, reels, flyers, and banners for your affiliates and students with 1-click download options.
                    </p>
                </div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="{{ url('/marketing-tool') }}" target="_blank" style="background: #ffffff; color: #05B396; border: 1.5px solid #05B396; padding: 0.75rem 1.2rem; border-radius: 10px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 0.9rem; box-shadow: 0 2px 8px rgba(5,179,150,0.12);">
                        <span>View Affiliate Page</span>
                        <span>↗</span>
                    </a>
                    <button type="button" onclick="openAddToolModal()" style="background: linear-gradient(135deg, #05B396 0%, #0A6B5C 100%); color: #ffffff; border: none; padding: 0.75rem 1.4rem; border-radius: 10px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 16px rgba(5, 179, 150, 0.35); font-size: 0.92rem; transition: transform 0.15s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add Marketing Tool</span>
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

            <!-- Live Status Toast for AJAX -->
            <div id="liveToast" style="display: none; position: fixed; top: 24px; right: 24px; z-index: 9999; background: #0f172a; color: #ffffff; padding: 1rem 1.4rem; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); font-weight: 700; font-size: 0.9rem; align-items: center; gap: 10px; border-left: 4px solid #05B396; transition: opacity 0.3s ease;">
                <span id="toastIcon">✅</span>
                <span id="toastMsg">Status updated successfully.</span>
            </div>

            <!-- Stat Cards Grid -->
            <div class="admin-stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.8rem;">
                <!-- Total Assets -->
                <div class="admin-stat-card">
                    <div class="admin-stat-label">TOTAL ASSETS</div>
                    <div class="admin-stat-val">{{ $counts['total'] }}</div>
                    <div class="admin-stat-sub">Shorts, reels, posters &amp; banners</div>
                </div>

                <!-- Short Videos -->
                <div class="admin-stat-card" style="border-top: 3px solid #7c3aed;">
                    <div class="admin-stat-label" style="color: #7c3aed;">🎥 SHORT VIDEOS / REELS</div>
                    <div class="admin-stat-val" style="color: #7c3aed;">{{ $counts['video'] }}</div>
                    <div class="admin-stat-sub">9:16 vertical reels &amp; shorts</div>
                </div>

                <!-- Promotional Photos -->
                <div class="admin-stat-card" style="border-top: 3px solid #05B396;">
                    <div class="admin-stat-label" style="color: #05B396;">🖼️ PHOTOS &amp; POSTERS</div>
                    <div class="admin-stat-val" style="color: #05B396;">{{ $counts['photo'] }}</div>
                    <div class="admin-stat-sub">High-converting flyers &amp; stories</div>
                </div>

                <!-- Total Downloads -->
                <div class="admin-stat-card" style="border-top: 3px solid #f59e0b;">
                    <div class="admin-stat-label" style="color: #d97706;">📥 TOTAL USER DOWNLOADS</div>
                    <div class="admin-stat-val" style="color: #d97706;">{{ number_format($counts['downloads']) }}</div>
                    <div class="admin-stat-sub">Downloaded by affiliates</div>
                </div>
            </div>

            <!-- Filters & Search Toolbar -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.2rem; margin-bottom: 1.5rem;">
                <form method="GET" action="{{ url('/admin/marketing-tools') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; justify-content: space-between;">
                    <!-- Filter Pills -->
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <a href="{{ url('/admin/marketing-tools') }}" class="admin-filter-pill {{ $typeFilter === 'all' && $statusFilter === 'all' ? 'active' : '' }}">
                            All Assets ({{ $counts['total'] }})
                        </a>
                        <a href="{{ url('/admin/marketing-tools?type=video') }}" class="admin-filter-pill {{ $typeFilter === 'video' ? 'active' : '' }}" style="{{ $typeFilter === 'video' ? 'background: #7c3aed; border-color: #7c3aed; color: #fff;' : '' }}">
                            🎥 Short Videos ({{ $counts['video'] }})
                        </a>
                        <a href="{{ url('/admin/marketing-tools?type=photo') }}" class="admin-filter-pill {{ $typeFilter === 'photo' ? 'active' : '' }}" style="{{ $typeFilter === 'photo' ? 'background: #05B396; border-color: #05B396; color: #fff;' : '' }}">
                            🖼️ Photos &amp; Posters ({{ $counts['photo'] }})
                        </a>
                        <a href="{{ url('/admin/marketing-tools?status=active') }}" class="admin-filter-pill {{ $statusFilter === 'active' ? 'active' : '' }}">
                            Active ({{ $counts['active'] }})
                        </a>
                        <a href="{{ url('/admin/marketing-tools?status=hidden') }}" class="admin-filter-pill {{ $statusFilter === 'hidden' ? 'active' : '' }}" style="{{ $statusFilter === 'hidden' ? 'background: #f59e0b; border-color: #f59e0b; color: #fff;' : '' }}">
                            Hidden ({{ $counts['hidden'] }})
                        </a>
                    </div>

                    <!-- Search Input -->
                    <div style="display: flex; gap: 8px; flex: 1; max-width: 340px;">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search title, category, caption..." style="width: 100%; padding: 0.55rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none;">
                        <button type="submit" style="background: #0f172a; color: #fff; border: none; padding: 0.55rem 1rem; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.88rem;">Search</button>
                    </div>
                </form>
            </div>

            <!-- Marketing Tools Table Card -->
            <div class="admin-table-wrapper" style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); overflow: hidden;">
                <div style="padding: 1.2rem 1.6rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.8rem;">
                    <div>
                        <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0;">
                            Marketing Assets List ({{ $tools->total() }})
                        </h3>
                        <span style="font-size: 0.8rem; color: #64748b;">
                            Toggle visibility to immediately publish or hide assets from affiliate users.
                        </span>
                    </div>
                </div>

                @if($tools->isEmpty())
                    <div style="padding: 3.5rem 1.5rem; text-align: center;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🎨</div>
                        <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0 0 0.5rem;">No Marketing Tools Found</h3>
                        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1.2rem;">Get started by uploading your first short video reel or promotional poster.</p>
                        <button type="button" onclick="openAddToolModal()" style="background: #05B396; color: #fff; border: none; padding: 0.65rem 1.3rem; border-radius: 8px; font-weight: 700; cursor: pointer;">
                            + Add Marketing Tool
                        </button>
                    </div>
                @else
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.88rem; text-align: left;">
                            <thead>
                                <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-weight: 700;">
                                    <th style="padding: 1rem;">Preview</th>
                                    <th style="padding: 1rem;">Title &amp; Category</th>
                                    <th style="padding: 1rem;">Type</th>
                                    <th style="padding: 1rem;">Social Caption / Description</th>
                                    <th style="padding: 1rem; text-align: center;">Downloads</th>
                                    <th style="padding: 1rem; text-align: center;">Visibility</th>
                                    <th style="padding: 1rem; text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tools as $tool)
                                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#faf5ff'" onmouseout="this.style.background='transparent'">
                                        <!-- Preview -->
                                        <td style="padding: 1rem; width: 85px;">
                                            @if($tool->type === 'video')
                                                <div style="position: relative; width: 68px; height: 96px; border-radius: 10px; overflow: hidden; background: #0f172a; border: 1.5px solid #7c3aed; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                                    @if(!empty($tool->thumbnail_path))
                                                        <img src="{{ $tool->thumb_url }}" alt="{{ $tool->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    @else
                                                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1e1b4b, #312e81); color: #fff;">
                                                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                                                        </div>
                                                    @endif
                                                    <span style="position: absolute; bottom: 4px; right: 4px; background: rgba(0,0,0,0.7); color: #fff; font-size: 0.62rem; font-weight: 800; padding: 1px 4px; border-radius: 4px;">REEL</span>
                                                </div>
                                            @else
                                                <div style="width: 68px; height: 68px; border-radius: 10px; overflow: hidden; background: #f1f5f9; border: 1.5px solid #05B396; box-shadow: 0 2px 6px rgba(0,0,0,0.06);">
                                                    <img src="{{ $tool->asset_url ?: $tool->thumb_url }}" alt="{{ $tool->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                </div>
                                            @endif
                                        </td>

                                        <!-- Title & Category -->
                                        <td style="padding: 1rem; min-width: 220px;">
                                            <div style="font-weight: 800; color: #0f172a; font-size: 0.95rem; margin-bottom: 4px;">{{ $tool->title }}</div>
                                            <span style="display: inline-block; background: #f1f5f9; color: #475569; font-size: 0.75rem; font-weight: 700; padding: 2px 8px; border-radius: 6px;">
                                                🏷️ {{ $tool->category }}
                                            </span>
                                            @if($tool->sort_order > 0)
                                                <span style="font-size: 0.72rem; color: #94a3b8; margin-left: 6px;">Order: {{ $tool->sort_order }}</span>
                                            @endif
                                        </td>

                                        <!-- Type -->
                                        <td style="padding: 1rem; white-space: nowrap;">
                                            @if($tool->type === 'video')
                                                <span style="background: rgba(124, 58, 237, 0.12); color: #7c3aed; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                                    🎥 Short Video
                                                </span>
                                            @else
                                                <span style="background: rgba(5, 179, 150, 0.12); color: #05B396; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                                    🖼️ Photo / Poster
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Caption / Description -->
                                        <td style="padding: 1rem; max-width: 280px;">
                                            <p style="margin: 0; color: #64748b; font-size: 0.83rem; line-height: 1.45; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                                {{ $tool->description ?: 'No caption provided' }}
                                            </p>
                                        </td>

                                        <!-- Downloads Count -->
                                        <td style="padding: 1rem; text-align: center; white-space: nowrap;">
                                            <span style="background: #f8fafc; border: 1px solid #e2e8f0; color: #0f172a; font-weight: 800; font-size: 0.88rem; padding: 4px 10px; border-radius: 8px;">
                                                📥 {{ number_format($tool->download_count) }}
                                            </span>
                                        </td>

                                        <!-- Visibility Switch -->
                                        <td style="padding: 1rem; text-align: center;">
                                            <form method="POST" action="{{ route('admin.marketing-tools.toggle-visibility', $tool) }}" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" style="background: {{ $tool->is_active ? 'rgba(5, 179, 150, 0.12)' : 'rgba(239, 68, 68, 0.12)' }}; border: 1.5px solid {{ $tool->is_active ? '#05B396' : '#ef4444' }}; color: {{ $tool->is_active ? '#05B396' : '#ef4444' }}; padding: 4px 12px; border-radius: 20px; font-weight: 800; font-size: 0.78rem; cursor: pointer;">
                                                    {{ $tool->is_active ? '● Active' : '○ Hidden' }}
                                                </button>
                                            </form>
                                        </td>

                                        <!-- Actions -->
                                        <td style="padding: 1rem; text-align: right; white-space: nowrap;">
                                            <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                                <!-- Download preview test -->
                                                <a href="{{ route('portal.marketing.download', $tool) }}" title="Download File" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #05B396; padding: 6px 10px; border-radius: 8px; font-weight: 700; font-size: 0.8rem; text-decoration: none;">
                                                    📥
                                                </a>

                                                <!-- Edit button -->
                                                <button type="button" onclick='openEditToolModal(@json($tool))' title="Edit Asset" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; padding: 6px 10px; border-radius: 8px; font-weight: 700; font-size: 0.8rem; cursor: pointer;">
                                                    ✏️ Edit
                                                </button>

                                                <!-- Delete button -->
                                                <form method="POST" action="{{ route('admin.marketing-tools.destroy', $tool) }}" onsubmit="return confirm('Are you sure you want to delete this marketing asset?');" style="display: inline-block;">
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
                    @if($tools->hasPages())
                        <div style="padding: 1.2rem; border-top: 1px solid #f1f5f9; display: flex; justify-content: center;">
                            {{ $tools->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </main>
    </div>
</div>

<!-- ========================================== -->
<!-- 1. ADD MARKETING TOOL MODAL -->
<!-- ========================================== -->
<div id="addToolModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); overflow-y: auto; padding: 1.5rem 1rem;">
    <div style="max-width: 620px; margin: 1rem auto; background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,0.3);">
        <!-- Modal Header -->
        <div style="background: linear-gradient(135deg, #05B396 0%, #0A6B5C 100%); color: #ffffff; padding: 1.5rem 1.8rem; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800;">🎨 Add New Marketing Asset</h3>
                <p style="margin: 4px 0 0; opacity: 0.85; font-size: 0.85rem;">Upload short videos, reels, photos, flyers or banners</p>
            </div>
            <button type="button" onclick="closeAddToolModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; width: 34px; height: 34px; border-radius: 50%; font-size: 1.3rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.marketing-tools.store') }}" enctype="multipart/form-data" style="padding: 1.8rem;">
            @csrf

            <!-- Asset Type Selector -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 8px;">Select Asset Type *</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <label style="display: flex; align-items: center; gap: 8px; padding: 0.8rem 1rem; border: 2px solid #cbd5e1; border-radius: 10px; cursor: pointer; transition: all 0.2s;" id="type_photo_label">
                        <input type="radio" name="type" value="photo" checked onchange="toggleAssetType(this.value)" style="accent-color: #05B396; width: 18px; height: 18px;">
                        <div>
                            <div style="font-weight: 800; color: #0f172a; font-size: 0.9rem;">🖼️ Photo / Poster</div>
                            <div style="font-size: 0.75rem; color: #64748b;">Posters, Flyers, Banners</div>
                        </div>
                    </label>

                    <label style="display: flex; align-items: center; gap: 8px; padding: 0.8rem 1rem; border: 2px solid #cbd5e1; border-radius: 10px; cursor: pointer; transition: all 0.2s;" id="type_video_label">
                        <input type="radio" name="type" value="video" onchange="toggleAssetType(this.value)" style="accent-color: #7c3aed; width: 18px; height: 18px;">
                        <div>
                            <div style="font-weight: 800; color: #0f172a; font-size: 0.9rem;">🎥 Short Video</div>
                            <div style="font-size: 0.75rem; color: #64748b;">9:16 Reels &amp; Shorts</div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Title -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Asset Title *</label>
                <input type="text" name="title" required placeholder="e.g. Viral Reel: Earn 30K In First Month" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
            </div>

            <!-- Category & Sort Order Grid -->
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Category / Tag</label>
                    <input type="text" id="add_category_input" name="category" placeholder="e.g. Shorts &amp; Reels, Posters &amp; Flyers, WhatsApp Stories" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Sort Order</label>
                    <input type="number" name="sort_order" value="0" min="0" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Media Upload Box -->
            <div style="background: #f8fafc; border: 1.5px dashed #05B396; border-radius: 12px; padding: 1.2rem; margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 800; font-size: 0.88rem; color: #0A6B5C; margin-bottom: 6px;" id="add_file_label">
                    📁 Upload Photo File (JPG, PNG, WEBP, GIF, SVG) *
                </label>
                <input type="file" id="add_media_file" name="file" accept="image/*" style="width: 100%; padding: 0.55rem; background: #fff; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; cursor: pointer; box-sizing: border-box;">
                <div style="font-size: 0.75rem; color: #64748b; margin-top: 4px;" id="add_file_hint">
                    Supports high-resolution JPG, PNG, WEBP, GIF (Max 500MB)
                </div>
            </div>

            <!-- Optional Video Thumbnail (Shown when video type selected) -->
            <div id="add_thumbnail_section" style="display: none; background: #faf5ff; border: 1.5px dashed #7c3aed; border-radius: 12px; padding: 1.2rem; margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 800; font-size: 0.88rem; color: #7c3aed; margin-bottom: 6px;">
                    🖼️ Optional Custom Video Thumbnail (JPG, PNG)
                </label>
                <input type="file" name="thumbnail" accept="image/*" style="width: 100%; padding: 0.55rem; background: #fff; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; cursor: pointer; box-sizing: border-box;">
                <div style="font-size: 0.75rem; color: #64748b; margin-top: 4px;">
                    Displays on video card before user plays or downloads.
                </div>
            </div>

            <!-- External File / Fallback URL -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">External Media Link (Optional / Cloud Drive)</label>
                <input type="url" name="file_url" placeholder="https://..." style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                <div style="font-size: 0.72rem; color: #64748b; margin-top: 3px;">Use if media is hosted on external CDN or Google Drive direct download.</div>
            </div>

            <!-- Social Caption / Description -->
            <div style="margin-bottom: 1.4rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                    📝 Social Caption &amp; Description (Affiliates can copy this)
                </label>
                <textarea name="description" rows="3" placeholder="Write ready-made caption, hashtags and call-to-action that students can copy &amp; paste with this asset..." style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box;"></textarea>
            </div>

            <!-- Active Visibility Checkbox -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 0.88rem; color: #0f172a; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" checked style="width: 18px; height: 18px; accent-color: #05B396;">
                    <span>Publish immediately (Make visible on Affiliate Marketing page)</span>
                </label>
            </div>

            <!-- Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeAddToolModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" style="background: #05B396; color: #ffffff; border: none; padding: 0.65rem 1.5rem; border-radius: 8px; font-weight: 800; cursor: pointer; box-shadow: 0 4px 12px rgba(5,179,150,0.3);">
                    Save &amp; Upload
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- 2. EDIT MARKETING TOOL MODAL -->
<!-- ========================================== -->
<div id="editToolModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); overflow-y: auto; padding: 1.5rem 1rem;">
    <div style="max-width: 620px; margin: 1rem auto; background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,0.3);">
        <!-- Modal Header -->
        <div style="background: linear-gradient(135deg, #0A6B5C 0%, #0f172a 100%); color: #ffffff; padding: 1.5rem 1.8rem; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800;">✏️ Edit Marketing Asset</h3>
                <p style="margin: 4px 0 0; opacity: 0.85; font-size: 0.85rem;">Modify title, replace media file, or update social caption</p>
            </div>
            <button type="button" onclick="closeEditToolModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; width: 34px; height: 34px; border-radius: 50%; font-size: 1.3rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>

        <form id="editToolForm" method="POST" action="" enctype="multipart/form-data" style="padding: 1.8rem;">
            @csrf
            @method('PUT')

            <!-- Type -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Asset Type</label>
                <select id="edit_type" name="type" onchange="toggleEditAssetType(this.value)" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box; background: #fff;">
                    <option value="photo">🖼️ Photo / Poster / Banner</option>
                    <option value="video">🎥 Short Video (Reel / Story)</option>
                </select>
            </div>

            <!-- Title -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Asset Title *</label>
                <input type="text" id="edit_title" name="title" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
            </div>

            <!-- Category & Sort Order Grid -->
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Category / Tag</label>
                    <input type="text" id="edit_category" name="category" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Sort Order</label>
                    <input type="number" id="edit_sort_order" name="sort_order" min="0" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Replace Media File -->
            <div style="background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 12px; padding: 1.2rem; margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 800; font-size: 0.88rem; color: #0f172a; margin-bottom: 6px;" id="edit_file_label">
                    📁 Replace Media File (Leave blank to keep existing)
                </label>
                <div id="edit_current_preview" style="font-size: 0.78rem; color: #05B396; margin-bottom: 6px; font-weight: 700;"></div>
                <input type="file" id="edit_media_file" name="file" style="width: 100%; padding: 0.55rem; background: #fff; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; cursor: pointer; box-sizing: border-box;">
            </div>

            <!-- Replace Thumbnail File (Video Only) -->
            <div id="edit_thumbnail_section" style="background: #faf5ff; border: 1.5px dashed #7c3aed; border-radius: 12px; padding: 1.2rem; margin-bottom: 1.2rem; display: none;">
                <label style="display: block; font-weight: 800; font-size: 0.88rem; color: #7c3aed; margin-bottom: 6px;">
                    🖼️ Replace Custom Thumbnail Image
                </label>
                <div id="edit_current_thumb" style="font-size: 0.78rem; color: #7c3aed; margin-bottom: 6px; font-weight: 700;"></div>
                <input type="file" name="thumbnail" accept="image/*" style="width: 100%; padding: 0.55rem; background: #fff; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; cursor: pointer; box-sizing: border-box;">
            </div>

            <!-- External File / Fallback URL -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">External Media Link</label>
                <input type="url" id="edit_file_url" name="file_url" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
            </div>

            <!-- Social Caption / Description -->
            <div style="margin-bottom: 1.4rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Social Caption &amp; Description</label>
                <textarea id="edit_description" name="description" rows="3" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box;"></textarea>
            </div>

            <!-- Active Visibility Checkbox -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 0.88rem; color: #0f172a; cursor: pointer;">
                    <input type="checkbox" id="edit_is_active" name="is_active" value="1" style="width: 18px; height: 18px; accent-color: #05B396;">
                    <span>Active &amp; Visible to Affiliate Users</span>
                </label>
            </div>

            <!-- Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeEditToolModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" style="background: #0A6B5C; color: #ffffff; border: none; padding: 0.65rem 1.5rem; border-radius: 8px; font-weight: 800; cursor: pointer;">
                    Update Asset
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function toggleAssetType(type) {
        const fileLabel = document.getElementById('add_file_label');
        const fileInput = document.getElementById('add_media_file');
        const fileHint = document.getElementById('add_file_hint');
        const thumbSection = document.getElementById('add_thumbnail_section');
        const catInput = document.getElementById('add_category_input');

        if (type === 'video') {
            fileLabel.innerHTML = '🎥 Upload Short Video File (MP4, MOV, WEBM) *';
            fileInput.accept = 'video/mp4,video/webm,video/quicktime,video/*';
            fileHint.innerText = '9:16 vertical short or reel video file (Max 500MB)';
            thumbSection.style.display = 'block';
            if (!catInput.value || catInput.value === 'Posters & Flyers') {
                catInput.value = 'Shorts & Reels';
            }
        } else {
            fileLabel.innerHTML = '📁 Upload Photo File (JPG, PNG, WEBP, GIF, SVG) *';
            fileInput.accept = 'image/*';
            fileHint.innerText = 'High-resolution image, flyer, or story graphic (Max 500MB)';
            thumbSection.style.display = 'none';
            if (!catInput.value || catInput.value === 'Shorts & Reels') {
                catInput.value = 'Posters & Flyers';
            }
        }
    }

    function toggleEditAssetType(type) {
        const fileLabel = document.getElementById('edit_file_label');
        const fileInput = document.getElementById('edit_media_file');
        const thumbSection = document.getElementById('edit_thumbnail_section');

        if (type === 'video') {
            fileLabel.innerText = '🎥 Replace Short Video File (MP4, MOV, WEBM)';
            fileInput.accept = 'video/mp4,video/webm,video/quicktime,video/*';
            thumbSection.style.display = 'block';
        } else {
            fileLabel.innerText = '📁 Replace Photo File (JPG, PNG, WEBP, GIF, SVG)';
            fileInput.accept = 'image/*';
            thumbSection.style.display = 'none';
        }
    }

    function openAddToolModal() {
        document.getElementById('addToolModal').style.display = 'block';
    }
    function closeAddToolModal() {
        document.getElementById('addToolModal').style.display = 'none';
    }

    function openEditToolModal(tool) {
        const form = document.getElementById('editToolForm');
        form.action = '/admin/marketing-tools/' + tool.id;

        document.getElementById('edit_type').value = tool.type || 'photo';
        toggleEditAssetType(tool.type || 'photo');

        document.getElementById('edit_title').value = tool.title || '';
        document.getElementById('edit_category').value = tool.category || '';
        document.getElementById('edit_sort_order').value = tool.sort_order || 0;
        document.getElementById('edit_file_url').value = tool.file_url || '';
        document.getElementById('edit_description').value = tool.description || '';
        document.getElementById('edit_is_active').checked = Boolean(tool.is_active);

        const curPreview = document.getElementById('edit_current_preview');
        if (tool.file_path) {
            curPreview.innerText = '✓ Current file: ' + tool.file_path;
        } else if (tool.file_url) {
            curPreview.innerText = '✓ Current URL: ' + tool.file_url;
        } else {
            curPreview.innerText = '';
        }

        const curThumb = document.getElementById('edit_current_thumb');
        if (tool.thumbnail_path) {
            curThumb.innerText = '✓ Current thumbnail: ' + tool.thumbnail_path;
        } else {
            curThumb.innerText = '';
        }

        document.getElementById('editToolModal').style.display = 'block';
    }
    function closeEditToolModal() {
        document.getElementById('editToolModal').style.display = 'none';
    }
</script>
@endpush
@endsection
