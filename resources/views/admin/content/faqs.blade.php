@extends('layouts.app')

@section('title', 'Frequently Asked Questions (FAQ) — SkillLearner Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-content-faqs'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-content-faqs'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header Banner -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 class="welcome-heading" style="font-size: 1.6rem; margin-bottom: 0.25rem;">
                        ❓ Frequently Asked Questions (FAQ)
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Manage public questions and answers for platform overview, packages, commissions, and withdrawals.
                    </p>
                </div>
                <div>
                    <button type="button" onclick="openAddFaqModal()" style="background: #05B396; color: #ffffff; border: none; padding: 0.65rem 1.3rem; border-radius: 8px; font-weight: 800; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.35);">
                        <span>+ Add New FAQ</span>
                    </button>
                </div>
            </div>

            <!-- Content Management Tabs Navigation -->
            @include('admin.content.tabs', ['tab' => 'faqs'])

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

            <!-- Category Filter Pills -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1rem 1.2rem; margin-bottom: 1.5rem; display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ route('admin.content.faqs', ['category' => 'all']) }}" 
                   style="padding: 0.45rem 1rem; border-radius: 20px; font-size: 0.82rem; font-weight: 700; text-decoration: none; {{ $currentCategory === 'all' ? 'background: #05B396; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                    All FAQs ({{ $faqs->count() }})
                </a>
                <a href="{{ route('admin.content.faqs', ['category' => 'general']) }}" 
                   style="padding: 0.45rem 1rem; border-radius: 20px; font-size: 0.82rem; font-weight: 700; text-decoration: none; {{ $currentCategory === 'general' ? 'background: #05B396; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                    🌐 General
                </a>
                <a href="{{ route('admin.content.faqs', ['category' => 'courses']) }}" 
                   style="padding: 0.45rem 1rem; border-radius: 20px; font-size: 0.82rem; font-weight: 700; text-decoration: none; {{ $currentCategory === 'courses' ? 'background: #05B396; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                    🎓 Courses &amp; Certs
                </a>
                <a href="{{ route('admin.content.faqs', ['category' => 'affiliate']) }}" 
                   style="padding: 0.45rem 1rem; border-radius: 20px; font-size: 0.82rem; font-weight: 700; text-decoration: none; {{ $currentCategory === 'affiliate' ? 'background: #05B396; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                    💼 2-Tier Affiliate
                </a>
                <a href="{{ route('admin.content.faqs', ['category' => 'payment']) }}" 
                   style="padding: 0.45rem 1rem; border-radius: 20px; font-size: 0.82rem; font-weight: 700; text-decoration: none; {{ $currentCategory === 'payment' ? 'background: #05B396; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                    💳 Payments &amp; Payouts
                </a>
            </div>

            <!-- FAQ List -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden;">
                <div style="padding: 1.2rem 1.6rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0;">
                        FAQ Accordion Items ({{ $faqs->count() }})
                    </h3>
                </div>

                <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                    @forelse($faqs as $faq)
                        <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.2rem; transition: border-color 0.2s;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; margin-bottom: 0.6rem;">
                                <div>
                                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                        <span style="background: #e0f2fe; color: #0369a1; font-size: 0.7rem; font-weight: 800; padding: 2px 7px; border-radius: 4px; text-transform: uppercase;">
                                            {{ strtoupper($faq->category) }}
                                        </span>
                                        @if($faq->is_active)
                                            <span style="background: #f0fdf4; color: #166534; font-size: 0.7rem; font-weight: 700; padding: 2px 6px; border-radius: 4px;">Active</span>
                                        @else
                                            <span style="background: #fef2f2; color: #dc2626; font-size: 0.7rem; font-weight: 700; padding: 2px 6px; border-radius: 4px;">Hidden</span>
                                        @endif
                                        <span style="font-size: 0.72rem; color: #94a3b8;">Order: {{ $faq->sort_order }}</span>
                                    </div>
                                    <h4 style="font-size: 1.05rem; font-weight: 800; color: #0f172a; margin: 0;">
                                        {{ $faq->question }}
                                    </h4>
                                </div>

                                <div style="display: flex; gap: 6px; flex-shrink: 0;">
                                    <button type="button" 
                                            onclick="openEditFaqModal({{ $faq->id }}, '{{ $faq->category }}', '{{ addslashes($faq->question) }}', '{{ addslashes($faq->answer) }}', {{ $faq->sort_order }}, {{ $faq->is_active ? 1 : 0 }})"
                                            style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; font-size: 0.78rem; font-weight: 700; padding: 5px 10px; border-radius: 6px; cursor: pointer;">
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.content.faqs.delete', $faq->id) }}" onsubmit="return confirm('Delete this FAQ question?');" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: #fff5f5; border: 1px solid #fecaca; color: #dc2626; font-size: 0.78rem; font-weight: 700; padding: 5px 10px; border-radius: 6px; cursor: pointer;">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <p style="font-size: 0.9rem; color: #475569; line-height: 1.6; margin: 0; padding-top: 0.6rem; border-top: 1px solid #f1f5f9;">
                                {{ $faq->answer }}
                            </p>
                        </div>
                    @empty
                        <div style="padding: 3rem 1.5rem; text-align: center; color: #64748b;">
                            <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">❓</div>
                            <h4 style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.3rem;">No FAQs Found</h4>
                            <p style="font-size: 0.88rem; margin: 0;">Click the "+ Add New FAQ" button above to add questions.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </main>
    </div>
