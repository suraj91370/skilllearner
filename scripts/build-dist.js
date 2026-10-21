import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const rootDir = path.resolve(__dirname, '..');
const distDir = path.resolve(rootDir, 'dist');
const publicDir = path.resolve(rootDir, 'public');
const cachedPagesDir = path.resolve(__dirname, 'pages');

console.log('🚀 Starting static build for AWS Amplify...');

// 1. Ensure dist and cached directories exist
if (fs.existsSync(distDir)) {
    fs.rmSync(distDir, { recursive: true, force: true });
}
fs.mkdirSync(distDir, { recursive: true });

if (!fs.existsSync(cachedPagesDir)) {
    fs.mkdirSync(cachedPagesDir, { recursive: true });
}

// 2. Copy public directory to dist (images, build, favicon, etc.)
function copyRecursiveSync(src, dest) {
    if (!fs.existsSync(src)) return;
    const stats = fs.statSync(src);
    if (stats.isDirectory()) {
        if (!fs.existsSync(dest)) fs.mkdirSync(dest, { recursive: true });
        fs.readdirSync(src).forEach((childItemName) => {
            copyRecursiveSync(path.join(src, childItemName), path.join(dest, childItemName));
        });
    } else {
        fs.copyFileSync(src, dest);
    }
}

copyRecursiveSync(publicDir, distDir);
console.log('✅ Copied public assets to dist/');

// 3. Define all application routes
const routes = [
    { url: '/', fileKey: 'index', isHome: true },
    { url: '/plans', fileKey: 'plans' },
    { url: '/programs', fileKey: 'programs' },
    { url: '/about', fileKey: 'about' },
    { url: '/contact', fileKey: 'contact' },
    { url: '/courses', fileKey: 'courses' },
    { url: '/buy-now', fileKey: 'buy-now' },
    { url: '/register', fileKey: 'register' },
    { url: '/login', fileKey: 'login' },
    { url: '/my-account', fileKey: 'my-account' },
    { url: '/classroom', fileKey: 'classroom' },
    { url: '/my-courses', fileKey: 'my-courses' },
    { url: '/dashboard', fileKey: 'dashboard' },
    { url: '/profile', fileKey: 'profile' },
    { url: '/social-community', fileKey: 'social-community' },
    { url: '/kyc', fileKey: 'kyc' },
    { url: '/affiliate-link', fileKey: 'affiliate-link' },
    { url: '/token-purchases', fileKey: 'token-purchases' },
    { url: '/affiliate-training', fileKey: 'affiliate-training' },
    { url: '/marketing-tool', fileKey: 'marketing-tool' },
    { url: '/my-payout', fileKey: 'my-payout' },
    { url: '/leaderboard', fileKey: 'leaderboard' },
    { url: '/team-leaderboard', fileKey: 'team-leaderboard' },
    { url: '/qualification', fileKey: 'qualification' },
    { url: '/certificates', fileKey: 'certificates' },
    { url: '/courses/affiliate-marketing-masterclass', fileKey: 'courses_affiliate-marketing-masterclass', subPath: 'courses/affiliate-marketing-masterclass' },
    { url: '/courses/ai-chatgpt-automation', fileKey: 'courses_ai-chatgpt-automation', subPath: 'courses/ai-chatgpt-automation' },
    { url: '/courses/short-form-video-editing', fileKey: 'courses_short-form-video-editing', subPath: 'courses/short-form-video-editing' },
    { url: '/courses/meta-ads-mastery', fileKey: 'courses_meta-ads-mastery', subPath: 'courses/meta-ads-mastery' },
    { url: '/courses/wordpress-landing-page-design', fileKey: 'courses_wordpress-landing-page-design', subPath: 'courses/wordpress-landing-page-design' },
    { url: '/courses/personal-branding-instagram-reels', fileKey: 'courses_personal-branding-instagram-reels', subPath: 'courses/personal-branding-instagram-reels' },
];

