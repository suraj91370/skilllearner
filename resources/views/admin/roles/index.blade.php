@extends('layouts.app')

@section('title', 'Roles & Permissions (RBAC) — SkillLearner Super Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Nav -->
    @include('portal.mobile-nav', ['active' => 'admin-roles'])

    <div class="portal-main-grid">
        <!-- Sidebar -->
        @include('portal.sidebar', ['active' => 'admin-roles'])

        <!-- Main Content Area -->
        <main class="portal-content-area">
            
            <!-- Header Row -->
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.8rem; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(5, 179, 150, 0.1); border: 1px solid rgba(5, 179, 150, 0.25); color: #05B396; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 800; text-transform: uppercase; margin-bottom: 0.5rem;">
                        <span>🛡️ ACCESS CONTROL &amp; RBAC</span>
                    </div>
                    <h2 class="welcome-heading" style="font-size: 1.8rem; margin: 0 0 0.3rem 0; color: #0f172a; font-weight: 900;">
                        Roles &amp; Permissions Management
                    </h2>
                    <p style="font-size: 0.92rem; color: #64748b; margin: 0;">
                        Create sub-admins (Support, Finance, Content), configure granular module-wise permissions, and inspect the real-time activity audit trail.
                    </p>
                </div>

                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="{{ route('admin.activity-logs') }}" style="background: #ffffff; border: 1.5px solid #cbd5e1; color: #334155; padding: 0.65rem 1.2rem; border-radius: 10px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                        <span>📋 View Audit Trail</span>
                    </a>
                    @if($activeTab === 'staff')
                        <button type="button" onclick="openStaffModal()" style="background: #05B396; color: #ffffff; border: none; padding: 0.65rem 1.3rem; border-radius: 10px; font-weight: 800; font-size: 0.88rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.35);">
                            <span>➕ Add New Staff</span>
                        </button>
                    @else
                        <button type="button" onclick="openRoleModal()" style="background: #05B396; color: #ffffff; border: none; padding: 0.65rem 1.3rem; border-radius: 10px; font-weight: 800; font-size: 0.88rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.35);">
                            <span>➕ Create New Role</span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Flash Notifications -->
            @if(session('success'))
                <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 1rem 1.2rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 700; display: flex; align-items: center; justify-content: space-between;">
                    <div>✅ {{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 1rem 1.2rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 700;">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 1rem 1.2rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 0.92rem;">
                    <ul style="margin: 0; padding-left: 1.2rem; font-weight: 600;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Navigation Tabs -->
            <div style="display: flex; gap: 12px; margin-bottom: 1.8rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.6rem;">
                <a href="{{ route('admin.roles', ['tab' => 'staff']) }}" style="padding: 0.7rem 1.4rem; border-radius: 10px; font-weight: 800; font-size: 0.95rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; {{ $activeTab === 'staff' ? 'background: #0f172a; color: #ffffff;' : 'background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0;' }}">
                    <span>👥 Staff Members (Sub-Admins)</span>
                    <span style="background: {{ $activeTab === 'staff' ? '#05B396' : '#cbd5e1' }}; color: #ffffff; font-size: 0.72rem; padding: 2px 7px; border-radius: 12px;">{{ $staffUsers->total() }}</span>
                </a>
                <a href="{{ route('admin.roles', ['tab' => 'roles']) }}" style="padding: 0.7rem 1.4rem; border-radius: 10px; font-weight: 800; font-size: 0.95rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; {{ $activeTab === 'roles' ? 'background: #0f172a; color: #ffffff;' : 'background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0;' }}">
                    <span>🛡️ Roles &amp; Permissions Matrix</span>
                    <span style="background: {{ $activeTab === 'roles' ? '#05B396' : '#cbd5e1' }}; color: #ffffff; font-size: 0.72rem; padding: 2px 7px; border-radius: 12px;">{{ $roles->count() }}</span>
                </a>
            </div>

            {{-- ========================================================================= --}}
            {{-- TAB 1: STAFF USERS (SUB-ADMINS) LIST                                      --}}
            {{-- ========================================================================= --}}
            @if($activeTab === 'staff')
                <!-- Quick Metric Cards -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 1.8rem;">
                    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                        <div style="font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Staff Accounts</div>
                        <div style="font-size: 1.8rem; font-weight: 900; color: #0f172a; margin-top: 4px;">{{ $staffUsers->total() }}</div>
                        <div style="font-size: 0.76rem; color: #05B396; font-weight: 700; margin-top: 2px;">Active Sub-Admins with Roles</div>
                    </div>

                    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                        <div style="font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase;">System Roles Active</div>
                        <div style="font-size: 1.8rem; font-weight: 900; color: #05B396; margin-top: 4px;">{{ $roles->count() }}</div>
                        <div style="font-size: 0.76rem; color: #64748b; font-weight: 600; margin-top: 2px;">Support, Finance, Content &amp; Custom</div>
                    </div>

                    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                        <div style="font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Security Protocol</div>
                        <div style="font-size: 1.25rem; font-weight: 900; color: #0f172a; margin-top: 8px;">Audit Trail Active</div>
                        <div style="font-size: 0.76rem; color: #16a34a; font-weight: 700; margin-top: 2px;">All staff actions tracked with IP</div>
                    </div>
                </div>

                <!-- Staff Table -->
                <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                    <div style="padding: 1.2rem 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0;">
                            Staff Members &amp; Sub-Admins Directory
                        </h3>
                        <span style="font-size: 0.82rem; color: #64748b;">
                            Showing {{ $staffUsers->count() }} of {{ $staffUsers->total() }} accounts
                        </span>
                    </div>

                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
                            <thead>
                                <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-weight: 800; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.6px;">
                                    <th style="padding: 1rem 1.5rem;">Staff Member</th>
                                    <th style="padding: 1rem 1rem;">Assigned Role</th>
                                    <th style="padding: 1rem 1rem;">Phone</th>
                                    <th style="padding: 1rem 1rem;">Account Status</th>
                                    <th style="padding: 1rem 1rem;">Created At</th>
                                    <th style="padding: 1rem 1.5rem; text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($staffUsers as $staff)
                                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;">
                                        <!-- Member Info -->
                                        <td style="padding: 1.1rem 1.5rem;">
                                            <div style="display: flex; align-items: center; gap: 12px;">
                                                <div style="width: 42px; height: 42px; border-radius: 50%; background: #0f172a; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.05rem;">
                                                    {{ strtoupper(substr($staff->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div style="font-weight: 800; color: #0f172a;">
                                                        {{ $staff->name }}
                                                        @if($staff->isSuperAdmin())
                                                            <span style="background: #fef3c7; color: #b45309; font-size: 0.68rem; font-weight: 800; padding: 2px 6px; border-radius: 4px; margin-left: 4px;">Root</span>
                                                        @endif
                                                    </div>
                                                    <div style="font-size: 0.8rem; color: #64748b;">
                                                        {{ $staff->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Assigned Role -->
                                        <td style="padding: 1.1rem 1rem;">
                                            @php
                                                $roleSlug = $staff->roleModel?->slug ?? $staff->role;
                                                $badgeBg = match($roleSlug) {
                                                    'super_admin' => '#fef3c7',
                                                    'support' => '#e0f2fe',
                                                    'finance' => '#f3e8ff',
                                                    'content_manager' => '#ecfdf5',
                                                    default => '#f1f5f9',
                                                };
                                                $badgeColor = match($roleSlug) {
                                                    'super_admin' => '#92400e',
                                                    'support' => '#0369a1',
                                                    'finance' => '#7e22ce',
                                                    'content_manager' => '#047857',
                                                    default => '#334155',
                                                };
                                            @endphp
                                            <span style="background: {{ $badgeBg }}; color: {{ $badgeColor }}; font-size: 0.78rem; font-weight: 800; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                                <span>●</span> {{ $staff->roleModel?->name ?? ucfirst(str_replace('_', ' ', $staff->role)) }}
                                            </span>
                                        </td>

                                        <!-- Phone -->
                                        <td style="padding: 1.1rem 1rem; color: #334155; font-weight: 600;">
                                            {{ $staff->phone ?: '—' }}
                                        </td>

                                        <!-- Account Status -->
                                        <td style="padding: 1.1rem 1rem;">
                                            @if($staff->is_blocked)
                                                <span style="background: #fee2e2; color: #991b1b; font-size: 0.76rem; font-weight: 800; padding: 3px 9px; border-radius: 12px;">
                                                    🔒 Blocked
                                                </span>
                                            @else
                                                <span style="background: #dcfce7; color: #15803d; font-size: 0.76rem; font-weight: 800; padding: 3px 9px; border-radius: 12px;">
                                                    ✓ Active
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Date -->
                                        <td style="padding: 1.1rem 1rem; color: #64748b; font-size: 0.82rem;">
                                            {{ $staff->created_at ? $staff->created_at->format('d M Y') : '—' }}
                                        </td>

                                        <!-- Actions -->
                                        <td style="padding: 1.1rem 1.5rem; text-align: right;">
                                            <div style="display: inline-flex; gap: 8px;">
                                                <button type="button" 
                                                        onclick="editStaffModal({{ json_encode([
                                                            'id' => $staff->id,
                                                            'name' => $staff->name,
                                                            'email' => $staff->email,
                                                            'phone' => $staff->phone,
                                                            'role_id' => $staff->role_id ?: ($staff->roleModel?->id ?? ''),
                                                            'is_blocked' => (bool)$staff->is_blocked,
                                                            'is_super_admin' => $staff->isSuperAdmin(),
                                                        ]) }})" 
                                                        style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; padding: 5px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 700; cursor: pointer;">
                                                    ✏️ Edit
                                                </button>

                                                @if(!$staff->isSuperAdmin() && $staff->id !== auth()->id())
                                                    <form method="POST" action="{{ route('admin.staff.delete', $staff->id) }}" onsubmit="return confirm('Kya aap sach me is staff member ko delete karna chahte hain?');" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 5px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 700; cursor: pointer;">
                                                            🗑️ Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="padding: 3rem; text-align: center; color: #64748b;">
                                            Koi staff accounts nahi mile. "Add New Staff" button se sub-admin create karein.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($staffUsers->hasPages())
                        <div style="padding: 1.2rem 1.5rem; border-top: 1px solid #f1f5f9;">
                            {{ $staffUsers->links() }}
                        </div>
                    @endif
                </div>

            {{-- ========================================================================= --}}
            {{-- TAB 2: ROLES & PERMISSIONS MATRIX                                         --}}
            {{-- ========================================================================= --}}
            @else
                <div style="display: flex; flex-direction: column; gap: 2rem;">
                    @foreach($roles as $role)
                        @php
                            $rolePerms = $role->permissions ?? [];
                            $isSuper = $role->slug === 'super_admin';
                        @endphp

                        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.8rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                            
                            <!-- Role Header -->
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.4rem; padding-bottom: 1rem; border-bottom: 1.5px solid #f1f5f9; flex-wrap: wrap; gap: 10px;">
                                <div>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <h3 style="font-size: 1.25rem; font-weight: 900; color: #0f172a; margin: 0;">
                                            {{ $role->name }}
                                        </h3>
                                        @if($role->is_system)
                                            <span style="background: #f1f5f9; color: #475569; font-size: 0.72rem; font-weight: 800; padding: 3px 8px; border-radius: 6px; text-transform: uppercase;">
                                                System Role
                                            </span>
                                        @else
                                            <span style="background: #ecfdf5; color: #047857; font-size: 0.72rem; font-weight: 800; padding: 3px 8px; border-radius: 6px; text-transform: uppercase;">
                                                Custom Role
                                            </span>
                                        @endif
                                        <span style="background: #05B396; color: #ffffff; font-size: 0.72rem; font-weight: 800; padding: 3px 8px; border-radius: 12px;">
                                            {{ $role->users_count }} Staff Assigned
                                        </span>
                                    </div>
                                    <p style="color: #64748b; font-size: 0.88rem; margin: 4px 0 0 0;">
                                        {{ $role->description ?: 'No description provided.' }}
                                    </p>
                                </div>

                                <div>
                                    @if(!$role->is_system)
                                        <form method="POST" action="{{ route('admin.roles.delete', $role->id) }}" onsubmit="return confirm('Kya aap sach me is role ko delete karna chahte hain?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 6px 12px; border-radius: 8px; font-size: 0.82rem; font-weight: 700; cursor: pointer;">
                                                🗑️ Delete Role
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            @if($isSuper)
                                <!-- Super Admin Notification -->
                                <div style="background: #fffbeb; border: 1.5px solid #fde68a; border-radius: 12px; padding: 1rem 1.2rem; color: #92400e; font-size: 0.9rem; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                                    <span style="font-size: 1.3rem;">👑</span>
                                    <span>Super Admin role has full universal root permissions across every module and cannot be restricted.</span>
                                </div>
                            @else
                                <!-- Permissions Matrix Form -->
                                <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                                    @csrf
                                    @method('PUT')

                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 1.2rem;">
                                        <div>
                                            <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #334155; margin-bottom: 3px;">Role Name *</label>
                                            <input type="text" name="name" value="{{ $role->name }}" required style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; font-weight: 700;">
                                        </div>
                                        <div>
                                            <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #334155; margin-bottom: 3px;">Role Description</label>
                                            <input type="text" name="description" value="{{ $role->description }}" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem;">
                                        </div>
                                    </div>

                                    <!-- Module Checkbox Matrix Table -->
                                    <div style="overflow-x: auto; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 1.2rem;">
                                        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                                            <thead>
                                                <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-weight: 800; font-size: 0.78rem; text-transform: uppercase;">
                                                    <th style="padding: 0.85rem 1rem; width: 35%;">Module</th>
                                                    @foreach($actions as $actKey => $actLabel)
                                                        <th style="padding: 0.85rem 1rem; text-align: center;">{{ $actLabel }}</th>
                                                    @endforeach
                                                    <th style="padding: 0.85rem 1rem; text-align: center;">Toggle All</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($modules as $modKey => $modInfo)
                                                    @php
                                                        $assignedActs = $rolePerms[$modKey] ?? [];
                                                    @endphp
                                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                                        <td style="padding: 0.9rem 1rem;">
                                                            <div style="font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 6px;">
                                                                <span>{{ $modInfo['icon'] }}</span>
                                                                <span>{{ $modInfo['name'] }}</span>
                                                            </div>
                                                            <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">
                                                                {{ $modInfo['desc'] }}
                                                            </div>
                                                        </td>

                                                        @foreach($actions as $actKey => $actLabel)
                                                            @php
                                                                $isChecked = in_array($actKey, (array)$assignedActs, true);
                                                            @endphp
                                                            <td style="padding: 0.9rem 1rem; text-align: center;">
                                                                <input type="checkbox" 
                                                                       name="permissions[{{ $modKey }}][]" 
                                                                       value="{{ $actKey }}" 
                                                                       class="perm-checkbox-{{ $role->id }}-{{ $modKey }}"
                                                                       {{ $isChecked ? 'checked' : '' }}
                                                                       style="accent-color: #05B396; width: 17px; height: 17px; cursor: pointer;">
                                                            </td>
                                                        @endforeach

                                                        <td style="padding: 0.9rem 1rem; text-align: center;">
                                                            <button type="button" 
                                                                    onclick="toggleModuleRow('{{ $role->id }}', '{{ $modKey }}')"
                                                                    style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; font-size: 0.72rem; font-weight: 700; padding: 3px 8px; border-radius: 4px; cursor: pointer;">
                                                                Toggle Row
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div style="text-align: right;">
                                        <button type="submit" style="background: #0f172a; color: #ffffff; border: none; padding: 0.65rem 1.4rem; border-radius: 8px; font-weight: 800; font-size: 0.88rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);">
                                            <span>💾 Save Permissions for {{ $role->name }}</span>
                                        </button>
                                    </div>
                                </form>
                            @endif

                        </div>
                    @endforeach
                </div>
            @endif

        </main>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- MODAL 1: ADD NEW STAFF MEMBER                                             --}}
{{-- ========================================================================= --}}
<div id="addStaffModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center; padding: 1.5rem;">
    <div style="background: #ffffff; border-radius: 18px; width: 100%; max-width: 520px; box-shadow: 0 20px 50px rgba(0,0,0,0.3); overflow: hidden;">
        <div style="background: #0f172a; color: #ffffff; padding: 1.2rem 1.6rem; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 1.15rem; font-weight: 800; margin: 0; display: flex; align-items: center; gap: 8px;">
                <span>➕ Add New Staff Member</span>
            </h3>
            <button type="button" onclick="closeStaffModal()" style="background: transparent; border: none; color: #94a3b8; font-size: 1.3rem; cursor: pointer;">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.staff.store') }}" style="padding: 1.6rem;">
            @csrf

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 4px;">Staff Name *</label>
                <input type="text" name="name" required placeholder="e.g. Rahul Sharma" style="width: 100%; padding: 0.7rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 4px;">Official Email *</label>
                    <input type="email" name="email" required placeholder="staff@skilllearner.org" style="width: 100%; padding: 0.7rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 4px;">Phone Number</label>
                    <input type="text" name="phone" placeholder="9876543210" style="width: 100%; padding: 0.7rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem;">
                </div>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 4px;">Assign Role *</label>
                <select name="role_id" required style="width: 100%; padding: 0.7rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem; background: #ffffff;">
                    @foreach($roles as $r)
                        <option value="{{ $r->id }}">{{ $r->name }} ({{ $r->slug }})</option>
                    @endforeach
                </select>
                <small style="color: #64748b; font-size: 0.74rem; display: block; margin-top: 3px;">Permissions are inherited automatically from this role.</small>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 4px;">Account Password *</label>
                <input type="password" name="password" required placeholder="Minimum 6 characters" minlength="6" style="width: 100%; padding: 0.7rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem;">
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeStaffModal()" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">Cancel</button>
                <button type="submit" style="background: #05B396; color: #ffffff; border: none; padding: 0.65rem 1.4rem; border-radius: 8px; font-weight: 800; cursor: pointer; box-shadow: 0 4px 12px rgba(5, 179, 150, 0.35);">Create Staff Account</button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- MODAL 2: EDIT STAFF MEMBER                                                --}}
{{-- ========================================================================= --}}
<div id="editStaffModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center; padding: 1.5rem;">
    <div style="background: #ffffff; border-radius: 18px; width: 100%; max-width: 520px; box-shadow: 0 20px 50px rgba(0,0,0,0.3); overflow: hidden;">
        <div style="background: #0f172a; color: #ffffff; padding: 1.2rem 1.6rem; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 1.15rem; font-weight: 800; margin: 0;">✏️ Edit Staff Member</h3>
            <button type="button" onclick="closeEditStaffModal()" style="background: transparent; border: none; color: #94a3b8; font-size: 1.3rem; cursor: pointer;">&times;</button>
        </div>

        <form id="editStaffForm" method="POST" action="" style="padding: 1.6rem;">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 4px;">Staff Name *</label>
                <input type="text" name="name" id="editStaffName" required style="width: 100%; padding: 0.7rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 4px;">Email *</label>
                    <input type="email" name="email" id="editStaffEmail" required style="width: 100%; padding: 0.7rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 4px;">Phone</label>
                    <input type="text" name="phone" id="editStaffPhone" style="width: 100%; padding: 0.7rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem;">
                </div>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 4px;">Assigned Role *</label>
                <select name="role_id" id="editStaffRoleId" required style="width: 100%; padding: 0.7rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem; background: #ffffff;">
                    @foreach($roles as $r)
                        <option value="{{ $r->id }}">{{ $r->name }} ({{ $r->slug }})</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 4px;">New Password (Optional)</label>
                <input type="password" name="password" placeholder="Leave blank to keep existing" minlength="6" style="width: 100%; padding: 0.7rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem;">
            </div>

            <div style="margin-bottom: 1.5rem;" id="blockAccountWrapper">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.85rem; font-weight: 700; color: #991b1b;">
                    <input type="checkbox" name="is_blocked" id="editStaffIsBlocked" value="1" style="accent-color: #ef4444; width: 16px; height: 16px;">
                    <span>Block / Suspend this staff account</span>
                </label>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeEditStaffModal()" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">Cancel</button>
                <button type="submit" style="background: #0f172a; color: #ffffff; border: none; padding: 0.65rem 1.4rem; border-radius: 8px; font-weight: 800; cursor: pointer;">Update Staff</button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- MODAL 3: CREATE CUSTOM ROLE                                               --}}
{{-- ========================================================================= --}}
<div id="addRoleModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center; padding: 1.5rem;">
    <div style="background: #ffffff; border-radius: 18px; width: 100%; max-width: 580px; box-shadow: 0 20px 50px rgba(0,0,0,0.3); overflow: hidden;">
        <div style="background: #0f172a; color: #ffffff; padding: 1.2rem 1.6rem; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 1.15rem; font-weight: 800; margin: 0;">➕ Create New Custom Role</h3>
            <button type="button" onclick="closeRoleModal()" style="background: transparent; border: none; color: #94a3b8; font-size: 1.3rem; cursor: pointer;">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.roles.store') }}" style="padding: 1.6rem;">
            @csrf

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 4px;">Role Title *</label>
                <input type="text" name="name" required placeholder="e.g. Regional Support Head" style="width: 100%; padding: 0.7rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem;">
            </div>

            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 4px;">Role Description</label>
                <textarea name="description" rows="2" placeholder="Briefly describe what this role owns and manages..." style="width: 100%; padding: 0.6rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem;"></textarea>
            </div>

            <div style="font-weight: 800; font-size: 0.85rem; color: #0f172a; margin-bottom: 8px;">Select Allowed Modules:</div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 1.5rem; max-height: 220px; overflow-y: auto; padding: 4px;">
                @foreach($modules as $modKey => $modInfo)
                    <label style="display: flex; align-items: center; gap: 8px; border: 1px solid #e2e8f0; padding: 8px 10px; border-radius: 8px; cursor: pointer; background: #f8fafc;">
                        <input type="checkbox" name="permissions[{{ $modKey }}][]" value="view" checked style="accent-color: #05B396; width: 16px; height: 16px;">
                        <span style="font-size: 0.82rem; font-weight: 700; color: #334155;">{{ $modInfo['icon'] }} {{ $modInfo['name'] }}</span>
                    </label>
                @endforeach
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeRoleModal()" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">Cancel</button>
                <button type="submit" style="background: #05B396; color: #ffffff; border: none; padding: 0.65rem 1.4rem; border-radius: 8px; font-weight: 800; cursor: pointer; box-shadow: 0 4px 12px rgba(5, 179, 150, 0.35);">Save &amp; Configure Permissions</button>
            </div>
        </form>
    </div>
