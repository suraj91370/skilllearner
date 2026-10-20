@extends('layouts.app')

@section('title', 'Buy Now & Instant Enrollment — Skillleaner')

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
<section class="container" style="max-width: 1100px; padding-top: 1rem; padding-bottom: 5rem;">
    <div style="display: grid; grid-template-columns: 1.15fr 1fr; gap: 2.5rem; align-items: start;">
        
        <!-- Left Column: Order Summary & Item Description -->
        <div>
            
            <!-- Item Selector Tabs (Course vs Package) -->
            <div style="display: flex; gap: 10px; margin-bottom: 1.5rem;">
                <button type="button" onclick="switchCheckoutMode('package')" id="tabBtnPackage" class="checkout-tab-btn {{ $type === 'package' ? 'active' : '' }}">
                    📦 Package Bundle (Best Value)
                </button>
                <button type="button" onclick="switchCheckoutMode('course')" id="tabBtnCourse" class="checkout-tab-btn {{ $type === 'course' ? 'active' : '' }}">
                    🎓 Single Course Masterclass
                </button>
            </div>

            <!-- Active Item Summary Card -->
            <div class="glass" style="padding: 2.2rem; border-radius: var(--radius-lg); border: 2px solid #05B396; position: relative;">
                
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
                            {{ $type === 'course' ? $selectedCourse['cat'] : 'SKILLLEANER BUNDLE' }}
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
                <p id="displayItemDesc" style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem; background: rgba(255, 255, 255, 0.02); padding: 1rem; border-radius: 8px; border: 1px solid var(--border-glass);">
                    {{ $type === 'course' ? $selectedCourse['desc'] : $selectedPackage['desc'] }}
                </p>

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
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-top: 1.5rem; text-align: center;">
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
        <div class="glass" style="padding: 2.4rem; border-radius: var(--radius-lg); position: sticky; top: 100px; border: 1px solid var(--border-glass);">
            
            <h3 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 0.4rem; color: #fff;">
                Student Enrollment & Payment
            </h3>
            <p style="color: var(--text-body); font-size: 0.88rem; margin-bottom: 1.8rem;">
                Enter your details to generate your student ID and unlock your learning dashboard.
            </p>

            <form method="POST" action="{{ url('/process-buy-now') }}" id="checkoutForm">
                @csrf
                
                <!-- Hidden inputs for active selection -->
                <input type="hidden" name="item_type" id="formItemType" value="{{ $type }}">
                <input type="hidden" name="item_id" id="formItemId" value="{{ $type === 'course' ? $selectedCourse['slug'] : $selectedPackage['id'] }}">

                <!-- Full Name -->
                <div class="form-group" style="margin-bottom: 1.1rem;">
                    <label style="font-size: 0.86rem; font-weight: 700; color: #e2e8f0; margin-bottom: 0.4rem; display: block;">
                        Student Full Name <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="name" required class="form-control" placeholder="Suraj Kumar" value="{{ session('user.name', '') }}" style="background: rgba(255, 255, 255, 0.05); border: 1px solid var(--border-glass); padding: 0.8rem 1rem; border-radius: 8px; color: #fff; width: 100%;">
                </div>

                <!-- WhatsApp Number -->
                <div class="form-group" style="margin-bottom: 1.1rem;">
                    <label style="font-size: 0.86rem; font-weight: 700; color: #e2e8f0; margin-bottom: 0.4rem; display: block;">
                        WhatsApp Number <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="tel" name="phone" required class="form-control" placeholder="9876543210" value="{{ session('user.phone', '') }}" style="background: rgba(255, 255, 255, 0.05); border: 1px solid var(--border-glass); padding: 0.8rem 1rem; border-radius: 8px; color: #fff; width: 100%;">
                </div>

                <!-- Email Address -->
                <div class="form-group" style="margin-bottom: 1.1rem;">
                    <label style="font-size: 0.86rem; font-weight: 700; color: #e2e8f0; margin-bottom: 0.4rem; display: block;">
                        Email Address (for LMS Login) <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="email" name="email" required class="form-control" placeholder="suraj@example.com" value="{{ session('user.email', '') }}" style="background: rgba(255, 255, 255, 0.05); border: 1px solid var(--border-glass); padding: 0.8rem 1rem; border-radius: 8px; color: #fff; width: 100%;">
                </div>

                <!-- State / City -->
                <div class="form-group" style="margin-bottom: 1.1rem;">
                    <label style="font-size: 0.86rem; font-weight: 700; color: #e2e8f0; margin-bottom: 0.4rem; display: block;">
                        Your State
                    </label>
                    <select name="state" class="form-control" style="background: #0f172a; border: 1px solid var(--border-glass); padding: 0.8rem 1rem; border-radius: 8px; color: #fff; width: 100%;">
                        <option value="Maharashtra" selected>Maharashtra</option>
                        <option value="Delhi">Delhi NCR</option>
                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                        <option value="Bihar">Bihar</option>
                        <option value="Gujarat">Gujarat</option>
                        <option value="Karnataka">Karnataka</option>
                        <option value="Rajasthan">Rajasthan</option>
                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                        <option value="West Bengal">West Bengal</option>
                        <option value="Other">Other State</option>
                    </select>
                </div>

                <!-- Sponsor Referral ID -->
                <div class="form-group" style="margin-bottom: 1.6rem;">
                    <label style="font-size: 0.86rem; font-weight: 700; color: #94a3b8; margin-bottom: 0.4rem; display: block;">
                        Sponsor / Referral ID (Auto-Locked)
                    </label>
                    <input type="text" name="sponsor_id" readonly value="{{ request('ref', session('user.sponsor_id', 'SKL-ADMIN')) }}" class="form-control" style="background: rgba(5, 179, 150, 0.08); border: 1px solid rgba(5, 179, 150, 0.3); color: #05B396; font-weight: 800; padding: 0.75rem 1rem; border-radius: 8px; width: 100%;">
                </div>

                <!-- Payment Method Simulator Tabs -->
                <div style="border-top: 1px solid var(--border-glass); padding-top: 1.4rem; margin-bottom: 1.6rem;">
                    <label style="font-size: 0.88rem; font-weight: 800; color: #ffffff; margin-bottom: 0.8rem; display: block;">
                        Select Payment Option
                    </label>

                    <div style="display: flex; gap: 8px; margin-bottom: 1rem;">
                        <button type="button" onclick="selectPaymentMethod('upi')" id="payTabUpi" class="pay-method-tab active">
                            <span>📲 UPI / QR</span>
                        </button>
                        <button type="button" onclick="selectPaymentMethod('card')" id="payTabCard" class="pay-method-tab">
                            <span>💳 Card</span>
                        </button>
                        <button type="button" onclick="selectPaymentMethod('netbanking')" id="payTabNb" class="pay-method-tab">
                            <span>🏦 NetBanking</span>
                        </button>
                    </div>

                    <!-- UPI Content -->
                    <div id="methodContentUpi" style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-glass); border-radius: 10px; padding: 1.2rem; text-align: center;">
                        <div style="display: flex; justify-content: center; margin-bottom: 0.8rem;">
                            <!-- Simulated Visual UPI QR Code -->
                            <div style="background: #ffffff; padding: 12px; border-radius: 12px; display: inline-block;">
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

                        <div style="font-size: 0.85rem; color: #cbd5e1; margin-bottom: 0.5rem;">
                            Scan QR with <strong>GPay, PhonePe, Paytm, or CRED</strong>
                        </div>
                        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(5, 179, 150, 0.12); padding: 5px 12px; border-radius: 6px; font-size: 0.82rem; color: #05B396; font-weight: 700;">
                            <span>UPI: skillleaner.pay@okaxis</span>
                            <button type="button" onclick="navigator.clipboard.writeText('skillleaner.pay@okaxis'); alert('UPI ID copied to clipboard!')" style="background: none; border: none; color: #05B396; cursor: pointer; font-size: 0.82rem; text-decoration: underline;">Copy</button>
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div id="methodContentCard" style="display: none; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-glass); border-radius: 10px; padding: 1.2rem;">
                        <input type="text" placeholder="Card Number (4000 1234 5678 9010)" class="form-control" style="margin-bottom: 0.8rem; font-size: 0.88rem; width: 100%;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem;">
                            <input type="text" placeholder="MM / YY" class="form-control" style="font-size: 0.88rem; width: 100%;">
                            <input type="password" placeholder="CVV" maxlength="3" class="form-control" style="font-size: 0.88rem; width: 100%;">
                        </div>
                    </div>

                    <!-- Net Banking Content -->
                    <div id="methodContentNetbanking" style="display: none; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-glass); border-radius: 10px; padding: 1.2rem;">
                        <select class="form-control" style="font-size: 0.88rem; width: 100%; background: #0f172a;">
                            <option>HDFC Bank</option>
                            <option>State Bank of India (SBI)</option>
                            <option>ICICI Bank</option>
                            <option>Axis Bank</option>
                            <option>Kotak Mahindra Bank</option>
                            <option>Punjab National Bank</option>
                        </select>
                    </div>

                </div>

                <!-- Submit Buy Now Button -->
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1.05rem 1.5rem; font-size: 1.15rem; font-weight: 800; background: #05B396; border-radius: 10px; box-shadow: 0 6px 22px rgba(5, 179, 150, 0.4); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <span>Complete Order & Buy Now ➔</span>
                </button>

                <p style="text-align: center; font-size: 0.78rem; color: #94a3b8; margin-top: 1rem;">
                    🔒 Instant activation: You will be immediately redirected to your video classroom and student dashboard.
                </p>

            </form>

        </div>

    </div>
