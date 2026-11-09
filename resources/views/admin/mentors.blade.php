@extends('layouts.app')

@section('title', 'Mentor Management — SkillLearner Super Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-mentors'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-mentors'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header & Action Row -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(124, 58, 237, 0.12); color: #7c3aed; font-size: 0.75rem; font-weight: 800; padding: 3px 10px; border-radius: 20px; margin-bottom: 0.4rem;">
                        👑 SUPER ADMIN &amp; ADMIN ACCESS
                    </div>
                    <h2 class="welcome-heading" style="font-size: clamp(1.2rem, 4.5vw, 1.65rem); word-break: break-word; overflow-wrap: anywhere; margin-bottom: 0.25rem;">
                        👥 Mentor Management &amp; Instructor Hub
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Add mentors, assign courses, set commission &amp; revenue share %, approve payouts, and manage KYC verification.
                    </p>
                </div>
                <button type="button" onclick="openAddMentorModal()" style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); color: #ffffff; border: none; padding: 0.75rem 1.4rem; border-radius: 10px; font-weight: 800; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 16px rgba(124, 58, 237, 0.35); font-size: 0.92rem; cursor: pointer; transition: transform 0.15s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                    <span>Add New Mentor</span>
                </button>
            </div>

            <!-- Flash Notifications -->
            @if(session('success'))
                <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if(session('info'))
                <div style="background: #eff6ff; border-left: 4px solid #3b82f6; color: #1e40af; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ℹ️ {{ session('info') }}
                </div>
            @endif
            @if($errors->any())
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ⚠️ {{ $errors->first() }}
                </div>
            @endif

            <!-- Stat Cards Grid -->
            <div class="admin-stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 1rem; margin-bottom: 1.8rem;">
                <div class="admin-stat-card">
                    <div class="admin-stat-label">TOTAL MENTORS</div>
                    <div class="admin-stat-val">{{ $stats['total_mentors'] }}</div>
                    <div class="admin-stat-sub">Registered platform instructors</div>
                </div>

                <div class="admin-stat-card" style="border-top: 3px solid #05B396;">
                    <div class="admin-stat-label" style="color: #05B396;">ACTIVE INSTRUCTORS</div>
                    <div class="admin-stat-val" style="color: #05B396;">{{ $stats['active_mentors'] }}</div>
                    <div class="admin-stat-sub">{{ $stats['blocked_mentors'] }} currently blocked</div>
                </div>

                <div class="admin-stat-card" style="border-top: 3px solid #0A6B5C;">
                    <div class="admin-stat-label" style="color: #0A6B5C;">ON HOMEPAGE</div>
                    <div class="admin-stat-val" style="color: #0A6B5C;">{{ $stats['featured_mentors'] }}</div>
                    <div class="admin-stat-sub">Shown in Expert Team grid</div>
                </div>

                <div class="admin-stat-card" style="border-top: 3px solid #f59e0b;">
                    <div class="admin-stat-label" style="color: #d97706;">PENDING KYC</div>
                    <div class="admin-stat-val" style="color: #d97706;">{{ $stats['pending_kyc'] }}</div>
                    <div class="admin-stat-sub">Verification requests</div>
                </div>

                <div class="admin-stat-card" style="border-top: 3px solid #7c3aed;">
                    <div class="admin-stat-label" style="color: #7c3aed;">PENDING PAYOUTS</div>
                    <div class="admin-stat-val" style="color: #7c3aed;">{{ $stats['pending_payouts'] }}</div>
                    <div class="admin-stat-sub">Awaiting admin transfer</div>
                </div>

                <div class="admin-stat-card" style="border-top: 3px solid #10b981;">
                    <div class="admin-stat-label" style="color: #10b981;">TOTAL PAID OUT</div>
                    <div class="admin-stat-val" style="color: #10b981; font-size: 1.4rem;">₹{{ number_format($stats['total_paid']) }}</div>
                    <div class="admin-stat-sub">Processed mentor revenue</div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div style="display: flex; gap: 8px; border-bottom: 2px solid #e2e8f0; margin-bottom: 1.5rem; flex-wrap: wrap;">
                <button type="button" onclick="switchMentorTab('mentors')" id="tabBtn-mentors" class="mentor-tab-btn active" style="padding: 10px 18px; font-weight: 700; font-size: 0.95rem; border: none; background: transparent; cursor: pointer; border-bottom: 3px solid #7c3aed; color: #7c3aed;">
                    👨‍🏫 All Mentors ({{ $stats['total_mentors'] }})
                </button>
                <button type="button" onclick="switchMentorTab('kyc')" id="tabBtn-kyc" class="mentor-tab-btn" style="padding: 10px 18px; font-weight: 700; font-size: 0.95rem; border: none; background: transparent; cursor: pointer; border-bottom: 3px solid transparent; color: #64748b;">
                    📄 KYC Verification ({{ $stats['pending_kyc'] }})
                </button>
                <button type="button" onclick="switchMentorTab('payouts')" id="tabBtn-payouts" class="mentor-tab-btn" style="padding: 10px 18px; font-weight: 700; font-size: 0.95rem; border: none; background: transparent; cursor: pointer; border-bottom: 3px solid transparent; color: #64748b;">
                    💳 Payouts &amp; History ({{ $stats['pending_payouts'] }})
                </button>
            </div>

            <!-- TAB 1: ALL MENTORS -->
            <div id="tabContent-mentors" class="mentor-tab-content">
                <!-- Search & Filters Toolbar -->
                <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.2rem; margin-bottom: 1.5rem;">
                    <form method="GET" action="{{ url('/admin/mentors') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; justify-content: space-between;">
                        <input type="hidden" name="tab" value="mentors">
                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            <a href="{{ url('/admin/mentors?status=all') }}" class="admin-filter-pill {{ $statusFilter === 'all' ? 'active' : '' }}">
                                All ({{ $stats['total_mentors'] }})
                            </a>
                            <a href="{{ url('/admin/mentors?status=active') }}" class="admin-filter-pill {{ $statusFilter === 'active' ? 'active' : '' }}" style="{{ $statusFilter === 'active' ? 'background: #05B396; border-color: #05B396;' : '' }}">
                                Active ({{ $stats['active_mentors'] }})
                            </a>
                            <a href="{{ url('/admin/mentors?status=blocked') }}" class="admin-filter-pill {{ $statusFilter === 'blocked' ? 'active' : '' }}" style="{{ $statusFilter === 'blocked' ? 'background: #ef4444; border-color: #ef4444;' : '' }}">
                                Blocked ({{ $stats['blocked_mentors'] }})
                            </a>
                            <a href="{{ url('/admin/mentors?featured=yes') }}" class="admin-filter-pill {{ $featuredFilter === 'yes' ? 'active' : '' }}" style="{{ $featuredFilter === 'yes' ? 'background: #0A6B5C; border-color: #0A6B5C; color: #fff;' : '' }}">
                                👁️ On Homepage ({{ $stats['featured_mentors'] }})
                            </a>
                        </div>
                        <div style="display: flex; gap: 8px; flex: 1; max-width: 380px;">
                            <input type="text" name="search" value="{{ $search }}" placeholder="Search by mentor name, email, expertise..." style="flex: 1; padding: 0.65rem 1rem; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.88rem; outline: none;">
                            <button type="submit" style="background: #0f172a; color: #ffffff; border: none; padding: 0.65rem 1.2rem; border-radius: 10px; font-weight: 700; cursor: pointer;">Search</button>
                        </div>
                    </form>
                </div>

                <!-- Mentors Table -->
                <div class="admin-table-wrapper" style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.88rem; text-align: left;">
                            <thead>
                                <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-weight: 700;">
                                    <th style="padding: 1rem;">Mentor Profile</th>
                                    <th style="padding: 1rem;">Expertise &amp; Experience</th>
                                    <th style="padding: 1rem;">Assigned Courses</th>
                                    <th style="padding: 1rem;">Revenue Share %</th>
                                    <th style="padding: 1rem;">Homepage Display</th>
                                    <th style="padding: 1rem;">KYC Status</th>
                                    <th style="padding: 1rem;">Status</th>
                                    <th style="padding: 1rem; text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mentors as $mentor)
                                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#faf5ff'" onmouseout="this.style.background='transparent'">
                                        <!-- Mentor Profile -->
                                        <td style="padding: 1rem;">
                                            <div style="display: flex; align-items: center; gap: 12px;">
                                                <img src="{{ $mentor->photo ?: 'https://ui-avatars.com/api/?name='.urlencode($mentor->name).'&background=7c3aed&color=ffffff&bold=true' }}" alt="{{ $mentor->name }}" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid #7c3aed; flex-shrink: 0;">
                                                <div>
                                                    <div style="font-weight: 800; color: #0f172a; font-size: 0.95rem;">{{ $mentor->name }}</div>
                                                    <div style="color: #64748b; font-size: 0.8rem;">{{ $mentor->email }}</div>
                                                    @if($mentor->phone)
                                                        <div style="color: #94a3b8; font-size: 0.75rem;">📞 {{ $mentor->phone }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Expertise & Experience -->
                                        <td style="padding: 1rem;">
                                            <div style="font-weight: 700; color: #1e293b;">{{ $mentor->expertise ?: 'Instructor' }}</div>
                                            <div style="color: #64748b; font-size: 0.8rem;">{{ $mentor->experience ?: 'Experienced' }} &bull; {{ $mentor->qualification ?: 'Certified' }}</div>
                                            <!-- Social links icons -->
                                            <div style="display: flex; gap: 6px; margin-top: 4px;">
                                                @if(!empty($mentor->social_links['linkedin']))
                                                    <a href="{{ $mentor->social_links['linkedin'] }}" target="_blank" title="LinkedIn" style="color: #0284c7; text-decoration: none; font-size: 0.75rem;">🔗 LinkedIn</a>
                                                @endif
                                                @if(!empty($mentor->social_links['youtube']))
                                                    <a href="{{ $mentor->social_links['youtube'] }}" target="_blank" title="YouTube" style="color: #ef4444; text-decoration: none; font-size: 0.75rem;">▶️ YouTube</a>
                                                @endif
                                                @if(!empty($mentor->social_links['github']))
                                                    <a href="{{ $mentor->social_links['github'] }}" target="_blank" title="GitHub" style="color: #334155; text-decoration: none; font-size: 0.75rem;">💻 GitHub</a>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Assigned Courses -->
                                        <td style="padding: 1rem;">
                                            @php
                                                $assignedIds = is_array($mentor->assigned_courses) ? $mentor->assigned_courses : [];
                                                $assignedCoursesList = $courses->whereIn('id', $assignedIds);
                                            @endphp
                                            @if($assignedCoursesList->isNotEmpty())
                                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                                    @foreach($assignedCoursesList as $ac)
                                                        <span style="background: rgba(124, 58, 237, 0.1); color: #7c3aed; font-size: 0.75rem; font-weight: 700; padding: 2px 8px; border-radius: 6px; display: inline-block;">
                                                            📚 {{ Str::limit($ac->title, 25) }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span style="color: #94a3b8; font-size: 0.8rem; font-style: italic;">No courses assigned</span>
                                            @endif
                                        </td>

                                        <!-- Commission % -->
                                        <td style="padding: 1rem;">
                                            <span style="background: rgba(5, 179, 150, 0.15); color: #05B396; font-size: 0.85rem; font-weight: 800; padding: 4px 10px; border-radius: 8px; display: inline-block;">
                                                {{ (float) $mentor->commission_percentage }}% Share
                                            </span>
                                            <div style="font-size: 0.75rem; color: #64748b; margin-top: 4px;">
                                                Earned: ₹{{ number_format($mentor->total_earned) }}
                                            </div>
                                        </td>

                                        <!-- Homepage Display 1-Click Toggle -->
                                        <td style="padding: 1rem;">
                                            <form method="POST" action="{{ route('admin.mentors.toggle-featured', $mentor) }}">
                                                @csrf
                                                @if($mentor->is_featured)
                                                    <button type="submit" title="Click to remove from homepage display" style="background: rgba(10, 107, 92, 0.12); border: 1.5px solid #0A6B5C; color: #0A6B5C; padding: 4px 10px; border-radius: 20px; font-weight: 800; font-size: 0.78rem; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; transition: all 0.2s ease;">
                                                        <span style="font-size: 0.85rem;">👁️</span>
                                                        <span>On Home</span>
                                                        <span style="background: #0A6B5C; color: #fff; border-radius: 50%; width: 14px; height: 14px; display: inline-flex; align-items: center; justify-content: center; font-size: 9px;">✓</span>
                                                    </button>
                                                @else
                                                    <button type="submit" title="Click to display on homepage" style="background: #f8fafc; border: 1.5px dashed #cbd5e1; color: #64748b; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 0.78rem; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; transition: all 0.2s ease;">
                                                        <span style="font-size: 0.85rem;">🙈</span>
                                                        <span>Hidden</span>
                                                        <span style="color: #94a3b8; font-size: 10px;">+ Show</span>
                                                    </button>
                                                @endif
                                            </form>
                                            @if($mentor->designation)
                                                <div style="font-size: 0.72rem; color: #64748b; margin-top: 4px; max-width: 140px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $mentor->designation }}">
                                                    {{ $mentor->designation }}
                                                </div>
                                            @endif
                                            @if($mentor->badge)
                                                <div style="font-size: 0.68rem; color: #7c3aed; font-weight: 700; margin-top: 2px;">
                                                    {{ $mentor->badge }}
                                                </div>
                                            @endif
                                        </td>

                                        <!-- KYC Status -->
                                        <td style="padding: 1rem;">
                                            @if($mentor->kyc_status === 'approved')
                                                <span style="background: #dcfce7; color: #15803d; font-size: 0.75rem; font-weight: 800; padding: 3px 9px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                                                    ✓ Verified
                                                </span>
                                            @elseif($mentor->kyc_status === 'pending')
                                                <span style="background: #fef9c3; color: #a16207; font-size: 0.75rem; font-weight: 800; padding: 3px 9px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                                                    ⏳ Pending
                                                </span>
                                            @else
                                                <span style="background: #fee2e2; color: #b91c1c; font-size: 0.75rem; font-weight: 800; padding: 3px 9px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                                                    ✗ Rejected
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Status -->
                                        <td style="padding: 1rem;">
                                            @if($mentor->status === 'active')
                                                <span style="background: #e0f2fe; color: #0369a1; font-size: 0.75rem; font-weight: 800; padding: 3px 9px; border-radius: 12px;">
                                                    Active
                                                </span>
                                            @else
                                                <span style="background: #fee2e2; color: #b91c1c; font-size: 0.75rem; font-weight: 800; padding: 3px 9px; border-radius: 12px;">
                                                    Blocked
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td style="padding: 1rem; text-align: right;">
                                            <div style="display: inline-flex; gap: 6px; align-items: center;">
                                                <!-- Edit Button -->
                                                <button type="button" onclick='openEditMentorModal(@json($mentor))' title="Edit Profile & Assign Courses" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; padding: 6px 10px; border-radius: 8px; font-weight: 700; font-size: 0.78rem; cursor: pointer;">
                                                    ✏️ Edit
                                                </button>

                                                <!-- Request Payout Modal Button -->
                                                <button type="button" onclick="openPayoutModal({{ $mentor->id }}, '{{ addslashes($mentor->name) }}')" title="Create Payout Request" style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 6px 10px; border-radius: 8px; font-weight: 700; font-size: 0.78rem; cursor: pointer;">
                                                    💳 Payout
                                                </button>

                                                <!-- Toggle Block/Unblock -->
                                                <form method="POST" action="{{ route('admin.mentors.toggle-status', $mentor) }}" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" onclick="return confirm('Change status for this mentor?')" title="{{ $mentor->status === 'active' ? 'Block Mentor' : 'Activate Mentor' }}" style="background: {{ $mentor->status === 'active' ? '#fff1f2' : '#f0fdf4' }}; border: 1px solid {{ $mentor->status === 'active' ? '#fecdd3' : '#bbf7d0' }}; color: {{ $mentor->status === 'active' ? '#be123c' : '#15803d' }}; padding: 6px 10px; border-radius: 8px; font-weight: 700; font-size: 0.78rem; cursor: pointer;">
                                                        {{ $mentor->status === 'active' ? '🚫 Block' : '✓ Unblock' }}
                                                    </button>
                                                </form>

                                                <!-- Delete Mentor -->
                                                <form method="POST" action="{{ route('admin.mentors.destroy', $mentor) }}" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this mentor?')" title="Delete Mentor" style="background: #fee2e2; border: 1px solid #fca5a5; color: #dc2626; padding: 6px 10px; border-radius: 8px; font-weight: 700; font-size: 0.78rem; cursor: pointer;">
                                                        🗑️
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" style="padding: 3rem; text-align: center; color: #94a3b8;">
                                            <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">👨‍🏫</div>
                                            <div style="font-weight: 700; color: #475569; font-size: 1.1rem; margin-bottom: 0.3rem;">No Mentors Found</div>
                                            <p style="margin: 0; font-size: 0.88rem;">Click "+ Add New Mentor" above to onboard your first instructor.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($mentors->hasPages())
                    <div style="margin-top: 1.5rem;">
                        {{ $mentors->links() }}
                    </div>
                @endif
            </div>

            <!-- TAB 2: KYC VERIFICATION -->
            <div id="tabContent-kyc" class="mentor-tab-content" style="display: none;">
                <div class="admin-table-wrapper" style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                    <div style="padding: 1.2rem; background: #f8fafc; border-bottom: 1.5px solid #e2e8f0;">
                        <h4 style="margin: 0; font-size: 1.05rem; color: #0f172a; font-weight: 800;">📄 Mentor KYC Approval &amp; Bank Verification</h4>
                        <p style="margin: 4px 0 0; font-size: 0.85rem; color: #64748b;">Review mentor PAN, Aadhar, Bank details and approve or reject verification.</p>
                    </div>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.88rem; text-align: left;">
                            <thead>
                                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; color: #475569;">
                                    <th style="padding: 1rem;">Mentor</th>
                                    <th style="padding: 1rem;">Bank / UPI Details</th>
                                    <th style="padding: 1rem;">Identity Numbers</th>
                                    <th style="padding: 1rem;">Current Status</th>
                                    <th style="padding: 1rem; text-align: right;">Approval Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mentors as $mentor)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="padding: 1rem;">
                                            <div style="font-weight: 800; color: #0f172a;">{{ $mentor->name }}</div>
                                            <div style="color: #64748b; font-size: 0.8rem;">{{ $mentor->email }}</div>
                                        </td>
                                        <td style="padding: 1rem;">
                                            <div><strong>Bank:</strong> {{ $mentor->bank_name ?: 'Not Provided' }}</div>
                                            <div><strong>A/C:</strong> {{ $mentor->account_number ?: '—' }} ({{ $mentor->ifsc_code ?: '—' }})</div>
                                            <div><strong>Holder:</strong> {{ $mentor->holder_name ?: '—' }}</div>
                                            <div><strong>UPI:</strong> {{ $mentor->upi_id ?: '—' }}</div>
                                        </td>
                                        <td style="padding: 1rem;">
                                            <div><strong>PAN:</strong> {{ $mentor->pan_number ?: 'Not Provided' }}</div>
                                            <div><strong>Aadhar:</strong> {{ $mentor->aadhar_number ?: 'Not Provided' }}</div>
                                        </td>
                                        <td style="padding: 1rem;">
                                            @if($mentor->kyc_status === 'approved')
                                                <span style="background: #dcfce7; color: #15803d; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 12px;">✓ Approved</span>
                                            @elseif($mentor->kyc_status === 'pending')
                                                <span style="background: #fef9c3; color: #a16207; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 12px;">⏳ Pending Review</span>
                                            @else
                                                <span style="background: #fee2e2; color: #b91c1c; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 12px;">✗ Rejected</span>
                                            @endif
                                        </td>
                                        <td style="padding: 1rem; text-align: right;">
                                            <form method="POST" action="{{ route('admin.mentors.kyc', $mentor) }}" style="display: inline-flex; gap: 6px;">
                                                @csrf
                                                @if($mentor->kyc_status !== 'approved')
                                                    <button type="submit" name="action" value="approve" style="background: #05B396; color: #fff; border: none; padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 0.8rem; cursor: pointer;">
                                                        ✓ Approve KYC
                                                    </button>
                                                @endif
                                                @if($mentor->kyc_status !== 'rejected')
                                                    <button type="submit" name="action" value="reject" style="background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 0.8rem; cursor: pointer;">
                                                        ✗ Reject
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="padding: 2.5rem; text-align: center; color: #94a3b8;">No mentors available for KYC review.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 3: PAYOUT APPROVALS & HISTORY -->
            <div id="tabContent-payouts" class="mentor-tab-content" style="display: none;">
                <div class="admin-table-wrapper" style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                    <div style="padding: 1.2rem; background: #f8fafc; border-bottom: 1.5px solid #e2e8f0;">
                        <h4 style="margin: 0; font-size: 1.05rem; color: #0f172a; font-weight: 800;">💳 Mentor Revenue Share Payout Queue</h4>
                        <p style="margin: 4px 0 0; font-size: 0.85rem; color: #64748b;">Review and approve withdrawal requests submitted by course instructors.</p>
                    </div>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.88rem; text-align: left;">
                            <thead>
                                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; color: #475569;">
                                    <th style="padding: 1rem;">Payout ID</th>
                                    <th style="padding: 1rem;">Mentor</th>
                                    <th style="padding: 1rem;">Amount</th>
                                    <th style="padding: 1rem;">Method</th>
                                    <th style="padding: 1rem;">Status</th>
                                    <th style="padding: 1rem;">Transaction ID / Date</th>
                                    <th style="padding: 1rem; text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payouts as $payout)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="padding: 1rem; font-weight: 800; color: #7c3aed;">
                                            #MP-{{ $payout->id }}
                                        </td>
                                        <td style="padding: 1rem;">
                                            <div style="font-weight: 700; color: #0f172a;">{{ $payout->mentor?->name ?? 'Unknown' }}</div>
                                            <div style="font-size: 0.78rem; color: #64748b;">{{ $payout->mentor?->email }}</div>
                                        </td>
                                        <td style="padding: 1rem; font-size: 1rem; font-weight: 800; color: #10b981;">
                                            ₹{{ number_format($payout->amount) }}
                                        </td>
                                        <td style="padding: 1rem; color: #334155;">
                                            {{ $payout->payment_method }}
                                        </td>
                                        <td style="padding: 1rem;">
                                            @if($payout->status === 'approved')
                                                <span style="background: #dcfce7; color: #15803d; font-size: 0.75rem; font-weight: 800; padding: 3px 9px; border-radius: 12px;">✓ Paid</span>
                                            @elseif($payout->status === 'pending')
                                                <span style="background: #fef9c3; color: #a16207; font-size: 0.75rem; font-weight: 800; padding: 3px 9px; border-radius: 12px;">⏳ Pending</span>
                                            @else
                                                <span style="background: #fee2e2; color: #b91c1c; font-size: 0.75rem; font-weight: 800; padding: 3px 9px; border-radius: 12px;">✗ Rejected</span>
                                            @endif
                                        </td>
                                        <td style="padding: 1rem; font-size: 0.8rem; color: #64748b;">
                                            @if($payout->transaction_id)
                                                <div style="font-family: monospace; color: #0f172a;">{{ $payout->transaction_id }}</div>
                                            @endif
                                            <div>{{ $payout->created_at->format('d M Y, h:i A') }}</div>
                                        </td>
                                        <td style="padding: 1rem; text-align: right;">
                                            @if($payout->status === 'pending')
                                                <form method="POST" action="{{ route('admin.mentors.payouts.process', $payout) }}" style="display: inline-flex; gap: 6px;">
                                                    @csrf
                                                    <button type="submit" name="action" value="approve" style="background: #05B396; color: #fff; border: none; padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 0.8rem; cursor: pointer;">
                                                        ✓ Approve &amp; Pay
                                                    </button>
                                                    <button type="submit" name="action" value="reject" style="background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 0.8rem; cursor: pointer;">
                                                        ✗ Reject
                                                    </button>
                                                </form>
                                            @else
                                                <span style="color: #94a3b8; font-size: 0.8rem;">Completed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="padding: 2.5rem; text-align: center; color: #94a3b8;">No mentor payout history recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- MODAL 1: ADD NEW MENTOR -->
            <!-- ======================================================== -->
            <div id="addMentorModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 99999; overflow-y: auto; padding: 2rem 1rem;">
                <div style="max-width: 720px; margin: 0 auto; background: #ffffff; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); overflow: hidden;">
                    <div style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); padding: 1.5rem 1.8rem; color: #ffffff; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="margin: 0; font-size: 1.3rem; font-weight: 800;">👨‍🏫 Add New Mentor / Instructor</h3>
                            <p style="margin: 4px 0 0; opacity: 0.85; font-size: 0.88rem;">Fill in mentor profile, course assignments &amp; commission share %</p>
                        </div>
                        <button type="button" onclick="closeAddMentorModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; width: 34px; height: 34px; border-radius: 50%; font-size: 1.3rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">&times;</button>
                    </div>

                    <form method="POST" action="{{ route('admin.mentors.store') }}" style="padding: 1.8rem;">
                        @csrf
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                            <!-- Name -->
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Mentor Full Name *</label>
                                <input type="text" name="name" required placeholder="e.g. Rahul Verma" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                            <!-- Email -->
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Email Address *</label>
                                <input type="email" name="email" required placeholder="e.g. rahul@example.com" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                            <!-- Phone -->
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Phone Number</label>
                                <input type="text" name="phone" placeholder="e.g. +91 98765 43210" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                            <!-- Photo URL -->
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Photo URL (Optional)</label>
                                <input type="url" name="photo" placeholder="https://..." style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                            <!-- Expertise -->
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Expertise / Domain</label>
                                <input type="text" name="expertise" placeholder="e.g. Full Stack AI" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                            <!-- Experience -->
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Experience</label>
                                <input type="text" name="experience" placeholder="e.g. 8+ Years" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                            <!-- Qualification -->
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Qualification</label>
                                <input type="text" name="qualification" placeholder="e.g. B.Tech / MBA" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Bio -->
                        <div style="margin-bottom: 1.2rem;">
                            <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Bio / Introduction</label>
                            <textarea name="bio" rows="2" placeholder="Brief biography of the mentor..." style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;"></textarea>
                        </div>

                        <!-- Homepage Display Settings -->
                        <div style="background: #f0fdfa; border: 1.5px solid #99f6e4; border-radius: 12px; padding: 1.1rem; margin-bottom: 1.2rem;">
                            <div style="font-weight: 800; font-size: 0.92rem; color: #0A6B5C; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                                <span>🌐 Homepage 'Our Expert Team &amp; Mentors' Display</span>
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 0.88rem; color: #0f172a; cursor: pointer;">
                                    <input type="checkbox" name="is_featured" value="1" style="width: 18px; height: 18px; accent-color: #0A6B5C;">
                                    <span>Display on Homepage (Show this mentor in homepage cards)</span>
                                </label>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                <div>
                                    <label style="display: block; font-weight: 700; font-size: 0.8rem; color: #334155; margin-bottom: 4px;">Designation / Subtitle</label>
                                    <input type="text" name="designation" placeholder="e.g. Founder &amp; CEO – Skilllearner" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                                </div>
                                <div>
                                    <label style="display: block; font-weight: 700; font-size: 0.8rem; color: #334155; margin-bottom: 4px;">Bottom Badge Text</label>
                                    <input type="text" name="badge" placeholder="e.g. ★ FOUNDER &amp; CEO" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                                </div>
                            </div>
                        </div>

                        <!-- Commission / Revenue Share % -->
                        <div style="background: #faf5ff; border: 1.5px solid #e9d5ff; border-radius: 12px; padding: 1rem; margin-bottom: 1.2rem;">
                            <label style="display: block; font-weight: 800; font-size: 0.9rem; color: #6b21a8; margin-bottom: 6px;">
                                💰 Mentor Commission / Revenue Share % *
                            </label>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="number" step="0.5" min="0" max="100" name="commission_percentage" value="15" required style="width: 120px; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 1rem; font-weight: 800;">
                                <span style="font-size: 0.9rem; color: #475569;">% of course sales credited to mentor wallet</span>
                            </div>
                        </div>

                        <!-- Assign Courses Checkboxes -->
                        <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 1rem; margin-bottom: 1.2rem;">
                            <label style="display: block; font-weight: 800; font-size: 0.9rem; color: #0f172a; margin-bottom: 8px;">
                                📚 Assign Platform Courses
                            </label>
                            <div style="max-height: 150px; overflow-y: auto; display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                                @foreach($courses as $c)
                                    <label style="display: flex; align-items: center; gap: 8px; font-size: 0.84rem; color: #334155; cursor: pointer;">
                                        <input type="checkbox" name="assigned_courses[]" value="{{ $c->id }}">
                                        <span>{{ $c->title }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Social Links -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #475569; margin-bottom: 4px;">LinkedIn URL</label>
                                <input type="url" name="linkedin" placeholder="https://linkedin.com/in/..." style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 0.82rem; color: #475569; margin-bottom: 4px;">YouTube URL</label>
                                <input type="url" name="youtube" placeholder="https://youtube.com/@..." style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                            </div>
                        </div>

                        <!-- Bank & Tax Info -->
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem;">
                            <div style="font-weight: 800; font-size: 0.88rem; color: #0f172a; margin-bottom: 8px;">🏦 Bank &amp; KYC Details (For Payouts)</div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px;">
                                <input type="text" name="bank_name" placeholder="Bank Name" style="padding: 0.55rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.82rem;">
                                <input type="text" name="account_number" placeholder="Account Number" style="padding: 0.55rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.82rem;">
                                <input type="text" name="ifsc_code" placeholder="IFSC Code" style="padding: 0.55rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.82rem;">
                                <input type="text" name="upi_id" placeholder="UPI ID" style="padding: 0.55rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.82rem;">
                                <input type="text" name="pan_number" placeholder="PAN Number" style="padding: 0.55rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.82rem;">
                                <input type="text" name="aadhar_number" placeholder="Aadhar Number" style="padding: 0.55rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.82rem;">
                            </div>
                        </div>

                        <div style="display: flex; justify-content: flex-end; gap: 10px;">
                            <button type="button" onclick="closeAddMentorModal()" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #475569; padding: 0.75rem 1.4rem; border-radius: 10px; font-weight: 700; cursor: pointer;">Cancel</button>
                            <button type="submit" style="background: #7c3aed; color: #ffffff; border: none; padding: 0.75rem 1.8rem; border-radius: 10px; font-weight: 800; cursor: pointer; box-shadow: 0 4px 14px rgba(124, 58, 237, 0.35);">Save Mentor</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- MODAL 2: EDIT MENTOR -->
            <!-- ======================================================== -->
            <div id="editMentorModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 99999; overflow-y: auto; padding: 2rem 1rem;">
                <div style="max-width: 720px; margin: 0 auto; background: #ffffff; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); overflow: hidden;">
                    <div style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 1.5rem 1.8rem; color: #ffffff; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="margin: 0; font-size: 1.3rem; font-weight: 800;">✏️ Edit Mentor Profile</h3>
                            <p style="margin: 4px 0 0; opacity: 0.85; font-size: 0.88rem;">Update bio, courses, revenue share % &amp; payout settings</p>
                        </div>
                        <button type="button" onclick="closeEditMentorModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; width: 34px; height: 34px; border-radius: 50%; font-size: 1.3rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">&times;</button>
                    </div>

                    <form id="editMentorForm" method="POST" action="" style="padding: 1.8rem;">
                        @csrf
                        @method('PUT')
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Mentor Full Name *</label>
                                <input type="text" id="edit_name" name="name" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Email Address *</label>
                                <input type="email" id="edit_email" name="email" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Phone Number</label>
                                <input type="text" id="edit_phone" name="phone" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Photo URL</label>
                                <input type="url" id="edit_photo" name="photo" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Expertise</label>
                                <input type="text" id="edit_expertise" name="expertise" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Experience</label>
                                <input type="text" id="edit_experience" name="experience" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Qualification</label>
                                <input type="text" id="edit_qualification" name="qualification" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                            </div>
                        </div>

                        <div style="margin-bottom: 1.2rem;">
                            <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Bio</label>
                            <textarea id="edit_bio" name="bio" rows="2" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;"></textarea>
                        </div>

                        <!-- Homepage Display Settings -->
                        <div style="background: #f0fdfa; border: 1.5px solid #99f6e4; border-radius: 12px; padding: 1.1rem; margin-bottom: 1.2rem;">
                            <div style="font-weight: 800; font-size: 0.92rem; color: #0A6B5C; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                                <span>🌐 Homepage 'Our Expert Team &amp; Mentors' Display</span>
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 0.88rem; color: #0f172a; cursor: pointer;">
                                    <input type="checkbox" id="edit_is_featured" name="is_featured" value="1" style="width: 18px; height: 18px; accent-color: #0A6B5C;">
                                    <span>Display on Homepage (Show this mentor in homepage cards)</span>
                                </label>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                <div>
                                    <label style="display: block; font-weight: 700; font-size: 0.8rem; color: #334155; margin-bottom: 4px;">Designation / Subtitle</label>
                                    <input type="text" id="edit_designation" name="designation" placeholder="e.g. Founder &amp; CEO – Skilllearner" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                                </div>
                                <div>
                                    <label style="display: block; font-weight: 700; font-size: 0.8rem; color: #334155; margin-bottom: 4px;">Bottom Badge Text</label>
                                    <input type="text" id="edit_badge" name="badge" placeholder="e.g. ★ FOUNDER &amp; CEO" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box;">
                                </div>
                            </div>
                        </div>

                        <!-- Commission % -->
                        <div style="background: #faf5ff; border: 1.5px solid #e9d5ff; border-radius: 12px; padding: 1rem; margin-bottom: 1.2rem;">
                            <label style="display: block; font-weight: 800; font-size: 0.9rem; color: #6b21a8; margin-bottom: 6px;">
                                💰 Mentor Commission / Revenue Share % *
                            </label>
                            <input type="number" step="0.5" min="0" max="100" id="edit_commission" name="commission_percentage" required style="width: 120px; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 1rem; font-weight: 800;">
                        </div>

                        <!-- Assigned Courses -->
                        <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 1rem; margin-bottom: 1.2rem;">
                            <label style="display: block; font-weight: 800; font-size: 0.9rem; color: #0f172a; margin-bottom: 8px;">
                                📚 Assigned Courses
                            </label>
                            <div style="max-height: 150px; overflow-y: auto; display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                                @foreach($courses as $c)
                                    <label style="display: flex; align-items: center; gap: 8px; font-size: 0.84rem; color: #334155; cursor: pointer;">
                                        <input type="checkbox" class="edit-course-checkbox" name="assigned_courses[]" value="{{ $c->id }}">
                                        <span>{{ $c->title }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Bank & Tax Info -->
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem;">
                            <div style="font-weight: 800; font-size: 0.88rem; color: #0f172a; margin-bottom: 8px;">🏦 Bank &amp; KYC Details</div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px;">
                                <input type="text" id="edit_bank_name" name="bank_name" placeholder="Bank Name" style="padding: 0.55rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.82rem;">
                                <input type="text" id="edit_account_number" name="account_number" placeholder="Account Number" style="padding: 0.55rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.82rem;">
                                <input type="text" id="edit_ifsc_code" name="ifsc_code" placeholder="IFSC Code" style="padding: 0.55rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.82rem;">
                                <input type="text" id="edit_upi_id" name="upi_id" placeholder="UPI ID" style="padding: 0.55rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.82rem;">
                                <input type="text" id="edit_pan_number" name="pan_number" placeholder="PAN Number" style="padding: 0.55rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.82rem;">
                                <input type="text" id="edit_aadhar_number" name="aadhar_number" placeholder="Aadhar Number" style="padding: 0.55rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.82rem;">
                            </div>
                        </div>

                        <div style="display: flex; justify-content: flex-end; gap: 10px;">
                            <button type="button" onclick="closeEditMentorModal()" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #475569; padding: 0.75rem 1.4rem; border-radius: 10px; font-weight: 700; cursor: pointer;">Cancel</button>
                            <button type="submit" style="background: #0f172a; color: #ffffff; border: none; padding: 0.75rem 1.8rem; border-radius: 10px; font-weight: 800; cursor: pointer;">Update Mentor</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- MODAL 3: CREATE PAYOUT REQUEST FOR MENTOR -->
            <!-- ======================================================== -->
            <div id="payoutModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 99999; overflow-y: auto; padding: 2rem 1rem;">
                <div style="max-width: 480px; margin: 3rem auto 0; background: #ffffff; border-radius: 18px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); overflow: hidden;">
                    <div style="background: #05B396; padding: 1.2rem 1.5rem; color: #ffffff; display: flex; justify-content: space-between; align-items: center;">
                        <h4 style="margin: 0; font-size: 1.15rem; font-weight: 800;">💳 Create Mentor Payout</h4>
                        <button type="button" onclick="closePayoutModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; width: 30px; height: 30px; border-radius: 50%; font-size: 1.2rem; cursor: pointer;">&times;</button>
                    </div>
                    <form id="payoutForm" method="POST" action="" style="padding: 1.5rem;">
                        @csrf
                        <p style="margin: 0 0 1rem; color: #64748b; font-size: 0.9rem;">
                            Creating payout for: <strong id="payoutMentorName" style="color: #0f172a;"></strong>
                        </p>
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Payout Amount (₹) *</label>
                            <input type="number" min="100" step="1" name="amount" required placeholder="e.g. 5000" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 1rem; font-weight: 800; box-sizing: border-box;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Payment Method</label>
                            <select name="payment_method" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                                <option value="Bank Transfer (IMPS/NEFT)">Bank Transfer (IMPS/NEFT)</option>
                                <option value="UPI">UPI</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                        </div>
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">Notes / Remarks</label>
                            <input type="text" name="notes" placeholder="e.g. October course revenue share" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; box-sizing: border-box;">
                        </div>
                        <div style="display: flex; justify-content: flex-end; gap: 10px;">
                            <button type="button" onclick="closePayoutModal()" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #475569; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">Cancel</button>
                            <button type="submit" style="background: #05B396; color: #ffffff; border: none; padding: 0.65rem 1.5rem; border-radius: 8px; font-weight: 800; cursor: pointer;">Submit Payout</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

@include('portal.styles')

@push('scripts')
<script>
    function switchMentorTab(tabKey) {
        document.querySelectorAll('.mentor-tab-content').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.mentor-tab-btn').forEach(btn => {
            btn.style.borderBottomColor = 'transparent';
            btn.style.color = '#64748b';
        });

        const activeContent = document.getElementById('tabContent-' + tabKey);
        const activeBtn = document.getElementById('tabBtn-' + tabKey);
        if (activeContent) activeContent.style.display = 'block';
        if (activeBtn) {
            activeBtn.style.borderBottomColor = '#7c3aed';
            activeBtn.style.color = '#7c3aed';
        }
    }

    function openAddMentorModal() {
        document.getElementById('addMentorModal').style.display = 'block';
    }
    function closeAddMentorModal() {
        document.getElementById('addMentorModal').style.display = 'none';
    }

    function openEditMentorModal(mentor) {
        const form = document.getElementById('editMentorForm');
        form.action = '/admin/mentors/' + mentor.id;

        document.getElementById('edit_name').value = mentor.name || '';
        document.getElementById('edit_email').value = mentor.email || '';
        document.getElementById('edit_phone').value = mentor.phone || '';
        document.getElementById('edit_photo').value = mentor.photo || '';
        document.getElementById('edit_expertise').value = mentor.expertise || '';
        document.getElementById('edit_experience').value = mentor.experience || '';
        document.getElementById('edit_qualification').value = mentor.qualification || '';
        document.getElementById('edit_bio').value = mentor.bio || '';
        document.getElementById('edit_commission').value = mentor.commission_percentage || 15;
        document.getElementById('edit_designation').value = mentor.designation || '';
        document.getElementById('edit_badge').value = mentor.badge || '';
        document.getElementById('edit_is_featured').checked = Boolean(mentor.is_featured);

        document.getElementById('edit_bank_name').value = mentor.bank_name || '';
        document.getElementById('edit_account_number').value = mentor.account_number || '';
        document.getElementById('edit_ifsc_code').value = mentor.ifsc_code || '';
        document.getElementById('edit_upi_id').value = mentor.upi_id || '';
        document.getElementById('edit_pan_number').value = mentor.pan_number || '';
        document.getElementById('edit_aadhar_number').value = mentor.aadhar_number || '';

        // Check assigned courses
        const assignedIds = Array.isArray(mentor.assigned_courses) ? mentor.assigned_courses.map(String) : [];
        document.querySelectorAll('.edit-course-checkbox').forEach(cb => {
            cb.checked = assignedIds.includes(String(cb.value));
        });

        document.getElementById('editMentorModal').style.display = 'block';
    }
    function closeEditMentorModal() {
        document.getElementById('editMentorModal').style.display = 'none';
    }

    function openPayoutModal(mentorId, mentorName) {
        document.getElementById('payoutForm').action = '/admin/mentors/' + mentorId + '/payouts';
        document.getElementById('payoutMentorName').innerText = mentorName;
        document.getElementById('payoutModal').style.display = 'block';
    }
    function closePayoutModal() {
        document.getElementById('payoutModal').style.display = 'none';
    }

    // Auto switch tab if URL query parameter tab exists
    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get('tab');
    if (tabParam && ['mentors', 'kyc', 'payouts'].includes(tabParam)) {
        switchMentorTab(tabParam);
    }
</script>
@endpush
@endsection

