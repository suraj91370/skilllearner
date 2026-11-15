<!-- ===================================================================
     FULLSCREEN WELCOME INTRO OVERLAY
     Sequence: 10s Countdown -> Side 🎉 Emojis & Fullscreen Welcome -> Reveal Website
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
         STAGE 1: 10 SECONDS COUNTDOWN
         =============================================================== -->
    <div id="introCountdownStage" class="intro-stage active">
        <!-- Brand Logo -->
        <div class="intro-logo-box">
            <img src="{{ asset(\App\Models\Setting::get('site_logo', 'images/logo.png')) }}" alt="SkillLearner" class="intro-brand-logo">
        </div>

        <div class="intro-pill-badge">
            <span class="intro-pill-dot"></span>
            <span>GET READY TO LEARN &amp; EARN</span>
        </div>

        <!-- Animated Circular Countdown Ring -->
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
                <span id="introCountdownNumber" class="timer-number">10</span>
                <span class="timer-unit">SEC</span>
            </div>
        </div>

        <!-- Tagline below timer -->
        <h2 class="intro-countdown-title">
            Preparing Your Learning Experience...
        </h2>
        <p class="intro-countdown-subtitle">
            Welcome to India's trusted platform for digital skills &amp; career growth.
        </p>
    </div>

    <!-- ===============================================================
         STAGE 2: GRAND FULLSCREEN WELCOME & 🎉 EMOJI BURST
         =============================================================== -->
    <div id="introWelcomeStage" class="intro-stage">
        <div class="welcome-card-inner">
            <!-- Celebration Top Icons -->
            <div class="welcome-emojis-header">
                <span class="welcome-icon-pop left-pop">🎉</span>
                <span class="welcome-icon-pop center-pop">🥳</span>
                <span class="welcome-icon-pop right-pop">🎉</span>
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

            <!-- Loading / Entering Indicator -->
            <div class="welcome-entering-pill">
                <span class="entering-spinner"></span>
                <span>Opening Website Now...</span>
            </div>
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
    overflow: hidden;
    color: #ffffff;
    font-family: inherit;
    box-sizing: border-box;
    opacity: 1;
    transform: scale(1);
    transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1), transform 0.85s cubic-bezier(0.16, 1, 0.3, 1), filter 0.85s ease;
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

/* Stage containers */
.intro-stage {
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 2rem 1.5rem;
    max-width: 850px;
    width: 100%;
    box-sizing: border-box;
    position: relative;
    z-index: 10;
}
.intro-stage.active {
    display: flex;
    animation: stageFadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes stageFadeIn {
    from { opacity: 0; transform: scale(0.92); }
    to { opacity: 1; transform: scale(1); }
}

/* Stage 1: Countdown Layout */
.intro-logo-box {
    margin-bottom: 1.25rem;
}
.intro-brand-logo {
    max-width: 190px;
    height: auto;
    object-fit: contain;
    filter: drop-shadow(0 6px 20px rgba(5, 179, 150, 0.4));
}

.intro-pill-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(5, 179, 150, 0.15);
    border: 1px solid rgba(5, 179, 150, 0.4);
    color: #34d399;
    font-size: 0.74rem;
    font-weight: 800;
    letter-spacing: 1px;
    padding: 5px 15px;
    border-radius: 30px;
    margin-bottom: 1.8rem;
    text-transform: uppercase;
}
.intro-pill-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #34d399;
    box-shadow: 0 0 10px #34d399;
    animation: dotPulse 1.2s infinite ease-in-out;
}
@keyframes dotPulse {
    0%, 100% { opacity: 0.4; transform: scale(0.9); }
    50% { opacity: 1; transform: scale(1.3); }
}

