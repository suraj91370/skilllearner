<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AffiliateLinkController;
use App\Http\Controllers\AffiliateTrainingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\MarketingToolController;
use App\Http\Controllers\PayoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\SocialCommunityController;
use App\Http\Controllers\StudentCourseController;
use App\Http\Controllers\TokenPurchaseController;
use App\Http\Controllers\VideoController;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// Demo User Data Definition
if (! function_exists('getDemoUserData')) {
    function getDemoUserData()
    {
        return [
            'name' => 'Vansh Tandon',
            'email' => 'vansh@skilllearner.com',
            'phone' => '+91 98765 43210',
            'affiliate_id' => 'SL-8821',
            'sponsor_id' => 'SL-ADMIN',
            'active_package' => 'Advance Package',
            'wallet_balance' => 14200,
            'today_earning' => 2200,
            'weekly_earning' => 7400,
            'total_earning' => 48600,
            'kyc_status' => 'Verified ✅',
            'role' => 'user',
        ];
    }
}

// 12 Enrolled Courses for Student Portal (Matches Image 1 Exactly)
if (! function_exists('getEnrolledCourses')) {
    function getEnrolledCourses()
    {
        return [
            [
                'id' => 1,
                'slug' => 'basic-business-automation',
                'title' => 'Basic Business Automation',
                'instructor' => 'Aman Rawat',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'BASIC BUSINESS AUTOMATION',
                'banner_tag' => 'All About Automation — Work Smarter, Not Harder',
                'accent' => '#06b6d4',
                'gradient' => 'linear-gradient(135deg, #070d1e 0%, #0f172a 45%, #0e7490 100%)',
                'lessons' => 16,
                'duration' => '4h 30m',
            ],
            [
                'id' => 2,
                'slug' => 'basic-facebook-ads-course',
                'title' => 'Basic Facebook ADs course',
                'instructor' => 'Prateek Garg',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'BASIC FACEBOOK ADS COURSE',
                'banner_tag' => 'Run High-Converting Ads — Zero Prior Experience',
                'accent' => '#8b5cf6',
                'gradient' => 'linear-gradient(135deg, #09090b 0%, #1e1b4b 50%, #4c1d95 100%)',
                'lessons' => 14,
                'duration' => '5h 15m',
            ],
            [
                'id' => 3,
                'slug' => 'canva-pro-mastery',
                'title' => 'Canva Pro',
                'instructor' => 'Kunal Sharma',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'CANVA MASTERY COURSE',
                'banner_tag' => 'Design Like A Pro — 50+ Ready Social Templates',
                'accent' => '#d946ef',
                'gradient' => 'linear-gradient(135deg, #18052e 0%, #3b0764 50%, #701a75 100%)',
                'lessons' => 12,
                'duration' => '3h 45m',
            ],
            [
                'id' => 4,
                'slug' => 'capcut-mobile-editing',
                'title' => 'Capcut Mobile Editing',
                'instructor' => 'Kunal Sharma',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'CAPCUT MOBILE VIDEO EDITING',
                'banner_tag' => 'From Beginner to Pro Editor — Mobile Friendly',
                'accent' => '#a855f7',
                'gradient' => 'linear-gradient(135deg, #050510 0%, #1e103a 50%, #311054 100%)',
                'lessons' => 18,
                'duration' => '6h 10m',
            ],
            [
                'id' => 5,
                'slug' => 'content-creation-mastery',
                'title' => 'Content Creation Mastery Course',
                'instructor' => 'Rohan Sen',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'CONTENT CREATION MASTERY COURSE',
                'banner_tag' => 'Viral Short Video Formats for Instagram & YouTube',
                'accent' => '#818cf8',
                'gradient' => 'linear-gradient(135deg, #0f0a28 0%, #2e1065 60%, #4338ca 100%)',
                'lessons' => 20,
                'duration' => '7h 20m',
            ],
            [
                'id' => 6,
                'slug' => 'meta-ads-mastery',
                'title' => 'Basic Facebook ADs course',
                'instructor' => 'Prateek Garg',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'BASIC FACEBOOK ADS COURSE',
                'banner_tag' => 'High Return On Ad Spend & Custom Audience Secrets',
                'accent' => '#38bdf8',
                'gradient' => 'linear-gradient(135deg, #020617 0%, #172554 60%, #1e3a8a 100%)',
                'lessons' => 16,
                'duration' => '5h 50m',
            ],
            [
                'id' => 7,
                'slug' => 'instagram-growth-mastery',
                'title' => 'Instagram Growth Mastery',
                'instructor' => 'Vikram Malhotra',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'INSTAGRAM GROWTH MASTERY',
                'banner_tag' => 'From Zero to Influencer — Complete Organic Blueprint',
                'accent' => '#c084fc',
                'gradient' => 'linear-gradient(135deg, #110726 0%, #2e1065 50%, #581c87 100%)',
                'lessons' => 15,
                'duration' => '4h 50m',
            ],
            [
                'id' => 8,
                'slug' => 'lead-generation-mastery',
                'title' => 'Lead Generation Mastery Course',
                'instructor' => 'Aryan Verma',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'LEAD GENERATION MASTERY COURSE',
                'banner_tag' => 'Organic & Paid High-Ticket Lead Closing Formulas',
                'accent' => '#f97316',
                'gradient' => 'linear-gradient(135deg, #0c0a09 0%, #291505 50%, #7c2d12 100%)',
                'lessons' => 12,
                'duration' => '4h 10m',
            ],
            [
                'id' => 9,
                'slug' => 'sales-funnel-mastery',
                'title' => 'High-Converting Sales Funnel',
                'instructor' => 'Aryan Verma',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'SALES FUNNEL BLUEPRINT',
                'banner_tag' => 'Landing Pages, WhatsApp Automation & High Conversions',
                'accent' => '#10b981',
                'gradient' => 'linear-gradient(135deg, #022c22 0%, #064e3b 50%, #047857 100%)',
                'lessons' => 14,
                'duration' => '5h 00m',
            ],
            [
                'id' => 10,
                'slug' => 'premiere-pro-video-editing',
                'title' => 'Premiere Pro Video Editing',
                'instructor' => 'Rohan Sen',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'PREMIERE PRO MASTERY',
                'banner_tag' => 'Cinematic Transitions, SFX & Viral Reels Workflow',
                'accent' => '#38bdf8',
                'gradient' => 'linear-gradient(135deg, #020617 0%, #0c4a6e 60%, #0284c7 100%)',
                'lessons' => 22,
                'duration' => '8h 15m',
            ],
            [
                'id' => 11,
                'slug' => 'chatgpt-ai-automation',
                'title' => 'AI & ChatGPT Monetization Kit',
                'instructor' => 'Aman Rawat',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'AI & CHATGPT AUTOMATION',
                'banner_tag' => 'Automate Marketing, Copywriting & Workflows with AI',
                'accent' => '#ec4899',
                'gradient' => 'linear-gradient(135deg, #180324 0%, #4a044e 50%, #86198f 100%)',
                'lessons' => 11,
                'duration' => '3h 30m',
            ],
            [
                'id' => 12,
                'slug' => 'affiliate-marketing-masterclass',
                'title' => 'High-Ticket Affiliate Blueprint',
                'instructor' => 'Kunal Joshi',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'AFFILIATE BLUEPRINT',
                'banner_tag' => 'Scale Your Commissions to 70%+ Passive Direct Income',
                'accent' => '#f59e0b',
                'gradient' => 'linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%)',
                'lessons' => 18,
                'duration' => '6h 40m',
            ],
        ];
    }
}

