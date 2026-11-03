@extends('layouts.app')

@section('title', 'Buy Now & Instant Enrollment — SkillLearner')

@section('content')
<!-- Checkout Hero Banner -->
<section style="background: linear-gradient(180deg, rgba(5, 179, 150, 0.14) 0%, rgba(7, 10, 18, 0) 100%); padding: 3rem 1.5rem 2rem; text-align: center;">
    <div class="container" style="max-width: 800px; padding: 0;">
        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(5, 179, 150, 0.12); border: 1px solid rgba(5, 179, 150, 0.35); color: #05B396; padding: 6px 18px; border-radius: 50px; font-size: 0.82rem; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1rem;">
            <span>⚡ Instant Enrollment & Access</span>
        </div>
        <h1 style="font-size: 2.8rem; font-weight: 800; margin-bottom: 0.6rem; letter-spacing: -0.5px;">
            Complete Your <span class="text-gradient">Purchase</span>
        </h1>
        <p style="color: var(--text-body); font-size: 1.05rem;">
            You are 1 minute away from lifetime video masterclasses, community mentorship, and direct learning access.
        </p>
    </div>
</section>

<!-- 2-Column Buy Now Checkout Section -->
<section class="container checkout-section" style="max-width: 1100px; padding-top: 1rem; padding-bottom: 5rem;">
    <div class="checkout-grid">
        
        <!-- Left Column: Order Summary & Item Description -->
        <div class="checkout-summary-col">
            
            @php
                $isSpecificPackage = request()->filled('package') && strtolower(request('package')) !== 'all';
                $sponsorRef = request('ref', session('user.sponsor_id', 'SKL-ADMIN'));
            @endphp

            @if($isSpecificPackage)
                <!-- Direct Single Package Banner (Opened via specific package link) -->
                <div style="background: rgba(5, 179, 150, 0.12); border: 1.5px solid #05B396; border-radius: 12px; padding: 0.9rem 1.2rem; margin-bottom: 1.2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 1.2rem;">🎯</span>
                        <span style="font-size: 0.92rem; font-weight: 800; color: #ffffff;">
                            Direct Package Link: <span style="color: #05B396;">{{ $selectedPackage['name'] }} (₹{{ number_format($selectedPackage['price']) }})</span>
                        </span>
                    </div>
                    <a href="{{ url('/plans') }}?ref={{ urlencode($sponsorRef) }}" style="font-size: 0.82rem; font-weight: 700; color: #38bdf8; text-decoration: underline;">
                        Want to see all 5 packages? ➔
                    </a>
                </div>
            @else
                <!-- Common All-Packages Selector (Opened via common link or no specific package) -->
                <div style="margin-bottom: 1.4rem; background: rgba(15, 23, 42, 0.85); border: 1.5px solid rgba(255, 255, 255, 0.12); border-radius: 14px; padding: 1.1rem 1.2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.85rem; flex-wrap: wrap; gap: 6px;">
                        <span style="font-size: 0.82rem; font-weight: 800; color: #38bdf8; text-transform: uppercase; letter-spacing: 0.8px; display: flex; align-items: center; gap: 6px;">
                            <span>🌟</span> ALL 5 PACKAGES OPEN — CHOOSE YOUR PACKAGE:
                        </span>
                        <span style="font-size: 0.78rem; color: #94a3b8;">
                            Click to select &amp; enroll
                        </span>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 8px;">
                        @foreach($packages as $p)
                            @php $isActivePkg = (strtolower($selectedPackage['id']) === strtolower($p['id'])); @endphp
                            <button type="button" 
                                    onclick="applySelectedPackage('{{ $p['id'] }}')" 
                                    id="btn-pkg-{{ $p['id'] }}" 
                                    class="pkg-select-btn {{ $isActivePkg ? 'active' : '' }}" 
                                    style="padding: 10px 8px; border-radius: 10px; font-size: 0.82rem; font-weight: 800; cursor: pointer; text-align: center; border: 1.5px solid {{ $isActivePkg ? '#05B396' : 'rgba(255,255,255,0.1)' }}; background: {{ $isActivePkg ? 'rgba(5, 179, 150, 0.22)' : 'rgba(255,255,255,0.04)' }}; color: #ffffff; transition: all 0.2s ease;">
                                <div style="font-size: 0.76rem; color: {{ $p['color'] ?? '#05B396' }};">{{ $p['name'] }}</div>
                                <div style="font-size: 0.96rem; font-weight: 900; margin-top: 3px;">₹{{ number_format($p['price']) }}</div>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Active Item Summary Card -->
            <div class="glass checkout-card" style="padding: 2.2rem; border-radius: var(--radius-lg); border: 2px solid #05B396; position: relative;">
                
                <span id="displayItemBadge" style="position: absolute; top: 16px; right: 20px; background: linear-gradient(135deg, #05B396, #0284c7); color: #fff; padding: 4px 14px; border-radius: 20px; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.5px;">
                    {{ $type === 'course' ? ($selectedCourse['badge'] ?? 'MASTERCLASS') : ($selectedPackage['badge'] ?? 'RECOMMENDED') }}
                </span>

                <div style="display: flex; align-items: center; gap: 18px; margin-bottom: 1.4rem;">
                    <!-- Visual Icon / Image -->
                    <div id="displayVisualWrapper" style="width: 78px; height: 78px; border-radius: 14px; background: rgba(5, 179, 150, 0.12); border: 1px solid rgba(5, 179, 150, 0.35); display: flex; align-items: center; justify-content: center; font-size: 2.6rem; flex-shrink: 0;">
                        @if($type === 'course')
                            <span>{{ $selectedCourse['icon'] }}</span>
                        @else
                            <img src="{{ asset($selectedPackage['image']) }}" alt="{{ $selectedPackage['name'] }}" style="width: 100%; height: 100%; object-fit: contain;">
                        @endif
                    </div>

                    <div>
                        <div id="displayItemCategory" style="font-size: 0.78rem; color: #05B396; font-weight: 800; text-transform: uppercase; letter-spacing: 0.8px;">
                            {{ $type === 'course' ? $selectedCourse['cat'] : 'SKILLLEARNER BUNDLE' }}
                        </div>
                        <h3 id="displayItemTitle" style="font-size: 1.55rem; font-weight: 800; color: #ffffff; margin: 2px 0;">
                            {{ $type === 'course' ? $selectedCourse['title'] : $selectedPackage['name'] }}
                        </h3>
                        <div id="displayItemMeta" style="font-size: 0.85rem; color: #94a3b8;">
                            {{ $type === 'course' ? ($selectedCourse['lessons'] . ' Lessons • ' . $selectedCourse['duration'] . ' Video Runtime') : (count($selectedPackage['courses_included']) . ' Full Courses Included') }}
                        </div>
                    </div>
                </div>

                <!-- Description Snippet -->
                {{-- <p id="displayItemDesc" style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem; background: rgba(255, 255, 255, 0.02); padding: 1rem; border-radius: 8px; border: 1px solid var(--border-glass);">
                    {{ $type === 'course' ? $selectedCourse['desc'] : $selectedPackage['desc'] }}
                </p> --}}

                <!-- What is Included In This Purchase -->
                <div style="margin-bottom: 1.8rem;">
                    <div style="font-size: 0.82rem; font-weight: 800; text-transform: uppercase; color: #94a3b8; letter-spacing: 0.6px; margin-bottom: 0.6rem;">
                        Included with this order:
                    </div>
                    <ul id="displayInclusionsList" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px;">
                        @if($type === 'course')
                            @foreach($selectedCourse['what_you_learn'] as $wyl)
                                <li style="font-size: 0.88rem; color: #cbd5e1; display: flex; align-items: center; gap: 8px;">
                                    <span style="color: #05B396; font-weight: bold;">✓</span> {{ $wyl }}
                                </li>
                            @endforeach
                        @else
                            @foreach($selectedPackage['courses_included'] as $ci)
                                <li style="font-size: 0.88rem; color: #cbd5e1; display: flex; align-items: center; gap: 8px;">
                                    <span style="color: #05B396; font-weight: bold;">✓</span> {{ $ci }}
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <!-- Price Breakdown Table -->
                <div style="background: rgba(15, 23, 42, 0.9); border: 1px solid var(--border-glass); border-radius: 12px; padding: 1.4rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.92rem; color: #94a3b8; margin-bottom: 0.5rem;">
                        <span>Original Course Fee</span>
                        <span id="displayOldPrice" style="text-decoration: line-through;">₹{{ number_format($type === 'course' ? $selectedCourse['old_price'] : $selectedPackage['old_price']) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.92rem; color: #05B396; margin-bottom: 0.5rem;">
                        <span>Limited Student Discount</span>
                        <span id="displayDiscount">-₹{{ number_format(($type === 'course' ? $selectedCourse['old_price'] : $selectedPackage['old_price']) - ($type === 'course' ? $selectedCourse['price'] : $selectedPackage['price'])) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.92rem; color: #94a3b8; margin-bottom: 0.8rem;">
                        <span>GST & Platform Access</span>
                        <span style="color: #22c55e; font-weight: 700;">FREE (₹0)</span>
                    </div>
                    <div style="border-top: 1px solid var(--border-glass); padding-top: 0.8rem; display: flex; justify-content: space-between; align-items: baseline;">
                        <span style="font-size: 1.1rem; font-weight: 800; color: #ffffff;">Total Payable Today</span>
                        <span id="displayPrice" style="font-size: 1.9rem; font-weight: 800; color: #05B396;">
                            ₹{{ number_format($type === 'course' ? $selectedCourse['price'] : $selectedPackage['price']) }}
                        </span>
                    </div>
                </div>

            </div>

            <!-- Trust Badges -->
            <div class="trust-badges-grid">
                <div class="glass" style="padding: 1rem; border-radius: 10px;">
                    <div style="font-size: 1.5rem; margin-bottom: 4px;">🔒</div>
                    <div style="font-size: 0.8rem; font-weight: 700; color: #f8fafc;">256-Bit SSL</div>
                    <div style="font-size: 0.72rem; color: #94a3b8;">Encrypted Checkout</div>
                </div>
                <div class="glass" style="padding: 1rem; border-radius: 10px;">
                    <div style="font-size: 1.5rem; margin-bottom: 4px;">⚡</div>
                    <div style="font-size: 0.8rem; font-weight: 700; color: #f8fafc;">Instant Access</div>
                    <div style="font-size: 0.72rem; color: #94a3b8;">Classroom Unlocked</div>
                </div>
                <div class="glass" style="padding: 1rem; border-radius: 10px;">
                    <div style="font-size: 1.5rem; margin-bottom: 4px;">📜</div>
                    <div style="font-size: 0.8rem; font-weight: 700; color: #f8fafc;">Certification</div>
                    <div style="font-size: 0.72rem; color: #94a3b8;">Official ISO Credential</div>
                </div>
            </div>

        </div>

        <!-- Right Column: Student Details & Payment Form -->
        <div class="glass checkout-sidebar checkout-card" style="padding: 2.2rem; border-radius: var(--radius-lg); border: 1.5px solid rgba(5, 179, 150, 0.4); background: rgba(15, 23, 42, 0.95); box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);">
            
            {{-- Notification Banners --}}
            @if(session('success'))
                <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #34d399; padding: 0.8rem 1rem; border-radius: 8px; font-size: 0.88rem; font-weight: 700; margin-bottom: 1.2rem; display: flex; align-items: center; gap: 8px;">
                    <span>✓</span> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #f87171; padding: 0.8rem 1rem; border-radius: 8px; font-size: 0.88rem; font-weight: 700; margin-bottom: 1.2rem; display: flex; align-items: center; gap: 8px;">
                    <span>⚠️</span> {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #f87171; padding: 0.8rem 1rem; border-radius: 8px; font-size: 0.85rem; margin-bottom: 1.2rem;">
                    <ul style="margin: 0; padding-left: 1.2rem;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(!Auth::check())
                {{-- ========================================================= --}}
                {{-- STATE 1: GUEST USER (MUST REGISTER OR LOGIN FIRST)        --}}
                {{-- ========================================================= --}}
                
                <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(245, 158, 11, 0.15); border: 1px solid #f59e0b; color: #fbbf24; padding: 4px 12px; border-radius: 20px; font-size: 0.74rem; font-weight: 800; letter-spacing: 0.8px; text-transform: uppercase; margin-bottom: 0.8rem;">
                    <span>🔒 STEP 1 OF 2: ACCOUNT REQUIRED</span>
                </div>

                <h3 style="font-size: 1.45rem; font-weight: 800; margin-bottom: 0.35rem; color: #fff;">
                    Register or Log In to Enroll
                </h3>
                <p style="color: var(--text-body); font-size: 0.88rem; margin-bottom: 1.3rem; line-height: 1.5;">
                    Create your student profile or log in below. Your payment section will unlock automatically once your account is ready.
                </p>

                <!-- Step 1 Tabs: Register vs Login -->
                <div style="display: flex; gap: 6px; background: rgba(255, 255, 255, 0.05); padding: 4px; border-radius: 10px; margin-bottom: 1.3rem;">
                    <button type="button" onclick="showCheckoutTab('register')" id="tabBtnRegister" class="checkout-auth-tab active" style="flex: 1; padding: 9px; font-size: 0.84rem; font-weight: 800; border-radius: 8px; border: none; cursor: pointer; transition: all 0.2s;">
                        📝 Register (New Student)
                    </button>
                    <button type="button" onclick="showCheckoutTab('login')" id="tabBtnLogin" class="checkout-auth-tab" style="flex: 1; padding: 9px; font-size: 0.84rem; font-weight: 800; border-radius: 8px; border: none; cursor: pointer; transition: all 0.2s;">
                        🔑 Login (Existing)
                    </button>
                </div>

                <!-- 1. REGISTER FORM -->
                <form method="POST" action="{{ route('checkout.register') }}" id="checkoutRegisterForm">
                    @csrf
                    <input type="hidden" name="package" id="regPackageInput" value="{{ $selectedPackage['id'] }}">
                    <input type="hidden" name="ref" value="{{ request('ref', session('user.sponsor_id', 'SKL-ADMIN')) }}">

                    <div style="margin-bottom: 0.95rem;">
                        <label style="font-size: 0.82rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.35rem; display: block;">
                            Student Full Name <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="name" required class="form-control" placeholder="e.g. Rahul Sharma" value="{{ old('name') }}" style="background: #1e293b; border: 1px solid rgba(255, 255, 255, 0.12); padding: 0.75rem 0.9rem; border-radius: 8px; color: #fff; width: 100%; font-size: 0.9rem;">
                    </div>

                    <div style="margin-bottom: 0.95rem;">
                        <label style="font-size: 0.82rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.35rem; display: block;">
                            WhatsApp Mobile Number <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="tel" name="phone" required class="form-control" placeholder="10-digit mobile number" value="{{ old('phone') }}" style="background: #1e293b; border: 1px solid rgba(255, 255, 255, 0.12); padding: 0.75rem 0.9rem; border-radius: 8px; color: #fff; width: 100%; font-size: 0.9rem;">
                    </div>

                    <div style="margin-bottom: 0.95rem;">
                        <label style="font-size: 0.82rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.35rem; display: block;">
                            Email Address <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="email" name="email" required class="form-control" placeholder="student@example.com" value="{{ old('email') }}" style="background: #1e293b; border: 1px solid rgba(255, 255, 255, 0.12); padding: 0.75rem 0.9rem; border-radius: 8px; color: #fff; width: 100%; font-size: 0.9rem;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem; margin-bottom: 0.95rem;">
                        <div>
                            <label style="font-size: 0.82rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.35rem; display: block;">
                                State
                            </label>
                            <select name="state" class="form-control" style="background: #1e293b; border: 1px solid rgba(255, 255, 255, 0.12); padding: 0.75rem 0.6rem; border-radius: 8px; color: #fff; width: 100%; font-size: 0.88rem;">
                                <option value="Maharashtra" selected>Maharashtra</option>
                                <option value="Delhi">Delhi NCR</option>
                                <option value="Uttar Pradesh">Uttar Pradesh</option>
                                <option value="Bihar">Bihar</option>
                                <option value="Gujarat">Gujarat</option>
                                <option value="Rajasthan">Rajasthan</option>
                                <option value="Madhya Pradesh">Madhya Pradesh</option>
                                <option value="Other">Other State</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 0.82rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.35rem; display: block;">
                                Password <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="password" name="password" required class="form-control" placeholder="Min. 6 chars" style="background: #1e293b; border: 1px solid rgba(255, 255, 255, 0.12); padding: 0.75rem 0.9rem; border-radius: 8px; color: #fff; width: 100%; font-size: 0.9rem;">
                        </div>
                    </div>

                    <div style="margin-bottom: 1.4rem;">
                        <label style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; margin-bottom: 0.35rem; display: flex; justify-content: space-between; align-items: center;">
                            <span>Sponsor / Referral ID (Auto-Locked)</span>
                            <span style="color: #10b981; font-size: 0.72rem;">✓ Verified</span>
                        </label>
                        <input type="text" name="sponsor_id" readonly value="{{ request('ref', session('user.sponsor_id', 'SKL-ADMIN')) }}" class="form-control" style="background: rgba(5, 179, 150, 0.1); border: 1px solid rgba(5, 179, 150, 0.4); color: #05B396; font-weight: 800; padding: 0.7rem 0.9rem; border-radius: 8px; width: 100%; font-size: 0.88rem;">
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.95rem; font-size: 1.05rem; font-weight: 800; background: #05B396; border: none; border-radius: 10px; color: #fff; box-shadow: 0 4px 18px rgba(5, 179, 150, 0.4); cursor: pointer;">
                        Create Account &amp; Unlock Payment ➔
                    </button>
                    
                    <p style="text-align: center; font-size: 0.78rem; color: #94a3b8; margin-top: 0.8rem; margin-bottom: 0;">
                        Already registered? <a href="#" onclick="showCheckoutTab('login'); return false;" style="color: #38bdf8; font-weight: 700; text-decoration: underline;">Click here to Login</a>
                    </p>
                </form>

                <!-- 2. LOGIN FORM -->
                <form method="POST" action="{{ route('checkout.login') }}" id="checkoutLoginForm" style="display: none;">
                    @csrf
                    <input type="hidden" name="package" id="loginPackageInput" value="{{ $selectedPackage['id'] }}">
                    <input type="hidden" name="ref" value="{{ request('ref', session('user.sponsor_id', 'SKL-ADMIN')) }}">

                    <div style="margin-bottom: 1.1rem;">
                        <label style="font-size: 0.82rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.35rem; display: block;">
                            Email / Phone / Student ID <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="username" required class="form-control" placeholder="Registered email, phone, or ID" value="{{ old('username') }}" style="background: #1e293b; border: 1px solid rgba(255, 255, 255, 0.12); padding: 0.78rem 0.9rem; border-radius: 8px; color: #fff; width: 100%; font-size: 0.9rem;">
                    </div>

                    <div style="margin-bottom: 1.4rem;">
                        <label style="font-size: 0.82rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.35rem; display: block;">
                            Account Password <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="password" name="password" required class="form-control" placeholder="Your password" style="background: #1e293b; border: 1px solid rgba(255, 255, 255, 0.12); padding: 0.78rem 0.9rem; border-radius: 8px; color: #fff; width: 100%; font-size: 0.9rem;">
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.95rem; font-size: 1.05rem; font-weight: 800; background: #05B396; border: none; border-radius: 10px; color: #fff; box-shadow: 0 4px 18px rgba(5, 179, 150, 0.4); cursor: pointer;">
                        Log In &amp; Unlock Payment ➔
                    </button>

                    <p style="text-align: center; font-size: 0.78rem; color: #94a3b8; margin-top: 0.8rem; margin-bottom: 0;">
                        New student? <a href="#" onclick="showCheckoutTab('register'); return false;" style="color: #38bdf8; font-weight: 700; text-decoration: underline;">Click here to Register</a>
                    </p>
                </form>

                <!-- STEP 2: PAYMENT SECTION (LOCKED FOR GUESTS) -->
                <div style="margin-top: 1.8rem; background: rgba(15, 23, 42, 0.7); border: 1.5px dashed rgba(255, 255, 255, 0.18); border-radius: 14px; padding: 1.5rem 1.2rem; text-align: center; position: relative; overflow: hidden;">
                    <div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(245, 158, 11, 0.15); border: 1.5px solid #f59e0b; color: #fbbf24; display: inline-flex; align-items: center; justify-content: center; font-size: 1.4rem; margin-bottom: 0.5rem;">
                        🔒
                    </div>
                    <h4 style="color: #ffffff; font-size: 1.1rem; font-weight: 800; margin-bottom: 0.3rem;">
                        Step 2: Payment Details (Locked)
                    </h4>
                    <p style="color: #94a3b8; font-size: 0.85rem; line-height: 1.5; margin: 0 auto; max-width: 360px;">
                        The <strong>UPI QR code</strong>, official UPI ID (<span style="color: #05B396;">support.skilllearner@oksbi</span>), and <strong>12-digit UTR verification form</strong> will unlock immediately once you create an account or log in above.
                    </p>
                </div>

            @else
                {{-- ========================================================= --}}
                {{-- STATE 2: AUTHENTICATED USER (STEP 2 PAYMENT UNLOCKED)     --}}
                {{-- ========================================================= --}}

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 8px;">
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #34d399; padding: 4px 12px; border-radius: 20px; font-size: 0.74rem; font-weight: 800; letter-spacing: 0.8px; text-transform: uppercase;">
                        <span>✓ STEP 1 COMPLETE</span>
                    </div>
                    <a href="{{ url('/logout') }}?redirect={{ urlencode(url()->full()) }}" style="color: #f87171; font-size: 0.78rem; font-weight: 700; text-decoration: underline;">
                        Switch Account / Logout
                    </a>
                </div>

                <!-- Logged In User Pill Card -->
                <div style="background: rgba(5, 179, 150, 0.1); border: 1.5px solid #05B396; border-radius: 12px; padding: 0.9rem 1.1rem; margin-bottom: 1.4rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-size: 0.72rem; text-transform: uppercase; color: #05B396; font-weight: 800; letter-spacing: 0.5px;">Account Connected</div>
                            <div style="font-size: 1.05rem; font-weight: 800; color: #ffffff;">{{ Auth::user()->name }}</div>
                            <div style="font-size: 0.82rem; color: #94a3b8;">{{ Auth::user()->email }} • {{ Auth::user()->phone ?? 'No Phone' }}</div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 0.72rem; text-transform: uppercase; color: #94a3b8; font-weight: 700;">Sponsor ID</div>
                            <div style="font-size: 0.88rem; font-weight: 800; color: #38bdf8;">{{ Auth::user()->sponsor_id ?? request('ref', 'SKL-ADMIN') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Step 2 Unlocked Header -->
                <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(5, 179, 150, 0.15); border: 1px solid #05B396; color: #05B396; padding: 4px 12px; border-radius: 20px; font-size: 0.74rem; font-weight: 800; letter-spacing: 0.8px; text-transform: uppercase; margin-bottom: 0.6rem;">
                    <span>⚡ STEP 2: COMPLETE PAYMENT &amp; SUBMIT UTR</span>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 1.2rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1); padding-bottom: 0.8rem;">
                    <div>
                        <div style="font-size: 0.78rem; text-transform: uppercase; color: #94a3b8; font-weight: 700;">Selected Package</div>
                        <div id="rightPkgName" style="font-size: 1.15rem; font-weight: 800; color: #ffffff;">{{ $selectedPackage['name'] }}</div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 0.78rem; text-transform: uppercase; color: #94a3b8; font-weight: 700;">Total Payable</div>
                        <div id="rightPkgPrice" style="font-size: 1.6rem; font-weight: 900; color: #05B396;">₹{{ number_format($selectedPackage['price']) }}</div>
                    </div>
                </div>

                <!-- Payment Method Tabs -->
                <div style="display: flex; gap: 8px; margin-bottom: 1rem;">
                    <button type="button" onclick="selectPaymentMethod('upi')" id="payTabUpi" class="pay-method-tab active">
                        <span>📲 UPI / QR</span>
                    </button>
                    <button type="button" onclick="selectPaymentMethod('bank')" id="payTabBank" class="pay-method-tab">
                        <span>🏦 Bank Transfer</span>
                    </button>
                </div>

                <!-- 1. UPI QR Code Option -->
                <div id="methodContentUpi" style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-glass); border-radius: 12px; padding: 1.2rem; text-align: center; margin-bottom: 1.4rem;">
                    <div style="display: flex; justify-content: center; margin-bottom: 0.7rem;">
                        <div style="background: #ffffff; padding: 10px; border-radius: 12px; display: inline-block;">
                            <svg width="130" height="130" viewBox="0 0 100 100">
                                <rect width="100" height="100" fill="#ffffff"/>
                                <!-- QR Corners -->
                                <rect x="5" y="5" width="28" height="28" fill="#0f172a" rx="2"/>
                                <rect x="9" y="9" width="20" height="20" fill="#ffffff" rx="1"/>
                                <rect x="13" y="13" width="12" height="12" fill="#05B396" rx="1"/>

                                <rect x="67" y="5" width="28" height="28" fill="#0f172a" rx="2"/>
                                <rect x="71" y="9" width="20" height="20" fill="#ffffff" rx="1"/>
                                <rect x="75" y="13" width="12" height="12" fill="#05B396" rx="1"/>

                                <rect x="5" y="67" width="28" height="28" fill="#0f172a" rx="2"/>
                                <rect x="9" y="71" width="20" height="20" fill="#ffffff" rx="1"/>
                                <rect x="13" y="75" width="12" height="12" fill="#05B396" rx="1"/>

                                <!-- QR Data Patterns -->
                                <rect x="40" y="8" width="6" height="6" fill="#0f172a"/>
                                <rect x="52" y="8" width="6" height="6" fill="#0f172a"/>
                                <rect x="40" y="20" width="6" height="6" fill="#0f172a"/>
                                <rect x="50" y="24" width="8" height="8" fill="#0f172a"/>
                                <rect x="12" y="42" width="6" height="6" fill="#0f172a"/>
                                <rect x="24" y="46" width="8" height="8" fill="#0f172a"/>
                                <rect x="42" y="42" width="16" height="16" fill="#05B396" rx="2"/>
                                <rect x="68" y="42" width="6" height="6" fill="#0f172a"/>
                                <rect x="80" y="46" width="8" height="8" fill="#0f172a"/>
                                <rect x="42" y="68" width="8" height="8" fill="#0f172a"/>
                                <rect x="56" y="72" width="6" height="6" fill="#0f172a"/>
                                <rect x="72" y="72" width="16" height="16" fill="#0f172a"/>
                                <rect x="44" y="86" width="10" height="6" fill="#05B396"/>
                            </svg>
                        </div>
                    </div>

                    <div style="font-size: 0.85rem; color: #cbd5e1; margin-bottom: 0.4rem;">
                        Scan QR with <strong>GPay, PhonePe, Paytm, CRED or BHIM</strong>
                    </div>
                    <div style="font-size: 0.8rem; color: #94a3b8; margin-bottom: 0.6rem;">
                        Pay Amount: <strong id="qrAmountDisplay" style="color: #ffffff;">₹{{ number_format($selectedPackage['price']) }}</strong>
                    </div>
                    <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(5, 179, 150, 0.12); padding: 5px 12px; border-radius: 6px; font-size: 0.82rem; color: #05B396; font-weight: 700;">
                        <span>UPI: support.skilllearner@oksbi</span>
                        <button type="button" onclick="navigator.clipboard.writeText('support.skilllearner@oksbi'); alert('Official UPI ID copied to clipboard: support.skilllearner@oksbi')" style="background: none; border: none; color: #05B396; cursor: pointer; font-size: 0.82rem; text-decoration: underline; font-weight: 800;">
                            Copy
                        </button>
                    </div>
                </div>

                <!-- 2. Bank Transfer Option -->
                <div id="methodContentBank" style="display: none; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-glass); border-radius: 12px; padding: 1.2rem; margin-bottom: 1.4rem; font-size: 0.86rem;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.6rem;">
                        <div>
                            <span style="color: #94a3b8; font-size: 0.74rem; text-transform: uppercase;">Bank Name</span>
                            <div style="color: #ffffff; font-weight: 700;">State Bank of India (SBI)</div>
                        </div>
                        <div>
                            <span style="color: #94a3b8; font-size: 0.74rem; text-transform: uppercase;">Account Holder</span>
                            <div style="color: #ffffff; font-weight: 700;">SkillLearner Edutech</div>
                        </div>
                        <div>
                            <span style="color: #94a3b8; font-size: 0.74rem; text-transform: uppercase;">Account Number</span>
                            <div style="color: #05B396; font-weight: 800; font-family: monospace;">42189034821</div>
                        </div>
                        <div>
                            <span style="color: #94a3b8; font-size: 0.74rem; text-transform: uppercase;">IFSC Code</span>
                            <div style="color: #05B396; font-weight: 800; font-family: monospace;">SBIN0001234</div>
                        </div>
                    </div>
                </div>

                <!-- Payment Verification Form (Submits UTR) -->
                <form method="POST" action="{{ url('/process-buy-now') }}" id="checkoutPaymentForm">
                    @csrf
                    <input type="hidden" name="item_type" value="package">
                    <input type="hidden" name="item_id" id="payItemId" value="{{ $selectedPackage['id'] }}">
                    <input type="hidden" name="sponsor_id" value="{{ Auth::user()->sponsor_id ?? request('ref', 'SKL-ADMIN') }}">

                    <div style="margin-bottom: 1.3rem;">
                        <label style="font-size: 0.86rem; font-weight: 800; color: #ffffff; margin-bottom: 0.45rem; display: block;">
                            Enter 12-Digit UTR / Transaction Reference Number <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="transaction_id" required class="form-control" placeholder="e.g. 439281928471" maxlength="35" style="background: #1e293b; border: 1.5px solid #05B396; padding: 0.85rem 1rem; border-radius: 8px; color: #fff; width: 100%; font-size: 1rem; font-family: monospace; font-weight: 700; letter-spacing: 1px;">
                        <span style="font-size: 0.76rem; color: #94a3b8; display: block; margin-top: 0.35rem;">
                            💡 Found in your UPI payment app (GPay/PhonePe/Paytm) confirmation SMS or receipt.
                        </span>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1.05rem 1.5rem; font-size: 1.12rem; font-weight: 800; background: #05B396; border: none; border-radius: 10px; box-shadow: 0 6px 22px rgba(5, 179, 150, 0.4); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; color: #ffffff;">
                        <span>Submit Payment for Verification ➔</span>
                    </button>

                    <p style="text-align: center; font-size: 0.78rem; color: #94a3b8; margin-top: 0.9rem; margin-bottom: 0; line-height: 1.5;">
                        🔒 Instant submission: Super Admin verifies your UTR within 5-15 minutes, activating your full video classroom and bonuses.
                    </p>
                </form>

            @endif

        </div>

    </div>
</section>

@push('styles')
<style>
    .checkout-auth-tab {
        background: transparent;
        color: #94a3b8;
    }
    .checkout-auth-tab.active {
        background: #05B396 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 10px rgba(5, 179, 150, 0.3);
    }

    .pay-method-tab {
        flex: 1;
        padding: 0.65rem 0.5rem;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-glass);
        color: #94a3b8;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }
    .pay-method-tab.active {
        background: rgba(5, 179, 150, 0.15);
        color: #05B396;
        border-color: #05B396;
    }

    .checkout-grid {
        display: grid;
        grid-template-columns: 1.15fr 1fr;
        gap: 2.2rem;
        align-items: start;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .checkout-summary-col {
        width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    .checkout-sidebar {
        width: 100%;
        min-width: 0;
        position: sticky;
        top: 100px;
        box-sizing: border-box;
    }

    .trust-badges-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-top: 1.5rem;
        text-align: center;
    }

    @media (max-width: 992px) {
        .checkout-grid {
            display: flex !important;
            flex-direction: column !important;
            gap: 1.8rem !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .checkout-summary-col,
        .checkout-sidebar {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            box-sizing: border-box !important;
            position: static !important;
            top: auto !important;
            display: block !important;
            visibility: visible !important;
        }

        .checkout-card {
            padding: 1.4rem 1.1rem !important;
            border-radius: 16px !important;
        }

        .trust-badges-grid {
            gap: 0.5rem !important;
            margin-bottom: 1.5rem !important;
        }

        .trust-badges-grid .glass {
            padding: 0.75rem 0.35rem !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const packagesData = {
        'basic': {
            name: '1. Basic Package',
            price: 599,
            oldPrice: 1199,
            badge: '',
            image: "{{ asset('images/packages/basic.png') }}",
            desc: 'Foundational digital skillset covering Affiliate Marketing basics, spoken English fluency, and high-impact communication.',
            inclusions: ['Get Access of 3+ Courses', 'What Is Affiliate Marketing', 'Spoken English', 'Communication Skill', 'Certificate of Completion']
        },
        'growth': {
            name: '2. Growth Package',
            price: 1199,
            oldPrice: 2499,
            badge: '',
            image: "{{ asset('images/packages/growth.png') }}",
            desc: 'Accelerate your creative monetization with Canva graphic design, viral reel workflows, and VN mobile video editing.',
            inclusions: ['Get Access of 6+ Courses', 'Canva Graphic Designing', 'Reel Mastery by Canva', 'VN Editing Course', '+ Full Access of Basic Package (All 3 Courses)', 'Certificate of Completion']
        },
        'advance': {
            name: '3. Advance Package',
            price: 2499,
            oldPrice: 4999,
            badge: '',
            image: "{{ asset('images/packages/advance.png') }}",
            desc: 'Scale conversions with Email Marketing, Sales Closing mastery, and Video Marketing frameworks.',
            inclusions: ['Get Access of 9+ Courses', 'E-mail Marketing', 'Sales Mastery', 'Video Marketing', '+ Full Access of Basic & Growth Packages (All 6 Courses)', 'Certificate of Completion']
        },
        'premium': {
            name: '4. Premium Package',
            price: 4999,
            oldPrice: 9999,
            badge: '',
            image: "{{ asset('images/packages/premium.png') }}",
            desc: 'High-ticket authority skills including full YouTube channel monetization, Meta Facebook advertising, and professional web design.',
            inclusions: ['Get Access of 12+ Courses', 'YouTube Mastery', 'Facebook Ads', 'Web Designing', '+ Full Access of Basic, Growth & Advance Packages (All 9 Courses)', 'Certificate of Completion']
        },
        'infinity': {
            name: '5. Infinity Package',
            price: 7999,
            oldPrice: 15999,
            badge: '',
            image: "{{ asset('images/packages/infinity.png') }}",
            desc: 'VIP flagship bundle mastering 0 to Hero AI Content Creation, Artificial Intelligence tools, and Stock Market wealth generation.',
            inclusions: ['Get Access of 15+ Courses (All Access)', '0 to Hero AI Content Creation', 'Artificial Intelligence', 'Stock Market Course', '+ Full Access of All Previous Packages (Lifetime All Access)', 'Verified Certificate of Completion']
        }
    };

    function showCheckoutTab(tab) {
        const regTab = document.getElementById('tabBtnRegister');
        const loginTab = document.getElementById('tabBtnLogin');
        const regForm = document.getElementById('checkoutRegisterForm');
        const loginForm = document.getElementById('checkoutLoginForm');

        if (regTab && loginTab && regForm && loginForm) {
            if (tab === 'register') {
                regTab.classList.add('active');
                loginTab.classList.remove('active');
                regForm.style.display = 'block';
                loginForm.style.display = 'none';
            } else {
                loginTab.classList.add('active');
                regTab.classList.remove('active');
                loginForm.style.display = 'block';
                regForm.style.display = 'none';
            }
        }
    }

    function selectPaymentMethod(method) {
        const upiTab = document.getElementById('payTabUpi');
        const bankTab = document.getElementById('payTabBank');
        const upiContent = document.getElementById('methodContentUpi');
        const bankContent = document.getElementById('methodContentBank');

        if (upiTab && bankTab && upiContent && bankContent) {
            upiTab.classList.toggle('active', method === 'upi');
            bankTab.classList.toggle('active', method === 'bank');
            upiContent.style.display = method === 'upi' ? 'block' : 'none';
            bankContent.style.display = method === 'bank' ? 'block' : 'none';
        }
    }

    function applySelectedPackage(pkgKey) {
        if (!packagesData[pkgKey]) return;
        const pkg = packagesData[pkgKey];

        // 1. Update Left Summary Column
        if (document.getElementById('formItemType')) document.getElementById('formItemType').value = 'package';
        if (document.getElementById('formItemId')) document.getElementById('formItemId').value = pkgKey;
        if (document.getElementById('displayItemBadge')) document.getElementById('displayItemBadge').innerText = pkg.badge || 'RECOMMENDED';
        if (document.getElementById('displayVisualWrapper')) document.getElementById('displayVisualWrapper').innerHTML = `<img src="${pkg.image}" style="width:100%;height:100%;object-fit:contain;">`;
        if (document.getElementById('displayItemCategory')) document.getElementById('displayItemCategory').innerText = 'SKILLLEARNER BUNDLE';
        if (document.getElementById('displayItemTitle')) document.getElementById('displayItemTitle').innerText = pkg.name;
        if (document.getElementById('displayItemMeta')) document.getElementById('displayItemMeta').innerText = pkg.inclusions.length + ' Full Courses Included';
        if (document.getElementById('displayOldPrice')) document.getElementById('displayOldPrice').innerText = '₹' + pkg.oldPrice.toLocaleString();
        if (document.getElementById('displayDiscount')) document.getElementById('displayDiscount').innerText = '-₹' + (pkg.oldPrice - pkg.price).toLocaleString();
        if (document.getElementById('displayPrice')) document.getElementById('displayPrice').innerText = '₹' + pkg.price.toLocaleString();

        // 2. Update Right Column Form Inputs & Price Displays
        if (document.getElementById('regPackageInput')) document.getElementById('regPackageInput').value = pkgKey;
        if (document.getElementById('loginPackageInput')) document.getElementById('loginPackageInput').value = pkgKey;
        if (document.getElementById('payItemId')) document.getElementById('payItemId').value = pkgKey;
        if (document.getElementById('rightPkgName')) document.getElementById('rightPkgName').innerText = pkg.name;
        if (document.getElementById('rightPkgPrice')) document.getElementById('rightPkgPrice').innerText = '₹' + pkg.price.toLocaleString();
        if (document.getElementById('qrAmountDisplay')) document.getElementById('qrAmountDisplay').innerText = '₹' + pkg.price.toLocaleString();

        // Highlight active package button in selector
        document.querySelectorAll('.pkg-select-btn').forEach(btn => {
            btn.style.borderColor = 'rgba(255,255,255,0.1)';
            btn.style.background = 'rgba(255,255,255,0.04)';
        });
        const activeBtn = document.getElementById('btn-pkg-' + pkgKey);
        if (activeBtn) {
            activeBtn.style.borderColor = '#05B396';
            activeBtn.style.background = 'rgba(5, 179, 150, 0.25)';
        }

        let incHtml = '';
        pkg.inclusions.forEach(item => {
            incHtml += `<li style="font-size: 0.88rem; color: #cbd5e1; display: flex; align-items: center; gap: 8px;"><span style="color: #05B396; font-weight: bold;">✓</span> ${item}</li>`;
        });
        if (document.getElementById('displayInclusionsList')) {
            document.getElementById('displayInclusionsList').innerHTML = incHtml;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const pkgParam = urlParams.get('package');
        if (pkgParam && packagesData[pkgParam.toLowerCase()]) {
            applySelectedPackage(pkgParam.toLowerCase());
        }

        const tabParam = urlParams.get('tab');
        if (tabParam === 'login') {
            showCheckoutTab('login');
        }
    });
</script>
@endpush
@endsection