/* Circular Timer */
.intro-timer-container {
    position: relative;
    width: 190px;
    height: 190px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.8rem;
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
    stroke: rgba(255, 255, 255, 0.1);
    stroke-width: 9;
}
.timer-circle-bar {
    fill: none;
    stroke: url(#timerGrad);
    stroke-width: 9;
    stroke-linecap: round;
    /* Circumference for r=86 is ~540.35 */
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
    font-size: 4.8rem;
    font-weight: 950;
    line-height: 1;
    color: #ffffff;
    letter-spacing: -2px;
    text-shadow: 0 0 35px rgba(5, 179, 150, 0.7);
    transition: transform 0.2s ease;
}
.timer-number.pop {
    animation: numberTickPop 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes numberTickPop {
    0% { transform: scale(1.28); color: #34d399; }
    100% { transform: scale(1); color: #ffffff; }
}

.timer-unit {
    font-size: 0.72rem;
    font-weight: 900;
    color: #94a3b8;
    letter-spacing: 1.8px;
    margin-top: 4px;
}

.intro-countdown-title {
    font-size: 1.55rem;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 0.5rem;
    letter-spacing: -0.3px;
}
.intro-countdown-subtitle {
    font-size: 0.95rem;
    color: #94a3b8;
    max-width: 520px;
    margin: 0 auto;
    line-height: 1.5;
}

/* Stage 2: Grand Welcome Card */
.welcome-card-inner {
    background: rgba(255, 255, 255, 0.04);
    border: 1.5px solid rgba(5, 179, 150, 0.35);
    border-radius: 28px;
    padding: 3rem 2.2rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4), 0 0 40px rgba(5, 179, 150, 0.15);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    max-width: 760px;
    width: 100%;
    animation: welcomeCardZoom 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes welcomeCardZoom {
    0% { transform: scale(0.85); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

.welcome-emojis-header {
    display: flex;
    justify-content: center;
    gap: 16px;
    font-size: 3.2rem;
    margin-bottom: 0.8rem;
}
.welcome-icon-pop {
    display: inline-block;
    filter: drop-shadow(0 4px 15px rgba(245, 158, 11, 0.5));
}
.left-pop { animation: popBounceLeft 1s infinite alternate ease-in-out; }
.center-pop { animation: popBounceCenter 1.1s infinite alternate ease-in-out 0.2s; }
.right-pop { animation: popBounceRight 1s infinite alternate ease-in-out 0.4s; }

@keyframes popBounceLeft {
    from { transform: translateY(0) rotate(-15deg); }
    to { transform: translateY(-12px) rotate(-5deg); }
}
@keyframes popBounceCenter {
    from { transform: translateY(0) scale(1); }
    to { transform: translateY(-16px) scale(1.15); }
}
@keyframes popBounceRight {
    from { transform: translateY(0) rotate(15deg); }
    to { transform: translateY(-12px) rotate(5deg); }
}

.welcome-badge-glow {
    display: inline-flex;
    padding: 4px 14px;
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(5, 179, 150, 0.2) 100%);
    border: 1px solid rgba(245, 158, 11, 0.5);
    border-radius: 20px;
    font-size: 0.76rem;
    font-weight: 800;
    color: #fef08a;
    letter-spacing: 1px;
    margin-bottom: 1.25rem;
}

.welcome-grand-heading {
    font-size: clamp(2.2rem, 5.5vw, 3.8rem);
    font-weight: 950;
    line-height: 1.15;
    letter-spacing: -1px;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #ffffff 0%, #34d399 38%, #fef08a 70%, #ffffff 100%);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: shineHeading 4s linear infinite;
    text-shadow: 0 0 35px rgba(5, 179, 150, 0.5);
}
@keyframes shineHeading {
    to { background-position: 200% center; }
}

.welcome-grand-tagline {
    font-size: clamp(1.1rem, 2.5vw, 1.45rem);
    font-weight: 700;
    color: #e2e8f0;
    margin-bottom: 0.8rem;
}
.brand-highlight {
    color: #34d399;
    text-decoration: underline;
    text-decoration-color: #f59e0b;
}

.welcome-grand-description {
    font-size: 0.98rem;
    color: #94a3b8;
    max-width: 580px;
    margin: 0 auto 1.8rem;
    line-height: 1.6;
}

.welcome-entering-pill {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(5, 179, 150, 0.16);
    border: 1.5px solid #05B396;
    color: #34d399;
    font-size: 0.88rem;
    font-weight: 800;
    padding: 8px 22px;
    border-radius: 50px;
    box-shadow: 0 4px 18px rgba(5, 179, 150, 0.3);
}
.entering-spinner {
    width: 14px;
    height: 14px;
    border: 2px solid rgba(52, 211, 153, 0.3);
    border-top-color: #34d399;
    border-radius: 50%;
    animation: enterSpin 0.75s linear infinite;
}
@keyframes enterSpin {
    to { transform: rotate(360deg); }
}

/* ===================================================================
   SIDE FLYING 🎉 EMOJIS (FROM LEFT & RIGHT SIDES)
   =================================================================== */
.side-emoji-stream {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 50vw;
    pointer-events: none;
    overflow: hidden;
    z-index: 15;
}
.stream-left { left: 0; }
.stream-right { right: 0; }

.flying-emoji-item {
    position: absolute;
    user-select: none;
    pointer-events: none;
    will-change: transform, opacity;
}

/* Left fly-in animation */
@keyframes flyFromLeft {
    0% {
        opacity: 0;
        transform: translate3d(-60px, var(--flyY), 0) scale(0.3) rotate(0deg);
    }
    15% {
        opacity: 1;
    }
    75% {
        opacity: 1;
    }
    100% {
        opacity: 0;
        transform: translate3d(calc(32vw + 60px), calc(var(--flyY) + var(--driftY)), 0) scale(var(--finalScale)) rotate(var(--rot));
    }
}

/* Right fly-in animation */
@keyframes flyFromRight {
    0% {
        opacity: 0;
        transform: translate3d(60px, var(--flyY), 0) scale(0.3) rotate(0deg);
    }
    15% {
        opacity: 1;
    }
    75% {
        opacity: 1;
    }
    100% {
        opacity: 0;
        transform: translate3d(calc(-32vw - 60px), calc(var(--flyY) + var(--driftY)), 0) scale(var(--finalScale)) rotate(var(--rot));
    }
}

/* Responsive adjust */
@media (max-width: 640px) {
    .intro-timer-container {
        width: 160px;
        height: 160px;
        margin-bottom: 1.4rem;
    }
    .timer-number {
        font-size: 3.8rem;
    }
    .welcome-card-inner {
        padding: 2rem 1.25rem;
        border-radius: 20px;
    }
    .welcome-emojis-header {
        font-size: 2.5rem;
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
    const countdownStage = document.getElementById('introCountdownStage');
    const welcomeStage = document.getElementById('introWelcomeStage');
    const countdownNum = document.getElementById('introCountdownNumber');
    const timerCircle = document.getElementById('introTimerCircle');
    const leftStream = document.getElementById('introLeftEmojiStream');
    const rightStream = document.getElementById('introRightEmojiStream');

    const totalSeconds = 10;
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

    // Skip Button Event
    if (skipBtn) {
        skipBtn.addEventListener('click', function(e) {
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

        // Pick random emoji
        const randomChar = celebrationEmojis[Math.floor(Math.random() * celebrationEmojis.length)];
        emojiEl.textContent = randomChar;

        // Random Y start between 5% and 90% of screen height
        const startY = Math.random() * (window.innerHeight * 0.85) + 30;
        const driftY = (Math.random() - 0.5) * 160; // Up/down drift
        const duration = (Math.random() * 1.2 + 1.6).toFixed(2); // 1.6s to 2.8s
        const size = Math.floor(Math.random() * 26 + 28); // 28px to 54px
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

        // Remove element after flight completes
        setTimeout(function() {
            if (emojiEl.parentNode) {
                emojiEl.parentNode.removeChild(emojiEl);
            }
        }, duration * 1000 + 100);
    }

    // Function to start Stage 2: Grand Fullscreen Welcome
    function startWelcomeStage() {
        if (countdownInterval) clearInterval(countdownInterval);

        // Switch stages
        countdownStage.classList.remove('active');
        welcomeStage.classList.add('active');

        // Continuous streams of side emojis (Left & Right)
        // Fire initial wave immediately
        for (let i = 0; i < 6; i++) {
            setTimeout(function() {
                spawnSideEmoji('left');
                spawnSideEmoji('right');
            }, i * 80);
        }

        // Loop side emojis every 160ms
        emojiInterval = setInterval(function() {
            spawnSideEmoji('left');
            spawnSideEmoji('right');
        }, 160);

        // Keep welcome stage visible for ~4 seconds ("kuch sec tak") then open website
        setTimeout(function() {
            completeIntro();
        }, 4000);
    }

    // Update timer circle stroke
    function updateTimerProgress(sec) {
        if (!timerCircle) return;
        const progressFraction = (totalSeconds - sec) / totalSeconds;
        const offset = circumference * progressFraction;
        timerCircle.style.strokeDashoffset = offset;
    }

    // Start 10-second Countdown loop
    countdownInterval = setInterval(function() {
        remainingSeconds--;

        if (countdownNum) {
            countdownNum.textContent = remainingSeconds;
            countdownNum.classList.remove('pop');
            void countdownNum.offsetWidth; // Reflow for restart animation
            countdownNum.classList.add('pop');
        }

        updateTimerProgress(remainingSeconds);

        if (remainingSeconds <= 0) {
            clearInterval(countdownInterval);
            // Brief 200ms delay before exploding into welcome stage
            setTimeout(function() {
                startWelcomeStage();
            }, 250);
        }
    }, 1000);

})();
</script>
