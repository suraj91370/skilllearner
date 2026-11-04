import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const pagesDir = path.resolve(__dirname, 'pages');

const loginFilePath = path.join(pagesDir, 'login.html');
const loginHtml = fs.readFileSync(loginFilePath, 'utf-8');

// 1. Create Forgot Password Page Content Matching Uploaded Image
const forgotMainContent = `
<main>
    <!-- Page Banner Header -->
    <div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 2.5rem 1.5rem; text-align: center;">
        <h1 style="font-size: 2.2rem; font-weight: 800; color: #0f172a; margin-bottom: 0.4rem; letter-spacing: -0.5px;">Forgot Password</h1>
        <p style="font-size: 0.92rem; color: #64748b; font-weight: 600;">
            <a href="/" style="color: #64748b; text-decoration: none; transition: color 0.2s;">Home</a>
            <span style="margin: 0 8px; color: #94a3b8;">&gt;</span>
            <span style="color: #0f172a;">Forgot Password</span>
        </p>
    </div>

    <!-- Main Section Matching Uploaded Design -->
    <section style="background: #ffffff; padding: 4.5rem 1.5rem; min-height: 560px; display: flex; align-items: center; justify-content: center;">
        <div class="forgot-grid-container" style="max-width: 1040px; width: 100%; display: grid; grid-template-columns: 1.1fr 1fr; gap: 4rem; align-items: center;">
            
            <!-- Left Column: Illustration (Matching Uploaded Image) -->
            <div class="forgot-illustration-col" style="display: flex; justify-content: center; align-items: center;">
                <img src="/images/forgot-password-illustration.png" alt="Forgot Password Illustration" style="width: 100%; max-width: 480px; height: auto; object-fit: contain; display: block;">
            </div>

            <!-- Right Column: Reset Password Form -->
            <div style="display: flex; justify-content: center; width: 100%;">
                <div style="width: 100%; max-width: 440px;">
                    
                    <form onsubmit="event.preventDefault(); document.getElementById('clientResetSuccess').style.display='block'; document.getElementById('forgotFormInner').style.display='none';" id="forgotPasswordForm">
                        
                        <div id="forgotFormInner">
                            <!-- Email Address Input (Exact Match with Image) -->
                            <div style="margin-bottom: 1.4rem;">
                                <label for="resetEmail" style="display: block; font-size: 0.95rem; font-weight: 600; color: #334155; margin-bottom: 0.55rem;">
                                    Email Address
                                </label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="resetEmail" 
                                    required 
                                    placeholder="Enter your registered email" 
                                    value=""
                                    style="width: 100%; padding: 0.85rem 1.1rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; color: #0f172a; background: #ffffff; outline: none; box-sizing: border-box; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#05B396'; this.style.boxShadow='0 0 0 3px rgba(5, 179, 150, 0.15)';"
                                    onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';"
                                >
                            </div>

                            <!-- Send Reset Link Button (Exact Match with Image) -->
                            <button 
                                type="submit" 
                                id="resetSubmitBtn"
                                style="width: 100%; padding: 0.85rem 1.5rem; background: #05B396; border: none; border-radius: 8px; font-size: 1rem; font-weight: 700; color: #ffffff; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.3); display: flex; align-items: center; justify-content: center; gap: 8px;"
                                onmouseover="this.style.background='#049e84'; this.style.transform='translateY(-1px)';"
                                onmouseout="this.style.background='#05B396'; this.style.transform='none';"
                            >
                                <span>Send Reset Link</span>
                            </button>

                            <!-- Back to Login Link -->
                            <div style="text-align: center; margin-top: 1.6rem;">
                                <a href="/login" style="color: #64748b; font-size: 0.9rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: color 0.2s;" onmouseover="this.style.color='#0f172a'" onmouseout="this.style.color='#64748b'">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="19" y1="12" x2="5" y2="12"></line>
                                        <polyline points="12 19 5 12 12 5"></polyline>
                                    </svg>
                                    <span>Back to Login</span>
                                </a>
                            </div>
                        </div>

                        <!-- Success Confirmation Feedback -->
                        <div id="clientResetSuccess" style="display: none; background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 1.2rem; border-radius: 8px; font-size: 0.92rem; line-height: 1.5;">
                            <div style="font-weight: 800; font-size: 1rem; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#05B396" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span>Reset Link Dispatched!</span>
                            </div>
                            <div>A password reset link has been sent to your email address. Please check your inbox and spam folder.</div>
                            <div style="margin-top: 1rem;">
                                <a href="/login" style="color: #05B396; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                    &larr; Return to Login
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </section>
</main>
`;

// Extract <main>...</main> from login.html and replace with forgotMainContent
const mainRegex = /<main[\s\S]*?<\/main>/i;
let forgotHtml = loginHtml.replace(mainRegex, forgotMainContent);
forgotHtml = forgotHtml.replace(/<title>[\s\S]*?<\/title>/i, '<title>Forgot Password — SkillLearner</title>');

// Add responsive style for forgot-grid-container
if (!forgotHtml.includes('.forgot-grid-container')) {
    forgotHtml = forgotHtml.replace('</style>', `
    @media (max-width: 860px) {
        .forgot-grid-container {
            grid-template-columns: 1fr !important;
            gap: 2.5rem !important;
            padding: 1rem 0;
        }
        .forgot-illustration-col img {
            max-width: 340px !important;
        }
    }
    </style>`);
}

fs.writeFileSync(path.join(pagesDir, 'forgot-password.html'), forgotHtml, 'utf-8');
fs.writeFileSync(path.join(pagesDir, 'forget-password.html'), forgotHtml, 'utf-8');
console.log('✅ Created forgot-password.html and forget-password.html');

// 2. Update login.html, my-account.html, classroom.html:
// - placeholder="your@gmail.com"
// - value="" (no prefilled data)
// - password value=""
// - Forgot password link -> href="/forgot-password"
const loginPages = ['login.html', 'my-account.html', 'classroom.html'];

for (const p of loginPages) {
    const fPath = path.join(pagesDir, p);
    if (!fs.existsSync(fPath)) continue;
    let content = fs.readFileSync(fPath, 'utf-8');

    // Replace placeholder & values
    content = content.replace(/placeholder="user@skilllearner\.com"/gi, 'placeholder="your@gmail.com"');
    content = content.replace(/placeholder="username@gmail\.com"/gi, 'placeholder="your@gmail.com"');
    content = content.replace(/value="user@skilllearner\.com"/gi, 'value=""');
    content = content.replace(/value="password123"/gi, 'value=""');

    // Replace Forgot password javascript alert with link to /forgot-password
    content = content.replace(/<a\s+href="javascript:void\(0\)"\s+onclick="alert\('Password reset[^']*'\)"/gi, '<a href="/forgot-password"');

    fs.writeFileSync(fPath, content, 'utf-8');
    console.log(`✅ Updated credentials & forgot-password link in ${p}`);
}

console.log('🎉 Static pages setup completed!');

