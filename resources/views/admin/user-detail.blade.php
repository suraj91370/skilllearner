@extends('layouts.app')

@section('title', 'User Profile: ' . $user->name . ' — SkillLearner Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-users'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-users'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            
            <!-- Breadcrumb Navigation -->
            <div style="margin-bottom: 1.2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 8px; font-size: 0.9rem; color: #64748b;">
                    <a href="{{ route('admin.users') }}" style="color: #05B396; text-decoration: none; font-weight: 700;">&larr; Back to All Users</a>
                    <span>/</span>
                    <span style="color: #0f172a; font-weight: 700;">{{ $user->name }}</span>
                </div>

                <div style="display: flex; gap: 8px; align-items: center;">
                    <!-- Impersonate Login As -->
                    @if(Auth::id() !== $user->id)
                        <a href="{{ route('admin.impersonate', $user->id) }}" 
                           onclick="return confirm('Kya aap {{ $user->name }} ke account me Login As karna chahte hain?');" 
                           class="btn" 
                           style="background: #0284c7; color: #fff; font-size: 0.84rem; font-weight: 700; padding: 7px 14px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                            <span>Login As User</span>
                        </a>
                    @endif

                    <!-- Block / Unblock Button -->
                    @if(Auth::id() !== $user->id)
                        <form method="POST" action="{{ route('admin.users.toggle-block', $user->id) }}" style="margin: 0;">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('Kya aap {{ $user->name }} ko {{ $user->is_blocked ? 'UNBLOCK' : 'BLOCK' }} karna chahte hain?');" 
                                    style="background: {{ $user->is_blocked ? '#10b981' : '#ef4444' }}; color: #ffffff; border: none; padding: 7px 14px; border-radius: 8px; font-weight: 700; font-size: 0.84rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                                <span>{{ $user->is_blocked ? '🔓 Unblock Account' : '🔒 Block Account' }}</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>

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

            <!-- User Overview Hero Card -->
            <div style="background: #ffffff; border: 1.5px solid #a7f3d0; border-radius: 18px; padding: 1.8rem; margin-bottom: 1.8rem; box-shadow: 0 4px 20px rgba(5, 179, 150, 0.05); position: relative; overflow: hidden;">
                <div style="display: flex; gap: 1.5rem; flex-wrap: wrap; align-items: center; justify-content: space-between;">
                    
                    <div style="display: flex; gap: 1.2rem; align-items: center;">
                        <img src="{{ $user->avatar ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&auto=format&fit=crop&q=80' }}" 
                             alt="{{ $user->name }}" 
                             style="width: 72px; height: 72px; border-radius: 50%; object-fit: cover; border: 3px solid #05B396; box-shadow: 0 4px 12px rgba(5, 179, 150, 0.2);">
                        
                        <div>
                            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                <h1 style="font-size: 1.45rem; font-weight: 900; color: #0f172a; margin: 0;">{{ $user->name }}</h1>
                                
                                @if($user->role === 'super_admin')
                                    <span style="background: rgba(124, 58, 237, 0.12); color: #7c3aed; font-weight: 800; font-size: 0.75rem; padding: 3px 10px; border-radius: 20px; border: 1px solid rgba(124, 58, 237, 0.3);">
                                        👑 Super Admin
                                    </span>
                                @elseif($user->role === 'admin')
                                    <span style="background: rgba(2, 132, 199, 0.12); color: #0284c7; font-weight: 800; font-size: 0.75rem; padding: 3px 10px; border-radius: 20px; border: 1px solid rgba(2, 132, 199, 0.3);">
                                        🛡️ Admin
                                    </span>
                                @else
                                    <span style="background: rgba(5, 179, 150, 0.12); color: #05B396; font-weight: 800; font-size: 0.75rem; padding: 3px 10px; border-radius: 20px; border: 1px solid rgba(5, 179, 150, 0.3);">
                                        🎓 Student / User
                                    </span>
                                @endif

                                @if($user->is_blocked)
                                    <span style="background: #fef2f2; color: #dc2626; font-weight: 800; font-size: 0.75rem; padding: 3px 10px; border-radius: 20px; border: 1px solid #fecaca;">
                                        🔴 BLOCKED
                                    </span>
                                @else
                                    <span style="background: #f0fdf4; color: #166534; font-weight: 800; font-size: 0.75rem; padding: 3px 10px; border-radius: 20px; border: 1px solid #bbf7d0;">
                                        🟢 ACTIVE
                                    </span>
                                @endif
                            </div>

                            <div style="font-size: 0.88rem; color: #64748b; margin-top: 4px; display: flex; gap: 14px; flex-wrap: wrap;">
                                <span>📧 {{ $user->email }}</span>
                                <span>📱 {{ $user->phone ?? 'No phone' }}</span>
                                <span style="color: #05B396; font-weight: 700;">ID: {{ $user->affiliate_id ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Status Pills & Actions -->
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <button type="button" 
                                onclick="openAssignPackageModal('{{ $user->id }}', '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ addslashes($user->active_package ?? 'Advance Package') }}', '{{ $user->payment_status ?? 'paid' }}')" 
                                style="background: linear-gradient(135deg, #05B396 0%, #00137a 100%); color: #ffffff; border: none; font-size: 0.84rem; font-weight: 800; padding: 8px 16px; border-radius: 10px; cursor: pointer; box-shadow: 0 4px 12px rgba(5,179,150,0.3); display: inline-flex; align-items: center; gap: 6px;">
                            <span>⚡ Assign Package / Free Activate</span>
                        </button>

                        <button type="button" 
                                onclick="openPasswordResetModal('{{ $user->id }}', '{{ addslashes($user->name) }}')" 
                                style="background: #f8fafc; border: 1.5px solid #cbd5e1; color: #334155; font-size: 0.84rem; font-weight: 700; padding: 8px 14px; border-radius: 10px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                            <span>🔑 Reset Password</span>
                        </button>

                        @if($user->payment_status !== 'paid' || !str_contains(strtolower($user->kyc_status ?? ''), 'verified'))
                            <form method="POST" action="{{ route('admin.users.verify-account', $user->id) }}" style="margin: 0;">
                                @csrf
                                <button type="submit" 
                                        onclick="return confirm('Kya aap {{ $user->name }} ka account verify karke payment activate aur courses unlock karna chahte hain?');" 
                                        style="background: #05B396; color: #fff; border: none; font-size: 0.84rem; font-weight: 800; padding: 8px 16px; border-radius: 10px; cursor: pointer; box-shadow: 0 4px 12px rgba(5,179,150,0.3); display: inline-flex; align-items: center; gap: 6px;">
                                    <span>✔ Verify &amp; Activate Account</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Account Metrics Row -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px dashed #cbd5e1;">
                    <div>
                        <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Active Package</div>
                        <div style="display: flex; align-items: center; gap: 6px; margin-top: 2px;">
                            <span style="font-size: 1.05rem; font-weight: 800; color: #0f172a;">{{ $user->active_package ?? 'Advance Package' }}</span>
                            <button type="button" 
                                    onclick="openAssignPackageModal('{{ $user->id }}', '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ addslashes($user->active_package ?? 'Advance Package') }}', '{{ $user->payment_status ?? 'paid' }}')"
                                    title="Change Package" 
                                    style="background: #f0fdfa; border: 1px solid #05B396; color: #05B396; border-radius: 4px; padding: 2px 6px; font-size: 0.7rem; font-weight: 700; cursor: pointer;">
                                Edit
                            </button>
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Payment Status</div>
                        <div style="font-size: 1.05rem; font-weight: 800; color: {{ $user->payment_status === 'paid' ? '#059669' : '#d97706' }}; margin-top: 2px;">
                            {{ $user->payment_status === 'paid' ? '✔ Paid & Active' : '⏳ Pending Payment' }}
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase;">KYC Verification</div>
                        <div style="font-size: 1.05rem; font-weight: 800; color: {{ str_contains(strtolower($user->kyc_status ?? ''), 'verified') ? '#059669' : '#d97706' }}; margin-top: 2px;">
                            {{ $user->kyc_status ?? 'Pending' }}
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Wallet Balance</div>
                        <div style="font-size: 1.15rem; font-weight: 900; color: #05B396; margin-top: 2px;">₹{{ number_format((float) $user->wallet_balance, 2) }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Total Earnings</div>
                        <div style="font-size: 1.15rem; font-weight: 900; color: #0f172a; margin-top: 2px;">₹{{ number_format((float) $user->total_earning, 2) }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Industry Revenue</div>
                        <div style="font-size: 1.15rem; font-weight: 900; color: #0284c7; margin-top: 2px;">₹{{ number_format((float) ($user->industry_revenue ?? 0), 2) }}</div>
                    </div>
                </div>
            </div>

            <!-- Two Column Layout: Courses & Progress (Left) + Affiliate / Sponsor Info (Right) -->
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; align-items: start;">
                
                <!-- Left: Courses, Progress & Certificates -->
                <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 18px rgba(0,0,0,0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <h2 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0;">
                                🎓 Enrolled Courses &amp; Progress ({{ $userCourses->count() }})
                            </h2>
                            <p style="font-size: 0.82rem; color: #64748b; margin: 3px 0 0;">
                                Completed: <strong>{{ $completedCoursesCount }}</strong> &bull; Total Certificates Generated: <strong>{{ $completedCoursesCount }}</strong>
                            </p>
                        </div>

                        <!-- Manual Course Enrollment Form Dropdown -->
                        <form method="POST" action="{{ route('admin.users.enroll', $user->id) }}" style="display: flex; gap: 6px; align-items: center; margin: 0;">
                            @csrf
                            <select name="course_id" required style="font-size: 0.82rem; padding: 6px 10px; border: 1.5px solid #cbd5e1; border-radius: 8px; outline: none; background: #fff; max-width: 220px;">
                                <option value="" disabled selected>+ Select Course to Enroll</option>
                                @foreach($allCourses as $c)
                                    @if(!$userCourses->has($c->id))
                                        <option value="{{ $c->id }}">{{ $c->title }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <button type="submit" style="background: #05B396; color: #fff; border: none; padding: 7px 12px; border-radius: 8px; font-weight: 700; font-size: 0.82rem; cursor: pointer;">
                                Enroll
                            </button>
                        </form>
                    </div>

                    <!-- Courses List -->
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @forelse($allCourses as $c)
                            @php
                                $uc = $userCourses->get($c->id);
                                $isEnrolled = !empty($uc);
                                $progress = $uc ? $uc->progress_percent : 0;
                                $isCompleted = $progress >= 100;
                                $certId = 'SL-CERT-' . (1000 + $c->id) . '-' . $user->id;
                            @endphp

                            <div style="border: 1.5px solid {{ $isEnrolled ? ($isCompleted ? '#a7f3d0' : '#e2e8f0') : '#f1f5f9' }}; border-radius: 12px; padding: 14px 16px; background: {{ $isEnrolled ? ($isCompleted ? '#f0fdf9' : '#ffffff') : '#fafafa' }};">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; flex-wrap: wrap; gap: 8px;">
                                    <div>
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span style="font-weight: 800; font-size: 0.98rem; color: #0f172a;">{{ $c->title }}</span>
                                            <span style="font-size: 0.72rem; color: #64748b; background: #f1f5f9; padding: 2px 8px; border-radius: 4px; font-weight: 600;">{{ $c->package }}</span>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        @if($isEnrolled)
                                            @if($isCompleted)
                                                <button type="button" 
                                                        onclick="openCertificatePreviewModal('{{ addslashes($user->name) }}', '{{ addslashes($c->title) }}', '{{ $certId }}', '{{ $uc->completed_at ? $uc->completed_at->format('d M, Y') : now()->format('d M, Y') }}')" 
                                                        style="background: #ecfdf5; border: 1.5px solid #a7f3d0; color: #059669; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                                    <span>🎖️ View Certificate</span>
                                                </button>
                                            @endif

                                            <!-- Unenroll Button -->
                                            <form method="POST" action="{{ route('admin.users.unenroll', $user->id) }}" style="margin: 0;">
                                                @csrf
                                                <input type="hidden" name="course_id" value="{{ $c->id }}">
                                                <button type="submit" 
                                                        onclick="return confirm('Kya aap {{ $user->name }} ko is course se unenroll karna chahte hain?');" 
                                                        style="background: transparent; border: 1px solid #fecaca; color: #dc2626; font-size: 0.74rem; font-weight: 700; padding: 4px 8px; border-radius: 6px; cursor: pointer;">
                                                    Unenroll
                                                </button>
                                            </form>
                                        @else
                                            <!-- Quick Enroll Button -->
                                            <form method="POST" action="{{ route('admin.users.enroll', $user->id) }}" style="margin: 0;">
                                                @csrf
                                                <input type="hidden" name="course_id" value="{{ $c->id }}">
                                                <button type="submit" style="background: #f0fdfa; border: 1.5px solid #05B396; color: #05B396; font-size: 0.76rem; font-weight: 800; padding: 4px 10px; border-radius: 6px; cursor: pointer;">
                                                    + Enroll Now
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>

                                @if($isEnrolled)
                                    <!-- Progress Bar & Adjust Control -->
                                    <div style="display: flex; align-items: center; gap: 12px; margin-top: 8px;">
                                        <div style="flex: 1; background: #e2e8f0; height: 8px; border-radius: 999px; overflow: hidden;">
                                            <div style="width: {{ $progress }}%; height: 100%; background: {{ $isCompleted ? '#05B396' : '#3b82f6' }}; border-radius: 999px;"></div>
                                        </div>
                                        <span style="font-size: 0.82rem; font-weight: 800; color: {{ $isCompleted ? '#059669' : '#0f172a' }}; min-width: 45px;">
                                            {{ $progress }}%
                                        </span>

                                        <!-- Quick Set Progress Form -->
                                        <form method="POST" action="{{ route('admin.users.progress', $user->id) }}" style="display: inline-flex; align-items: center; gap: 4px; margin: 0;">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $c->id }}">
                                            <select name="progress_percent" onchange="this.form.submit()" style="font-size: 0.74rem; font-weight: 700; padding: 3px 6px; border: 1px solid #cbd5e1; border-radius: 6px; background: #ffffff; cursor: pointer;">
                                                <option value="0" {{ $progress == 0 ? 'selected' : '' }}>Set 0%</option>
                                                <option value="25" {{ $progress == 25 ? 'selected' : '' }}>Set 25%</option>
                                                <option value="50" {{ $progress == 50 ? 'selected' : '' }}>Set 50%</option>
                                                <option value="75" {{ $progress == 75 ? 'selected' : '' }}>Set 75%</option>
                                                <option value="100" {{ $progress == 100 ? 'selected' : '' }}>Set 100% (Issue Cert 🎖️)</option>
                                            </select>
                                        </form>
                                    </div>
                                @else
                                    <div style="font-size: 0.78rem; color: #94a3b8; font-style: italic;">
                                        Not enrolled yet. Click "+ Enroll Now" to grant student access.
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p style="color: #64748b; font-size: 0.9rem;">No courses created in platform.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Right: Sponsor Info & Account Security -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    
                    <!-- Sponsor Affiliate Card -->
                    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.4rem;">
                        <h3 style="font-size: 1.05rem; font-weight: 800; color: #0f172a; margin: 0 0 1rem;">
                            🤝 Sponsor (Affiliate Lead)
                        </h3>

                        @if($sponsor)
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                                <img src="{{ $sponsor->avatar ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=80&auto=format&fit=crop&q=80' }}" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 1.5px solid #05B396;">
                                <div>
                                    <div style="font-weight: 800; color: #0f172a; font-size: 0.94rem;">{{ $sponsor->name }}</div>
                                    <div style="font-size: 0.78rem; color: #64748b;">{{ $sponsor->email }}</div>
                                    <div style="font-size: 0.72rem; color: #05B396; font-weight: 700;">ID: {{ $sponsor->affiliate_id }}</div>
                                </div>
                            </div>
                            <div style="border-top: 1px dashed #cbd5e1; padding-top: 8px; font-size: 0.8rem; color: #475569;">
                                Sponsor Tier: <strong>{{ $sponsor->active_package }}</strong> &bull; Role: <strong>{{ strtoupper($sponsor->role) }}</strong>
                            </div>
                        @else
                            <div style="font-size: 0.88rem; color: #64748b;">
                                Sponsor Code: <strong>{{ $user->sponsor_id ?? 'SL-ADMIN' }}</strong> (Direct Platform Referral)
                            </div>
                        @endif
                    </div>

                    <!-- KYC Verification Card -->
                    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.4rem;">
                        <h3 style="font-size: 1.05rem; font-weight: 800; color: #0f172a; margin: 0 0 1rem;">
                            📑 KYC &amp; Banking Details
                        </h3>

                        @if($user->kyc)
                            <div style="font-size: 0.85rem; color: #334155; line-height: 1.6;">
                                <div><strong>Bank:</strong> {{ $user->kyc->bank_name ?? 'N/A' }}</div>
                                <div><strong>A/C No:</strong> {{ $user->kyc->account_number ?? 'N/A' }}</div>
                                <div><strong>IFSC:</strong> {{ $user->kyc->ifsc_code ?? 'N/A' }}</div>
                                <div><strong>UPI ID:</strong> {{ $user->kyc->upi_id ?? 'N/A' }}</div>
                                <div><strong>Status:</strong> <span style="font-weight: 700; color: #059669;">{{ $user->kyc->status ?? 'Verified' }}</span></div>
                            </div>
                        @else
                            <div style="font-size: 0.86rem; color: #64748b; line-height: 1.5;">
                                KYC documents have not been submitted by user yet. Status is marked: <strong>{{ $user->kyc_status }}</strong>.
                            </div>
                        @endif
                    </div>

                    <!-- Quick Role Switcher (Super Admin Only) -->
                    @if(Auth::user()?->role === 'super_admin' && Auth::id() !== $user->id)
                        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.4rem;">
                            <h3 style="font-size: 1.05rem; font-weight: 800; color: #0f172a; margin: 0 0 0.8rem;">
                                👑 Modify Account Role
                            </h3>
                            <form method="POST" action="{{ route('admin.users.role', $user->id) }}">
                                @csrf
                                <select name="role" style="width: 100%; font-size: 0.88rem; font-weight: 600; padding: 8px 10px; border: 1.5px solid #cbd5e1; border-radius: 8px; margin-bottom: 8px;">
                                    <option value="super_admin" {{ $user->role === 'super_admin' ? 'selected' : '' }}>👑 Super Admin</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>🛡️ Operations Admin</option>
                                    <option value="user" {{ in_array($user->role, ['user', 'affiliate', 'student']) ? 'selected' : '' }}>🎓 Student / User</option>
                                </select>
                                <button type="submit" style="width: 100%; background: #0f172a; color: #fff; border: none; padding: 8px; border-radius: 8px; font-weight: 700; font-size: 0.84rem; cursor: pointer;">
                                    Update Role
                                </button>
                            </form>
                        </div>
                    @endif

                </div>

            </div>

        </main>
    </div>
</div>

<!-- Reset Password Modal -->
<div id="passwordResetModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); z-index: 9999; backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #ffffff; border-radius: 18px; max-width: 440px; width: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.25); border: 1.5px solid #cbd5e1; overflow: hidden;">
        <div style="background: #0f172a; padding: 1.2rem 1.4rem; color: #ffffff; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 1.2rem;">🔑</span>
                <h3 style="margin: 0; font-size: 1.05rem; font-weight: 800; color: #ffffff;">Reset User Password</h3>
            </div>
            <button type="button" onclick="closePasswordResetModal()" style="background: rgba(255,255,255,0.2); border: none; color: #ffffff; width: 28px; height: 28px; border-radius: 50%; cursor: pointer; font-size: 1rem; display: flex; align-items: center; justify-content: center; font-weight: 700;">&times;</button>
        </div>

        <form id="passwordResetForm" method="POST" action="" style="padding: 1.4rem;">
            @csrf
            <p style="font-size: 0.88rem; color: #475569; margin: 0 0 1rem; line-height: 1.5;">
                Enter a new password for <strong id="resetModalUserName"></strong>. User will immediately be able to log in with this new password.
            </p>

            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem; text-transform: uppercase;">
                    New Password
                </label>
                <input type="text" name="password" id="newPasswordInput" required minlength="6" placeholder="Enter at least 6 characters" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; font-weight: 600; outline: none;">
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closePasswordResetModal()" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #475569; padding: 8px 16px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.86rem;">
                    Cancel
                </button>
                <button type="submit" style="background: #05B396; color: #ffffff; border: none; padding: 8px 20px; border-radius: 8px; font-weight: 800; cursor: pointer; font-size: 0.86rem;">
                    Save New Password
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Certificate Preview Modal -->
<div id="certificatePreviewModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.75); z-index: 9999; backdrop-filter: blur(5px); align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #ffffff; border-radius: 20px; max-width: 650px; width: 100%; box-shadow: 0 25px 60px rgba(0,0,0,0.35); border: 2px solid #05B396; overflow: hidden; position: relative;">
        
        <!-- Header -->
        <div style="background: #0f172a; padding: 1.2rem 1.5rem; color: #ffffff; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 1.4rem;">🎖️</span>
                <div>
                    <h3 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: #ffffff;">{{ \App\Models\Setting::get('cert_title', 'CERTIFICATE OF COMPLETION') }}</h3>
                    <div style="font-size: 0.76rem; color: #05B396; font-weight: 700;">{{ \App\Models\Setting::get('cert_subtitle', 'SkillLearner ISO 9001:2015 Accredited') }}</div>
                </div>
            </div>
            <button type="button" onclick="closeCertificatePreviewModal()" style="background: rgba(255,255,255,0.2); border: none; color: #ffffff; width: 30px; height: 30px; border-radius: 50%; cursor: pointer; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; font-weight: 700;">&times;</button>
        </div>

        <!-- Certificate Body -->
        <div style="padding: 2.2rem 2rem; text-align: center; background: radial-gradient(circle, #f0fdf9 0%, #ffffff 80%);">
            <img src="{{ asset('images/logo.png') }}" alt="SkillLearner" style="max-height: 48px; margin-bottom: 1.2rem;" onerror="this.src='/images/logo.png';">
            
            <div style="font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: {{ \App\Models\Setting::get('cert_theme_color', '#05B396') }}; margin-bottom: 0.6rem;">
                {{ \App\Models\Setting::get('cert_title', 'CERTIFICATE OF COMPLETION') }}
            </div>

            <p style="font-size: 0.95rem; color: #64748b; margin-bottom: 0.8rem;">This is proudly presented to</p>

            <h2 id="certStudentName" style="font-size: 1.8rem; font-weight: 900; color: #0f172a; margin-bottom: 0.8rem; letter-spacing: -0.5px;"></h2>

            <p style="font-size: 0.9rem; color: #475569; max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.5;">
                For successfully completing all video lectures, practical evaluations, quizzes, and projects for the masterclass program in
            </p>

            <div id="certCourseTitle" style="font-size: 1.25rem; font-weight: 800; color: #05B396; margin-bottom: 1.8rem;"></div>

            <div style="display: flex; justify-content: space-around; border-top: 1px dashed #cbd5e1; padding-top: 1.2rem; font-size: 0.82rem; color: #64748b;">
                <div>
                    <div>Issue Date</div>
                    <strong id="certIssueDate" style="color: #0f172a;"></strong>
                </div>
                <div>
                    <div>Certificate ID</div>
                    <strong id="certIdNumber" style="font-family: monospace; color: #0f172a;"></strong>
                </div>
                <div>
                    <div>Verification</div>
                    <strong style="color: #05B396;">VERIFIED ✅</strong>
                </div>
            </div>
        </div>

        <div style="background: #f8fafc; padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #e2e8f0;">
            <span style="font-size: 0.78rem; color: #64748b;">Issued via SkillLearner Administration Console</span>
            <button type="button" onclick="window.print()" class="btn" style="background: #05B396; color: #fff; font-weight: 800; font-size: 0.85rem; padding: 6px 16px; border-radius: 8px;">
                🖨️ Print / Download
            </button>
        </div>
    </div>
</div>

<!-- Super Admin: Assign Package & Free Activate Modal -->
<div id="assignPackageModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); z-index: 9999; backdrop-filter: blur(5px); align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #ffffff; border-radius: 20px; max-width: 540px; width: 100%; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); border: 1.5px solid #a7f3d0; overflow: hidden; animation: popIn 0.2s ease-out;">
        <!-- Modal Header -->
        <div style="background: linear-gradient(135deg, #00137a 0%, #05B396 100%); padding: 1.2rem 1.5rem; color: #ffffff; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                    ⚡
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: #ffffff; line-height: 1.2;">Assign Package / Free Activate</h3>
                    <div style="font-size: 0.78rem; color: #e2e8f0; margin-top: 2px;">Bina payment ke ID active karein &amp; package assign karein</div>
                </div>
            </div>
            <button type="button" onclick="closeAssignPackageModal()" style="background: rgba(255,255,255,0.2); border: none; color: #ffffff; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; font-weight: 700; transition: background 0.15s ease;">&times;</button>
        </div>

        <!-- Modal Body Form -->
        <form id="assignPackageForm" method="POST" action="" style="padding: 1.4rem 1.5rem; max-height: calc(85vh - 70px); overflow-y: auto;">
            @csrf
            
            <!-- User Highlight Card -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 0.85rem 1rem; margin-bottom: 1.2rem; display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                <div>
                    <div style="font-size: 0.72rem; text-transform: uppercase; font-weight: 800; color: #64748b; letter-spacing: 0.5px;">Target User</div>
                    <div id="assignModalUserName" style="font-weight: 800; color: #0f172a; font-size: 0.95rem; margin-top: 2px;">{{ $user->name }}</div>
                    <div id="assignModalUserEmail" style="font-size: 0.8rem; color: #64748b;">{{ $user->email }}</div>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 0.72rem; text-transform: uppercase; font-weight: 800; color: #64748b; letter-spacing: 0.5px;">Current Status</div>
                    <div id="assignModalCurrentBadge" style="display: inline-block; margin-top: 2px; font-size: 0.75rem; font-weight: 800; padding: 2px 8px; border-radius: 6px; background: {{ $user->payment_status === 'paid' ? '#f0fdf4' : '#fffbeb' }}; color: {{ $user->payment_status === 'paid' ? '#166534' : '#b45309' }};">
                        {{ $user->active_package ?? 'Advance Package' }} • {{ strtoupper($user->payment_status ?? 'pending') }}
                    </div>
                </div>
            </div>

            <!-- 1. Select Package -->
            <div style="margin-bottom: 1.1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 800; color: #1e293b; margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.5px;">
                    📦 Select Package to Assign <span style="color: #ef4444;">*</span>
                </label>
                <select name="package_name" id="assignModalPackageSelect" required style="width: 100%; box-sizing: border-box; padding: 0.75rem 1rem; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.92rem; font-weight: 700; color: #0f172a; outline: none; background: #ffffff; cursor: pointer;">
                    @if(!empty($packages) && count($packages) > 0)
                        @foreach($packages as $pkg)
                            <option value="{{ $pkg['name'] }}" {{ ($user->active_package ?? '') === $pkg['name'] ? 'selected' : '' }}>
                                {{ $pkg['name'] }} (₹{{ number_format($pkg['price']) }}) &mdash; {{ $pkg['access_badge'] ?? ($pkg['total_courses_count'] ?? 0).' Courses' }}
                            </option>
                        @endforeach
                    @else
                        <option value="Basic Package">Basic Package (₹599) &mdash; 3 Courses</option>
                        <option value="Growth Package">Growth Package (₹1,199) &mdash; 6 Courses</option>
                        <option value="Advance Package" selected>Advance Package (₹2,399) &mdash; 10+ Courses</option>
                        <option value="Premium Package">Premium Package (₹4,799) &mdash; 15+ Courses</option>
                        <option value="Infinity Package">Infinity Package (₹9,599) &mdash; All 20+ Courses</option>
                    @endif
                </select>
                <div style="font-size: 0.75rem; color: #64748b; margin-top: 4px;">
                    User's active package will be updated immediately.
                </div>
            </div>

            <!-- 2. Payment & Activation Status -->
            <div style="margin-bottom: 1.1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 800; color: #1e293b; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px;">
                    🟢 Payment &amp; Activation Mode <span style="color: #ef4444;">*</span>
                </label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <label style="display: flex; align-items: flex-start; gap: 8px; border: 1.5px solid #a7f3d0; background: #f0fdf4; padding: 0.75rem; border-radius: 10px; cursor: pointer;">
                        <input type="radio" name="payment_status" value="paid" id="assignStatusPaid" checked style="margin-top: 3px; accent-color: #05B396;">
                        <div>
                            <div style="font-weight: 800; color: #166534; font-size: 0.86rem;">🟢 Free Active (Paid)</div>
                            <div style="font-size: 0.72rem; color: #15803d; line-height: 1.3; margin-top: 2px;">
                                Account active instantly. User can login immediately without payment.
                            </div>
                        </div>
                    </label>

                    <label style="display: flex; align-items: flex-start; gap: 8px; border: 1.5px solid #e2e8f0; background: #f8fafc; padding: 0.75rem; border-radius: 10px; cursor: pointer;">
                        <input type="radio" name="payment_status" value="pending" id="assignStatusPending" style="margin-top: 3px; accent-color: #05B396;">
                        <div>
                            <div style="font-weight: 800; color: #475569; font-size: 0.86rem;">⏳ Keep Pending</div>
                            <div style="font-size: 0.72rem; color: #64748b; line-height: 1.3; margin-top: 2px;">
                                Assign package only. Login remains gated until payment.
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- 3. Course Access / Unlock Mode -->
            <div style="margin-bottom: 1.1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 800; color: #1e293b; margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.5px;">
                    🎓 Course Access Unlock
                </label>
                <select name="unlock_courses" style="width: 100%; box-sizing: border-box; padding: 0.75rem 1rem; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.9rem; font-weight: 600; color: #0f172a; outline: none; background: #ffffff;">
                    <option value="package_only" selected>🎓 Unlock all courses of selected package bundle (Recommended)</option>
                    <option value="all_courses">🌟 Unlock ALL platform courses (Full Access)</option>
                    <option value="none">🔒 Do not auto-unlock courses</option>
                </select>
            </div>

            <!-- 4. Sponsor Commission Toggle -->
            <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 0.75rem 0.9rem; margin-bottom: 1.1rem;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; margin: 0;">
                    <input type="checkbox" name="distribute_commission" value="1" style="accent-color: #05B396; width: 16px; height: 16px;">
                    <span style="font-weight: 700; color: #92400e; font-size: 0.84rem;">
                        Sponsor ko affiliate commission credit karein
                    </span>
                </label>
                <div style="font-size: 0.73rem; color: #b45309; margin-top: 4px; padding-left: 24px; line-height: 1.3;">
                    Default unchecked: Bina payment ki free activation me sponsor wallet me fake money add nahi hoga jab tak aap explicitly check na karein.
                </div>
            </div>

            <!-- 5. Admin Note / Remarks -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 800; color: #1e293b; margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.5px;">
                    📝 Admin Remarks / Reason
                </label>
                <input type="text" 
                       name="admin_note" 
                       id="assignModalAdminNote" 
                       placeholder="Reason (e.g. Free activation by Super Admin, Special Onboarding, VIP pass)" 
                       value="Activated by Super Admin without payment"
                       style="width: 100%; box-sizing: border-box; padding: 0.7rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.88rem; outline: none;">
            </div>

            <!-- Modal Actions -->
            <div style="display: flex; gap: 10px; justify-content: flex-end; padding-top: 0.8rem; border-top: 1px solid #e2e8f0;">
                <button type="button" onclick="closeAssignPackageModal()" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 0.7rem 1.2rem; border-radius: 8px; font-weight: 700; font-size: 0.88rem; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" style="background: linear-gradient(135deg, #05B396 0%, #00137a 100%); color: #ffffff; border: none; padding: 0.7rem 1.4rem; border-radius: 8px; font-weight: 800; font-size: 0.9rem; cursor: pointer; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.4); display: inline-flex; align-items: center; gap: 6px;">
                    <span>⚡ Activate &amp; Assign Package</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openPasswordResetModal(userId, userName) {
        const modal = document.getElementById('passwordResetModal');
        const form = document.getElementById('passwordResetForm');
        const nameSpan = document.getElementById('resetModalUserName');
        const input = document.getElementById('newPasswordInput');

        if (nameSpan) nameSpan.innerText = userName;
        if (form) form.action = "/admin/users/" + userId + "/reset-password";
        if (input) input.value = "Skill@" + Math.floor(1000 + Math.random() * 9000);

        if (modal) {
            modal.style.display = 'flex';
        }
    }

    function closePasswordResetModal() {
        const modal = document.getElementById('passwordResetModal');
        if (modal) modal.style.display = 'none';
    }

    function openCertificatePreviewModal(studentName, courseTitle, certId, issueDate) {
        document.getElementById('certStudentName').innerText = studentName;
        document.getElementById('certCourseTitle').innerText = courseTitle;
        document.getElementById('certIdNumber').innerText = certId;
        document.getElementById('certIssueDate').innerText = issueDate;

        const modal = document.getElementById('certificatePreviewModal');
        if (modal) modal.style.display = 'flex';
    }

    function closeCertificatePreviewModal() {
        const modal = document.getElementById('certificatePreviewModal');
        if (modal) modal.style.display = 'none';
    }

    function openAssignPackageModal(userId, userName, userEmail, currentPackage, currentStatus) {
        const modal = document.getElementById('assignPackageModal');
        const form = document.getElementById('assignPackageForm');
        const nameSpan = document.getElementById('assignModalUserName');
        const emailSpan = document.getElementById('assignModalUserEmail');
        const badgeDiv = document.getElementById('assignModalCurrentBadge');
        const pkgSelect = document.getElementById('assignModalPackageSelect');
        const statusPaidRadio = document.getElementById('assignStatusPaid');

        if (form) form.action = '{{ url("/admin/users") }}/' + userId + '/assign-package';
        if (nameSpan) nameSpan.textContent = userName;
        if (emailSpan) emailSpan.textContent = userEmail || 'No email';
        if (badgeDiv) {
            badgeDiv.textContent = (currentPackage || 'None') + ' • ' + (currentStatus || 'pending').toUpperCase();
            if (currentStatus === 'paid') {
                badgeDiv.style.background = '#f0fdf4';
                badgeDiv.style.color = '#166534';
            } else {
                badgeDiv.style.background = '#fffbeb';
                badgeDiv.style.color = '#b45309';
            }
        }

        if (pkgSelect && currentPackage) {
            for (let i = 0; i < pkgSelect.options.length; i++) {
                if (pkgSelect.options[i].value.toLowerCase() === currentPackage.toLowerCase()) {
                    pkgSelect.selectedIndex = i;
                    break;
                }
            }
        }

        if (statusPaidRadio) {
            statusPaidRadio.checked = true;
        }

        if (modal) {
            modal.style.display = 'flex';
        }
    }

    function closeAssignPackageModal() {
        const modal = document.getElementById('assignPackageModal');
        if (modal) {
            modal.style.display = 'none';
        }
    }
</script>

@include('portal.styles')
@endsection