// Default Commissions & Payouts for logged in user
if (! function_exists('initDefaultCommissions')) {
    function initDefaultCommissions()
    {
        if (! session()->has('commissions')) {
            session(['commissions' => [
                ['name' => 'Amit Verma', 'package' => 'Advance Package', 'amount' => 2200, 'type' => 'Direct (Tier-1)', 'time' => '10 mins ago', 'status' => 'Credited'],
                ['name' => 'Priya Nair', 'package' => 'Basic Package', 'amount' => 1200, 'type' => 'Direct (Tier-1)', 'time' => '2 hours ago', 'status' => 'Credited'],
                ['name' => 'Karan Joshi', 'package' => 'Infinity Package', 'amount' => 800, 'type' => 'Passive (Tier-2)', 'time' => 'Yesterday', 'status' => 'Credited'],
                ['name' => 'Sneha Patel', 'package' => 'Growth Package', 'amount' => 500, 'type' => 'Direct (Tier-1)', 'time' => '2 days ago', 'status' => 'Credited'],
            ]]);
        }

        if (! session()->has('payouts')) {
            session(['payouts' => [
                ['id' => 'PAY-1082', 'amount' => 5000, 'method' => 'UPI (suraj@okaxis)', 'status' => 'Transferred', 'date' => date('Y-m-d', strtotime('-3 days'))],
                ['id' => 'PAY-1049', 'amount' => 10000, 'method' => 'HDFC Bank (A/C ...4819)', 'status' => 'Transferred', 'date' => date('Y-m-d', strtotime('-10 days'))],
            ]]);
        }
    }
}

