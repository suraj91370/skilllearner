<!-- ===================================================================
     FULLSCREEN WELCOME INTRO OVERLAY
     Design: "Bas Welcome Wala" (Grand Welcome Card + 30s Countdown Timer + 🎉 Side Emojis)
     Schedule: 12:00 PM Indian Standard Time (IST) on 24/11/2026
     =================================================================== -->
<div id="siteWelcomeIntro" class="welcome-intro-overlay" role="dialog" aria-modal="true" aria-label="Welcome to SkillLearner">
    <!-- Ambient Background Glow Accents -->
    <div class="intro-ambient-glow glow-emerald"></div>
    <div class="intro-ambient-glow glow-gold"></div>

    <!-- Quick Skip Button (Top Right) -->
    <button type="button" id="skipIntroBtn" class="intro-skip-btn" title="Skip Intro & Enter Website">
        <span>Skip Intro</span>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="13 17 18 12 13 7"></polyline>
            <polyline points="6 17 11 12 6 7"></polyline>
        </svg>
    </button>

    <!-- Side Emojis Container (Left & Right streams of 🎉 emojis) -->
    <div id="introLeftEmojiStream" class="side-emoji-stream stream-left" aria-hidden="true"></div>
    <div id="introRightEmojiStream" class="side-emoji-stream stream-right" aria-hidden="true"></div>

    <!-- ===============================================================
         GRAND WELCOME CARD (BAS WELCOME WALA WITH 30S TIMER)
         =============================================================== -->
    <div class="welcome-card-inner">
        <!-- Celebration Top Icons -->
        <div class="welcome-emojis-header">
            <span class="welcome-icon-pop left-pop">🎉</span>
            <span class="welcome-icon-pop center-pop">🥳</span>
            <span class="welcome-icon-pop right-pop">🎉</span>
        </div>

        <!-- Brand Logo -->
        <div class="intro-logo-box" style="margin-bottom: 0.9rem;">
            <img src="{{ asset(\App\Models\Setting::get('site_logo', 'images/logo.png')) }}" alt="SkillLearner" class="intro-brand-logo">
        </div>

        <div class="welcome-badge-glow">
            <span>✨ SPECIAL WELCOME ✨</span>
        </div>

        <!-- Grand Headline -->
        <h1 class="welcome-grand-heading">
            Welcome to Our Website!
        </h1>

        <!-- Brand Slogan -->
        <p class="welcome-grand-tagline">
            Build Skill, Build Future with <span class="brand-highlight">SkillLearner</span>
        </p>

        <p class="welcome-grand-description">
            Unlock high-demand courses, certified mentorship, and practical digital income opportunities.
        </p>

        <!-- Animated Circular Countdown Ring (30 SEC TIMER) -->
        <div class="intro-timer-container">
            <svg class="intro-timer-svg" viewBox="0 0 200 200">
                <defs>
                    <linearGradient id="timerGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#34d399" />
                        <stop offset="50%" stop-color="#05B396" />
                        <stop offset="100%" stop-color="#fbbf24" />
                    </linearGradient>
                </defs>
                <!-- Background Inactive Track -->
                <circle class="timer-circle-track" cx="100" cy="100" r="86" />
                <!-- Active Animated Progress Bar -->
                <circle class="timer-circle-bar" id="introTimerCircle" cx="100" cy="100" r="86" />
            </svg>
            <div class="intro-timer-content">
                <span id="introCountdownNumber" class="timer-number">{{ (int) \App\Models\Setting::get('welcome_intro_seconds', 30) }}</span>
                <span class="timer-unit">SEC</span>
            </div>
        </div>

        <!-- Auto-entry progress status -->
        <div style="font-size: 0.88rem; color: #cbd5e1; margin-bottom: 1.4rem; font-weight: 600;">
            Opening website in <span id="introSecondsText" style="color: #34d399; font-weight: 800;">{{ (int) \App\Models\Setting::get('welcome_intro_seconds', 30) }}</span> seconds...
        </div>

        <!-- Direct Enter Button -->
        <div>
            <button type="button" id="enterWebsiteBtn" class="welcome-enter-btn">
                <span>🚀 Enter Website Now</span>
            </button>
        </div>
    </div>
</div>

<style>
/* ===================================================================
   WELCOME INTRO PRELOADER STYLES
   =================================================================== */
.welcome-intro-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 9999999;
    background: radial-gradient(circle at center, #0B4F4A 0%, #031B18 55%, #000B09 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow-y: auto;
    overflow-x: hidden;
    color: #ffffff;
    font-family: inherit;
    box-sizing: border-box;
    opacity: 1;
    transform: scale(1);
    transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1), transform 0.85s cubic-bezier(0.16, 1, 0.3, 1), filter 0.85s ease;
    padding: 1.5rem;
}

