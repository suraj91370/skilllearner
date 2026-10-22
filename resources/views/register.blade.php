@extends('layouts.app')

@section('title', 'Enroll in SkillLearner')

@section('content')
<section class="container" style="max-width: 760px; padding: 3rem 1.5rem;">
    <div class="glass" style="padding: 2.5rem; border-radius: var(--radius-lg); text-align: center;">
        
        <img src="{{ asset('images/logo.png') }}" alt="SkillLearner" style="height: 58px; width: auto; margin-bottom: 0.8rem; object-fit: contain;">
        
        <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.4rem;">Enroll in SkillLearner</h2>
        <p style="color: var(--text-body); font-size: 0.92rem; margin-bottom: 2rem;">Activate lifetime access to skill video masterclasses, community mentorship, and learning resources.</p>

        @if ($errors->any())
            <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #fca5a5; padding: 0.85rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem; text-align: left;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ url('/register-user') }}">
            @csrf
            
            <!-- Sponsor ID -->
            <div class="form-group" style="text-align: left; margin-bottom: 1.5rem;">
                <label style="font-size: 0.88rem; font-weight: 700; color: var(--text-body);">Sponsor / Referral ID (Auto-Locked)</label>
                <input type="text" name="sponsor_id" class="form-control" value="{{ request('ref', session('user.affiliate_id', 'SKL-ADMIN')) }}" readonly style="background: rgba(5, 179, 150, 0.1); border-color: rgba(5, 179, 150, 0.35); color: #05B396; font-weight: 800; letter-spacing: 0.5px;">
            </div>

            <!-- Visual Package Selector with 3D Images (No Amounts) -->
            <div class="form-group" style="text-align: left; margin-bottom: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                    <label style="font-size: 0.95rem; font-weight: 800; color: #fff; margin: 0;">Select Your Learning Package</label>
                    <span style="font-size: 0.8rem; color: #05B396; font-weight: 700;">● Click card to choose</span>
                </div>

                @php
                    $selectedPkg = request('package', 'Advance Package');
                @endphp

                <!-- Hidden Input that carries selected package value to backend -->
                <input type="hidden" name="package" id="selectedPackageInput" value="{{ $selectedPkg }}">

                <div class="package-visual-grid">
                    
                    <!-- 1. Basic Package -->
                    <div class="package-visual-card {{ $selectedPkg === 'Basic Package' ? 'selected' : '' }}" data-package="Basic Package" onclick="chooseVisualPackage(this, 'Basic Package')">
                        <div class="check-pill">✓</div>
                        <div class="img-wrapper">
                            <img src="{{ asset('images/packages/basic.jpg') }}" alt="Basic Package">
                        </div>
                        <div class="pkg-title">BASIC</div>
                    </div>

                    <!-- 2. Advance Package -->
                    <div class="package-visual-card {{ $selectedPkg === 'Advance Package' ? 'selected' : '' }}" data-package="Advance Package" onclick="chooseVisualPackage(this, 'Advance Package')">
                        <span class="card-ribbon">POPULAR</span>
                        <div class="check-pill">✓</div>
                        <div class="img-wrapper">
                            <img src="{{ asset('images/packages/advance.jpg') }}" alt="Advance Package">
                        </div>
                        <div class="pkg-title">ADVANCE</div>
                    </div>

                    <!-- 3. Premium Package -->
                    <div class="package-visual-card {{ $selectedPkg === 'Premium Package' ? 'selected' : '' }}" data-package="Premium Package" onclick="chooseVisualPackage(this, 'Premium Package')">
                        <div class="check-pill">✓</div>
                        <div class="img-wrapper">
                            <img src="{{ asset('images/packages/premium.jpg') }}" alt="Premium Package">
                        </div>
                        <div class="pkg-title">PREMIUM</div>
                    </div>

                    <!-- 4. Growth Package -->
                    <div class="package-visual-card {{ $selectedPkg === 'Growth Package' ? 'selected' : '' }}" data-package="Growth Package" onclick="chooseVisualPackage(this, 'Growth Package')">
                        <div class="check-pill">✓</div>
                        <div class="img-wrapper">
                            <img src="{{ asset('images/packages/growth.jpg') }}" alt="Growth Package">
                        </div>
                        <div class="pkg-title">GROWTH</div>
                    </div>

                    <!-- 5. Infinity Package -->
                    <div class="package-visual-card {{ $selectedPkg === 'Infinity Package' ? 'selected' : '' }}" data-package="Infinity Package" onclick="chooseVisualPackage(this, 'Infinity Package')">
                        <span class="card-ribbon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">VIP</span>
                        <div class="check-pill">✓</div>
                        <div class="img-wrapper">
                            <img src="{{ asset('images/packages/infinity.jpg') }}" alt="Infinity Package">
                        </div>
                        <div class="pkg-title">INFINITY</div>
                    </div>

                </div>
            </div>

            <!-- Student Form Inputs -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; text-align: left;">
                <div class="form-group">
                    <label>Your Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Suraj Kumar" required>
                </div>
                <div class="form-group">
                    <label>WhatsApp Number</label>
                    <input type="tel" name="phone" class="form-control" placeholder="9876543210" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; text-align: left;">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="suraj@example.com" required>
                </div>
                <div class="form-group">
                    <label>Create Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <!-- Submit Button (No amount) -->
            <button type="submit" id="enrollSubmitBtn" class="btn btn-primary" style="width: 100%; padding: 1rem; margin-top: 1.5rem; font-size: 1.05rem; background: linear-gradient(135deg, #05B396 0%, #048873 100%); box-shadow: 0 4px 18px rgba(5, 179, 150, 0.35);">
                Enroll in {{ $selectedPkg }}
            </button>
        </form>
    </div>
