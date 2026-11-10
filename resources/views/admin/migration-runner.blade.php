@extends('layouts.app')

@section('title', 'Database Migration Runner — Super Admin')

@section('content')
<div class="student-portal-wrapper">
    @include('portal.mobile-nav', ['active' => 'admin-settings'])

    <div class="portal-main-grid">
        @include('portal.sidebar', ['active' => 'admin-settings'])

        <main class="portal-content-area">
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem;">
                <h2 class="welcome-heading" style="font-size: 1.65rem; margin-bottom: 0.35rem; display: flex; align-items: center; gap: 10px;">
                    <span>⚡ Database Migration Runner</span>
                </h2>
                <p style="font-size: 0.92rem; color: #64748b; margin: 0;">
                    Execute pending database migrations safely from the web browser without requiring SSH or terminal access.
                </p>
            </div>

            <div style="background: #ffffff; border-radius: 14px; padding: 1.8rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 14px rgba(0,0,0,0.03); margin-bottom: 1.8rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.2rem; flex-wrap: wrap; gap: 10px;">
                    <div style="font-weight: 800; font-size: 1.1rem; color: #0f172a;">
                        Migration Execution Result
                    </div>
                    <a href="{{ route('admin.run-migrations') }}" class="btn" style="background: #05B396; color: #fff; font-weight: 700; font-size: 0.85rem; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none;">
                        🔄 Re-run Migrations
                    </a>
                </div>

                @if($success)
                    <div style="background: #f0fdf4; border-left: 4px solid #10b981; color: #166534; padding: 1rem 1.2rem; border-radius: 8px; font-weight: 700; margin-bottom: 1.2rem;">
                        ✓ Migrations executed successfully! All database tables (mentors, offers, coupons, redemptions) are now ready.
                    </div>
                @else
                    <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 1rem 1.2rem; border-radius: 8px; font-weight: 700; margin-bottom: 1.2rem;">
                        ⚠️ Migration error encountered. Output details below.
                    </div>
                @endif

                <div style="background: #0f172a; color: #38bdf8; padding: 1.2rem; border-radius: 10px; font-family: monospace; font-size: 0.88rem; white-space: pre-wrap; overflow-x: auto; max-height: 400px;">
{{ $output ?: 'No pending migrations to run. Everything is up to date!' }}
                </div>

                <div style="margin-top: 1.5rem; display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="{{ route('admin.offers') }}" class="btn" style="background: #1e293b; color: #fff; font-size: 0.88rem; font-weight: 700; padding: 0.6rem 1.2rem; border-radius: 8px; text-decoration: none;">
                        🏷️ Open Offers &amp; Pricing Management
                    </a>
                    <a href="{{ url('/admin/dashboard') }}" class="btn" style="background: #f1f5f9; color: #334155; font-size: 0.88rem; font-weight: 700; padding: 0.6rem 1.2rem; border-radius: 8px; text-decoration: none;">
                        🏢 Back to Admin Dashboard
                    </a>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