</div>

{{-- MODAL: ADD FAQ --}}
<div id="addFaqModal" style="display: none; position: fixed; inset: 0; z-index: 99999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #ffffff; border-radius: 16px; max-width: 520px; width: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden;">
        <div style="background: #0f172a; padding: 1.2rem 1.5rem; color: #fff; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-size: 1.05rem; font-weight: 800;">+ Add New FAQ Question</div>
            <button type="button" onclick="closeAddFaqModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; border-radius: 50%; width: 28px; height: 28px; cursor: pointer;">✕</button>
        </div>

        <form method="POST" action="{{ route('admin.content.faqs.store') }}" style="padding: 1.5rem;">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 120px; gap: 10px; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Category *</label>
                    <select name="category" required style="width: 100%; padding: 0.65rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; background: #fff;">
                        <option value="general">🌐 General Platform</option>
                        <option value="courses">🎓 Courses &amp; Certs</option>
                        <option value="affiliate">💼 2-Tier Affiliate</option>
                        <option value="payment">💳 Payments &amp; Payouts</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Sort Order</label>
                    <input type="number" name="sort_order" value="0" style="width: 100%; padding: 0.65rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none;">
                </div>
            </div>

            <div style="margin-bottom: 1.1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Question Title *</label>
                <input type="text" name="question" required placeholder="e.g. How does the 2-Tier commission payout work?" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; font-weight: 600; outline: none;">
            </div>

            <div style="margin-bottom: 1.4rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Detailed Answer *</label>
                <textarea name="answer" rows="4" required placeholder="Provide clear, transparent explanations for students..." style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; line-height: 1.5; outline: none;"></textarea>
            </div>

            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                <button type="button" onclick="closeAddFaqModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">Cancel</button>
                <button type="submit" style="background: #05B396; color: #fff; border: none; padding: 0.65rem 1.4rem; border-radius: 8px; font-weight: 800; cursor: pointer;">Save Question</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: EDIT FAQ --}}
<div id="editFaqModal" style="display: none; position: fixed; inset: 0; z-index: 99999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #ffffff; border-radius: 16px; max-width: 520px; width: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden;">
        <div style="background: #0f172a; padding: 1.2rem 1.5rem; color: #fff; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-size: 1.05rem; font-weight: 800;">Edit FAQ Question</div>
            <button type="button" onclick="closeEditFaqModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; border-radius: 50%; width: 28px; height: 28px; cursor: pointer;">✕</button>
        </div>

        <form id="editFaqForm" method="POST" action="" style="padding: 1.5rem;">
            @csrf
            @method('PUT')
            
            <div style="display: grid; grid-template-columns: 1fr 120px; gap: 10px; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Category *</label>
                    <select name="category" id="editFaqCategory" required style="width: 100%; padding: 0.65rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; background: #fff;">
                        <option value="general">🌐 General Platform</option>
                        <option value="courses">🎓 Courses &amp; Certs</option>
                        <option value="affiliate">💼 2-Tier Affiliate</option>
                        <option value="payment">💳 Payments &amp; Payouts</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Sort Order</label>
                    <input type="number" name="sort_order" id="editFaqOrder" style="width: 100%; padding: 0.65rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none;">
                </div>
            </div>

            <div style="margin-bottom: 1.1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Question Title *</label>
                <input type="text" name="question" id="editFaqQuestion" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; font-weight: 600; outline: none;">
            </div>

            <div style="margin-bottom: 1.1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Detailed Answer *</label>
                <textarea name="answer" id="editFaqAnswer" rows="4" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; line-height: 1.5; outline: none;"></textarea>
            </div>

            <div style="margin-bottom: 1.4rem;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 700; color: #334155; cursor: pointer;">
                    <input type="checkbox" name="is_active" id="editFaqActive" value="1" style="width: 18px; height: 18px; accent-color: #05B396;">
                    <span>Active / Visible in Accordion</span>
                </label>
            </div>

            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                <button type="button" onclick="closeEditFaqModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">Cancel</button>
                <button type="submit" style="background: #05B396; color: #fff; border: none; padding: 0.65rem 1.4rem; border-radius: 8px; font-weight: 800; cursor: pointer;">Update Question</button>
            </div>
        </form>
    </div>
</div>

@include('portal.styles')

@push('scripts')
<script>
    function openAddFaqModal() {
        document.getElementById('addFaqModal').style.display = 'flex';
    }

    function closeAddFaqModal() {
        document.getElementById('addFaqModal').style.display = 'none';
    }

    function openEditFaqModal(id, category, question, answer, order, isActive) {
        document.getElementById('editFaqForm').action = '/admin/content/faqs/' + id;
        document.getElementById('editFaqCategory').value = category;
        document.getElementById('editFaqQuestion').value = question;
        document.getElementById('editFaqAnswer').value = answer;
        document.getElementById('editFaqOrder').value = order;
        document.getElementById('editFaqActive').checked = (isActive == 1);
        document.getElementById('editFaqModal').style.display = 'flex';
    }

    function closeEditFaqModal() {
        document.getElementById('editFaqModal').style.display = 'none';
    }
</script>
@endpush
@endsection

