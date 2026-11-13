@extends('layouts.app')

@section('title', 'Activity Log & Audit Trail — SkillLearner Super Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Nav -->
    @include('portal.mobile-nav', ['active' => 'admin-activity-logs'])

    <div class="portal-main-grid">
        <!-- Sidebar -->
        @include('portal.sidebar', ['active' => 'admin-activity-logs'])

        <!-- Main Content Area -->
        <main class="portal-content-area">
            
            <!-- Header Row -->
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.8rem; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(15, 23, 42, 0.08); border: 1px solid rgba(15, 23, 42, 0.2); color: #0f172a; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 800; text-transform: uppercase; margin-bottom: 0.5rem;">
                        <span>📋 AUDIT TRAIL &amp; COMPLIANCE</span>
                    </div>
                    <h2 class="welcome-heading" style="font-size: 1.8rem; margin: 0 0 0.3rem 0; color: #0f172a; font-weight: 900;">
                        System Activity Log
                    </h2>
                    <p style="font-size: 0.92rem; color: #64748b; margin: 0;">
                        Complete tamper-evident audit trail tracking every staff action, price change, permission update, refund, and user modification with IP snapshot.
                    </p>
                </div>

                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('admin.roles') }}" style="background: #ffffff; border: 1.5px solid #cbd5e1; color: #334155; padding: 0.65rem 1.2rem; border-radius: 10px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                        <span>🛡️ Manage Roles &amp; Staff</span>
                    </a>
                </div>
            </div>

            <!-- Filters Bar Card -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.4rem; margin-bottom: 1.8rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <form method="GET" action="{{ route('admin.activity-logs') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)) 100px; gap: 12px; align-items: flex-end;">
                    
                    <!-- Search input -->
                    <div>
                        <label style="display: block; font-size: 0.78rem; font-weight: 700; color: #475569; margin-bottom: 4px;">Search Keyword</label>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Action, staff name, IP..." style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem;">
                    </div>

                    <!-- Staff User Filter -->
                    <div>
                        <label style="display: block; font-size: 0.78rem; font-weight: 700; color: #475569; margin-bottom: 4px;">Staff Member</label>
                        <select name="user_id" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; background: #ffffff;">
                            <option value="">All Staff Members</option>
                            @foreach($allStaff as $s)
                                <option value="{{ $s->id }}" {{ (string)$currentUserId === (string)$s->id ? 'selected' : '' }}>
                                    {{ $s->name }} ({{ $s->roleModel?->name ?? $s->role }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Module Filter -->
                    <div>
                        <label style="display: block; font-size: 0.78rem; font-weight: 700; color: #475569; margin-bottom: 4px;">Target Module</label>
                        <select name="module" style="width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; background: #ffffff;">
                            <option value="">All Modules</option>
                            @foreach($modules as $mKey => $mInfo)
                                <option value="{{ $mKey }}" {{ $currentModule === $mKey ? 'selected' : '' }}>
                                    {{ $mInfo['icon'] }} {{ $mInfo['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter & Reset Buttons -->
                    <div style="display: flex; gap: 8px;">
                        <button type="submit" style="flex: 1; background: #0f172a; color: #ffffff; border: none; padding: 0.65rem; border-radius: 8px; font-weight: 800; font-size: 0.88rem; cursor: pointer;">
                            Filter
                        </button>
                        <a href="{{ route('admin.activity-logs') }}" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #475569; padding: 0.65rem 0.8rem; border-radius: 8px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Audit Trail Log Table -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                <div style="padding: 1.2rem 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <div style="font-weight: 800; color: #0f172a; font-size: 1.05rem;">
                        Recorded Events &bull; {{ $logs->total() }} Log Entries
                    </div>
                    <span style="font-size: 0.82rem; color: #64748b;">
                        Page {{ $logs->currentPage() }} of {{ $logs->lastPage() }}
                    </span>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-weight: 800; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.6px;">
                                <th style="padding: 1rem 1.2rem; width: 180px;">Timestamp</th>
                                <th style="padding: 1rem 1.2rem; width: 220px;">Staff Member</th>
                                <th style="padding: 1rem 1rem; width: 140px;">Action / Module</th>
                                <th style="padding: 1rem 1.5rem;">Event Description</th>
                                <th style="padding: 1rem 1.2rem; width: 130px; text-align: right;">IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;">
                                    
                                    <!-- Timestamp -->
                                    <td style="padding: 1.1rem 1.2rem;">
                                        <div style="font-weight: 800; color: #0f172a; font-size: 0.88rem;">
                                            {{ $log->created_at ? $log->created_at->format('d M Y, h:i A') : '—' }}
                                        </div>
                                        <div style="font-size: 0.75rem; color: #05B396; font-weight: 700; margin-top: 2px;">
                                            {{ $log->created_at ? $log->created_at->diffForHumans() : '' }}
                                        </div>
                                    </td>

                                    <!-- Staff Member -->
                                    <td style="padding: 1.1rem 1.2rem;">
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #0f172a; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.92rem; flex-shrink: 0;">
                                                {{ strtoupper(substr($log->user_name ?: 'S', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div style="font-weight: 800; color: #0f172a;">
                                                    {{ $log->user_name ?: 'System Automator' }}
                                                </div>
                                                <div style="font-size: 0.74rem; color: #64748b; font-weight: 600;">
                                                    Role: {{ ucfirst(str_replace('_', ' ', $log->user_role ?: 'system')) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Action & Module Badges -->
                                    <td style="padding: 1.1rem 1rem;">
                                        @php
                                            $actionColors = match(true) {
                                                str_contains($log->action, 'PRICE') => ['bg' => '#fef3c7', 'text' => '#b45309'],
                                                str_contains($log->action, 'REFUND') => ['bg' => '#dcfce7', 'text' => '#15803d'],
                                                str_contains($log->action, 'BLOCKED') || str_contains($log->action, 'DELETE') => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                                                str_contains($log->action, 'STAFF') || str_contains($log->action, 'ROLE') => ['bg' => '#e0f2fe', 'text' => '#0369a1'],
                                                default => ['bg' => '#f1f5f9', 'text' => '#334155'],
                                            };
                                        @endphp
                                        <div style="background: {{ $actionColors['bg'] }}; color: {{ $actionColors['text'] }}; font-size: 0.74rem; font-weight: 900; padding: 3px 8px; border-radius: 6px; display: inline-block; margin-bottom: 4px; letter-spacing: 0.3px;">
                                            {{ $log->action }}
                                        </div>
                                        <div style="font-size: 0.76rem; color: #64748b; font-weight: 700;">
                                            📦 {{ ucfirst($log->module) }}
                                        </div>
                                    </td>

                                    <!-- Description & Changes -->
                                    <td style="padding: 1.1rem 1.5rem;">
                                        <div style="color: #1e293b; font-weight: 600; line-height: 1.5;">
                                            {{ $log->description }}
                                        </div>
                                        @if(!empty($log->properties))
                                            <div style="margin-top: 6px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 6px 10px; font-family: monospace; font-size: 0.78rem; color: #475569; display: inline-block; max-width: 100%;">
                                                @foreach($log->properties as $propK => $propV)
                                                    <span style="font-weight: 700; color: #0f172a;">{{ $propK }}:</span> {{ is_array($propV) ? json_encode($propV) : $propV }} &bull;
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>

                                    <!-- IP Address -->
                                    <td style="padding: 1.1rem 1.2rem; text-align: right;">
                                        <span style="font-family: monospace; font-size: 0.8rem; color: #475569; background: #f1f5f9; padding: 3px 8px; border-radius: 4px;">
                                            {{ $log->ip_address ?: '127.0.0.1' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="padding: 3rem; text-align: center; color: #64748b;">
                                        Koi activity logs nahi mile matching your filter.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($logs->hasPages())
                    <div style="padding: 1.2rem 1.5rem; border-top: 1px solid #f1f5f9;">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>

        </main>
    </div>
</div>
@endsection