// Packages Data with Prices and Descriptions
if (! function_exists('getPackages')) {
    function getPackages()
    {
        return [
            [
                'id' => 'basic',
                'name' => 'Basic Package',
                'price' => 599,
                'active_income' => 420,
                'passive_income' => 50,
                'old_price' => 1199,
                'image' => 'images/packages/basic.png',
                'color' => '#A855F7',
                'border_color' => 'rgba(168, 85, 247, 0.45)',
                'bg_gradient' => 'linear-gradient(180deg, #1b0c33 0%, #0d0519 100%)',
                'badge' => '',
                'featured' => false,
                'access_badge' => 'Get Access of 3+ Courses',
                'total_courses_count' => 3,
                'previous_access' => null,
                'desc' => 'Foundational digital skillset covering Affiliate Marketing basics, spoken English fluency, and high-impact communication.',
                'courses_included' => ['What Is Affiliate Marketing', 'Spoken English', 'Communication Skill'],
            ],
            [
                'id' => 'growth',
                'name' => 'Growth Package',
                'price' => 1199,
                'active_income' => 840,
                'passive_income' => 100,
                'old_price' => 2499,
                'image' => 'images/packages/growth.png',
                'color' => '#10B981',
                'border_color' => 'rgba(16, 185, 129, 0.45)',
                'bg_gradient' => 'linear-gradient(180deg, #063124 0%, #021711 100%)',
                'badge' => '',
                'featured' => false,
                'access_badge' => 'Get Access of 6+ Courses',
                'total_courses_count' => 6,
                'previous_access' => '+ Full Access of Basic Package',
                'desc' => 'Accelerate your creative monetization with Canva graphic design, viral reel workflows, and VN mobile video editing.',
                'courses_included' => ['Canva Graphic Designing', 'Reel Mastery by Canva', 'VN Editing Course'],
            ],
            [
                'id' => 'advance',
                'name' => 'Advance Package',
                'price' => 2499,
                'active_income' => 1900,
                'passive_income' => 200,
                'old_price' => 4999,
                'image' => 'images/packages/advance.png',
                'color' => '#0284C7',
                'border_color' => 'rgba(2, 132, 199, 0.45)',
                'bg_gradient' => 'linear-gradient(180deg, #07263e 0%, #021320 100%)',
                'badge' => '',
                'featured' => false,
                'access_badge' => 'Get Access of 9+ Courses',
                'total_courses_count' => 9,
                'previous_access' => '+ Full Access of Basic & Growth Packages',
                'desc' => 'Unlock high-converting sales funnels, direct video marketing strategies, and automated email marketing systems.',
                'courses_included' => ['E-mail Marketing', 'Sales Mastery', 'Video Marketing'],
            ],
            [
                'id' => 'premium',
                'name' => 'Premium Package',
                'price' => 4999,
                'active_income' => 3800,
                'passive_income' => 400,
                'old_price' => 9999,
                'image' => 'images/packages/premium.png',
                'color' => '#F59E0B',
                'border_color' => 'rgba(245, 158, 11, 0.45)',
                'bg_gradient' => 'linear-gradient(180deg, #331c02 0%, #150a00 100%)',
                'badge' => '',
                'featured' => false,
                'access_badge' => 'Get Access of 12+ Courses',
                'total_courses_count' => 12,
                'previous_access' => '+ Full Access of Basic, Growth & Advance Packages',
                'desc' => 'High-ticket authority skills including full YouTube channel monetization, Meta Facebook advertising, and professional web design.',
                'courses_included' => ['YouTube Mastery', 'Facebook Ads', 'Web Designing'],
            ],
            [
                'id' => 'infinity',
                'name' => 'Infinity Package',
                'price' => 7999,
                'active_income' => 5500,
                'passive_income' => 500,
                'old_price' => 15999,
                'image' => 'images/packages/infinity.png',
                'color' => '#EF4444',
                'border_color' => 'rgba(239, 68, 68, 0.45)',
                'bg_gradient' => 'linear-gradient(180deg, #330606 0%, #160202 100%)',
                'badge' => '',
                'featured' => false,
                'access_badge' => 'Get Access of 15+ Courses',
                'total_courses_count' => 15,
                'previous_access' => '+ Full Access of All Previous Packages (Complete Access)',
                'desc' => 'VIP flagship bundle mastering 0 to Hero AI Content Creation, Artificial Intelligence tools, and Stock Market wealth generation.',
                'courses_included' => ['0 to Hero AI Content Creation', 'Artificial Intelligence', 'Stock Market Course'],
            ],
        ];
    }
}

