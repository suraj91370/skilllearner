@php
    $loginVideoUrl = \App\Models\Setting::get('login_video_url', 'https://youtu.be/0VKDTph4Kqw?si=T7r0ira8-vQd-lUc');
    $loginVideoEmbed = \App\Models\Setting::formatEmbedUrl($loginVideoUrl);
    $loginVideoTitle = \App\Models\Setting::get('login_video_title', 'Welcome to SkillLearner! Watch This First');
    $loginVideoDesc = \App\Models\Setting::get('login_video_description', 'Get started with your courses, explore your affiliate dashboard, and maximize your learning journey.');
    $loginVideoEnabled = (string) \App\Models\Setting::get('login_video_enabled', '1') === '1';
    $autoShow = $loginVideoEnabled && (session('show_login_video_popup', false) || request()->query('preview_video_popup') === '1');
    
    $currentUser = auth()->user() ?? session('user');
    $isSuperOrAdmin = false;
    if ($currentUser) {
        $cRole = strtolower((string) ($currentUser->role ?? $currentUser['role'] ?? ''));
        $isSuperOrAdmin = in_array($cRole, ['super_admin', 'admin', 'staff']) || (! empty($currentUser->is_staff ?? $currentUser['is_staff'] ?? false));
    }
@endphp

<!-- Login Welcome Video Popup Modal -->
<div id="loginVideoModal" class="login-video-modal-overlay" style="display: none;" role="dialog" aria-modal="true" aria-labelledby="loginVideoModalTitle">
    <div class="login-video-modal-box">
        <!-- Modal Header -->
        <div class="login-video-modal-header">
            <div style="display: flex; align-items: center; gap: 10px; min-width: 0; flex: 1;">
                <span class="video-badge-icon">🎬</span>
                <div style="min-width: 0;">
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <h3 id="loginVideoModalTitle" class="login-video-title">{{ $loginVideoTitle }}</h3>
                        @if($isSuperOrAdmin)
                            <button type="button" onclick="openAdminQuickEditWelcomeVideo()" style="background: rgba(124, 58, 237, 0.25); border: 1.5px solid rgba(167, 139, 250, 0.5); color: #c4b5fd; font-size: 0.74rem; font-weight: 800; padding: 3px 10px; border-radius: 20px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;" title="Admin Quick Edit: Change this video URL and title">
                                <span>✏️ Admin: Edit Video</span>
                            </button>
                        @endif
                    </div>
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

    @if($isSuperOrAdmin)
    window.openAdminQuickEditWelcomeVideo = function() {
        const modal = document.getElementById('adminQuickEditWelcomeVideoModal');
        if (modal) {
            modal.style.display = 'flex';
            requestAnimationFrame(() => modal.classList.add('active'));
        }
    };

    window.closeAdminQuickEditWelcomeVideo = function() {
        const modal = document.getElementById('adminQuickEditWelcomeVideoModal');
        if (modal) {
            modal.classList.remove('active');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 250);
        }
    };

    window.submitAdminQuickEditWelcomeVideo = function(e) {
        e.preventDefault();
        const btn = document.getElementById('quick_edit_save_btn');
        const origText = btn ? btn.innerText : 'Save';
        if (btn) { btn.disabled = true; btn.innerText = 'Saving...'; }

        const title = document.getElementById('quick_edit_welcome_title').value;
        const url = document.getElementById('quick_edit_welcome_url').value;
        const desc = document.getElementById('quick_edit_welcome_desc').value;
        const enabled = document.getElementById('quick_edit_welcome_enabled').checked ? 1 : 0;

        fetch('{{ url("/admin/videos/welcome-video") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                login_video_title: title,
                login_video_url: url,
                login_video_description: desc,
                login_video_enabled: enabled
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success && data.data) {
                // Update title & subtitle live on popup
                const titleEl = document.getElementById('loginVideoModalTitle');
                if (titleEl) titleEl.innerText = data.data.title;
                const subtitleEl = document.querySelector('.login-video-subtitle');
                if (subtitleEl) subtitleEl.innerText = data.data.description;

                // Update iframe player live with new embed URL
                const iframe = document.getElementById('loginVideoIframe');
                if (iframe) {
                    iframe.setAttribute('data-embed-url', data.data.embed_url);
                    iframe.src = data.data.embed_url;
                }

                closeAdminQuickEditWelcomeVideo();
                alert('✅ Welcome orientation video updated successfully!');
            } else {
                alert(data.message || 'Error updating video');
            }
        })
        .catch(err => {
            alert('Server error updating welcome video. Please try again.');
        })
        .finally(() => {
            if (btn) { btn.disabled = false; btn.innerText = origText; }
        });
    };
    @endif
