@php
    $slug = $course['slug'] ?? '';
    
    // Choose banner configuration based on course slug
    $isVN = str_contains($slug, 'vn');
    $isEmail = str_contains($slug, 'mail');
    $isGraphic = str_contains($slug, 'graphic') || str_contains($slug, 'canva-pro');
    $isReel = str_contains($slug, 'reel');
    $isYoutube = str_contains($slug, 'youtube');
    $isVideo = str_contains($slug, 'video-marketing') || str_contains($slug, 'video-editing');
    $isSales = str_contains($slug, 'sales');
    $isComm = str_contains($slug, 'comm');
@endphp

@if($isVN)
    <!-- ================================================================= -->
    <!-- VN EDITING COURSE BANNER (Matches Image 1 Split Blue/Yellow Banner) -->
    <!-- ================================================================= -->
    <div class="vn-custom-banner" style="width: 100%; height: 100%; position: relative; overflow: hidden; display: flex; background: #002244; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
        <!-- Left 68%: Dark Royal Blue Section with Character Desk & Top Header -->
        <div style="flex: 1.8; position: relative; padding: 8px 10px; display: flex; flex-direction: column; justify-content: space-between; overflow: hidden; background: radial-gradient(circle at 30% 70%, #004488 0%, #001833 80%);">
            <!-- Header Pill Tag -->
            <div style="display: inline-block; align-self: flex-start; background: #0044cc; color: #ffffff; font-weight: 900; font-size: 0.68rem; padding: 2px 7px; border-radius: 4px; letter-spacing: 0.5px; text-transform: uppercase; box-shadow: 0 2px 5px rgba(0,0,0,0.3);">
                VN EDITING COURSE
            </div>

            <!-- Wave Lines & Grid Background Effect -->
            <svg style="position: absolute; right: 0; top: 0; bottom: 0; width: 60px; height: 100%; opacity: 0.4;" viewBox="0 0 60 180" fill="none">
                <path d="M0,0 Q30,90 60,180" stroke="#00ffff" stroke-width="2" />
                <path d="M15,0 Q45,90 75,180" stroke="#0088ff" stroke-width="1.5" />
            </svg>

            <!-- 3D Character Sitting at Desk Working on Monitor -->
            <div style="display: flex; align-items: flex-end; gap: 8px; z-index: 2; margin-top: 4px;">
                <!-- Character & Desk SVG -->
                <svg width="110" height="75" viewBox="0 0 110 75" fill="none">
                    <!-- Desk White Top -->
                    <rect x="35" y="46" width="60" height="4" rx="2" fill="#ffffff" />
                    <!-- Desk Leg -->
                    <rect x="62" y="50" width="6" height="22" fill="#cbd5e1" />
                    <rect x="42" y="70" width="46" height="3" rx="1.5" fill="#94a3b8" />
                    <!-- Monitor Screen on Desk -->
                    <rect x="46" y="24" width="34" height="20" rx="2" fill="#0f172a" stroke="#38bdf8" stroke-width="1.5" />
                    <!-- Screen Stand -->
                    <rect x="61" y="44" width="4" height="3" fill="#64748b" />
                    <!-- Video Timeline Bars on Screen -->
                    <rect x="49" y="38" width="28" height="2" rx="1" fill="#ec4899" />
                    <rect x="49" y="34" width="18" height="2" rx="1" fill="#38bdf8" />
                    <rect x="49" y="30" width="12" height="2" rx="1" fill="#facc15" />
                    <circle cx="68" cy="31" r="2" fill="#ef4444" />
                    
                    <!-- White Swivel Chair -->
                    <rect x="15" y="40" width="16" height="18" rx="4" fill="#ffffff" />
                    <rect x="22" y="58" width="3" height="14" fill="#94a3b8" />
                    <!-- Chair Wheels Base -->
                    <path d="M12,72 L34,72" stroke="#64748b" stroke-width="3" stroke-linecap="round" />
                    
                    <!-- 3D Sitting Character -->
                    <circle cx="24" cy="22" r="7" fill="#fcd34d" /> <!-- Head -->
                    <path d="M20,19 Q24,14 28,19" fill="#1e293b" /> <!-- Hair -->
                    <rect x="18" y="29" width="13" height="16" rx="3" fill="#ffffff" /> <!-- Shirt -->
                    <path d="M22,44 L28,54 L38,54" stroke="#1e293b" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" fill="none" /> <!-- Legs -->
                    <!-- Arms typing on desk -->
                    <path d="M24,33 L38,42 L48,44" stroke="#fcd34d" stroke-width="3.5" stroke-linecap="round" fill="none" />
                </svg>
            </div>
        </div>

        <!-- Curved Blue Wave Separator Arrow -->
        <div style="position: absolute; right: 29%; top: 48%; transform: translateY(-50%); z-index: 5;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
                <path d="M2 17 C 8 19, 14 16, 20 8" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-dasharray="2 3" />
                <path d="M16 6 L21 8 L18 12" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
            </svg>
        </div>

        <!-- Right 32%: Bright Electric Yellow Section with Rounded VN Square Badge -->
        <div style="flex: 1; background: #eaff04; display: flex; align-items: center; justify-content: center; position: relative; padding: 10px;">
            <!-- Rounded Yellow-Green VN App Icon Badge (Matches Image 1) -->
            <div style="width: 58px; height: 58px; border-radius: 14px; background: #eaff04; border: 3px solid #000000; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.25);">
                <span style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-weight: 900; font-size: 1.55rem; color: #000000; letter-spacing: -0.5px;">
                    VN
                </span>
            </div>
        </div>
    </div>