// Rich Courses Data with Detailed Descriptions and Syllabuses
if (! function_exists('getCourses')) {
    function getCourses()
    {
        return [
            [
                'id' => 1,
                'slug' => 'affiliate-marketing-masterclass',
                'title' => 'High-Ticket Affiliate Marketing Masterclass',
                'cat' => 'Affiliate Business',
                'badge' => 'BESTSELLER',
                'lessons' => 18,
                'duration' => '6h 40m',
                'icon' => '🚀',
                'image' => 'images/packages/advance.jpg',
                'price' => 1499,
                'old_price' => 3999,
                'package' => 'Advance Package',
                'tagline' => 'Step-by-step blueprint to generate ₹50,000+ monthly via organic leads and high-ticket affiliate funnels.',
                'desc' => 'This comprehensive masterclass takes you from complete beginner to high-earning affiliate entrepreneur. Discover how to identify high-converting offers, build automated lead generation funnels without spending on ads, leverage WhatsApp for fast conversions, and scale your personal brand with proven frameworks.',
                'what_you_learn' => [
                    'How to pick high-ticket digital products with 70%+ commission rates',
                    'Organic lead generation secrets on Instagram & LinkedIn without paid ads',
                    'Copy-paste WhatsApp DM scripts that close 1 in 3 prospects',
                    'Automated sales funnels that work 24/7 on autopilot',
                    'Psychology of persuasion & objection handling for Indian audiences',
                    'How to scale from ₹10,000 to ₹1,00,000 monthly income step-by-step',
                ],
                'modules' => [
                    ['title' => 'Module 1: Affiliate Business Foundations', 'lessons' => ['The 2026 Affiliate Landscape in India', 'Selecting High-Converting Digital Niches', 'Setting Up Your Affiliate Command Center']],
                    ['title' => 'Module 2: Organic Traffic Mastery', 'lessons' => ['Instagram Bio & Profile Optimization', 'The Viral 30-Second Reel Script Formula', 'Organic Story Selling Framework']],
                    ['title' => 'Module 3: Lead Magnets & WhatsApp Funnels', 'lessons' => ['Building High-Converting WhatsApp Broadcasts', 'Lead Qualification & First 5-Minute Rules', 'Automated Greeting & Follow-Up Sequences']],
                    ['title' => 'Module 4: High-Ticket Sales Closing', 'lessons' => ['Overcoming "Paisa Nahi Hai" & Trust Objections', 'Live Mock Sales Call Breakdown', 'Daily 2-Hour Action Routine for Guaranteed Results']],
                ],
                'requirements' => ['A smartphone or laptop with internet connection', 'Basic understanding of WhatsApp and Instagram', 'No prior marketing or technical experience required'],
                'instructor' => 'Aryan Verma — Senior Growth Strategist & 7-Figure Affiliate Mentor',
            ],
            [
                'id' => 2,
                'slug' => 'ai-chatgpt-automation',
                'title' => 'AI, ChatGPT & Automation Cashflow',
                'cat' => 'Artificial Intelligence',
                'badge' => 'TRENDING',
                'lessons' => 14,
                'duration' => '5h 15m',
                'icon' => '🤖',
                'image' => 'images/packages/premium.jpg',
                'price' => 1299,
                'old_price' => 3499,
                'package' => 'Premium Package',
                'tagline' => 'Harness ChatGPT, Midjourney, Claude & automation bots to deliver paid freelance services in minutes.',
                'desc' => 'Turn artificial intelligence into an unstoppable income engine. Learn secret prompt engineering recipes, automated content workflows, and modern AI tools that allow you to deliver copy, design, video scripts, and data analysis 10x faster than traditional agencies.',
                'what_you_learn' => [
                    'Master advanced prompt engineering for ChatGPT, Claude, and Perplexity',
                    'Generate hyper-realistic viral visuals with Midjourney and Ideogram',
                    'Automate repetitive workflows using Zapier & Make.com with zero code',
                    'Package AI-powered services to charge ₹15,000+ per freelance client',
                    'Build AI voiceovers and cloned video avatars for brand marketing',
                    'Create custom GPTs and monetize them as specialized business tools',
                ],
                'modules' => [
                    ['title' => 'Module 1: The AI Paradigm & Prompt Engineering', 'lessons' => ['Understanding Large Language Models in Practice', 'The 6-Step System Prompt Formula', 'Prompt Injection & Precision Output Rules']],
                    ['title' => 'Module 2: Visual & Multimedia AI Tools', 'lessons' => ['Midjourney & Ideogram Commercial Design', 'AI Voice Cloning with ElevenLabs', 'Automated Faceless Video Generation with Runway & CapCut']],
                    ['title' => 'Module 3: Workflow Automation Without Code', 'lessons' => ['Connecting ChatGPT to Google Sheets via Zapier', 'Automated Social Media Scheduling Pipelines', 'Automated Email Client Onboarding']],
                    ['title' => 'Module 4: Monetization & Client Acquisition', 'lessons' => ['5 High-Demand AI Services You Can Sell Today', 'Pitching Local Businesses on AI Efficiency', 'Pricing and Packaging Your AI Solutions']],
                ],
                'requirements' => ['Free ChatGPT account and modern browser', 'Curiosity to experiment with prompts and automation', 'No coding or math background needed'],
                'instructor' => 'Neha Kapoor — AI Product Consultant & Workflow Architect',
            ],
            [
                'id' => 3,
                'slug' => 'short-form-video-editing',
                'title' => 'Short-Form Video Editing (CapCut & Premiere Pro)',
                'cat' => 'Video & Media',
                'badge' => 'HOT SKILL',
                'lessons' => 22,
                'duration' => '8h 20m',
                'icon' => '🎬',
                'image' => 'images/packages/advance.jpg',
                'price' => 1499,
                'old_price' => 3999,
                'package' => 'Advance Package',
                'tagline' => 'Edit viral Instagram Reels, YouTube Shorts, and TikTok ads that grab attention in the first 2 seconds.',
                'desc' => 'Short-form content is the highest-demand digital marketing skill today. Master pacing, dynamic keyframing, trending sound design, hypnotic B-rolls, Alex Hormozi-style captions, and sound effects to charge premium rates per 60-second video.',
                'what_you_learn' => [
                    'CapCut Desktop & Mobile complete end-to-end masterclass',
                    'Adobe Premiere Pro timeline, color grading, and speed ramping workflows',
                    'The 2-Second Hook: Visual retention hacks that keep watch time above 90%',
                    'Animated kinetic typography & viral subtitle styling',
                    'Cinematic sound design: risers, whooshes, pop effects, and music curation',
                    'How to land international editing clients paying $300-$1000/month on retainer',
                ],
                'modules' => [
                    ['title' => 'Module 1: Software Setup & Workflow Essentials', 'lessons' => ['CapCut PC Interface & Shortcuts Mastery', 'Premiere Pro Workspace Optimization', 'Importing, Cutting & Assembly Timelines']],
                    ['title' => 'Module 2: Retention Editing & Visual Hooks', 'lessons' => ['The Psychology of Visual Hooks', 'Dynamic Zoom-Ins & Camera Shakes', 'Seamless B-Roll Overlays and Transitions']],
                    ['title' => 'Module 3: Animated Subtitles & Motion Graphics', 'lessons' => ['Creating Custom Hormozi Style Captions', 'Text Animations, Glows & Emoji Placement', 'Tracking Text to Moving Subjects']],
                    ['title' => 'Module 4: Sound Design & High-Paying Clients', 'lessons' => ['Layering Audio: Music, SFX & Clean Dialogue', 'Exporting for Maximum Instagram/YouTube Quality', 'Building a 1-Minute Showreel to Sign Retainer Clients']],
                ],
                'requirements' => ['A laptop/PC (or modern smartphone) with CapCut or Premiere Pro installed', 'Headphones for sound design practice', 'No prior editing knowledge necessary'],
                'instructor' => 'Rohan Sen — Viral Content Editor for 2M+ Follower Creators',
            ],
            [
                'id' => 4,
                'slug' => 'meta-ads-mastery',
                'title' => 'Meta Ads Mastery: Facebook & Instagram Leads',
                'cat' => 'Performance Marketing',
                'badge' => 'HIGH ROI',
                'lessons' => 16,
                'duration' => '5h 50m',
                'icon' => '📈',
                'image' => 'images/packages/premium.jpg',
                'price' => 1699,
                'old_price' => 4499,
                'package' => 'Premium Package',
                'tagline' => 'Run profitable Facebook & Instagram ads for real estate, e-commerce, coaching, and lead gen.',
                'desc' => 'Learn how to generate qualified leads at ₹10 to ₹30 using Ads Manager. Discover custom audiences, lookalikes, creative testing, CBO budget scaling, and conversion API integration without wasting ad budget on ineffective boosts.',
                'what_you_learn' => [
                    'Set up Meta Business Manager, Pixels, and Conversion API with zero errors',
                    'The 3:2:2 Dynamic Creative Testing framework that finds winning ads fast',
                    'Hyper-targeted audience research for Tier-1, Tier-2, and Tier-3 Indian cities',
                    'Creating high-CTR video and image ad creatives that stop the scroll',
                    'Campaign budget optimization (CBO) scaling strategies from ₹500 to ₹50,000/day',
                    'How to land and retain performance marketing agency clients',
                ],
                'modules' => [
                    ['title' => 'Module 1: Business Manager & Tracking Architecture', 'lessons' => ['Meta Business Suite & Asset Verification', 'Pixel Setup & Domain Verification Explained', 'Setting Up Custom Aggregated Events']],
                    ['title' => 'Module 2: Creative & Copy Strategy', 'lessons' => ['Writing Copy for the Problem-Agitate-Solve Framework', 'High-Converting Canva Ad Design Templates', 'Hook Rate & Hold Rate Analytics']],
                    ['title' => 'Module 3: Campaign Setup & Audience Targeting', 'lessons' => ['Broad vs Advantage+ vs Detailed Targeting', 'Instant Form Lead Campaigns for WhatsApp Integration', 'Retargeting Warm Funnel Audiences']],
                    ['title' => 'Module 4: Scaling & Agency Blueprint', 'lessons' => ['Identifying Creative Fatigue Before ROAS Drops', 'Vertical vs Horizontal Scaling Rules', 'Agency Pitch Deck & Contract Templates']],
                ],
                'requirements' => ['A computer with Chrome browser and a Facebook account', 'A minimal testing budget (optional, not needed to learn)', 'Basic analytical mindset'],
                'instructor' => 'Kunal Joshi — Ex-Growth Lead managing ₹2 Crore+ Annual Ad Spend',
            ],
            [
                'id' => 5,
                'slug' => 'wordpress-landing-page-design',
                'title' => 'WordPress & Landing Page Design No-Code',
                'cat' => 'Web Design',
                'badge' => 'MOST PRACTICAL',
                'lessons' => 20,
                'duration' => '7h 30m',
                'icon' => '💻',
                'image' => 'images/packages/premium.jpg',
                'price' => 1499,
                'old_price' => 3999,
                'package' => 'Premium Package',
                'tagline' => 'Build high-converting sales pages, company websites, and portfolios using Elementor without coding.',
                'desc' => 'Website design is an evergreen skill that commands instant respect and high client budgets. Learn to build modern, mobile-responsive, lightning-fast landing pages with Elementor, integrate payment gateways like Razorpay/Stripe, and deliver full websites in under 48 hours.',
                'what_you_learn' => [
                    'Domain, hosting, and WordPress installation from scratch',
                    'Elementor Pro drag-and-drop page builder complete deep-dive',
                    'Modern UI principles: visual hierarchy, spacing, typography, and color harmony',
                    'Building mobile-first layouts that convert at 15%+',
                    'Connecting contact forms, WhatsApp chat widgets, and Razorpay payment buttons',
                    'Speed optimization: caching, CDN setup, image compression for 90+ PageSpeed',
                ],
                'modules' => [
                    ['title' => 'Module 1: WordPress Foundations', 'lessons' => ['Domain & Cpanel/Hosting Configuration', 'WordPress Dashboard & Core Settings', 'Essential Plugins for Security & Speed']],
                    ['title' => 'Module 2: Elementor Pro Design Mastery', 'lessons' => ['Containers, Flexbox & Grid in Elementor', 'Designing Sticky Headers & Mega Menus', 'Interactive Animations & Scroll Effects']],
                    ['title' => 'Module 3: High-Converting Sales Funnels', 'lessons' => ['Anatomy of a 7-Figure Course Landing Page', 'Checkout Page Design with Payment Integrations', 'Setting Up Thank You & Upsell Pages']],
                    ['title' => 'Module 4: Speed, Launch & Client Delivery', 'lessons' => ['Mobile Viewport Optimization & Breakpoints', 'Speed Optimization with LiteSpeed & WebP', 'Exporting & Transferring Sites to Paying Clients']],
                ],
                'requirements' => ['A PC or Laptop with internet connectivity', 'No HTML, CSS or coding background required', 'Free local development tools provided in the course'],
                'instructor' => 'Pooja Singhal — UI Designer & Freelance Web Architect',
            ],
            [
                'id' => 6,
                'slug' => 'personal-branding-instagram-reels',
                'title' => 'Personal Branding & Instagram Reel Blueprint',
                'cat' => 'Social Media',
                'badge' => 'FAST GROWTH',
                'lessons' => 12,
                'duration' => '4h 10m',
                'icon' => '⭐',
                'image' => 'images/packages/basic.jpg',
                'price' => 999,
                'old_price' => 2499,
                'package' => 'Basic Package',
                'tagline' => 'Build authority, attract inbound client inquiries, and grow your Instagram followers organically.',
                'desc' => 'In today’s creator economy, your personal brand is your greatest asset. Learn how to position yourself as an authority, script viral reels that generate thousands of views, build deep trust with your followers, and convert DMs into high-paying clients and passive income.',
                'what_you_learn' => [
                    'The Niche Positioning Formula: Stand out in a crowded market',
                    'Camera confidence: Speaking smoothly without stuttering or scripts',
                    'Instagram algorithm secret signals: Saves, shares, and watch time hacks',
                    'The 3-post weekly content system that saves 15+ hours',
                    'How to monetize an account with less than 1,000 followers',
                    'Landing brand sponsorships, affiliate commissions, and coaching clients',
                ],
                'modules' => [
                    ['title' => 'Module 1: Brand Positioning & Profile Makeover', 'lessons' => ['Finding Your Unique Value Proposition (UVP)', 'Writing an Unignorable Instagram Bio & Linktree', 'Designing Branded Highlight Covers in Canva']],
                    ['title' => 'Module 2: Scripting & Video Presentation', 'lessons' => ['Teleprompter Apps & Camera Framing Rules', 'Hook, Story, Offer: The 3-Part Reel Framework', 'Batch Recording 10 Reels in One Afternoon']],
                    ['title' => 'Module 3: Algorithm Tactics & Engagement', 'lessons' => ['Optimal Posting Times and Hashtag Strategy', 'Story Sequences that Generate 20+ Daily DMs', 'Community Building and Collaborations']],
                    ['title' => 'Module 4: Inbound Monetization', 'lessons' => ['The DM Cash Machine: Turning Comments into Buyers', 'Pricing Your 1-on-1 Consultation Calls', 'Long-Term Brand Equity and Authority Building']],
                ],
                'requirements' => ['Smartphone with camera and Instagram app', 'Desire to build a recognizable personal brand', 'No fancy studio equipment needed'],
                'instructor' => 'Vikram Malhotra — Creator Growth Coach with 350K+ Audience',
            ],
        ];
    }
}