// Helper to write static file at both file.html and file/index.html for Amplify clean URLs
function writeHtmlFiles(subPath, html) {
    if (subPath === 'index') {
        fs.writeFileSync(path.resolve(distDir, 'index.html'), html, 'utf-8');
        fs.writeFileSync(path.resolve(distDir, '404.html'), html, 'utf-8');
        return;
    }

    // 1. Write file.html
    const flatFile = path.resolve(distDir, `${subPath}.html`);
    const flatDir = path.dirname(flatFile);
    if (!fs.existsSync(flatDir)) fs.mkdirSync(flatDir, { recursive: true });
    fs.writeFileSync(flatFile, html, 'utf-8');

    // 2. Write file/index.html
    const nestedDir = path.resolve(distDir, subPath);
    if (!fs.existsSync(nestedDir)) fs.mkdirSync(nestedDir, { recursive: true });
    fs.writeFileSync(path.resolve(nestedDir, 'index.html'), html, 'utf-8');
}

// 4. Check if local Laravel dev server is reachable
async function isLocalServerReachable() {
    try {
        const controller = new AbortController();
        const timeout = setTimeout(() => controller.abort(), 1200);
        const res = await fetch('http://127.0.0.1:8001/', { signal: controller.signal });
        clearTimeout(timeout);
        return res.ok;
    } catch {
        return false;
    }
}

function postProcessHtml(rawHtml) {
    return rawHtml
        .replace(/http:\/\/127\.0\.0\.1:8001\//g, '/')
        .replace(/http:\/\/localhost:8001\//g, '/')
        .replace(/http:\/\/127\.0\.0\.1:8001/g, '/')
        .replace(/http:\/\/localhost:8001/g, '/')
        .replace(/href=""/g, 'href="/"')
        .replace(/href=''/g, "href='/'")
        .replace(/method="POST"\s+action="\/login"/gi, 'onsubmit="event.preventDefault(); window.location.href=\'/my-courses\';"')
        .replace(/action="\/login"\s+method="POST"/gi, 'onsubmit="event.preventDefault(); window.location.href=\'/my-courses\';"')
        .replace(/method="POST"\s+action="\/register-user"/gi, 'onsubmit="event.preventDefault(); window.location.href=\'/dashboard\';"')
        .replace(/action="\/register-user"\s+method="POST"/gi, 'onsubmit="event.preventDefault(); window.location.href=\'/dashboard\';"')
        .replace(/href="\/simulate-sale"/gi, 'href="javascript:void(0)" onclick="alert(\'🎉 Direct Commission of ₹2,200 simulated and credited to your wallet!\'); window.location.reload();"')
        .replace(/href="\/logout"/gi, 'href="/login"');
}

async function build() {
    const isLocal = await isLocalServerReachable();
    console.log(isLocal ? '🌐 Fetching fresh Blade pages from http://127.0.0.1:8001...' : '📦 Using pre-rendered cached pages from scripts/pages/...');

    for (const r of routes) {
        const subPath = r.subPath || (r.isHome ? 'index' : r.url.replace(/^\//, ''));
        const cacheFile = path.resolve(cachedPagesDir, `${r.fileKey}.html`);
        let html = '';

        if (isLocal) {
            try {
                const res = await fetch(`http://127.0.0.1:8001${r.url}`);
                if (res.ok) {
                    const raw = await res.text();
                    html = postProcessHtml(raw);
                    fs.writeFileSync(cacheFile, html, 'utf-8');
                } else if (fs.existsSync(cacheFile)) {
                    html = fs.readFileSync(cacheFile, 'utf-8');
                }
            } catch (err) {
                if (fs.existsSync(cacheFile)) {
                    html = fs.readFileSync(cacheFile, 'utf-8');
                }
            }
        } else {
            if (fs.existsSync(cacheFile)) {
                html = fs.readFileSync(cacheFile, 'utf-8');
            } else {
                console.warn(`⚠️ Warning: Cache file not found for ${r.fileKey}`);
            }
        }

        if (html) {
            writeHtmlFiles(subPath, html);
            console.log(`✅ Generated ${subPath} (${html.length} bytes)`);
        }
    }

    console.log('🎉 Static build completed successfully! dist/ is 100% ready for AWS Amplify.');
}

build();