</section>

@push('styles')
<style>
    .checkout-tab-btn {
        flex: 1;
        padding: 0.8rem 1rem;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border-glass);
        color: #94a3b8;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .checkout-tab-btn.active, .checkout-tab-btn:hover {
        background: #05B396;
        color: #ffffff;
        border-color: #05B396;
        box-shadow: 0 4px 15px rgba(5, 179, 150, 0.25);
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

    @media (max-width: 900px) {
        section .container > div[style*="grid-template-columns: 1.15fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const packagesData = {
        'basic': {
            name: 'Basic Package',
            price: 1499,
            oldPrice: 2999,
            badge: 'STARTER',
            image: "{{ asset('images/packages/basic.jpg') }}",
            desc: 'Foundational digital skill package including Canva Pro, MS Excel Essentials, Spoken English, and Social Media Fundamentals.',
            inclusions: ['Canva Pro Mastery', 'MS Excel Essentials', 'Basic Spoken English', 'Social Media Fundamentals', 'Certificate of Completion']
        },
        'advance': {
            name: 'Advance Package',
            price: 2499,
            oldPrice: 4999,
            badge: 'MOST POPULAR',
            image: "{{ asset('images/packages/advance.jpg') }}",
            desc: 'The best-selling affiliate growth package with Short-Form Video Editing, Instagram Growth Formula, Organic Lead Generation, and all Basic courses.',
            inclusions: ['All Basic Package Courses', 'Video Editing (Premiere & CapCut)', 'Instagram Growth Formula', 'Organic Lead Generation Blueprint', '70% Direct Affiliate Commissions']
        },
        'premium': {
            name: 'Premium Package',
            price: 3999,
            oldPrice: 7999,
            badge: 'BEST VALUE',
            image: "{{ asset('images/packages/premium.jpg') }}",
            desc: 'Comprehensive monetization package covering Meta Ads Mastery, AI & ChatGPT Cashflow Kit, and WordPress Web Design.',
            inclusions: ['All Advance Courses', 'Facebook & Instagram Paid Ads', 'AI & ChatGPT Monetization Kit', 'WordPress Web Development', 'High-Tier Commission Access']
        },
        'growth': {
            name: 'Growth Package',
            price: 5999,
            oldPrice: 11999,
            badge: 'HIGH GROWTH',
            image: "{{ asset('images/packages/growth.jpg') }}",
            desc: 'Scale to high-ticket revenue with sales closing mastery, full funnel building, Google Ads, and automated conversion systems.',
            inclusions: ['All Premium Courses', 'Complete Funnel Building', 'High-Ticket Sales Closing', 'Google & YouTube Ads', 'Priority VIP Support']
        },
        'infinity': {
            name: 'Infinity Package',
            price: 9999,
            oldPrice: 19999,
            badge: 'VIP ALL ACCESS',
            image: "{{ asset('images/packages/infinity.jpg') }}",
            desc: 'Lifetime all-inclusive VIP pass with 1-on-1 mentorship, live weekly mastermind calls, and full access to every existing and future course.',
            inclusions: ['Full Lifetime Access Pass to All Masterclasses', 'UI/UX Design Masterclass', '1-on-1 Mentorship & Weekly Live Masterminds', 'VIP Community & Direct Founder Access']
        }
    };

    function selectPaymentMethod(method) {
        document.querySelectorAll('.pay-method-tab').forEach(b => b.classList.remove('active'));
        document.getElementById('payTabUpi').classList.toggle('active', method === 'upi');
        document.getElementById('payTabCard').classList.toggle('active', method === 'card');
        document.getElementById('payTabNb').classList.toggle('active', method === 'netbanking');

        document.getElementById('methodContentUpi').style.display = method === 'upi' ? 'block' : 'none';
        document.getElementById('methodContentCard').style.display = method === 'card' ? 'block' : 'none';
        document.getElementById('methodContentNetbanking').style.display = method === 'netbanking' ? 'block' : 'none';
    }

    function switchCheckoutMode(mode) {
        document.getElementById('tabBtnPackage').classList.toggle('active', mode === 'package');
        document.getElementById('tabBtnCourse').classList.toggle('active', mode === 'course');
        document.getElementById('formItemType').value = mode;

        if (mode === 'package') {
            const pkg = packagesData['advance'];
            document.getElementById('formItemId').value = 'advance';
            document.getElementById('displayItemBadge').innerText = pkg.badge;
            document.getElementById('displayVisualWrapper').innerHTML = `<img src="${pkg.image}" style="width:100%;height:100%;object-fit:contain;">`;
            document.getElementById('displayItemCategory').innerText = 'SKILLLEANER BUNDLE';
            document.getElementById('displayItemTitle').innerText = pkg.name;
            document.getElementById('displayItemMeta').innerText = pkg.inclusions.length + ' Full Courses Included';
            document.getElementById('displayItemDesc').innerText = pkg.desc;
            document.getElementById('displayOldPrice').innerText = '₹' + pkg.oldPrice.toLocaleString();
            document.getElementById('displayDiscount').innerText = '-₹' + (pkg.oldPrice - pkg.price).toLocaleString();
            document.getElementById('displayPrice').innerText = '₹' + pkg.price.toLocaleString();

            let incHtml = '';
            pkg.inclusions.forEach(item => {
                incHtml += `<li style="font-size: 0.88rem; color: #cbd5e1; display: flex; align-items: center; gap: 8px;"><span style="color: #05B396; font-weight: bold;">✓</span> ${item}</li>`;
            });
            document.getElementById('displayInclusionsList').innerHTML = incHtml;
        } else {
            // Course Mode - Default to Affiliate Marketing
            document.getElementById('formItemId').value = 'affiliate-marketing-masterclass';
            document.getElementById('displayItemBadge').innerText = 'BESTSELLER';
            document.getElementById('displayVisualWrapper').innerHTML = `<span style="font-size:2.6rem;">🚀</span>`;
            document.getElementById('displayItemCategory').innerText = 'AFFILIATE BUSINESS';
            document.getElementById('displayItemTitle').innerText = 'High-Ticket Affiliate Marketing Masterclass';
            document.getElementById('displayItemMeta').innerText = '18 Lessons • 6h 40m Video Runtime';
            document.getElementById('displayItemDesc').innerText = 'Master high-ticket affiliate funnels, organic lead generation on Instagram and LinkedIn, copy-paste WhatsApp DM scripts, and scaling to ₹50,000+ monthly.';
            document.getElementById('displayOldPrice').innerText = '₹3,999';
            document.getElementById('displayDiscount').innerText = '-₹2,500';
            document.getElementById('displayPrice').innerText = '₹1,499';

            let incHtml = `
                <li style="font-size: 0.88rem; color: #cbd5e1; display: flex; align-items: center; gap: 8px;"><span style="color: #05B396; font-weight: bold;">✓</span> 18 High-Def Masterclass Lessons</li>
                <li style="font-size: 0.88rem; color: #cbd5e1; display: flex; align-items: center; gap: 8px;"><span style="color: #05B396; font-weight: bold;">✓</span> Downloadable Funnel Blueprints & Scripts</li>
                <li style="font-size: 0.88rem; color: #cbd5e1; display: flex; align-items: center; gap: 8px;"><span style="color: #05B396; font-weight: bold;">✓</span> Verified Digital Certificate of Completion</li>
                <li style="font-size: 0.88rem; color: #cbd5e1; display: flex; align-items: center; gap: 8px;"><span style="color: #05B396; font-weight: bold;">✓</span> Lifetime Access on All Devices</li>
            `;
            document.getElementById('displayInclusionsList').innerHTML = incHtml;
        }
    }
</script>
@endpush
@endsection