// --- Application Routes ---

// 1. Homepage
Route::get('/', function () {
    return view('home', [
        'packages' => getPackages(),
        'courses' => getCourses(),
    ]);
});

// 2. Packages & Pricing Page
Route::get('/plans', function () {
    return view('plans', [
        'packages' => getPackages(),
    ]);
});
Route::get('/programs', function () {
    return redirect('/plans');
});

// 3. About Us Page
Route::get('/about', function () {
    return view('home', [
        'packages' => getPackages(),
        'courses' => getCourses(),
    ]);
});

// 4. Contact Us Page
Route::get('/contact', function () {
    return view('home', [
        'packages' => getPackages(),
        'courses' => getCourses(),
    ]);
});

// 5. Login & My Account (Database Authentication)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/my-account', [AuthController::class, 'showLoginForm'])->name('account');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');

// 6. Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout.perform');

// 7. Student Portal & Affiliate Center Routes (Dedicated Controllers & Blade Views)
Route::get('/my-courses', [StudentCourseController::class, 'index'])->name('portal.courses');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('portal.dashboard');
Route::get('/simulate-sale', [DashboardController::class, 'simulateSale'])->name('portal.simulate-sale');
Route::get('/profile', [ProfileController::class, 'index'])->name('portal.profile');
Route::get('/social-community', [SocialCommunityController::class, 'index'])->name('portal.community');
Route::get('/kyc', [KycController::class, 'index'])->name('portal.kyc');
Route::get('/affiliate-link', [AffiliateLinkController::class, 'index'])->name('portal.affiliate-link');
Route::get('/token-purchases', [TokenPurchaseController::class, 'index'])->name('portal.tokens');
Route::get('/affiliate-training', [AffiliateTrainingController::class, 'index'])->name('portal.training');
Route::get('/marketing-tool', [MarketingToolController::class, 'index'])->name('portal.marketing');
Route::get('/my-payout', [PayoutController::class, 'index'])->name('portal.payout');
Route::post('/payout-request', [PayoutController::class, 'requestPayout'])->name('portal.payout-request');
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('portal.leaderboard');
Route::get('/team-leaderboard', [LeaderboardController::class, 'teamLeaderboard'])->name('portal.team-leaderboard');
Route::get('/qualification', [QualificationController::class, 'index'])->name('portal.qualification');
Route::get('/certificates', [CertificateController::class, 'index'])->name('portal.certificates');

