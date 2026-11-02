@extends('layouts.app')

@section('title', 'Contact Us — SkillLearner Support & Inquiries')

@section('content')
<!-- Contact Hero Header -->
<section style="padding: 4.5rem 1.5rem 3.5rem; text-align: center; background: radial-gradient(circle at 50% 10%, rgba(10, 107, 92, 0.08) 0%, #ffffff 75%); border-bottom: 1px solid rgba(0,0,0,0.05); position: relative; overflow: hidden;">
    <!-- Ambient Blur Background Accents -->
    <div style="position: absolute; top: -50px; left: 15%; width: 280px; height: 280px; background: radial-gradient(circle, rgba(11, 79, 74, 0.08) 0%, transparent 70%); filter: blur(50px); pointer-events: none;"></div>
    <div style="position: absolute; bottom: -50px; right: 15%; width: 280px; height: 280px; background: radial-gradient(circle, rgba(10, 107, 92, 0.1) 0%, transparent 70%); filter: blur(50px); pointer-events: none;"></div>

    <div class="container" style="max-width: 900px; margin: 0 auto; position: relative; z-index: 2;">
        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(10, 107, 92, 0.08); border: 1px solid rgba(10, 107, 92, 0.25); color: #0A6B5C; padding: 6px 20px; border-radius: 50px; font-size: 0.85rem; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1.2rem;">
            <span>💬 WE'RE HERE TO HELP</span>
        </div>

        <h1 style="font-size: clamp(2.4rem, 5vw, 3.5rem); font-weight: 900; letter-spacing: -1.2px; line-height: 1.15; color: #0c2340; margin-bottom: 0.8rem;">
            Contact <span style="color: #0A6B5C;">Us</span>
        </h1>

       

        <p style="font-size: 1.1rem; line-height: 1.65; color: #475569; max-width: 650px; margin: 0 auto; font-weight: 500;">
            Have questions about courses, packages, or student dashboard access? Reach out to our dedicated support team anytime.
        </p>
    </div>
</section>