</script>

@if($isSuperOrAdmin)
<!-- Super Admin Quick Live Edit Modal for Welcome Video -->
<div id="adminQuickEditWelcomeVideoModal" class="login-video-modal-overlay" style="display: none; z-index: 99999999;" role="dialog" aria-modal="true" aria-labelledby="quickEditModalTitle">
    <div class="login-video-modal-box" style="max-width: 520px; background: #0f172a; border: 1.5px solid #7c3aed; padding: 1.8rem; border-radius: 18px; box-shadow: 0 25px 60px rgba(0,0,0,0.8);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.8rem;">
            <div>
                <span style="font-size: 0.72rem; font-weight: 800; color: #a78bfa; text-transform: uppercase; letter-spacing: 0.5px;">ADMIN LIVE SETTINGS</span>
                <h4 id="quickEditModalTitle" style="font-size: 1.18rem; font-weight: 800; color: #ffffff; margin: 3px 0 0;">Change Welcome Video</h4>
            </div>
            <button type="button" onclick="closeAdminQuickEditWelcomeVideo()" style="background: none; border: none; font-size: 1.6rem; color: #94a3b8; cursor: pointer;">&times;</button>
        </div>

        <form id="adminQuickEditWelcomeVideoForm" onsubmit="submitAdminQuickEditWelcomeVideo(event)">
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #e2e8f0; margin-bottom: 0.35rem;">
                    Video Popup Title <span style="color: #f43f5e;">*</span>
                </label>
                <input type="text" id="quick_edit_welcome_title" required value="{{ $loginVideoTitle }}" class="clean-form-input" style="background: #1e293b; border: 1px solid #334155; color: #ffffff; width: 100%; padding: 0.6rem 0.8rem; border-radius: 8px; font-size: 0.88rem; outline: none; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #e2e8f0; margin-bottom: 0.35rem;">
                    Video Stream / YouTube URL <span style="color: #f43f5e;">*</span>
                </label>
                <input type="url" id="quick_edit_welcome_url" required value="{{ $loginVideoUrl }}" placeholder="https://www.youtube.com/watch?v=..." class="clean-form-input" style="background: #1e293b; border: 1px solid #334155; color: #ffffff; width: 100%; padding: 0.6rem 0.8rem; border-radius: 8px; font-size: 0.88rem; outline: none; box-sizing: border-box;">
                <span style="font-size: 0.72rem; color: #94a3b8; display: block; margin-top: 3px;">Accepts YouTube (regular/shorts/youtu.be), Vimeo, or direct MP4 stream URL.</span>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #e2e8f0; margin-bottom: 0.35rem;">
                    Subtitle / Description
                </label>
                <textarea id="quick_edit_welcome_desc" rows="2" class="clean-form-input" style="background: #1e293b; border: 1px solid #334155; color: #ffffff; width: 100%; padding: 0.6rem 0.8rem; border-radius: 8px; font-size: 0.88rem; outline: none; box-sizing: border-box; resize: vertical;">{{ $loginVideoDesc }}</textarea>
            </div>

            <div style="margin-bottom: 1.4rem; display: flex; align-items: center; justify-content: space-between; background: rgba(255,255,255,0.05); padding: 8px 12px; border-radius: 8px;">
                <span style="font-size: 0.82rem; color: #cbd5e1; font-weight: 600;">Auto-show on student login</span>
                <label style="display: inline-flex; align-items: center; cursor: pointer; margin: 0;">
                    <input type="checkbox" id="quick_edit_welcome_enabled" value="1" {{ $loginVideoEnabled ? 'checked' : '' }} style="accent-color: #05B396; width: 18px; height: 18px; cursor: pointer;">
                </label>
            </div>

            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                <button type="button" onclick="closeAdminQuickEditWelcomeVideo()" style="background: rgba(255,255,255,0.1); color: #e2e8f0; border: none; padding: 7px 14px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.82rem;">
                    Cancel
                </button>
                <button type="submit" id="quick_edit_save_btn" style="background: #05B396; color: #ffffff; border: none; padding: 7px 16px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.82rem;">
                    Save &amp; Update Live
                </button>
            </div>
        </form>
    </div>
</div>
@endif