.welcome-intro-overlay.fade-out {
    opacity: 0 !important;
    transform: scale(1.05) !important;
    filter: blur(8px) !important;
    pointer-events: none !important;
}

/* Ambient Radial Glow Orbs */
.intro-ambient-glow {
    position: absolute;
    width: 480px;
    height: 480px;
    border-radius: 50%;
    pointer-events: none;
    filter: blur(80px);
    opacity: 0.45;
}
.glow-emerald {
    top: -100px;
    left: -100px;
    background: radial-gradient(circle, rgba(5, 179, 150, 0.6) 0%, transparent 70%);
    animation: introGlowFloat1 7s ease-in-out infinite alternate;
}
.glow-gold {
    bottom: -100px;
    right: -100px;
    background: radial-gradient(circle, rgba(245, 158, 11, 0.45) 0%, transparent 70%);
    animation: introGlowFloat2 9s ease-in-out infinite alternate;
}

@keyframes introGlowFloat1 {
    from { transform: translate(0, 0) scale(1); }
    to { transform: translate(50px, 40px) scale(1.15); }
}
@keyframes introGlowFloat2 {
    from { transform: translate(0, 0) scale(1); }
    to { transform: translate(-40px, -50px) scale(1.2); }
}

/* Skip Intro Pill Button */
.intro-skip-btn {
    position: absolute;
    top: 24px;
    right: 24px;
    z-index: 100;
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.28);
    color: #ffffff;
    font-size: 0.85rem;
    font-weight: 800;
    letter-spacing: 0.3px;
    padding: 8px 18px;
    border-radius: 50px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: all 0.25s ease;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.25);
}
.intro-skip-btn:hover {
    background: #05B396;
    border-color: #05B396;
    transform: translateY(-2px);
    box-shadow: 0 6px 22px rgba(5, 179, 150, 0.45);
}

/* Brand Logo */
.intro-logo-box {
    margin-bottom: 0.8rem;
}
.intro-brand-logo {
    max-width: 175px;
    height: auto;
    object-fit: contain;
    filter: drop-shadow(0 6px 20px rgba(5, 179, 150, 0.4));
}

/* Grand Welcome Card */
.welcome-card-inner {
    background: rgba(255, 255, 255, 0.05);
    border: 1.5px solid rgba(5, 179, 150, 0.4);
    border-radius: 28px;
    padding: 2.8rem 2.2rem 2.5rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5), 0 0 50px rgba(5, 179, 150, 0.2);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    max-width: 680px;
    width: 100%;
    margin: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    box-sizing: border-box;
    position: relative;
    z-index: 10;
    animation: welcomeCardZoom 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes welcomeCardZoom {
    0% { transform: scale(0.85); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

.welcome-emojis-header {
    display: flex;
    gap: 16px;
    font-size: 3rem;
    margin-bottom: 0.75rem;
    filter: drop-shadow(0 8px 18px rgba(0, 0, 0, 0.35));
}
.welcome-icon-pop {
    display: inline-block;
    animation: popBounce 2s ease-in-out infinite;
}
.left-pop { animation-delay: 0s; }
.center-pop { animation-delay: 0.3s; }
.right-pop { animation-delay: 0.6s; }

@keyframes popBounce {
    0%, 100% { transform: translateY(0) scale(1) rotate(0deg); }
    50% { transform: translateY(-10px) scale(1.15) rotate(6deg); }
}

.welcome-badge-glow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.25) 0%, rgba(217, 119, 6, 0.3) 100%);
    border: 1px solid rgba(245, 158, 11, 0.6);
    color: #fbbf24;
    font-size: 0.75rem;
    font-weight: 900;
    letter-spacing: 1.2px;
    padding: 6px 18px;
    border-radius: 30px;
    margin-bottom: 1.2rem;
    box-shadow: 0 0 20px rgba(245, 158, 11, 0.3);
}

.welcome-grand-heading {
    font-size: 2.35rem;
    font-weight: 900;
    color: #ffffff;
    margin: 0 0 0.5rem;
    letter-spacing: -0.6px;
    line-height: 1.2;
    text-shadow: 0 4px 18px rgba(0, 0, 0, 0.4);
}

.welcome-grand-tagline {
    font-size: 1.15rem;
    font-weight: 700;
    color: #e2e8f0;
    margin: 0 0 0.75rem;
}
.brand-highlight {
    color: #34d399;
    font-weight: 900;
    text-shadow: 0 0 16px rgba(52, 211, 153, 0.6);
}