</section>

@push('styles')
<style>
    /* Visual Package Selector Grid */
    .package-visual-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0.9rem;
        margin-top: 0.5rem;
    }

    .package-visual-card {
        background: rgba(255, 255, 255, 0.03);
        border: 2px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 0.9rem 0.5rem 0.8rem;
        text-align: center;
        cursor: pointer;
        position: relative;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
    }

    .package-visual-card:hover {
        transform: translateY(-4px);
        border-color: rgba(5, 179, 150, 0.5);
        background: rgba(255, 255, 255, 0.06);
    }

    .package-visual-card.selected {
        border-color: #05B396;
        background: linear-gradient(180deg, rgba(5, 179, 150, 0.16) 0%, rgba(15, 23, 42, 0.85) 100%);
        box-shadow: 0 0 25px rgba(5, 179, 150, 0.3);
        transform: translateY(-4px);
    }

    .package-visual-card .img-wrapper {
        width: 100%;
        height: 135px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
    }

    .package-visual-card img {
        max-height: 130px;
        max-width: 100%;
        object-fit: contain;
        filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.45));
        transition: transform 0.25s ease;
    }

    .package-visual-card:hover img {
        transform: scale(1.05);
    }

    .package-visual-card .pkg-title {
        font-size: 0.85rem;
        font-weight: 800;
        letter-spacing: 0.6px;
        color: #fff;
    }

    .package-visual-card.selected .pkg-title {
        color: #05B396;
    }

    /* Checkmark Badge */
    .package-visual-card .check-pill {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        color: transparent;
        font-size: 0.72rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .package-visual-card.selected .check-pill {
        background: #05B396;
        color: #fff;
        box-shadow: 0 0 8px rgba(5, 179, 150, 0.6);
    }

    /* Ribbon */
    .package-visual-card .card-ribbon {
        position: absolute;
        top: -9px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, #05B396, #0284c7);
        color: #fff;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 10px;
        letter-spacing: 0.5px;
    }

    @media (max-width: 768px) {
        .package-visual-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        .package-visual-card:last-child {
            grid-column: span 2;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function chooseVisualPackage(element, packageName) {
        // Remove .selected class from all cards
        document.querySelectorAll('.package-visual-card').forEach(card => {
            card.classList.remove('selected');
        });

        // Add .selected to clicked card
        element.classList.add('selected');

        // Set hidden form input
        document.getElementById('selectedPackageInput').value = packageName;

        // Update button text
        const btn = document.getElementById('enrollSubmitBtn');
        if (btn) {
            btn.innerText = 'Enroll in ' + packageName;
        }
    }
</script>
@endpush
@endsection
