@extends('layouts.app')

@section('title', 'All Users & Role Control — SkillLearner Admin')

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
            <!-- Header & Welcome Banner -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem;">
                <div>
                    <h2 class="welcome-heading" style="font-size: 1.6rem; margin-bottom: 0.25rem;">
                        👥 User Management &amp; Access Control
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Inspect user profiles, manage course enrollments, track learning progress, block/unblock accounts, and reset credentials.
                    </p>
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

            <!-- Role Stat Summary Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 1rem; margin-bottom: 1.8rem;">
                <!-- Total Users -->
                <div class="admin-stat-card">
                    <div class="admin-stat-label">TOTAL PLATFORM USERS</div>
                    <div class="admin-stat-val">{{ $counts['total'] }}</div>
                    <div class="admin-stat-sub">Across all registered roles</div>
                </div>

                <!-- Super Admins -->
                <div class="admin-stat-card" style="border-top: 3px solid #7c3aed;">
                    <div class="admin-stat-label" style="color: #7c3aed;">👑 SUPER ADMINS</div>
                    <div class="admin-stat-val" style="color: #7c3aed;">{{ $counts['super_admin'] }}</div>
                    <div class="admin-stat-sub">Master system access</div>
                </div>

                <!-- Operations Admins -->
                <div class="admin-stat-card" style="border-top: 3px solid #0284c7;">
                    <div class="admin-stat-label" style="color: #0284c7;">🛡️ ADMINS</div>
                    <div class="admin-stat-val" style="color: #0284c7;">{{ $counts['admin'] }}</div>
                    <div class="admin-stat-sub">KYC &amp; payout managers</div>
                </div>

                <!-- Students & Affiliates -->
                <div class="admin-stat-card" style="border-top: 3px solid #05B396;">
                    <div class="admin-stat-label" style="color: #05B396;">🎓 STUDENTS</div>
                    <div class="admin-stat-val" style="color: #05B396;">{{ $counts['user'] }}</div>
                    <div class="admin-stat-sub">Active course learners</div>
                </div>

                <!-- Blocked Accounts -->
                <div class="admin-stat-card" style="border-top: 3px solid #ef4444;">
                    <div class="admin-stat-label" style="color: #ef4444;">🔴 BLOCKED ACCOUNTS</div>
                    <div class="admin-stat-val" style="color: #ef4444;">{{ $counts['blocked'] }}</div>
                    <div class="admin-stat-sub">Login access restricted</div>
                </div>

                <!-- Pending Payment -->
                <div class="admin-stat-card" style="border-top: 3px solid #f59e0b;">
                    <div class="admin-stat-label" style="color: #f59e0b;">⏳ PENDING VERIFY</div>
                    <div class="admin-stat-val" style="color: #f59e0b;">{{ $counts['pending'] }}</div>
                    <div class="admin-stat-sub">Awaiting verification</div>
                </div>
            </div>

            <!-- Search Bar & Filter Pills -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.2rem; margin-bottom: 1.5rem;">
                <form method="GET" action="{{ url('/admin/users') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; justify-content: space-between;">
                    <!-- Filter Pills -->
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <a href="{{ url('/admin/users') }}" class="admin-filter-pill {{ $currentFilter === 'all' ? 'active' : '' }}">
                            All ({{ $counts['total'] }})
                        </a>
                        <a href="{{ url('/admin/users?role=super_admin') }}" class="admin-filter-pill {{ $currentFilter === 'super_admin' ? 'active' : '' }}">
                            👑 Super Admin ({{ $counts['super_admin'] }})
                        </a>
                        <a href="{{ url('/admin/users?role=admin') }}" class="admin-filter-pill {{ $currentFilter === 'admin' ? 'active' : '' }}">
                            🛡️ Admin ({{ $counts['admin'] }})
                        </a>
                        <a href="{{ url('/admin/users?role=user') }}" class="admin-filter-pill {{ $currentFilter === 'user' ? 'active' : '' }}">
                            🎓 Users ({{ $counts['user'] }})
                        </a>
                        <a href="{{ url('/admin/users?status=active') }}" class="admin-filter-pill {{ $currentFilter === 'active' ? 'active' : '' }}">
                            🟢 Active
                        </a>
                        <a href="{{ url('/admin/users?status=blocked') }}" class="admin-filter-pill {{ $currentFilter === 'blocked' ? 'active' : '' }}">
                            🔴 Blocked ({{ $counts['blocked'] }})
                        </a>
                        <a href="{{ url('/admin/users?status=pending') }}" class="admin-filter-pill {{ $currentFilter === 'pending' ? 'active' : '' }}">
                            ⏳ Pending ({{ $counts['pending'] }})
                        </a>
                    </div>

                    <!-- Search Input -->
                    <div style="display: flex; gap: 8px; flex: 1; max-width: 320px;">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search by name, email, ID..." style="width: 100%; padding: 0.55rem 0.9rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none;">
                        <button type="submit" style="background: #05B396; color: #fff; border: none; padding: 0.55rem 1rem; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.88rem;">Search</button>
                    </div>
                </form>
            </div>

            <!-- Users Data Table Card -->
            <div style="background: #ffffff; border: 1.5px solid #a7f3d0; border-radius: 18px; box-shadow: 0 4px 20px rgba(5, 179, 150, 0.04); overflow: hidden;">
                <div style="padding: 1.2rem 1.6rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0;">
                        Registered Accounts ({{ count($users) }})
                    </h3>
                    <span style="font-size: 0.8rem; color: #64748b; font-weight: 600;">
                        Logged in as: <strong>{{ session('user.name') }}</strong> ({{ strtoupper(session('user.role', 'user')) }})
                    </span>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-size: 0.76rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                <th style="padding: 0.85rem 1.2rem;">User</th>
                                <th style="padding: 0.85rem 0.8rem;">Role</th>
                                <th style="padding: 0.85rem 0.8rem;">Status</th>
                                <th style="padding: 0.85rem 0.8rem;">Package &amp; Courses</th>
                                <th style="padding: 0.85rem 0.8rem;">Wallet / Earned</th>
                                <th style="padding: 0.85rem 0.8rem;">Industry Rev</th>
                                <th style="padding: 0.85rem 0.8rem;">KYC</th>
                                <th style="padding: 0.85rem 1.2rem; text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $u)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease; {{ $u->is_blocked ? 'background: #fff5f5;' : '' }}" onmouseover="this.style.background='{{ $u->is_blocked ? '#fee2e2' : '#f0fdfa' }}'" onmouseout="this.style.background='{{ $u->is_blocked ? '#fff5f5' : '#ffffff' }}'">
                                    
                                    <!-- User Info -->
                                    <td style="padding: 0.95rem 1.2rem;">
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <img src="{{ $u->avatar ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80' }}" alt="{{ $u->name }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid {{ $u->is_blocked ? '#ef4444' : '#05B396' }};">
                                            <div>
                                                <div style="display: flex; align-items: center; gap: 6px;">
                                                    <a href="{{ route('admin.users.show', $u->id) }}" style="font-weight: 800; color: #0f172a; font-size: 0.92rem; text-decoration: none;" onmouseover="this.style.color='#05B396'" onmouseout="this.style.color='#0f172a'">
                                                        {{ $u->name }}
                                                    </a>
                                                    @if($u->is_blocked)
                                                        <span style="background: #dc2626; color: #fff; font-size: 0.65rem; font-weight: 800; padding: 1px 6px; border-radius: 4px; text-transform: uppercase;">Blocked</span>
                                                    @endif
                                                </div>
                                                <div style="font-size: 0.78rem; color: #64748b;">{{ $u->email }}</div>
                                                <div style="font-size: 0.72rem; color: #05B396; font-weight: 700;">ID: {{ $u->affiliate_id ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Role Badge -->
                                    <td style="padding: 0.95rem 0.8rem;">
                                        @if($u->role === 'super_admin')
                                            <span style="background: rgba(124, 58, 237, 0.12); color: #7c3aed; font-weight: 800; font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; border: 1px solid rgba(124, 58, 237, 0.3); display: inline-flex; align-items: center; gap: 4px;">
                                                👑 Super Admin
                                            </span>
                                        @elseif($u->role === 'admin')
                                            <span style="background: rgba(2, 132, 199, 0.12); color: #0284c7; font-weight: 800; font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; border: 1px solid rgba(2, 132, 199, 0.3); display: inline-flex; align-items: center; gap: 4px;">
                                                🛡️ Admin
                                            </span>
                                        @else
                                            <span style="background: rgba(5, 179, 150, 0.12); color: #05B396; font-weight: 800; font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; border: 1px solid rgba(5, 179, 150, 0.3); display: inline-flex; align-items: center; gap: 4px;">
                                                👤 User
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Status (Account & Payment) -->
                                    <td style="padding: 0.95rem 0.8rem;">
                                        <div style="display: flex; flex-direction: column; gap: 4px; align-items: flex-start;">
                                            @if($u->is_blocked)
                                                <span style="background: #fef2f2; color: #dc2626; font-weight: 800; font-size: 0.72rem; padding: 2px 7px; border-radius: 6px; border: 1px solid #fecaca;">
                                                    🔒 Blocked
                                                </span>
                                            @else
                                                <span style="background: #f0fdf4; color: #166534; font-weight: 800; font-size: 0.72rem; padding: 2px 7px; border-radius: 6px; border: 1px solid #bbf7d0;">
                                                    🟢 Active
                                                </span>
                                            @endif

                                            @if(($u->payment_status ?? 'paid') === 'pending')
                                                <span style="background: #fffbeb; color: #b45309; font-weight: 700; font-size: 0.72rem; padding: 2px 7px; border-radius: 6px; border: 1px solid #fde68a;">
                                                    ⏳ Pending Pay
                                                </span>
                                            @else
                                                <span style="background: #f0fdf4; color: #059669; font-weight: 700; font-size: 0.72rem; padding: 2px 7px; border-radius: 6px;">
                                                    ✔ Paid
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Active Package & Enrolled Courses -->
                                    <td style="padding: 0.95rem 0.8rem;">
                                        <div style="font-weight: 700; color: #334155; font-size: 0.88rem;">{{ $u->active_package ?? 'Advance Package' }}</div>
                                        <div style="margin-top: 3px;">
                                            <a href="{{ route('admin.users.show', $u->id) }}" style="display: inline-flex; align-items: center; gap: 4px; background: #f0fdfa; border: 1px solid #a7f3d0; color: #05B396; font-size: 0.74rem; font-weight: 700; padding: 2px 8px; border-radius: 6px; text-decoration: none;">
                                                <span>🎓 {{ $u->user_courses_count ?? 0 }} Courses</span>
                                            </a>
                                        </div>
                                    </td>

                                    <!-- Wallet Balance -->
                                    <td style="padding: 0.95rem 0.8rem;">
                                        <div style="font-weight: 800; color: #0f172a;">₹{{ number_format((float) $u->wallet_balance, 2) }}</div>
                                        <div style="font-size: 0.75rem; color: #64748b;">Earned: ₹{{ number_format((float) $u->total_earning, 2) }}</div>
                                    </td>

                                    <!-- Industry Revenue (Admin Editable) -->
                                    <td style="padding: 0.95rem 0.8rem;">
                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            <div>
                                                <div style="font-weight: 800; color: #0284c7; font-size: 0.88rem;">
                                                    ₹{{ number_format((float) ($u->industry_revenue ?? 0), 2) }}
                                                </div>
                                            </div>
                                            <button type="button" 
                                                    onclick="openEditIndustryRevenueModal('{{ $u->id }}', '{{ addslashes($u->name) }}', '{{ (float) ($u->industry_revenue ?? 0) }}')"
                                                    title="Change Industry Revenue" 
                                                    style="background: #f8fafc; border: 1px solid #cbd5e1; color: #64748b; border-radius: 4px; padding: 3px 6px; font-size: 0.7rem; font-weight: 700; cursor: pointer;">
                                                Edit
                                            </button>
                                        </div>
                                    </td>

                                    <!-- KYC Status -->
                                    <td style="padding: 0.95rem 0.8rem;">
                                        @if(str_contains(strtolower($u->kyc_status ?? ''), 'verified'))
                                            <span style="background: #f0fdf4; color: #166534; font-weight: 700; font-size: 0.74rem; padding: 3px 8px; border-radius: 6px;">Verified ✅</span>
                                        @else
                                            <span style="background: #fffbeb; color: #b45309; font-weight: 700; font-size: 0.74rem; padding: 3px 8px; border-radius: 6px;">Pending ⏳</span>
                                        @endif
                                    </td>

                                    <!-- Action Buttons -->
                                    <td style="padding: 0.95rem 1.2rem; text-align: right;">
                                        @php
                                            $currentActiveRole = Auth::user()?->role ?? session('user.role', 'user');
                                            $canLoginAs = in_array($currentActiveRole, ['super_admin', 'admin']) && (Auth::id() !== $u->id);
                                            $isSuper = $currentActiveRole === 'super_admin';
                                        @endphp
                                        <div style="display: inline-flex; align-items: center; justify-content: flex-end; gap: 6px; flex-wrap: wrap;">
                                            
                                            <!-- 1. View Profile, Courses & Progress -->
                                            <a href="{{ route('admin.users.show', $u->id) }}" 
                                               class="btn-action-pill"
                                               style="background: #f0fdfa; border: 1.5px solid #05B396; color: #05B396;"
                                               title="View full profile, course enrollments & certificates">
                                                <span>👁️ View</span>
                                            </a>

                                            <!-- 2. Verify Account (if pending) -->
                                            @if(($u->payment_status ?? 'paid') === 'pending')
                                                <form method="POST" action="{{ route('admin.users.verify-account', $u->id) }}" style="margin: 0;">
                                                    @csrf
                                                    <button type="submit" 
                                                            onclick="return confirm('Kya aap {{ $u->name }} ka account verify karke activate karna chahte hain?');" 
                                                            class="btn-action-pill"
                                                            style="background: #05B396; color: #ffffff; border: none;"
                                                            title="Approve payment & activate ID">
                                                        <span>✔ Verify</span>
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- 3. Reset Password -->
                                            <button type="button" 
                                                    onclick="openPasswordResetModal('{{ $u->id }}', '{{ addslashes($u->name) }}')" 
                                                    class="btn-action-pill"
                                                    style="background: #f8fafc; border: 1px solid #cbd5e1; color: #334155;"
                                                    title="Reset user password">
                                                <span>🔑 Pwd</span>
                                            </button>

                                            <!-- 4. Block / Unblock Account -->
                                            @if(Auth::id() !== $u->id)
                                                <form method="POST" action="{{ route('admin.users.toggle-block', $u->id) }}" style="margin: 0;">
                                                    @csrf
                                                    <button type="submit" 
                                                            onclick="return confirm('Kya aap {{ $u->name }} ko {{ $u->is_blocked ? 'UNBLOCK' : 'BLOCK' }} karna chahte hain?');" 
                                                            class="btn-action-pill"
                                                            style="background: {{ $u->is_blocked ? '#ecfdf5' : '#fef2f2' }}; border: 1px solid {{ $u->is_blocked ? '#a7f3d0' : '#fecaca' }}; color: {{ $u->is_blocked ? '#059669' : '#dc2626' }};"
                                                            title="{{ $u->is_blocked ? 'Unblock user' : 'Block user from logging in' }}">
                                                        <span>{{ $u->is_blocked ? '🔓 Unblock' : '🔒 Block' }}</span>
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- 5. Login As (Impersonate) -->
                                            @if($canLoginAs)
                                                <a href="{{ route('admin.impersonate', $u->id) }}" 
                                                   class="btn-impersonate-action"
                                                   onclick="return confirm('Kya aap {{ $u->name }} ke account me login karna chahte hain?');"
                                                   title="Login directly as {{ $u->name }}">
                                                    <span>Login As</span>
                                                </a>
                                            @endif

                                            <!-- 6. Role Selector (Super Admin) -->
                                            @if($isSuper)
                                                <form method="POST" action="{{ url('/admin/users/'.$u->id.'/role') }}" style="display: inline-flex; align-items: center; margin: 0;">
                                                    @csrf
                                                    <select name="role" style="font-size: 0.74rem; font-weight: 600; padding: 4px 6px; border: 1px solid #cbd5e1; border-radius: 6px; background: #fff; outline: none; cursor: pointer;" onchange="this.form.submit()">
                                                        <option value="super_admin" {{ $u->role === 'super_admin' ? 'selected' : '' }}>👑 Super Admin</option>
                                                        <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>🛡️ Admin</option>
                                                        <option value="user" {{ in_array($u->role, ['user', 'affiliate', 'student']) ? 'selected' : '' }}>👤 User</option>
                                                    </select>
                                                </form>

                                                <!-- 7. Hard Delete -->
                                                @if(Auth::id() !== $u->id)
                                                    <form method="POST" action="{{ route('admin.users.delete', $u->id) }}" style="display: inline-flex; align-items: center; margin: 0;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                onclick="return confirm('⚠️ DANGER: Kya aap sach me user \'{{ addslashes($u->name) }}\' (ID: {{ $u->affiliate_id ?? $u->id }}) aur iska SARA DATA permanently HARD DELETE karna chahte hain?');"
                                                                title="Permanently hard delete user"
                                                                class="btn-delete-user-action">
                                                            <span>Delete</span>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="padding: 3rem 1rem; text-align: center; color: #64748b;">
                                        No users found matching your search.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
                            <input type="text" name="password" id="newPasswordInput" required minlength="6" placeholder="Enter at least 6 characters" style="width: 100%; box-sizing: border-box; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; font-weight: 600; outline: none;">
                        </div>

                        <div style="display: flex; gap: 10px; justify-content: flex-end;">
                            <button type="button" onclick="closePasswordResetModal()" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #475569; padding: 8px 16px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.86rem;">
                                Cancel
                            </button>
                            <button type="submit" style="background: #05B396; color: #ffffff; border: none; padding: 8px 20px; border-radius: 8px; font-weight: 800; cursor: pointer; font-size: 0.86rem;">
                                Save Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Industry Revenue Modal -->
            <div id="industryRevenueModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); z-index: 9999; backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 1rem;">
                <div style="background: #ffffff; border-radius: 18px; max-width: 440px; width: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.25); border: 1.5px solid #a7f3d0; overflow: hidden;">
                    <!-- Modal Header -->
                    <div style="background: linear-gradient(135deg, #00137a 0%, #05B396 100%); padding: 1.2rem 1.4rem; color: #ffffff; display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 1.2rem;">🏢</span>
                            <h3 style="margin: 0; font-size: 1.05rem; font-weight: 800; color: #ffffff;">Update Industry Revenue</h3>
                        </div>
                        <button type="button" onclick="closeEditIndustryRevenueModal()" style="background: rgba(255,255,255,0.2); border: none; color: #ffffff; width: 28px; height: 28px; border-radius: 50%; cursor: pointer; font-size: 1rem; display: flex; align-items: center; justify-content: center; font-weight: 700;">&times;</button>
                    </div>

                    <!-- Modal Form -->
                    <form id="industryRevenueForm" method="POST" action="" style="padding: 1.4rem;">
                        @csrf
                        <p style="font-size: 0.88rem; color: #475569; margin: 0 0 1rem; line-height: 1.5;">
                            Set custom <strong>Industry Revenue</strong> for <span id="modalUserName" style="color: #0f172a; font-weight: 700;"></span>. This will immediately reflect on their student dashboard.
                        </p>

                        <div style="margin-bottom: 1.2rem;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                Industry Revenue Amount (₹)
                            </label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-weight: 800; color: #05B396; font-size: 1.05rem;">₹</span>
                                <input type="number" 
                                       step="0.01" 
                                       min="0" 
                                       name="industry_revenue" 
                                       id="modalIndustryRevenueInput" 
                                       required 
                                       placeholder="0.00"
                                       style="width: 100%; box-sizing: border-box; padding: 0.75rem 1rem 0.75rem 2rem; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 1rem; font-weight: 800; color: #0f172a; outline: none;">
                            </div>
                            <div style="font-size: 0.75rem; color: #64748b; margin-top: 5px;">
                                Enter any amount (e.g. 0, 5000, 410940). Default is 0.
                            </div>
                        </div>

                        <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 1.5rem;">
                            <button type="button" onclick="closeEditIndustryRevenueModal()" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 0.65rem 1.1rem; border-radius: 8px; font-weight: 700; font-size: 0.88rem; cursor: pointer;">
                                Cancel
                            </button>
                            <button type="submit" style="background: #05B396; color: #ffffff; border: none; padding: 0.65rem 1.3rem; border-radius: 8px; font-weight: 800; font-size: 0.88rem; cursor: pointer; box-shadow: 0 4px 12px rgba(5, 179, 150, 0.35);">
                                Save Industry Revenue
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
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

    function openEditIndustryRevenueModal(userId, userName, currentAmount) {
        const modal = document.getElementById('industryRevenueModal');
        const form = document.getElementById('industryRevenueForm');
        const nameSpan = document.getElementById('modalUserName');
        const input = document.getElementById('modalIndustryRevenueInput');

        form.action = '{{ url("/admin/users") }}/' + userId + '/industry-revenue';
        nameSpan.textContent = userName;
        input.value = currentAmount || 0;

        modal.style.display = 'flex';
        setTimeout(() => input.focus(), 100);
    }

    function closeEditIndustryRevenueModal() {
        const modal = document.getElementById('industryRevenueModal');
        modal.style.display = 'none';
    }
</script>

@include('portal.styles')

@push('styles')
<style>
    .admin-stat-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.1rem 1.3rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }
    .admin-stat-label {
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.6px;
        color: #64748b;
        margin-bottom: 0.35rem;
    }
    .admin-stat-val {
        font-size: 1.8rem;
        font-weight: 900;
        color: #0f172a;
        line-height: 1.1;
        margin-bottom: 0.25rem;
    }
    .admin-stat-sub {
        font-size: 0.78rem;
        color: #94a3b8;
        font-weight: 500;
    }
    .admin-filter-pill {
        display: inline-block;
        padding: 0.45rem 0.95rem;
        border-radius: 20px;
        background: #f1f5f9;
        color: #475569;
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .admin-filter-pill:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    .admin-filter-pill.active {
        background: #05B396;
        color: #ffffff;
    }
    .btn-action-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 4px 9px;
        border-radius: 6px;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .btn-action-pill:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .btn-impersonate-action {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #0284c7;
        color: #ffffff;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 4px 9px;
        border-radius: 6px;
        text-decoration: none;
        box-shadow: 0 1px 4px rgba(2, 132, 199, 0.25);
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .btn-impersonate-action:hover {
        background: #0369a1;
        color: #ffffff;
        transform: translateY(-1px);
    }
    .btn-delete-user-action {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 4px 8px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .btn-delete-user-action:hover {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
        transform: translateY(-1px);
    }
</style>
@endpush
@endsection