@else
    <!-- ================================================================= -->
    <!-- LUXURY ROYAL DARK NAVY & 3D EMBOSSED GOLD BANNER (Matches Image 1) -->
    <!-- ================================================================= -->
    <div class="luxury-gold-banner" style="width: 100%; height: 100%; position: relative; overflow: hidden; background: radial-gradient(circle at 45% 30%, #0d234d 0%, #061127 65%, #020713 100%); display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; box-sizing: border-box; font-family: 'Cinzel', 'Times New Roman', Georgia, serif;">
        
        <!-- Ornate Golden Outer Filigree Frame (Matches Image 1) -->
        <div style="position: absolute; inset: 4px; border: 1.5px solid #d4af37; border-radius: 6px; pointer-events: none; opacity: 0.85;"></div>
        <div style="position: absolute; inset: 7px; border: 0.8px solid #b8860b; border-radius: 4px; pointer-events: none; opacity: 0.45;"></div>

        <!-- Golden Ornate Corners -->
        <div style="position: absolute; top: 5px; left: 5px; width: 12px; height: 12px; border-top: 2px solid #ffd700; border-left: 2px solid #ffd700; pointer-events: none;"></div>
        <div style="position: absolute; top: 5px; right: 5px; width: 12px; height: 12px; border-top: 2px solid #ffd700; border-right: 2px solid #ffd700; pointer-events: none;"></div>
        <div style="position: absolute; bottom: 5px; left: 5px; width: 12px; height: 12px; border-bottom: 2px solid #ffd700; border-left: 2px solid #ffd700; pointer-events: none;"></div>
        <div style="position: absolute; bottom: 5px; right: 5px; width: 12px; height: 12px; border-bottom: 2px solid #ffd700; border-right: 2px solid #ffd700; pointer-events: none;"></div>

        <!-- Bottom-Right Glowing Golden Light Swirls & Waves -->
        <svg style="position: absolute; right: 0; bottom: 0; width: 140px; height: 80px; opacity: 0.35; pointer-events: none;" viewBox="0 0 140 80" fill="none">
            <path d="M-10,75 Q50,40 140,55" stroke="url(#goldWaves)" stroke-width="2" />
            <path d="M10,85 Q70,50 150,65" stroke="url(#goldWaves)" stroke-width="1.2" />
            <path d="M90,70 L105,62 L120,70" stroke="#ffd700" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M100,75 L115,67 L130,75" stroke="#ffd700" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <defs>
                <linearGradient id="goldWaves" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#fff275" />
                    <stop offset="50%" stop-color="#ffd700" />
                    <stop offset="100%" stop-color="#b8860b" />
                </linearGradient>
            </defs>
        </svg>

        <!-- LEFT SIDE: Golden Ornate Thematic Emblem / Laurel (Matches Image 1) -->
        <div style="width: 44%; display: flex; align-items: center; justify-content: center; z-index: 2; position: relative;">
            @if($isReel)
                <!-- Reel Mastery Red Circular Medallion with Film Gear -->
                <div style="position: relative; width: 66px; height: 66px; border-radius: 50%; background: radial-gradient(circle, #b91c1c 0%, #7f1d1d 65%, #450a0a 100%); border: 2.5px solid #ffd700; box-shadow: 0 0 18px rgba(255, 215, 0, 0.45); display: flex; align-items: center; justify-content: center;">
                    <div style="position: absolute; inset: 2px; border: 1px dashed #fef08a; border-radius: 50%; opacity: 0.7;"></div>
                    <!-- Film Projector / Scissors Icon -->
                    <span style="font-size: 1.7rem; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.7));">🎬</span>
                </div>
            @elseif($isGraphic)
                <!-- Canva Graphic Designing Laptop with Color Swatches & Pen Tool -->
                <div style="position: relative; width: 68px; height: 68px; border-radius: 50%; border: 2px solid #ffd700; background: radial-gradient(circle, #1e1b4b 0%, #0f172a 80%); box-shadow: 0 0 16px rgba(255, 215, 0, 0.35); display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 1.8rem; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.8));">🎨</span>
                </div>
            @elseif($isEmail)
                <!-- E-mail Marketing Laptop with Flying Envelopes & Ornate Oval Frame -->
                <div style="position: relative; width: 68px; height: 68px; border-radius: 50%; border: 2px solid #ffd700; background: radial-gradient(circle, #0e7490 0%, #0f172a 80%); box-shadow: 0 0 16px rgba(255, 215, 0, 0.35); display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 1.8rem; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.8));">✉️</span>
                </div>
            @elseif($isYoutube)
                <!-- Youtube Mastery Laptop & Golden Laurel / Play Button -->
                <div style="position: relative; width: 68px; height: 68px; border-radius: 50%; border: 2px solid #ffd700; background: radial-gradient(circle, #831843 0%, #0f172a 80%); box-shadow: 0 0 16px rgba(255, 215, 0, 0.35); display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 1.8rem; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.8));">▶️</span>
                </div>
            @elseif($isVideo)
                <!-- Video Marketing Studio Cameras, Lights & Monitors -->
                <div style="position: relative; width: 68px; height: 68px; border-radius: 50%; border: 2px solid #ffd700; background: radial-gradient(circle, #312e81 0%, #0f172a 80%); box-shadow: 0 0 16px rgba(255, 215, 0, 0.35); display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 1.8rem; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.8));">📹</span>
                </div>
            @elseif($isSales)
                <!-- Sales Mastery Laptop, Books & Justice Scales of Value -->
                <div style="position: relative; width: 68px; height: 68px; border-radius: 50%; border: 2px solid #ffd700; background: radial-gradient(circle, #78350f 0%, #0f172a 80%); box-shadow: 0 0 16px rgba(255, 215, 0, 0.35); display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 1.8rem; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.8));">⚖️</span>
                </div>
            @else
                <!-- Communication Skill Laptop, Books & Globe -->
                <div style="position: relative; width: 68px; height: 68px; border-radius: 50%; border: 2px solid #ffd700; background: radial-gradient(circle, #134e4a 0%, #0f172a 80%); box-shadow: 0 0 16px rgba(255, 215, 0, 0.35); display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 1.8rem; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.8));">🎙️</span>
                </div>
            @endif
        </div>

        <!-- RIGHT SIDE: Multi-Line 3D Embossed Golden Serif Typography (Matches Image 1) -->
        <div style="flex: 1; text-align: center; z-index: 2; padding-left: 6px;">
            @if($isReel)
                <div class="gold-emboss-text" style="font-size: 1.05rem; font-weight: 900; line-height: 1.15; letter-spacing: 1px;">
                    REEL<br>MASTERY<br><span style="font-size: 0.88rem;">COURSE</span>
                </div>
            @elseif($isGraphic)
                <div class="gold-emboss-text" style="font-size: 0.98rem; font-weight: 900; line-height: 1.15; letter-spacing: 0.8px;">
                    GRAPHIC<br>DESIGNING<br><span style="font-size: 0.88rem;">COURSE</span>
                </div>
            @elseif($isEmail)
                <div class="gold-emboss-text" style="font-size: 0.98rem; font-weight: 900; line-height: 1.15; letter-spacing: 0.8px;">
                    EMAIL<br>MARKETING<br><span style="font-size: 0.88rem;">COURSE</span>
                </div>
            @elseif($isYoutube)
                <div class="gold-emboss-text" style="font-size: 0.96rem; font-weight: 900; line-height: 1.15; letter-spacing: 0.8px;">
                    YOUTUBE<br>MASTERY<br><span style="font-size: 0.88rem;">COURSE</span>
                </div>
            @elseif($isVideo)
                <div class="gold-emboss-text" style="font-size: 0.96rem; font-weight: 900; line-height: 1.15; letter-spacing: 0.8px;">
                    VIDEO<br>MARKETING<br><span style="font-size: 0.88rem;">COURSE</span>
                </div>
            @elseif($isSales)
                <div class="gold-emboss-text" style="font-size: 1.02rem; font-weight: 900; line-height: 1.15; letter-spacing: 0.8px;">
                    SALES<br>MASTERY<br><span style="font-size: 0.88rem;">COURSE</span>
                </div>
            @else
                <div class="gold-emboss-text" style="font-size: 0.85rem; font-weight: 900; line-height: 1.18; letter-spacing: 0.6px;">
                    COMMUNICATION<br>SKILLS<br><span style="font-size: 0.85rem;">COURSE</span>
                </div>
            @endif

            <!-- Underline Accent Flourish -->
            <div style="display: flex; align-items: center; justify-content: center; gap: 4px; margin-top: 5px;">
                <span style="display: inline-block; width: 12px; height: 1px; background: #ffd700;"></span>
                <span style="color: #ffd700; font-size: 0.55rem;">✦</span>
                <span style="display: inline-block; width: 12px; height: 1px; background: #ffd700;"></span>
            </div>
        </div>
    </div>

    <style>
        .gold-emboss-text {
            background: linear-gradient(180deg, #fff7b2 0%, #ffd700 35%, #d4af37 70%, #996515 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.9));
            text-transform: uppercase;
        }
    </style>
@endif

