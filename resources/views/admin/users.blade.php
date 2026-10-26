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
                        👥 User Management &amp; Role Control
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Manage all platform accounts, inspect affiliate details, and control permission levels.
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
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.8rem;">
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
                    <div class="admin-stat-sub">Full system master access</div>
                </div>

                <!-- Operations Admins -->
                <div class="admin-stat-card" style="border-top: 3px solid #0284c7;">
                    <div class="admin-stat-label" style="color: #0284c7;">🛡️ OPERATIONS ADMINS</div>
                    <div class="admin-stat-val" style="color: #0284c7;">{{ $counts['admin'] }}</div>
                    <div class="admin-stat-sub">KYC &amp; payout managers</div>
                </div>

                <!-- Students & Affiliates -->
                <div class="admin-stat-card" style="border-top: 3px solid #05B396;">
                    <div class="admin-stat-label" style="color: #05B396;">🎓 STUDENTS / USERS</div>
                    <div class="admin-stat-val" style="color: #05B396;">{{ $counts['user'] }}</div>
                    <div class="admin-stat-sub">Active course learners</div>
                </div>
            </div>

            <!-- Search Bar & Role Filter Pills -->
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
                <div style="padding: 1.2rem 1.6rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
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
                                <th style="padding: 0.85rem 1.4rem;">User</th>
                                <th style="padding: 0.85rem 1rem;">Role</th>
                                <th style="padding: 0.85rem 1rem;">Package</th>
                                <th style="padding: 0.85rem 1rem;">Wallet Balance</th>
                                <th style="padding: 0.85rem 1rem;">KYC Status</th>
                                <th style="padding: 0.85rem 1.4rem; text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $u)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#f0fdfa'" onmouseout="this.style.background='#ffffff'">
                                    <!-- User Info -->
                                    <td style="padding: 0.95rem 1.4rem;">
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <img src="{{ $u->avatar ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80' }}" alt="{{ $u->name }}" style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 1.5px solid #05B396;">
                                            <div>
                                                <div style="font-weight: 800; color: #0f172a; font-size: 0.92rem;">{{ $u->name }}</div>
                                                <div style="font-size: 0.78rem; color: #64748b;">{{ $u->email }}</div>
                                                <div style="font-size: 0.72rem; color: #05B396; font-weight: 700;">ID: {{ $u->affiliate_id ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Role Badge -->
                                    <td style="padding: 0.95rem 1rem;">
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
                                                🎓 Student / User
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Active Package -->
                                    <td style="padding: 0.95rem 1rem;">
                                        <span style="font-weight: 700; color: #334155;">{{ $u->active_package ?? 'Advance Package' }}</span>
                                    </td>

                                    <!-- Wallet Balance -->
                                    <td style="padding: 0.95rem 1rem;">
                                        <div style="font-weight: 800; color: #0f172a;">₹{{ number_format($u->wallet_balance, 2) }}</div>
                                        <div style="font-size: 0.75rem; color: #64748b;">Earned: ₹{{ number_format($u->total_earning, 2) }}</div>
                                    </td>

                                    <!-- KYC Status -->
                                    <td style="padding: 0.95rem 1rem;">
                                        @if(str_contains(strtolower($u->kyc_status ?? ''), 'verified'))
                                            <span style="background: #f0fdf4; color: #166534; font-weight: 700; font-size: 0.75rem; padding: 3px 8px; border-radius: 6px;">Verified ✅</span>
                                        @else
                                            <span style="background: #fffbeb; color: #b45309; font-weight: 700; font-size: 0.75rem; padding: 3px 8px; border-radius: 6px;">Pending ⏳</span>
                                        @endif
                                    </td>

                                    <!-- Action / Change Role (Super Admin can change role) -->
                                    <td style="padding: 0.95rem 1.4rem; text-align: right;">
                                        @if(session('user.role') === 'super_admin')
                                            <form method="POST" action="{{ url('/admin/users/'.$u->id.'/role') }}" style="display: inline-flex; align-items: center; gap: 6px;">
                                                @csrf
                                                <select name="role" style="font-size: 0.78rem; font-weight: 600; padding: 4px 8px; border: 1px solid #cbd5e1; border-radius: 6px; background: #fff; outline: none;" onchange="this.form.submit()">
                                                    <option value="super_admin" {{ $u->role === 'super_admin' ? 'selected' : '' }}>👑 Super Admin</option>
                                                    <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>🛡️ Admin</option>
                                                    <option value="user" {{ in_array($u->role, ['user', 'affiliate', 'student']) ? 'selected' : '' }}>🎓 Student / User</option>
                                                </select>
                                            </form>
                                        @else
                                            <span style="font-size: 0.78rem; color: #94a3b8; font-style: italic;">Super Admin Only</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="padding: 3rem 1rem; text-align: center; color: #64748b;">
                                        No users found matching your search.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</div>

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
</style>
@endpush
@endsection
