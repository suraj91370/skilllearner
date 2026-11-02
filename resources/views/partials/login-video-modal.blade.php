@php
    $loginVideoUrl = \App\Models\Setting::get('login_video_url', 'https://www.youtube.com/watch?v=kJQP7kiw5Fk');
    $loginVideoEmbed = \App\Models\Setting::formatEmbedUrl($loginVideoUrl);
    $loginVideoTitle = \App\Models\Setting::get('login_video_title', 'Welcome to SkillLearner! Watch This First');
    $loginVideoDesc = \App\Models\Setting::get('login_video_description', 'Watch this introductory guide to navigate your courses, discover earning opportunities, and set up your student profile.');
    $loginVideoEnabled = (string) \App\Models\Setting::get('login_video_enabled', '1') === '1';
    $autoShow = $loginVideoEnabled && (session('show_login_video_popup', false) || request()->query('preview_video_popup') === '1');
@endphp

<!-- Login Welcome Video Popup Modal -->
<div id="loginVideoModal" class="login-video-modal-overlay" style="display: none;" role="dialog" aria-modal="true" aria-labelledby="loginVideoModalTitle">
    <div class="login-video-modal-box">
        <!-- Modal Header -->
        <div class="login-video-modal-header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span class="video-badge-icon">🎬</span>
                <div>
                    <h3 id="loginVideoModalTitle" class="login-video-title">{{ $loginVideoTitle }}</h3>
                    <p class="login-video-subtitle">{{ $loginVideoDesc }}</p>
                </div>
            </div>
            <button type="button" class="login-video-close-btn" onclick="closeLoginVideoModal()" aria-label="Close Video">&times;</button>
        </div>

        <!-- Responsive 16:9 Video Player Container -->
        <div class="login-video-frame-container">
            <iframe
                id="loginVideoIframe"
                src=""
                data-embed-url="{{ $loginVideoEmbed }}"
                title="{{ $loginVideoTitle }}"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen>
            </iframe>
        </div>

        <!-- Modal Footer Actions -->
        <div class="login-video-modal-footer">
            <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 0.85rem; color: #94a3b8; cursor: pointer;">
                <input type="checkbox" id="dontShowVideoAgainCheck" style="accent-color: #05B396; width: 16px; height: 16px; cursor: pointer;">
                <span>Don't show this orientation video again</span>
            </label>
            <button type="button" class="login-video-btn-action" onclick="closeLoginVideoModal()">
                <span>Continue to Learning Dashboard ➔</span>
            </button>
        </div>
    </div>
</div>

<style>
    .login-video-modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 999999;
        background: rgba(10, 15, 29, 0.85);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.25rem;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .login-video-modal-overlay.active {
        opacity: 1;
        visibility: visible;
        display: flex !important;
    }
    .login-video-modal-box {
        background: #0f172a;
        color: #ffffff;
        border: 1.5px solid rgba(5, 179, 150, 0.45);
        border-radius: 20px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6), 0 0 35px rgba(5, 179, 150, 0.2);
        max-width: 820px;
        width: 100%;
        overflow: hidden;
        transform: scale(0.92);
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
    }
    .login-video-modal-overlay.active .login-video-modal-box {
        transform: scale(1);
    }
    .login-video-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 1.2rem 1.6rem;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.04) 0%, rgba(255, 255, 255, 0) 100%);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        gap: 1rem;
    }
    .video-badge-icon {
        font-size: 1.6rem;
        background: rgba(5, 179, 150, 0.15);
        border: 1px solid rgba(5, 179, 150, 0.3);
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .login-video-title {
        font-size: 1.18rem;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 3px 0;
        letter-spacing: -0.2px;
    }
    .login-video-subtitle {
        font-size: 0.82rem;
        color: #94a3b8;
        margin: 0;
        line-height: 1.4;
    }
    .login-video-close-btn {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #94a3b8;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        font-size: 1.4rem;
        line-height: 1;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    .login-video-close-btn:hover {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.4);
        transform: rotate(90deg);
    }
    .login-video-frame-container {
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* 16:9 Aspect Ratio */
        background: #000000;
    }
    .login-video-frame-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }
    .login-video-modal-footer {
        padding: 1rem 1.6rem;
        background: rgba(15, 23, 42, 0.95);
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .login-video-btn-action {
        background: linear-gradient(135deg, #05B396 0%, #048873 100%);
        color: #ffffff;
        border: none;
        padding: 0.65rem 1.4rem;
        border-radius: 10px;
        font-size: 0.92rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 15px rgba(5, 179, 150, 0.35);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .login-video-btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 22px rgba(5, 179, 150, 0.5);
    }

    @media (max-width: 640px) {
        .login-video-modal-header {
            padding: 1rem;
        }
        .login-video-title {
            font-size: 1rem;
        }
        .login-video-subtitle {
            font-size: 0.76rem;
        }
        .video-badge-icon {
            width: 36px;
            height: 36px;
            font-size: 1.3rem;
        }
        .login-video-modal-footer {
            padding: 0.85rem 1rem;
            flex-direction: column;
            align-items: stretch;
            text-align: center;
        }
        .login-video-btn-action {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
    window.openLoginVideoModal = function(customEmbedUrl) {
        const modal = document.getElementById('loginVideoModal');
        const iframe = document.getElementById('loginVideoIframe');
        if (!modal || !iframe) return;

        const embedUrl = customEmbedUrl || iframe.getAttribute('data-embed-url');
        if (embedUrl) {
            iframe.src = embedUrl;
        }

        modal.style.display = 'flex';
        // Allow transition to kick in
        requestAnimationFrame(() => {
            modal.classList.add('active');
        });
        document.body.style.overflow = 'hidden';
    };

    window.closeLoginVideoModal = function() {
        const modal = document.getElementById('loginVideoModal');
        const iframe = document.getElementById('loginVideoIframe');
        if (!modal) return;

        // Remember if user selected don't show again
        const dontShowCheck = document.getElementById('dontShowVideoAgainCheck');
        if (dontShowCheck && dontShowCheck.checked) {
            try {
                localStorage.setItem('sl_dismissed_welcome_video', '1');
            } catch (e) {}
        }

        modal.classList.remove('active');
        setTimeout(() => {
            modal.style.display = 'none';
            if (iframe) {
                iframe.src = ''; // Stop video audio
            }
            document.body.style.overflow = '';
        }, 300);
    };

    // Close on click outside
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('loginVideoModal');
        if (modal && e.target === modal) {
            closeLoginVideoModal();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('loginVideoModal');
            if (modal && modal.classList.contains('active')) {
                closeLoginVideoModal();
            }
        }
    });

    // Auto-open on page load if flagged
    document.addEventListener('DOMContentLoaded', function() {
        const autoShow = {{ $autoShow ? 'true' : 'false' }};
        let dismissed = false;
        try {
            dismissed = localStorage.getItem('sl_dismissed_welcome_video') === '1';
        } catch (e) {}

        // If explicitly previewing from Super Admin, ignore dismissal
        const isPreview = window.location.search.includes('preview_video_popup=1');

        if (autoShow && (!dismissed || isPreview)) {
            setTimeout(() => {
                window.openLoginVideoModal();
            }, 600);
        }
    });
</script>

