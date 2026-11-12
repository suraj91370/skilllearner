@extends('layouts.app')

@section('title', 'Student Testimonials — SkillLearner Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-content-testimonials'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-content-testimonials'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header Banner -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 class="welcome-heading" style="font-size: 1.6rem; margin-bottom: 0.25rem;">
                        ⭐ Student Testimonials &amp; Reviews
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Manage student feedback, star ratings, and earnings achievements showcased on public pages.
                    </p>
                </div>
                <div>
                    <button type="button" onclick="openAddTestimonialModal()" style="background: #05B396; color: #ffffff; border: none; padding: 0.65rem 1.3rem; border-radius: 8px; font-weight: 800; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.35);">
                        <span>+ Add New Testimonial</span>
                    </button>
                </div>
            </div>

            <!-- Content Management Tabs Navigation -->
            @include('admin.content.tabs', ['tab' => 'testimonials'])

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

            <!-- Testimonials Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.4rem;">
                @forelse($testimonials as $t)
                    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <!-- Header with Avatar & Details -->
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <img src="{{ $t->avatar ?: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80' }}" alt="{{ $t->name }}" style="width: 46px; height: 46px; border-radius: 50%; object-fit: cover; border: 2px solid #05B396;">
                                    <div>
                                        <h4 style="font-size: 1rem; font-weight: 800; color: #0f172a; margin: 0;">{{ $t->name }}</h4>
                                        <div style="font-size: 0.78rem; color: #64748b;">{{ $t->role_title ?: 'Student' }}</div>
                                    </div>
                                </div>
                                <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 4px;">
                                    <div style="color: #f59e0b; font-size: 0.85rem;">
                                        @for($i = 0; $i < $t->rating; $i++) ★ @endfor
                                    </div>
                                    @if($t->is_featured)
                                        <span style="background: rgba(245, 158, 11, 0.15); color: #b45309; font-size: 0.68rem; font-weight: 800; padding: 2px 6px; border-radius: 4px; text-transform: uppercase;">Featured</span>
                                    @endif
                                </div>
                            </div>

                            @if($t->earning_highlight)
                                <div style="margin-bottom: 0.8rem;">
                                    <span style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #059669; font-size: 0.76rem; font-weight: 800; padding: 3px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                                        💰 {{ $t->earning_highlight }}
                                    </span>
                                </div>
                            @endif

                            <p style="font-size: 0.88rem; color: #334155; line-height: 1.6; margin: 0 0 1.2rem; font-style: italic;">
                                "{{ $t->content }}"
                            </p>
                        </div>

                        <!-- Footer Actions -->
                        <div style="border-top: 1px solid #f1f5f9; padding-top: 0.8rem; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 0.72rem; color: {{ $t->is_active ? '#059669' : '#dc2626' }}; font-weight: 700;">
                                {{ $t->is_active ? '● Active on Homepage' : '○ Hidden' }}
                            </span>

                            <div style="display: flex; gap: 6px;">
                                <button type="button" 
                                        onclick="openEditTestimonialModal({{ $t->id }}, '{{ addslashes($t->name) }}', '{{ addslashes($t->role_title ?? '') }}', '{{ addslashes($t->avatar ?? '') }}', {{ $t->rating }}, '{{ addslashes($t->content) }}', '{{ addslashes($t->earning_highlight ?? '') }}', {{ $t->is_featured ? 1 : 0 }}, {{ $t->is_active ? 1 : 0 }}, {{ $t->sort_order }})"
                                        style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; font-size: 0.74rem; font-weight: 700; padding: 4px 8px; border-radius: 6px; cursor: pointer;">
                                    Edit
                                </button>
                                <form method="POST" action="{{ route('admin.content.testimonials.delete', $t->id) }}" onsubmit="return confirm('Delete testimonial of {{ $t->name }}?');" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #fff5f5; border: 1px solid #fecaca; color: #dc2626; font-size: 0.74rem; font-weight: 700; padding: 4px 8px; border-radius: 6px; cursor: pointer;">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 3rem 1.5rem; text-align: center; color: #64748b;">
                        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">⭐</div>
                        <h4 style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.3rem;">No Testimonials Added</h4>
                        <p style="font-size: 0.88rem; margin: 0;">Click the "+ Add New Testimonial" button above to add student reviews.</p>
                    </div>
                @endforelse
            </div>

        </main>
    </div>
</div>

{{-- MODAL: ADD TESTIMONIAL --}}
<div id="addTestimonialModal" style="display: none; position: fixed; inset: 0; z-index: 99999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #ffffff; border-radius: 16px; max-width: 500px; width: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden;">
        <div style="background: #0f172a; padding: 1.2rem 1.5rem; color: #fff; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-size: 1.05rem; font-weight: 800;">+ Add Student Testimonial</div>
            <button type="button" onclick="closeAddTestimonialModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; border-radius: 50%; width: 28px; height: 28px; cursor: pointer;">✕</button>
        </div>

        <form method="POST" action="{{ route('admin.content.testimonials.store') }}" style="padding: 1.5rem;">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Student Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Rahul Sharma" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Role / Package</label>
                    <input type="text" name="role_title" placeholder="e.g. Growth Package Student" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 100px; gap: 10px; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Avatar Photo URL</label>
                    <input type="text" name="avatar" placeholder="https://..." style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Rating</label>
                    <select name="rating" style="width: 100%; padding: 0.65rem 0.6rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; background: #fff;">
                        <option value="5">★★★★★ (5)</option>
                        <option value="4">★★★★☆ (4)</option>
                        <option value="3">★★★☆☆ (3)</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Earnings Badge / Highlight</label>
                <input type="text" name="earning_highlight" placeholder="e.g. Earned ₹45,000 in 30 Days" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none;">
            </div>

            <div style="margin-bottom: 1.1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Review / Testimonial Text *</label>
                <textarea name="content" rows="3" required placeholder="What did the student say about SkillLearner?" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none;"></textarea>
            </div>

            <div style="display: flex; gap: 15px; margin-bottom: 1.4rem;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 700; color: #334155; cursor: pointer;">
                    <input type="checkbox" name="is_featured" value="1" checked style="width: 18px; height: 18px; accent-color: #05B396;">
                    <span>Feature on Homepage</span>
                </label>
            </div>

            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                <button type="button" onclick="closeAddTestimonialModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">Cancel</button>
                <button type="submit" style="background: #05B396; color: #fff; border: none; padding: 0.65rem 1.4rem; border-radius: 8px; font-weight: 800; cursor: pointer;">Save Testimonial</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: EDIT TESTIMONIAL --}}