<!-- Main Contact Section (Cards + Form) -->
<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 4.5rem 1.5rem 6rem;">
    
    @if(session('success'))
    <div style="background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 16px; padding: 1.2rem 1.6rem; margin-bottom: 2.5rem; display: flex; align-items: center; gap: 14px; box-shadow: 0 4px 15px rgba(22, 101, 52, 0.08);">
        <span style="font-size: 1.6rem;">🎉</span>
        <div>
            <h4 style="margin: 0; color: #166534; font-size: 1.05rem; font-weight: 800;">Message Sent Successfully!</h4>
            <p style="margin: 3px 0 0; color: #15803d; font-size: 0.92rem;">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <div class="contact-page-layout" style="display: grid; grid-template-columns: 1fr 1.25fr; gap: 3.5rem; align-items: start;">
        
        <!-- LEFT COLUMN: 3 Contact Info Cards (Matching Reference Layout) -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            
            <!-- Card 1: Contact Phone Number -->
            <div class="contact-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 20px; padding: 2rem 1.8rem; box-shadow: 0 8px 25px -4px rgba(0, 0, 0, 0.04); transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;">
                <div class="contact-icon-box" style="width: 54px; height: 54px; border-radius: 16px; background: rgba(10, 107, 92, 0.08); border: 1px solid rgba(10, 107, 92, 0.2); display: flex; align-items: center; justify-content: center; color: #0A6B5C; margin-bottom: 1.2rem;">
                    <!-- Headset Icon matching Reference Image -->
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
                        <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
                    </svg>
                </div>
                <h3 style="font-size: 1.22rem; font-weight: 800; color: #0c2340; margin-bottom: 0.5rem; letter-spacing: -0.3px;">
                    Contact Phone Number
                </h3>
                <a href="tel:8318373108" style="font-size: 1.15rem; font-weight: 700; color: #0A6B5C; text-decoration: none; display: inline-block; transition: color 0.2s ease;">
                    8318373108
                </a>
                <p style="color: #64748b; font-size: 0.88rem; margin: 0.4rem 0 0; line-height: 1.5;">
                    Call or WhatsApp for immediate admission and enrollment support.
                </p>
            </div>

            <!-- Card 2: Our Email Address -->
            <div class="contact-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 20px; padding: 2rem 1.8rem; box-shadow: 0 8px 25px -4px rgba(0, 0, 0, 0.04); transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;">
                <div class="contact-icon-box" style="width: 54px; height: 54px; border-radius: 16px; background: rgba(10, 107, 92, 0.08); border: 1px solid rgba(10, 107, 92, 0.2); display: flex; align-items: center; justify-content: center; color: #0A6B5C; margin-bottom: 1.2rem;">
                    <!-- Email Envelope Icon matching Reference Image -->
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </div>
                <h3 style="font-size: 1.22rem; font-weight: 800; color: #0c2340; margin-bottom: 0.5rem; letter-spacing: -0.3px;">
                    Our Email Address
                </h3>
                <a href="mailto:support.skilllearner@gmail.com" style="font-size: 1.05rem; font-weight: 700; color: #0A6B5C; text-decoration: none; display: inline-block; word-break: break-all; transition: color 0.2s ease;">
                    support.skilllearner@gmail.com
                </a>
                <p style="color: #64748b; font-size: 0.88rem; margin: 0.4rem 0 0; line-height: 1.5;">
                    Official inquiries, student verification &amp; partnership requests.
                </p>
            </div>

            <!-- Card 3: Our Location -->
            <div class="contact-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 20px; padding: 2rem 1.8rem; box-shadow: 0 8px 25px -4px rgba(0, 0, 0, 0.04); transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;">
                <div class="contact-icon-box" style="width: 54px; height: 54px; border-radius: 16px; background: rgba(10, 107, 92, 0.08); border: 1px solid rgba(10, 107, 92, 0.2); display: flex; align-items: center; justify-content: center; color: #0A6B5C; margin-bottom: 1.2rem;">
                    <!-- Location Pin Icon matching Reference Image -->
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                </div>
                <h3 style="font-size: 1.22rem; font-weight: 800; color: #0c2340; margin-bottom: 0.5rem; letter-spacing: -0.3px;">
                    Our Location
                </h3>
                <div style="font-size: 1.05rem; font-weight: 700; color: #1e293b; line-height: 1.45;">
                    Mumbai Maharashtra
                </div>
                <p style="color: #64748b; font-size: 0.88rem; margin: 0.4rem 0 0; line-height: 1.5;">
                    Maharashtra, India
                </p>
            </div>

            <!-- WhatsApp Direct Assist -->
            <a href="https://wa.me/918318373108" target="_blank" rel="noopener noreferrer" style="background: rgba(16, 185, 129, 0.08); border: 1.5px solid rgba(16, 185, 129, 0.3); border-radius: 16px; padding: 1.1rem 1.4rem; display: flex; align-items: center; gap: 14px; text-decoration: none; transition: all 0.2s ease;">
                <div style="width: 42px; height: 42px; border-radius: 50%; background: #10B981; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">
                    💬
                </div>
                <div>
                    <div style="font-size: 0.95rem; font-weight: 800; color: #065f46;">Chat with Us on WhatsApp</div>
                    <div style="font-size: 0.82rem; color: #047857;">Instant response from student counsellors</div>
                </div>
            </a>

        </div>

        <!-- RIGHT COLUMN: Contact Form Card (Matching Reference Image 2) -->
        <div class="contact-form-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.95); border-radius: 24px; padding: 3rem 2.8rem; box-shadow: 0 20px 45px -12px rgba(11, 79, 74, 0.1), 0 4px 12px -2px rgba(0,0,0,0.03); position: relative;">
            
            <div style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.65rem; font-weight: 900; color: #0c2340; letter-spacing: -0.6px; margin-bottom: 0.5rem;">
                    Send Us a Message
                </h3>
                <p style="color: #64748b; font-size: 0.96rem; line-height: 1.6; margin: 0;">
                    Have questions about courses or want guidance? Leave your details below and our counsellor will get in touch with you shortly.
                </p>
            </div>

            <form id="contactForm" action="{{ url('/contact') }}" method="POST" onsubmit="handleContactSubmit(event)">
                @csrf

                <!-- Name Field -->
                <div class="contact-form-group" style="margin-bottom: 1.5rem;">
                    <label for="name" style="display: block; font-size: 0.95rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">
                        Name <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" id="name" name="name" required placeholder="Enter your full name" class="contact-input" style="width: 100%; padding: 0.85rem 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0; font-size: 0.96rem; color: #0f172a; outline: none; transition: border-color 0.2s, box-shadow 0.2s; font-family: inherit; background: #f8fafc;">
                </div>

                <!-- Email Field -->
                <div class="contact-form-group" style="margin-bottom: 1.5rem;">
                    <label for="email" style="display: block; font-size: 0.95rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">
                        Email <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="email" id="email" name="email" required placeholder="yourname@gmail.com" class="contact-input" style="width: 100%; padding: 0.85rem 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0; font-size: 0.96rem; color: #0f172a; outline: none; transition: border-color 0.2s, box-shadow 0.2s; font-family: inherit; background: #f8fafc;">
                </div>

                <!-- Phone Field -->
                <div class="contact-form-group" style="margin-bottom: 1.5rem;">
                    <label for="phone" style="display: block; font-size: 0.95rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">
                        Phone
                    </label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your 10-digit mobile number" class="contact-input" style="width: 100%; padding: 0.85rem 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0; font-size: 0.96rem; color: #0f172a; outline: none; transition: border-color 0.2s, box-shadow 0.2s; font-family: inherit; background: #f8fafc;">
                </div>

                <!-- Subject Field -->
                <div class="contact-form-group" style="margin-bottom: 1.5rem;">
                    <label for="subject" style="display: block; font-size: 0.95rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">
                        Subject
                    </label>
                    <input type="text" id="subject" name="subject" placeholder="Course details, admission query, etc." class="contact-input" style="width: 100%; padding: 0.85rem 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0; font-size: 0.96rem; color: #0f172a; outline: none; transition: border-color 0.2s, box-shadow 0.2s; font-family: inherit; background: #f8fafc;">
                </div>

                <!-- Message Field -->
                <div class="contact-form-group" style="margin-bottom: 2rem;">
                    <label for="message" style="display: block; font-size: 0.95rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">
                        Message <span style="color: #ef4444;">*</span>
                    </label>
                    <textarea id="message" name="message" rows="4" required placeholder="Write your message here..." class="contact-input" style="width: 100%; padding: 0.85rem 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0; font-size: 0.96rem; color: #0f172a; outline: none; transition: border-color 0.2s, box-shadow 0.2s; font-family: inherit; background: #f8fafc; resize: vertical;"></textarea>
                </div>

                <!-- Submit Button matching SkillLearner colors -->
                <button type="submit" id="contactSubmitBtn" class="contact-submit-btn" style="width: 100%; padding: 1.1rem 2rem; background: linear-gradient(135deg, #05B396 0%, #0A6B5C 100%); color: #ffffff; border: none; border-radius: 50px; font-size: 1.05rem; font-weight: 800; letter-spacing: 0.3px; cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease; box-shadow: 0 10px 25px rgba(10, 107, 92, 0.35); display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <span>Submit Message</span>
                    <span>➔</span>
                </button>

            </form>

            <div id="contactSuccessMsg" style="display: none; background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 16px; padding: 1.5rem; margin-top: 1.5rem; text-align: center; color: #166534;">
                <span style="font-size: 2rem;">✅</span>
                <h4 style="font-size: 1.15rem; font-weight: 800; margin: 0.5rem 0 0.2rem;">Message Sent!</h4>
                <p style="margin: 0; font-size: 0.92rem; color: #15803d;">Thank you for contacting SkillLearner. Our support team will get in touch with you shortly.</p>
            </div>

        </div>

    </div>