// 7.1 Admin & Super Admin Management Routes (Protected by role middleware)
Route::middleware(['role:admin,super_admin'])->prefix('admin')->group(function () {
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('admin.users.role');
    Route::get('/kyc-requests', [AdminController::class, 'kycRequests'])->name('admin.kyc');
    Route::post('/kyc/{kyc}/approve', [AdminController::class, 'approveKyc'])->name('admin.kyc.approve');
    Route::post('/kyc/{kyc}/reject', [AdminController::class, 'rejectKyc'])->name('admin.kyc.reject');
    Route::get('/payout-requests', [AdminController::class, 'payoutRequests'])->name('admin.payouts');
    Route::post('/payout/{payout}/status', [AdminController::class, 'updatePayoutStatus'])->name('admin.payouts.status');
});

// Super Admin Only System Settings & Video Management
Route::middleware(['role:super_admin'])->prefix('admin')->group(function () {
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');

    // Video Management & Show/Hide Control
    Route::get('/videos', [VideoController::class, 'index'])->name('admin.videos');
    Route::post('/videos', [VideoController::class, 'store'])->name('admin.videos.store');
    Route::put('/videos/{video}', [VideoController::class, 'update'])->name('admin.videos.update');
    Route::post('/videos/{video}/toggle-visibility', [VideoController::class, 'toggleVisibility'])->name('admin.videos.toggle-visibility');
    Route::delete('/videos/{video}', [VideoController::class, 'destroy'])->name('admin.videos.destroy');

    // Course Management & Show/Hide Control
    Route::get('/courses', [AdminController::class, 'courses'])->name('admin.courses');
    Route::post('/courses/{course}/toggle-visibility', [AdminController::class, 'toggleCourseVisibility'])->name('admin.courses.toggle-visibility');

    // Super Admin User/Admin Impersonation ("Login As")
    Route::get('/impersonate/{user}', [ImpersonateController::class, 'impersonate'])->name('admin.impersonate');
});