<div id="editTestimonialModal" style="display: none; position: fixed; inset: 0; z-index: 99999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #ffffff; border-radius: 16px; max-width: 500px; width: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden;">
        <div style="background: #0f172a; padding: 1.2rem 1.5rem; color: #fff; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-size: 1.05rem; font-weight: 800;">Edit Student Testimonial</div>
            <button type="button" onclick="closeEditTestimonialModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; border-radius: 50%; width: 28px; height: 28px; cursor: pointer;">✕</button>
        </div>

        <form id="editTestimonialForm" method="POST" action="" style="padding: 1.5rem;">
            @csrf
            @method('PUT')
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Student Name *</label>
                    <input type="text" name="name" id="editTestimonialName" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Role / Package</label>
                    <input type="text" name="role_title" id="editTestimonialRole" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 100px; gap: 10px; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Avatar Photo URL</label>
                    <input type="text" name="avatar" id="editTestimonialAvatar" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Rating</label>
                    <select name="rating" id="editTestimonialRating" style="width: 100%; padding: 0.65rem 0.6rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; background: #fff;">
                        <option value="5">★★★★★ (5)</option>
                        <option value="4">★★★★☆ (4)</option>
                        <option value="3">★★★☆☆ (3)</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Earnings Badge / Highlight</label>
                <input type="text" name="earning_highlight" id="editTestimonialHighlight" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none;">
            </div>

            <div style="margin-bottom: 1.1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Review / Testimonial Text *</label>
                <textarea name="content" id="editTestimonialContent" rows="3" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none;"></textarea>
            </div>

            <div style="display: flex; gap: 15px; margin-bottom: 1.4rem;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 700; color: #334155; cursor: pointer;">
                    <input type="checkbox" name="is_featured" id="editTestimonialFeatured" value="1" style="width: 18px; height: 18px; accent-color: #05B396;">
                    <span>Feature on Homepage</span>
                </label>
                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 700; color: #334155; cursor: pointer;">
                    <input type="checkbox" name="is_active" id="editTestimonialActive" value="1" style="width: 18px; height: 18px; accent-color: #05B396;">
                    <span>Active / Visible</span>
                </label>
            </div>

            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                <button type="button" onclick="closeEditTestimonialModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">Cancel</button>
                <button type="submit" style="background: #05B396; color: #fff; border: none; padding: 0.65rem 1.4rem; border-radius: 8px; font-weight: 800; cursor: pointer;">Update Testimonial</button>
            </div>
        </form>
    </div>
</div>

@include('portal.styles')

@push('scripts')
<script>
    function openAddTestimonialModal() {
        document.getElementById('addTestimonialModal').style.display = 'flex';
    }

    function closeAddTestimonialModal() {
        document.getElementById('addTestimonialModal').style.display = 'none';
    }

    function openEditTestimonialModal(id, name, role, avatar, rating, content, highlight, isFeatured, isActive, order) {
        document.getElementById('editTestimonialForm').action = '/admin/content/testimonials/' + id;
        document.getElementById('editTestimonialName').value = name;
        document.getElementById('editTestimonialRole').value = role;
        document.getElementById('editTestimonialAvatar').value = avatar;
        document.getElementById('editTestimonialRating').value = rating;
        document.getElementById('editTestimonialContent').value = content;
        document.getElementById('editTestimonialHighlight').value = highlight;
        document.getElementById('editTestimonialFeatured').checked = (isFeatured == 1);
        document.getElementById('editTestimonialActive').checked = (isActive == 1);
        document.getElementById('editTestimonialModal').style.display = 'flex';
    }

    function closeEditTestimonialModal() {
        document.getElementById('editTestimonialModal').style.display = 'none';
    }
</script>
@endpush
@endsection

