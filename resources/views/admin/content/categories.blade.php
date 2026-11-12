@extends('layouts.app')

@section('title', 'Course Categories & Sub-Categories — SkillLearner Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-content-categories'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-content-categories'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header Banner -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 class="welcome-heading" style="font-size: 1.6rem; margin-bottom: 0.25rem;">
                        📁 Course Categories &amp; Sub-Categories
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Structure courses into parent categories and targeted sub-categories for improved student discovery.
                    </p>
                </div>
                <div>
                    <button type="button" onclick="openAddCategoryModal()" style="background: #05B396; color: #ffffff; border: none; padding: 0.65rem 1.3rem; border-radius: 8px; font-weight: 800; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.35);">
                        <span>+ Add Category / Sub-Category</span>
                    </button>
                </div>
            </div>

            <!-- Content Management Tabs Navigation -->
            @include('admin.content.tabs', ['tab' => 'categories'])

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

            <!-- Categories Tree Card -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden;">
                <div style="padding: 1.2rem 1.6rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0;">
                        Registered Categories &amp; Sub-Branches ({{ $categories->count() }} Parent Domains)
                    </h3>
                </div>

                <div style="padding: 1.5rem;">
                    @forelse($categories as $cat)
                        <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.2rem; margin-bottom: 1.2rem;">
                            <!-- Parent Category Row -->
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: {{ $cat->subcategories->count() > 0 ? '1rem' : '0' }};">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span style="font-size: 1.5rem; background: #ffffff; width: 44px; height: 44px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; border: 1px solid #cbd5e1;">
                                        {{ $cat->icon ?: '📁' }}
                                    </span>
                                    <div>
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <h4 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0;">{{ $cat->name }}</h4>
                                            <span style="font-size: 0.72rem; color: #64748b; background: #e2e8f0; padding: 2px 7px; border-radius: 4px; font-family: monospace;">{{ $cat->slug }}</span>
                                            @if($cat->is_active)
                                                <span style="background: #f0fdf4; color: #166534; font-size: 0.7rem; font-weight: 700; padding: 1px 6px; border-radius: 4px;">Active</span>
                                            @else
                                                <span style="background: #fef2f2; color: #dc2626; font-size: 0.7rem; font-weight: 700; padding: 1px 6px; border-radius: 4px;">Hidden</span>
                                            @endif
                                        </div>
                                        <div style="font-size: 0.82rem; color: #64748b; margin-top: 2px;">
                                            {{ $cat->description ?: 'No description' }} &bull; 
                                            <strong style="color: #05B396;">{{ $cat->courses_count }} Courses</strong> assigned
                                        </div>
                                    </div>
                                </div>

                                <div style="display: flex; gap: 6px;">
                                    <button type="button" 
                                            onclick="openAddSubcategoryModal({{ $cat->id }}, '{{ addslashes($cat->name) }}')"
                                            style="background: #f0fdfa; border: 1px solid #a7f3d0; color: #05B396; font-size: 0.78rem; font-weight: 700; padding: 5px 10px; border-radius: 6px; cursor: pointer;">
                                        + Sub-Category
                                    </button>
                                    <button type="button" 
                                            onclick="openEditCategoryModal({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ $cat->parent_id }}', '{{ addslashes($cat->icon) }}', '{{ addslashes($cat->description ?? '') }}', {{ $cat->is_active ? 1 : 0 }}, {{ $cat->sort_order }})"
                                            style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; font-size: 0.78rem; font-weight: 700; padding: 5px 10px; border-radius: 6px; cursor: pointer;">
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.content.categories.delete', $cat->id) }}" onsubmit="return confirm('Delete parent category {{ $cat->name }} and all subcategories?');" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: #fff5f5; border: 1px solid #fecaca; color: #dc2626; font-size: 0.78rem; font-weight: 700; padding: 5px 10px; border-radius: 6px; cursor: pointer;">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Sub-Categories Children Pills / Table -->
                            @if($cat->subcategories->count() > 0)
                                <div style="padding-left: 3.5rem; display: flex; flex-direction: column; gap: 8px;">
                                    @foreach($cat->subcategories as $sub)
                                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.6rem 0.9rem; display: flex; justify-content: space-between; align-items: center;">
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <span style="font-size: 1.1rem;">{{ $sub->icon ?: '📌' }}</span>
                                                <span style="font-weight: 700; color: #1e293b; font-size: 0.9rem;">{{ $sub->name }}</span>
                                                <span style="font-size: 0.72rem; color: #64748b; font-family: monospace;">{{ $sub->slug }}</span>
                                                <span style="font-size: 0.74rem; color: #05B396; font-weight: 600;">({{ $sub->courses_count }} courses)</span>
                                            </div>
                                            <div style="display: flex; gap: 6px;">
                                                <button type="button" 
                                                        onclick="openEditCategoryModal({{ $sub->id }}, '{{ addslashes($sub->name) }}', '{{ $sub->parent_id }}', '{{ addslashes($sub->icon) }}', '{{ addslashes($sub->description ?? '') }}', {{ $sub->is_active ? 1 : 0 }}, {{ $sub->sort_order }})"
                                                        style="background: transparent; border: 1px solid #cbd5e1; color: #64748b; font-size: 0.72rem; font-weight: 700; padding: 3px 8px; border-radius: 4px; cursor: pointer;">
                                                    Edit
                                                </button>
                                                <form method="POST" action="{{ route('admin.content.categories.delete', $sub->id) }}" onsubmit="return confirm('Delete subcategory {{ $sub->name }}?');" style="margin: 0;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="background: transparent; border: 1px solid #fecaca; color: #dc2626; font-size: 0.72rem; font-weight: 700; padding: 3px 8px; border-radius: 4px; cursor: pointer;">
                                                        ✕
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <div style="padding: 3rem 1.5rem; text-align: center; color: #64748b;">
                            <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📁</div>
                            <h4 style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.3rem;">No Categories Defined</h4>
                            <p style="font-size: 0.88rem; margin: 0;">Click the "+ Add Category" button above to get started.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </main>
    </div>
</div>

{{-- MODAL: ADD CATEGORY / SUB-CATEGORY --}}
<div id="addCategoryModal" style="display: none; position: fixed; inset: 0; z-index: 99999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #ffffff; border-radius: 16px; max-width: 480px; width: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden;">
        <div style="background: #0f172a; padding: 1.2rem 1.5rem; color: #fff; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-size: 1.05rem; font-weight: 800;">+ Create Course Category</div>
            <button type="button" onclick="closeAddCategoryModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; border-radius: 50%; width: 28px; height: 28px; cursor: pointer;">✕</button>
        </div>

        <form method="POST" action="{{ route('admin.content.categories.store') }}" style="padding: 1.5rem;">
            @csrf
            
            <div style="margin-bottom: 1.1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                    Parent Domain / Category
                </label>
                <select name="parent_id" id="addCategoryParentSelect" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none; background: #fff;">
                    <option value="">(None - Create as Top-Level Category)</option>
                    @foreach($allParents as $p)
                        <option value="{{ $p->id }}">{{ $p->icon }} {{ $p->name }}</option>
                    @endforeach
                </select>
                <small style="color: #64748b; font-size: 0.74rem;">Leave as None to create a main parent category, or choose a parent to make this a Sub-Category.</small>
            </div>

            <div style="display: grid; grid-template-columns: 80px 1fr; gap: 10px; margin-bottom: 1.1rem;">
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Icon</label>
                    <input type="text" name="icon" placeholder="📈" style="width: 100%; padding: 0.65rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 1.2rem; text-align: center; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Category Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Performance Marketing" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none;">
                </div>
            </div>

            <div style="margin-bottom: 1.1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Description</label>
                <textarea name="description" rows="2" placeholder="Brief overview of courses in this category..." style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; outline: none;"></textarea>
            </div>

            <div style="margin-bottom: 1.4rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Display Order</label>
                <input type="number" name="sort_order" value="0" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none;">
            </div>

            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                <button type="button" onclick="closeAddCategoryModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">Cancel</button>
                <button type="submit" style="background: #05B396; color: #fff; border: none; padding: 0.65rem 1.4rem; border-radius: 8px; font-weight: 800; cursor: pointer;">Save Category</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: EDIT CATEGORY --}}