// Leave Impersonation (Return to Super Admin Account)
Route::get('/impersonate-leave', [ImpersonateController::class, 'leave'])->name('admin.impersonate.leave');

// Student & User Videos Hub (Shows only visible videos)
Route::get('/videos', [VideoController::class, 'userIndex'])->name('portal.videos');

// 8. Video Classroom LMS (Protected: requires login)
Route::get('/classroom', function () {
    if (! session()->has('user')) {
        return redirect('/login')->with('info', 'Please log in to access your classroom courses.');
    }

    $visibleVideos = Video::visible()->orderBy('sort_order')->get();

    return view('classroom', [
        'videos' => $visibleVideos,
    ]);
});

// 9. Registration Page & Action
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register-user', [AuthController::class, 'register'])->name('register.perform');

// 10. Action: Reset Demo
Route::get('/reset-demo', function () {
    Auth::logout();
    session()->forget(['user', 'commissions', 'payouts']);

    return redirect('/login')->with('info', 'Demo state reset. Please log in.');
});

// --- Courses Catalog & Descriptions ---
Route::get('/courses', function () {
    return view('courses', [
        'courses' => getCourses(),
        'packages' => getPackages(),
    ]);
});

// Single Course Description & Syllabus Detail
Route::get('/courses/{slug}', function ($slug) {
    $courses = getCourses();
    $course = collect($courses)->firstWhere('slug', $slug);
    if (! $course) {
        return redirect('/courses');
    }

    return view('course-detail', [
        'course' => $course,
        'packages' => getPackages(),
    ]);
});