.welcome-grand-description {
    font-size: 0.95rem;
    color: #94a3b8;
    max-width: 520px;
    margin: 0 auto 1.4rem;
    line-height: 1.55;
}

/* 30-Second Circular Countdown Timer Ring */
.intro-timer-container {
    position: relative;
    width: 150px;
    height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.2rem;
}
.intro-timer-svg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    transform: rotate(-90deg);
}
.timer-circle-track {
    fill: none;
    stroke: rgba(255, 255, 255, 0.12);
    stroke-width: 8;
}
.timer-circle-bar {
    fill: none;
    stroke: url(#timerGrad);
    stroke-width: 8;
    stroke-linecap: round;
    stroke-dasharray: 540.35;
    stroke-dashoffset: 0;
    transition: stroke-dashoffset 1s linear;
    filter: drop-shadow(0 0 10px rgba(5, 179, 150, 0.65));
}

.intro-timer-content {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.timer-number {
    font-size: 3.4rem;
    font-weight: 950;
    line-height: 1;
    color: #ffffff;
    letter-spacing: -1.5px;
    text-shadow: 0 0 25px rgba(5, 179, 150, 0.7);
    transition: transform 0.2s ease;
}
.timer-number.pop {
    animation: numberTickPop 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes numberTickPop {
    0% { transform: scale(1.25); color: #34d399; }
    100% { transform: scale(1); color: #ffffff; }
}

.timer-unit {
    font-size: 0.72rem;
    font-weight: 900;
    color: #94a3b8;
    letter-spacing: 1.8px;
    margin-top: 3px;
}

/* Direct Enter Button */
.welcome-enter-btn {
    background: linear-gradient(135deg, #05B396 0%, #047857 100%);
    color: #ffffff;
    border: none;
    font-size: 1rem;
    font-weight: 800;
    padding: 12px 34px;
    border-radius: 50px;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(5, 179, 150, 0.45);
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    letter-spacing: 0.3px;
}
.welcome-enter-btn:hover {
    transform: translateY(-2px) scale(1.03);
    box-shadow: 0 12px 30px rgba(5, 179, 150, 0.65);
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

/* Side Flying Emojis */
.side-emoji-stream {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 140px;
    pointer-events: none;
    overflow: hidden;
    z-index: 5;
}
.stream-left { left: 0; }
.stream-right { right: 0; }

.flying-emoji-item {
    position: absolute;
    user-select: none;
    pointer-events: none;
    filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.4));
    will-change: transform, opacity;
}

@keyframes flyFromLeft {
    0% {
        opacity: 0;
        transform: translate3d(-60px, var(--flyY), 0) scale(0.3) rotate(0deg);
    }
    15% { opacity: 1; }
    75% { opacity: 1; }
    100% {
        opacity: 0;
        transform: translate3d(calc(32vw + 60px), calc(var(--flyY) + var(--driftY)), 0) scale(var(--finalScale)) rotate(var(--rot));
    }
}

@keyframes flyFromRight {
    0% {
        opacity: 0;
        transform: translate3d(60px, var(--flyY), 0) scale(0.3) rotate(0deg);
    }
    15% { opacity: 1; }
    75% { opacity: 1; }
    100% {
        opacity: 0;
        transform: translate3d(calc(-32vw - 60px), calc(var(--flyY) + var(--driftY)), 0) scale(var(--finalScale)) rotate(var(--rot));
    }
}

/* Responsive adjust */
@media (max-width: 640px) {
    .welcome-card-inner {
        padding: 2rem 1.25rem 1.8rem;
        border-radius: 22px;
    }
    .welcome-grand-heading {
        font-size: 1.85rem;
    }
    .welcome-emojis-header {
        font-size: 2.3rem;
    }
    .intro-timer-container {
        width: 130px;
        height: 130px;
        margin-bottom: 1rem;
    }
    .timer-number {
        font-size: 2.8rem;
    }
    .welcome-enter-btn {
        padding: 10px 26px;
        font-size: 0.92rem;
    }
    .intro-skip-btn {
        top: 14px;
        right: 14px;
        padding: 6px 14px;
        font-size: 0.78rem;
    }
}
</style>

<script>
(function() {
    // Prevent double execution
    if (window.__siteWelcomeIntroInitialized) return;
    window.__siteWelcomeIntroInitialized = true;

    const overlay = document.getElementById('siteWelcomeIntro');
    if (!overlay) return;

    // Lock body scroll while intro is playing
    const originalBodyOverflow = document.body.style.overflow;
    document.body.style.overflow = 'hidden';

    const skipBtn = document.getElementById('skipIntroBtn');
    const enterBtn = document.getElementById('enterWebsiteBtn');
    const countdownNum = document.getElementById('introCountdownNumber');
    const secondsText = document.getElementById('introSecondsText');
    const timerCircle = document.getElementById('introTimerCircle');
    const leftStream = document.getElementById('introLeftEmojiStream');
    const rightStream = document.getElementById('introRightEmojiStream');

    const totalSeconds = {{ (int) \App\Models\Setting::get('welcome_intro_seconds', 30) }};
    let remainingSeconds = totalSeconds;
    const circumference = 540.35; // 2 * PI * 86
    let countdownInterval = null;
    let emojiInterval = null;
    let isFinished = false;

    // Function to dismiss and reveal website
    function completeIntro() {
        if (isFinished) return;
        isFinished = true;

        if (countdownInterval) clearInterval(countdownInterval);
        if (emojiInterval) clearInterval(emojiInterval);

        // Smooth fade-out & blur scale
        overlay.classList.add('fade-out');

        // Unlock scroll
        document.body.style.overflow = originalBodyOverflow;

        setTimeout(function() {
            if (overlay && overlay.parentNode) {
                overlay.style.display = 'none';
            }
        }, 900);
    }

    // Enter & Skip Button Events
    if (skipBtn) {
        skipBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            completeIntro();
        });
    }

    if (enterBtn) {
        enterBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            completeIntro();
        });
    }

    // Keyboard ESC key to skip
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !isFinished) {
            completeIntro();
        }
    });

    // Spawn animated 🎉 emojis from left and right edges
    const celebrationEmojis = ['🎉', '🥳', '✨', '🎊', '🎉', '🎈', '⭐', '🎉', '🌟'];

    function spawnSideEmoji(side) {
        if (isFinished) return;
        const container = side === 'left' ? leftStream : rightStream;
        if (!container) return;

        const emojiEl = document.createElement('div');
        emojiEl.className = 'flying-emoji-item';

        const randomChar = celebrationEmojis[Math.floor(Math.random() * celebrationEmojis.length)];
        emojiEl.textContent = randomChar;

        const startY = Math.random() * (window.innerHeight * 0.85) + 30;
        const driftY = (Math.random() - 0.5) * 160;
        const duration = (Math.random() * 1.2 + 1.6).toFixed(2);
        const size = Math.floor(Math.random() * 26 + 28);
        const finalScale = (Math.random() * 0.5 + 1.0).toFixed(2);
        const rot = side === 'left' ? Math.floor(Math.random() * 360 + 180) + 'deg' : '-' + Math.floor(Math.random() * 360 + 180) + 'deg';

        emojiEl.style.fontSize = size + 'px';
        emojiEl.style.top = startY + 'px';
        if (side === 'left') {
            emojiEl.style.left = '0px';
            emojiEl.style.animation = 'flyFromLeft ' + duration + 's cubic-bezier(0.25, 1, 0.5, 1) forwards';
        } else {
            emojiEl.style.right = '0px';
            emojiEl.style.animation = 'flyFromRight ' + duration + 's cubic-bezier(0.25, 1, 0.5, 1) forwards';
        }

        emojiEl.style.setProperty('--flyY', '0px');
        emojiEl.style.setProperty('--driftY', driftY + 'px');
        emojiEl.style.setProperty('--finalScale', finalScale);
        emojiEl.style.setProperty('--rot', rot);

        container.appendChild(emojiEl);

        setTimeout(function() {
            if (emojiEl.parentNode) {
                emojiEl.parentNode.removeChild(emojiEl);
            }
        }, duration * 1000 + 100);
    }

    // Start celebration emojis immediately
    for (let i = 0; i < 5; i++) {
        setTimeout(function() {
            spawnSideEmoji('left');
            spawnSideEmoji('right');
        }, i * 100);
    }

    emojiInterval = setInterval(function() {
        spawnSideEmoji('left');
        spawnSideEmoji('right');
    }, 280);

    // Update timer circle stroke
    function updateTimerProgress(sec) {
        if (!timerCircle) return;
        const progressFraction = (totalSeconds - sec) / totalSeconds;
        const offset = circumference * progressFraction;
        timerCircle.style.strokeDashoffset = offset;
    }

    // Start 30-second Countdown loop
    countdownInterval = setInterval(function() {
        remainingSeconds--;

        if (countdownNum) {
            countdownNum.textContent = remainingSeconds;
            countdownNum.classList.remove('pop');
            void countdownNum.offsetWidth;
            countdownNum.classList.add('pop');
        }

        if (secondsText) {
            secondsText.textContent = remainingSeconds;
        }

        updateTimerProgress(remainingSeconds);

        if (remainingSeconds <= 0) {
            clearInterval(countdownInterval);
            setTimeout(function() {
                completeIntro();
            }, 300);
        }
    }, 1000);

})();
</script>