</div>

<script>
function openStaffModal() {
    document.getElementById('addStaffModal').style.display = 'flex';
}
function closeStaffModal() {
    document.getElementById('addStaffModal').style.display = 'none';
}

function openRoleModal() {
    document.getElementById('addRoleModal').style.display = 'flex';
}
function closeRoleModal() {
    document.getElementById('addRoleModal').style.display = 'none';
}

function editStaffModal(data) {
    document.getElementById('editStaffForm').action = "/admin/roles/staff/" + data.id;
    document.getElementById('editStaffName').value = data.name;
    document.getElementById('editStaffEmail').value = data.email;
    document.getElementById('editStaffPhone').value = data.phone || '';
    document.getElementById('editStaffRoleId').value = data.role_id;
    document.getElementById('editStaffIsBlocked').checked = data.is_blocked;
    
    // Cannot block super admin
    const blockWrapper = document.getElementById('blockAccountWrapper');
    if (blockWrapper) {
        blockWrapper.style.display = data.is_super_admin ? 'none' : 'block';
    }

    document.getElementById('editStaffModal').style.display = 'flex';
}
function closeEditStaffModal() {
    document.getElementById('editStaffModal').style.display = 'none';
}

function toggleModuleRow(roleId, modKey) {
    const checkboxes = document.querySelectorAll('.perm-checkbox-' + roleId + '-' + modKey);
    const anyUnchecked = Array.from(checkboxes).some(cb => !cb.checked);
    checkboxes.forEach(cb => cb.checked = anyUnchecked);
}
</script>
@endsection