<div id="editCategoryModal" style="display: none; position: fixed; inset: 0; z-index: 99999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #ffffff; border-radius: 16px; max-width: 480px; width: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden;">
        <div style="background: #0f172a; padding: 1.2rem 1.5rem; color: #fff; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-size: 1.05rem; font-weight: 800;">Edit Course Category</div>
            <button type="button" onclick="closeEditCategoryModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; border-radius: 50%; width: 28px; height: 28px; cursor: pointer;">✕</button>
        </div>

        <form id="editCategoryForm" method="POST" action="" style="padding: 1.5rem;">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1.1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                    Parent Domain / Category
                </label>
                <select name="parent_id" id="editCategoryParentSelect" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none; background: #fff;">
                    <option value="">(None - Top-Level Category)</option>
                    @foreach($allParents as $p)
                        <option value="{{ $p->id }}">{{ $p->icon }} {{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 80px 1fr; gap: 10px; margin-bottom: 1.1rem;">
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Icon</label>
                    <input type="text" name="icon" id="editCategoryIconInput" style="width: 100%; padding: 0.65rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 1.2rem; text-align: center; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Category Name *</label>
                    <input type="text" name="name" id="editCategoryNameInput" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none;">
                </div>
            </div>

            <div style="margin-bottom: 1.1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Description</label>
                <textarea name="description" id="editCategoryDescInput" rows="2" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; outline: none;"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 1.4rem;">
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Display Order</label>
                    <input type="number" name="sort_order" id="editCategoryOrderInput" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none;">
                </div>
                <div style="display: flex; align-items: center; padding-top: 1.2rem;">
                    <label style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 700; color: #334155; cursor: pointer;">
                        <input type="checkbox" name="is_active" id="editCategoryActiveCheckbox" value="1" style="width: 18px; height: 18px; accent-color: #05B396;">
                        <span>Active / Visible</span>
                    </label>
                </div>
            </div>

            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                <button type="button" onclick="closeEditCategoryModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer;">Cancel</button>
                <button type="submit" style="background: #05B396; color: #fff; border: none; padding: 0.65rem 1.4rem; border-radius: 8px; font-weight: 800; cursor: pointer;">Update Category</button>
            </div>
        </form>
    </div>
</div>

@include('portal.styles')

@push('scripts')
<script>
    function openAddCategoryModal() {
        document.getElementById('addCategoryParentSelect').value = '';
        document.getElementById('addCategoryModal').style.display = 'flex';
    }

    function openAddSubcategoryModal(parentId, parentName) {
        document.getElementById('addCategoryParentSelect').value = parentId;
        document.getElementById('addCategoryModal').style.display = 'flex';
    }

    function closeAddCategoryModal() {
        document.getElementById('addCategoryModal').style.display = 'none';
    }

    function openEditCategoryModal(id, name, parentId, icon, desc, isActive, order) {
        document.getElementById('editCategoryForm').action = '/admin/content/categories/' + id;
        document.getElementById('editCategoryNameInput').value = name;
        document.getElementById('editCategoryParentSelect').value = parentId || '';
        document.getElementById('editCategoryIconInput').value = icon || '';
        document.getElementById('editCategoryDescInput').value = desc || '';
        document.getElementById('editCategoryActiveCheckbox').checked = (isActive == 1);
        document.getElementById('editCategoryOrderInput').value = order || 0;
        document.getElementById('editCategoryModal').style.display = 'flex';
    }

    function closeEditCategoryModal() {
        document.getElementById('editCategoryModal').style.display = 'none';
    }
</script>
@endpush
@endsection