// Dedicated Buy Now Checkout Page
Route::get('/buy-now', function (Request $request) {
    $courses = getCourses();
    $packages = getPackages();

    $courseSlug = $request->query('course');
    $packageId = $request->query('package');

    $selectedCourse = $courses[0];
    $selectedPackage = $packages[1]; // Advance Package
    $type = 'package';

    if ($courseSlug) {
        $found = collect($courses)->firstWhere('slug', $courseSlug);
        if ($found) {
            $selectedCourse = $found;
            $type = 'course';
        }
    } elseif ($packageId) {
        $found = collect($packages)->first(function ($p) use ($packageId) {
            return strtolower($p['id']) === strtolower($packageId) || strtolower($p['name']) === strtolower($packageId);
        });
        if ($found) {
            $selectedPackage = $found;
            $type = 'package';
        }
    }

    return view('buy-now', [
        'courses' => $courses,
        'packages' => $packages,
        'selectedCourse' => $selectedCourse,
        'selectedPackage' => $selectedPackage,
        'type' => $type,
    ]);
});

// Action: Process Buy Now
Route::post('/process-buy-now', function (Request $request) {
    $itemType = $request->input('item_type', 'package');
    $itemId = $request->input('item_id', 'advance');
    $name = $request->input('name', 'Suraj Kumar');
    $email = $request->input('email', 'student@skilllearner.test');
    $phone = $request->input('phone', '+91 98765 43210');
    $sponsorId = $request->input('sponsor_id', 'SKL-ADMIN');

    $packages = getPackages();
    $courses = getCourses();

    $activePackageName = 'Advance Package';
    if ($itemType === 'package') {
        $found = collect($packages)->first(function ($p) use ($itemId) {
            return strtolower($p['id']) === strtolower($itemId) || strtolower($p['name']) === strtolower($itemId);
        });
        if ($found) {
            $activePackageName = $found['name'];
        }
    } else {
        $found = collect($courses)->firstWhere('slug', $itemId);
        if ($found) {
            $activePackageName = $found['package'];
        }
    }

    $affiliateId = 'SKL-'.rand(1000, 9999);
    $user = User::firstOrCreate(
        ['email' => $email],
        [
            'name' => $name,
            'phone' => $phone,
            'password' => Hash::make('password123'),
            'affiliate_id' => $affiliateId,
            'sponsor_id' => $sponsorId,
            'active_package' => $activePackageName,
            'wallet_balance' => 0.00,
            'today_earning' => 0.00,
            'weekly_earning' => 0.00,
            'total_earning' => 0.00,
            'kyc_status' => 'Pending Verification',
            'role' => 'affiliate',
        ]
    );

    Auth::login($user);
    $request->session()->regenerate();

    session(['user' => [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'phone' => $user->phone ?? $phone,
        'affiliate_id' => $user->affiliate_id ?? $affiliateId,
        'sponsor_id' => $user->sponsor_id ?? $sponsorId,
        'active_package' => $user->active_package ?? $activePackageName,
        'wallet_balance' => (float) $user->wallet_balance,
        'today_earning' => (float) $user->today_earning,
        'weekly_earning' => (float) $user->weekly_earning,
        'total_earning' => (float) $user->total_earning,
        'kyc_status' => $user->kyc_status ?? 'Pending Verification',
        'avatar' => $user->avatar,
        'role' => $user->role ?? 'user',
    ]]);
    initDefaultCommissions();

    return redirect('/classroom')->with('alert', 'welcome');
});
