@extends('layouts.app')

@section('title', 'Live Offers & Poster Management — SkillLearner Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-live-offers'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-live-offers'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header & Action Row -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(5, 179, 150, 0.12); color: #05B396; font-size: 0.75rem; font-weight: 800; padding: 3px 10px; border-radius: 20px; margin-bottom: 0.4rem;">
                        🎯 CONTESTS &amp; PROMOTIONS MANAGEMENT
                    </div>
                    <h2 class="welcome-heading" style="font-size: clamp(1.2rem, 4.5vw, 1.6rem); word-break: break-word; overflow-wrap: anywhere; margin-bottom: 0.25rem;">
                        Live Offers &amp; Poster Upload
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Upload promotional posters, set prize rewards (Goa trip, cash bonus, etc.), milestone targets, and manage active contest timelines.
                    </p>
                </div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="{{ route('portal.live-offers') }}" target="_blank" style="background: #ffffff; color: #05B396; border: 1.5px solid #05B396; padding: 0.75rem 1.2rem; border-radius: 10px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 0.9rem; box-shadow: 0 2px 8px rgba(5,179,150,0.12);">
                        <span>View Student Offers</span>
                        <span>↗</span>
                    </a>
                    <button type="button" onclick="openAddOfferModal()" style="background: linear-gradient(135deg, #05B396 0%, #04826d 100%); color: #ffffff; border: none; padding: 0.75rem 1.4rem; border-radius: 10px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 16px rgba(5, 179, 150, 0.35); font-size: 0.92rem; transition: transform 0.15s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add Live Offer</span>
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
                <!-- Total Offers -->
                <div class="admin-stat-card">
                    <div class="admin-stat-label">TOTAL LIVE OFFERS</div>
                    <div class="admin-stat-val">{{ $counts['total'] }}</div>
                    <div class="admin-stat-sub">Across all contests</div>
                </div>

                <!-- Active Offers -->
                <div class="admin-stat-card" style="border-top: 3px solid #05B396;">
                    <div class="admin-stat-label" style="color: #05B396;">👁️ ACTIVE &amp; LIVE</div>
                    <div class="admin-stat-val" style="color: #05B396;">{{ $counts['active'] }}</div>
                    <div class="admin-stat-sub">Shown on /live-offers</div>
                </div>

                <!-- Hidden Offers -->
                <div class="admin-stat-card" style="border-top: 3px solid #f59e0b;">
                    <div class="admin-stat-label" style="color: #d97706;">🙈 HIDDEN / DRAFTS</div>
                    <div class="admin-stat-val" style="color: #d97706;">{{ $counts['hidden'] }}</div>
                    <div class="admin-stat-sub">Unpublished offers</div>
                </div>

                <!-- Downloads -->
                <div class="admin-stat-card" style="border-top: 3px solid #3b82f6;">
                    <div class="admin-stat-label" style="color: #2563eb;">📥 POSTER DOWNLOADS</div>
                    <div class="admin-stat-val" style="color: #2563eb;">{{ $counts['downloads'] }}</div>
                    <div class="admin-stat-sub">Total times saved by affiliates</div>
                </div>
            </div>

            <!-- Filters & Search Bar -->
            <div class="portal-box-card" style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; padding: 1.2rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="{{ route('admin.live-offers', ['status' => 'all', 'search' => request('search')]) }}" 
                       style="padding: 0.45rem 0.9rem; border-radius: 8px; font-size: 0.82rem; font-weight: 700; text-decoration: none; {{ $statusFilter === 'all' ? 'background: #05B396; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                        All ({{ $counts['total'] }})
                    </a>
                    <a href="{{ route('admin.live-offers', ['status' => 'active', 'search' => request('search')]) }}" 
                       style="padding: 0.45rem 0.9rem; border-radius: 8px; font-size: 0.82rem; font-weight: 700; text-decoration: none; {{ $statusFilter === 'active' ? 'background: #05B396; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                        Active ({{ $counts['active'] }})
                    </a>
                    <a href="{{ route('admin.live-offers', ['status' => 'hidden', 'search' => request('search')]) }}" 
                       style="padding: 0.45rem 0.9rem; border-radius: 8px; font-size: 0.82rem; font-weight: 700; text-decoration: none; {{ $statusFilter === 'hidden' ? 'background: #05B396; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                        Hidden ({{ $counts['hidden'] }})
                    </a>
                </div>

                <form method="GET" action="{{ route('admin.live-offers') }}" style="display: flex; gap: 6px; flex: 1; max-width: 340px;">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search offer title, prize, badge..." style="flex: 1; padding: 0.45rem 0.85rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem;">
                    <button type="submit" style="background: #334155; color: #fff; border: none; padding: 0.45rem 0.9rem; border-radius: 8px; font-weight: 700; font-size: 0.82rem; cursor: pointer;">
                        Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.live-offers', request()->except('search')) }}" style="display: flex; align-items: center; justify-content: center; padding: 0.45rem 0.7rem; background: #e2e8f0; border-radius: 8px; color: #475569; text-decoration: none; font-size: 0.85rem;">✕</a>
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
                                <th style="padding: 0.9rem 1.1rem;">Offer Title &amp; Badge</th>
                                <th style="padding: 0.9rem 1.1rem;">Reward &amp; Target</th>
                                <th style="padding: 0.9rem 1.1rem;">Timeline</th>
                                <th style="padding: 0.9rem 1.1rem; text-align: center;">Downloads</th>
                                <th style="padding: 0.9rem 1.1rem; text-align: center;">Status</th>
                                <th style="padding: 0.9rem 1.1rem; text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($offers as $offer)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#fbfcfe'" onmouseout="this.style.background='transparent'">
                                    <!-- Order -->
                                    <td style="padding: 1rem 1.1rem; font-weight: 800; color: #94a3b8;">
                                        #{{ $offer->sort_order }}
                                    </td>

                                    <!-- Poster Thumbnail -->
                                    <td style="padding: 1rem 1.1rem;">
                                        <a href="{{ $offer->poster_image }}" target="_blank" rel="noopener noreferrer" style="display: block; width: 80px; height: 48px; border-radius: 8px; overflow: hidden; border: 1px solid #cbd5e1; background: #0f172a;" title="Click to view full poster">
                                            <img src="{{ $offer->poster_image }}" alt="{{ $offer->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        </a>
                                    </td>

                                    <!-- Title & Badge -->
                                    <td style="padding: 1rem 1.1rem; max-width: 260px;">
                                        <div style="font-weight: 800; color: #0f172a; font-size: 0.95rem; margin-bottom: 2px;">
                                            {{ $offer->title }}
                                        </div>
                                        @if($offer->badge)
                                            <span style="font-size: 0.68rem; font-weight: 800; text-transform: uppercase; background: #e0f2fe; color: #0369a1; padding: 2px 7px; border-radius: 4px;">
                                                {{ $offer->badge }}
                                            </span>
                                        @endif
                                        @if($offer->subtitle)
                                            <div style="font-size: 0.8rem; color: #64748b; margin-top: 4px; line-height: 1.35;">
                                                {{ $offer->subtitle }}
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Reward & Target -->
                                    <td style="padding: 1rem 1.1rem; max-width: 240px;">
                                        @if($offer->prize)
                                            <div style="font-size: 0.85rem; font-weight: 700; color: #166534; display: flex; align-items: center; gap: 4px;">
                                                <span>🎁</span> <span>{{ $offer->prize }}</span>
                                            </div>
                                        @endif
                                        @if($offer->target_criteria)
                                            <div style="font-size: 0.8rem; color: #1e40af; font-weight: 600; margin-top: 3px; display: flex; align-items: center; gap: 4px;">
                                                <span>🎯</span> <span>{{ $offer->target_criteria }}</span>
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Timeline -->
                                    <td style="padding: 1rem 1.1rem; font-size: 0.82rem; color: #475569;">
                                        @if($offer->ends_at)
                                            <div style="font-weight: 700; color: {{ $offer->is_running ? '#05B396' : '#ef4444' }};">
                                                {{ $offer->is_running ? '🟢 Running' : '🔴 Expired' }}
                                            </div>
                                            <div style="margin-top: 2px; font-size: 0.78rem; color: #64748b;">
                                                Ends: {{ \Carbon\Carbon::parse($offer->ends_at)->format('d M, Y') }}
                                            </div>
                                            @if($offer->days_remaining !== null)
                                                <div style="font-size: 0.75rem; font-weight: 800; color: #d97706;">
                                                    ⏳ {{ $offer->days_remaining }} days left
                                                </div>
                                            @endif
                                        @else
                                            <span style="font-weight: 700; color: #64748b;">Ongoing / No Expiry</span>
                                        @endif
                                    </td>

                                    <!-- Downloads -->
                                    <td style="padding: 1rem 1.1rem; text-align: center; font-weight: 800; color: #2563eb;">
                                        {{ $offer->download_count }}
                                    </td>

                                    <!-- Status Toggle -->
                                    <td style="padding: 1rem 1.1rem; text-align: center;">
                                        <form method="POST" action="{{ route('admin.live-offers.toggle-status', $offer) }}" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" title="Click to toggle visibility" style="cursor: pointer; border: none; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; display: inline-flex; align-items: center; gap: 4px; {{ $offer->is_active ? 'background: #dcfce7; color: #15803d;' : 'background: #fee2e2; color: #b91c1c;' }}">
                                                <span style="width: 7px; height: 7px; border-radius: 50%; background: currentColor;"></span>
                                                <span>{{ $offer->is_active ? 'Active' : 'Hidden' }}</span>
                                            </button>
                                        </form>
                                    </td>

                                    <!-- Actions -->
                                    <td style="padding: 1rem 1.1rem; text-align: right;">
                                        <div style="display: flex; gap: 6px; justify-content: flex-end; align-items: center;">
                                            <!-- Download Poster Button -->
                                            <a href="{{ route('portal.live-offers.download', $offer) }}" title="Download Poster" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; padding: 5px 9px; border-radius: 6px; font-size: 0.78rem; text-decoration: none; display: inline-flex; align-items: center;">
                                                📥
                                            </a>

                                            <!-- Edit Button -->
                                            <button type="button" onclick='openEditOfferModal(@json($offer))' style="background: #f1f5f9; color: #1e293b; border: 1px solid #cbd5e1; padding: 5px 12px; border-radius: 6px; font-weight: 700; font-size: 0.78rem; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                                ✏️ Edit
                                            </button>

                                            <!-- Delete Button -->
                                            <form method="POST" action="{{ route('admin.live-offers.destroy', $offer) }}" onsubmit="return confirm('Are you sure you want to delete \'{{ addslashes($offer->title) }}\'?');" style="display: inline-block;">
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
                                        <div style="font-size: 2.2rem; margin-bottom: 0.5rem;">🎯</div>
                                        <div style="font-weight: 700; font-size: 1.1rem; color: #1e293b;">No Live Offers Found</div>
                                        <p style="font-size: 0.85rem; margin-top: 4px;">Click the "Add Live Offer" button above to upload a promotional contest poster.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($offers->hasPages())
                    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
                        {{ $offers->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

<!-- Add Live Offer Modal -->
<div id="addOfferModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 99999; overflow-y: auto; padding: 1.5rem;">
    <div style="background: #ffffff; max-width: 660px; margin: 2rem auto; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden;">
        <div style="background: #05B396; color: #ffffff; padding: 1.2rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-weight: 800; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                <span>🎯 Add New Live Offer &amp; Contest</span>
            </div>
            <button type="button" onclick="closeAddOfferModal()" style="background: transparent; border: none; color: #ffffff; font-size: 1.4rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.live-offers.store') }}" enctype="multipart/form-data" style="padding: 1.5rem;">
            @csrf

            <!-- Title & Subtitle Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Offer Title *
                    </label>
                    <input type="text" name="title" required placeholder="e.g. Goa National Tour Contest 2026" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Subtitle / Tagline
                    </label>
                    <input type="text" name="subtitle" placeholder="e.g. 3 Nights & 4 Days Luxury Resort Trip" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Poster File Upload & URL -->
            <div style="background: #f8fafc; border: 1.5px dashed #05B396; border-radius: 12px; padding: 1.1rem; margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 800; font-size: 0.85rem; color: #0f172a; margin-bottom: 6px;">
                    🖼️ Poster Image Upload (File Upload or External URL)
                </label>
                <div style="margin-bottom: 8px;">
                    <input type="file" name="poster" accept="image/*" style="font-size: 0.85rem; cursor: pointer;">
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 0.78rem; font-weight: 700; color: #64748b;">OR POSTER URL:</span>
                    <input type="url" name="poster_url" placeholder="https://... (image URL)" style="flex: 1; padding: 0.5rem 0.8rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.85rem; background: #fff;">
                </div>
                <span style="font-size: 0.75rem; color: #64748b; margin-top: 4px; display: block;">High resolution 16:9 banner recommended (PNG, JPG, WEBP).</span>
            </div>

            <!-- Reward Prize & Target Criteria -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        🎁 Reward / Prize
                    </label>
                    <input type="text" name="prize" placeholder="e.g. All-Expenses-Paid Goa Vacation" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        🎯 Target Criteria
                    </label>
                    <input type="text" name="target_criteria" placeholder="e.g. 50 Package Sales" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Badge, Sort Order & Validity Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0.8rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 4px;">Badge</label>
                    <input type="text" name="badge" placeholder="e.g. GOA TRIP" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 4px;">Valid Ends At</label>
                    <input type="date" name="ends_at" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 4px;">Sort Order</label>
                    <input type="number" name="sort_order" min="0" value="{{ $counts['total'] + 1 }}" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Description -->
            <div style="margin-bottom: 1.3rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Offer Description</label>
                <textarea name="description" rows="3" placeholder="Explain details, terms, hotel stay inclusions, or qualification milestones..." style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box;"></textarea>
            </div>

            <!-- Active Visibility Checkbox -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 0.88rem; color: #0f172a; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" checked style="width: 18px; height: 18px; accent-color: #05B396;">
                    <span>Active &amp; Visible to Students Immediately</span>
                </label>
            </div>

            <!-- Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeAddOfferModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" style="background: #05B396; color: #ffffff; border: none; padding: 0.65rem 1.5rem; border-radius: 8px; font-weight: 800; cursor: pointer; box-shadow: 0 4px 12px rgba(5, 179, 150, 0.3);">
                    Create Live Offer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Live Offer Modal -->
<div id="editOfferModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 99999; overflow-y: auto; padding: 1.5rem;">
    <div style="background: #ffffff; max-width: 660px; margin: 2rem auto; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden;">
        <div style="background: #0f172a; color: #ffffff; padding: 1.2rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-weight: 800; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                <span>✏️ Edit Live Offer &amp; Poster</span>
            </div>
            <button type="button" onclick="closeEditOfferModal()" style="background: transparent; border: none; color: #ffffff; font-size: 1.4rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <form id="editOfferForm" method="POST" action="" enctype="multipart/form-data" style="padding: 1.5rem;">
            @csrf
            @method('PUT')

            <!-- Title & Subtitle Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Offer Title *
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

            <!-- Reward Prize & Target Criteria -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        🎁 Reward / Prize
                    </label>
                    <input type="text" id="edit_prize" name="prize" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        🎯 Target Criteria
                    </label>
                    <input type="text" id="edit_target_criteria" name="target_criteria" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Badge, Sort Order & Validity Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0.8rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 4px;">Badge</label>
                    <input type="text" id="edit_badge" name="badge" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 4px;">Valid Ends At</label>
                    <input type="date" id="edit_ends_at" name="ends_at" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 4px;">Sort Order</label>
                    <input type="number" id="edit_sort_order" name="sort_order" min="0" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Description -->
            <div style="margin-bottom: 1.3rem;">
                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Offer Description</label>
                <textarea id="edit_description" name="description" rows="3" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box;"></textarea>
            </div>

            <!-- Active Visibility Checkbox -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 0.88rem; color: #0f172a; cursor: pointer;">
                    <input type="checkbox" id="edit_is_active" name="is_active" value="1" style="width: 18px; height: 18px; accent-color: #05B396;">
                    <span>Active &amp; Visible to Students</span>
                </label>
            </div>

            <!-- Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeEditOfferModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" style="background: #0f172a; color: #ffffff; border: none; padding: 0.65rem 1.5rem; border-radius: 8px; font-weight: 800; cursor: pointer;">
                    Update Live Offer
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openAddOfferModal() {
        document.getElementById('addOfferModal').style.display = 'block';
    }
    function closeAddOfferModal() {
        document.getElementById('addOfferModal').style.display = 'none';
    }

    function openEditOfferModal(item) {
        const form = document.getElementById('editOfferForm');
        form.action = '/admin/live-offers/' + item.id;

        document.getElementById('edit_title').value = item.title || '';
        document.getElementById('edit_subtitle').value = item.subtitle || '';
        document.getElementById('edit_poster_preview').src = item.poster_image || '';
        document.getElementById('edit_poster_url').value = item.poster_url || '';
        document.getElementById('edit_badge').value = item.badge || '';
        document.getElementById('edit_prize').value = item.prize || '';
        document.getElementById('edit_target_criteria').value = item.target_criteria || '';
        document.getElementById('edit_sort_order').value = item.sort_order || 0;
        document.getElementById('edit_description').value = item.description || '';
        document.getElementById('edit_is_active').checked = Boolean(item.is_active);

        if (item.ends_at) {
            const dateStr = item.ends_at.split('T')[0] || item.ends_at.split(' ')[0];
            document.getElementById('edit_ends_at').value = dateStr;
        } else {
            document.getElementById('edit_ends_at').value = '';
        }

        document.getElementById('editOfferModal').style.display = 'block';
    }
    function closeEditOfferModal() {
        document.getElementById('editOfferModal').style.display = 'none';
    }

    setTimeout(() => {
        const flash = document.getElementById('flashSuccess');
        if (flash) flash.style.display = 'none';
    }, 5000);
</script>
@endpush
@endsection