</div>

<script>
    function handleContactSubmit(e) {
        // If static build or JS handling
        var btn = document.getElementById('contactSubmitBtn');
        if (btn) {
            btn.innerHTML = 'Sending...';
            btn.style.opacity = '0.8';
        }
        // Let normal POST submit proceed if in Laravel, otherwise fallback to friendly notice
        setTimeout(function() {
            var successMsg = document.getElementById('contactSuccessMsg');
            var form = document.getElementById('contactForm');
            if (successMsg && form && window.location.protocol === 'file:') {
                form.style.display = 'none';
                successMsg.style.display = 'block';
            }
        }, 600);
    }
</script>

@push('styles')
<style>
    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 35px -6px rgba(11, 79, 74, 0.12), 0 4px 10px -2px rgba(0, 0, 0, 0.04) !important;
        border-color: rgba(11, 79, 74, 0.35) !important;
    }
    .contact-card:hover .contact-icon-box {
        background: rgba(10, 107, 92, 0.15) !important;
        transform: scale(1.05);
    }
    .contact-icon-box {
        transition: all 0.25s ease;
    }
    .contact-input:focus {
        border-color: #0A6B5C !important;
        background: #ffffff !important;
        box-shadow: 0 0 0 4px rgba(10, 107, 92, 0.12) !important;
    }
    .contact-submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(10, 107, 92, 0.45) !important;
        filter: brightness(1.04);
    }
    .contact-submit-btn:active {
        transform: translateY(0);
    }

    @media (max-width: 900px) {
        .contact-page-layout {
            grid-template-columns: 1fr !important;
            gap: 2.5rem !important;
        }
        .contact-form-card {
            padding: 2.2rem 1.6rem !important;
        }
    }
</style>
@endpush
@endsection

