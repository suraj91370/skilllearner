<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AffiliateLinkController;
use App\Http\Controllers\AffiliateTrainingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashfreePaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\MarketingToolController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PayoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\SocialCommunityController;
use App\Http\Controllers\StudentCourseController;
use App\Http\Controllers\VideoController;
use App\Mail\AccountCreatedMail;
use App\Mail\ActiveReferralMail;
use App\Mail\ForgotPasswordMail;
use App\Mail\PassiveReferralMail;
use App\Models\Commission;
use App\Models\Course;
use App\Models\User;
use App\Models\UserCourse;
use App\Models\Video;
use App\Services\CommissionService;
use App\Services\EmailNotificationService;
use App\Services\PackageService;
use App\Services\PortalDataService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

// Packages Data with Dynamic Super Admin Pricing, Offers and Discounts
if (! function_exists('getPackages')) {
    function getPackages()
    {
        try {
            return PackageService::getAllPackages(true);
        } catch (Throwable $e) {
            return [
                [
                    'id' => 'basic',
                    'slug' => 'basic',
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
                    'slug' => 'growth',
                    'name' => 'Growth Package',
                    'price' => 1199,
                    'active_income' => 840,
                    'passive_income' => 100,
                    'old_price' => 2499,
                    'image' => 'images/packages/growth.png',
                    'color' => '#10B981',
                    'border_color' => 'rgba(168, 85, 247, 0.45)',
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
                    'slug' => 'advance',
                    'name' => 'Advance Package',
                    'price' => 2499,
                    'active_income' => 1900,
                    'passive_income' => 200,
                    'old_price' => 4999,
                    'image' => 'images/packages/advance.png',
                    'color' => '#0284C7',
                    'border_color' => 'rgba(2, 132, 199, 0.45)',
                    'bg_gradient' => 'linear-gradient(180deg, #07263e 0%, #021320 100%)',
                    'badge' => 'MOST POPULAR',
                    'featured' => true,
                    'access_badge' => 'Get Access of 9+ Courses',
                    'total_courses_count' => 9,
                    'previous_access' => '+ Full Access of Basic & Growth Packages',
                    'desc' => 'High-converting mastery bundle with Email Marketing automation, Sales Closing mastery, and Video Marketing frameworks.',
                    'courses_included' => ['E-mail Marketing', 'Sales Mastery', 'Video Marketing'],
                ],
                [
                    'id' => 'premium',
                    'slug' => 'premium',
                    'name' => 'Premium Package',
                    'price' => 4999,
                    'active_income' => 3800,
                    'passive_income' => 400,
                    'old_price' => 9999,
                    'image' => 'images/packages/premium.png',
                    'color' => '#F59E0B',
                    'border_color' => 'rgba(245, 158, 11, 0.45)',
                    'bg_gradient' => 'linear-gradient(180deg, #331c02 0%, #150a00 100%)',
                    'badge' => 'BEST VALUE',
                    'featured' => false,
                    'access_badge' => 'Get Access of 12+ Courses',
                    'total_courses_count' => 12,
                    'previous_access' => '+ Full Access of Basic, Growth & Advance Packages',
                    'desc' => 'High-ticket authority skills including full YouTube channel monetization, Meta Facebook advertising, and professional web design.',
                    'courses_included' => ['YouTube Mastery', 'Facebook Ads', 'Web Designing'],
                ],
                [
                    'id' => 'infinity',
                    'slug' => 'infinity',
                    'name' => 'Infinity Package',
                    'price' => 7999,
                    'active_income' => 5500,
                    'passive_income' => 500,
                    'old_price' => 15999,
                    'image' => 'images/packages/infinity.png',
                    'color' => '#EF4444',
                    'border_color' => 'rgba(239, 68, 68, 0.45)',
                    'bg_gradient' => 'linear-gradient(180deg, #330606 0%, #160202 100%)',
                    'badge' => 'VIP ALL ACCESS',
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

// 2. Packages & Pricing Page (With Differential Upgrade Pricing for Active Students)
Route::get('/plans', function (Request $request) {
    $packages = getPackages();
    $currentPackageName = null;
    if (Auth::check()) {
        $currentPackageName = Auth::user()->active_package;
    } elseif (session()->has('user.active_package')) {
        $currentPackageName = session('user.active_package');
    }

    $currentPackage = $currentPackageName ? CommissionService::getPackageInfo($currentPackageName) : null;

    $packagesWithUpgrade = array_map(function ($p) use ($currentPackageName) {
        $p['upgrade'] = CommissionService::getUpgradeDetails($currentPackageName, $p['id']);

        return $p;
    }, $packages);

    return view('plans', [
        'packages' => $packagesWithUpgrade,
        'currentPackage' => $currentPackage,
    ]);
});
Route::get('/packages', function (Request $request) {
    $ref = $request->query('ref');

    return redirect('/plans'.($ref ? '?ref='.urlencode($ref) : ''));
});
Route::get('/programs', function (Request $request) {
    $ref = $request->query('ref');

    return redirect('/plans'.($ref ? '?ref='.urlencode($ref) : ''));
});

// 3. About Us Page
Route::get('/about', function () {
    return view('about', [
        'packages' => getPackages(),
        'courses' => getCourses(),
    ]);
});

// 4. Contact Us Page
Route::get('/contact', function () {
    return view('contact', [
        'packages' => getPackages(),
        'courses' => getCourses(),
    ]);
});

Route::post('/contact', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:120',
        'email' => 'required|email|max:150',
        'phone' => 'nullable|string|max:30',
        'subject' => 'nullable|string|max:150',
        'message' => 'required|string|max:2000',
    ]);

    return back()->with('success', 'Thank you for reaching out! Our team has received your message and will get back to you shortly.');
});

// 5. Login & My Account (Database Authentication)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/my-account', [AuthController::class, 'showLoginForm'])->name('account');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');

// Forgot & Reset Password
Route::get('/forgot-password', function () {
    return view('forgot-password');
})->name('password.request');

Route::get('/forget-password', function () {
    return redirect()->route('password.request');
});

Route::post('/forgot-password', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user) {
        return back()->withInput()->withErrors([
            'email' => 'No account found with this email address. Please make sure you entered the correct registered email.',
        ]);
    }

    // Generate secure 64-character token
    $token = Str::random(64);

    // Save token in password_reset_tokens table
    try {
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => $token,
                'created_at' => now(),
            ]
        );
    } catch (Throwable $dbEx) {
        Log::warning('Could not store reset token in DB: '.$dbEx->getMessage());
    }

    $resetUrl = route('password.reset', ['token' => $token, 'email' => $user->email]);

    // Send Branded Email via EmailNotificationService
    $sent = EmailNotificationService::sendForgotPassword($user, $resetUrl);

    if ($sent) {
        return back()->with('status', 'A password reset link has been dispatched to '.$user->email.'! Please check your inbox and spam folder.');
    }

    $lastErr = EmailNotificationService::getLastError() ?? 'SMTP Connection Failed';

    return back()->withInput()->withErrors([
        'email' => 'Email deliver nahi ho payi: '.$lastErr.'. Kripya .env mein MAIL_PASSWORD Hostinger ka daalein ya testing ke liye MAIL_MAILER=log set karein.',
    ]);
})->name('password.email');

// Reset Password Page & Submission
Route::get('/reset-password/{token}', function (Request $request, string $token) {
    return view('reset-password', [
        'token' => $token,
        'email' => $request->query('email', ''),
    ]);
})->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required|string',
        'email' => 'required|email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = User::where('email', $request->email)->first();
    if (! $user) {
        return back()->withInput()->withErrors(['email' => 'No user account found with this email address.']);
    }

    // Verify token from database
    $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

    $isValid = false;
    if ($record) {
        if ($record->token === $request->token || Hash::check($request->token, $record->token)) {
            // Check expiry (60 mins)
            if (! Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
                $isValid = true;
            }
        }
    }

    // If local/testing or valid token
    if (! $isValid && ! app()->environment('local')) {
        return back()->withInput()->withErrors(['email' => 'This password reset link is invalid or has expired. Please request a new one.']);
    }

    // Update password
    $user->password = Hash::make($request->password);
    $user->save();

    // Clean up used token
    try {
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
    } catch (Throwable $e) {
        // ignore
    }

    return redirect()->route('login')->with('success', 'Your password has been successfully reset! You can now log in with your new password.');
})->name('password.update');

// 5.1 SMTP Quick Test & Diagnostic Dashboard
Route::get('/test-email', function (Request $request) {
    $recipient = $request->query('to', 'suraj913708@gmail.com');
    $doSend = $request->has('send');

    $mailer = config('mail.default', 'log');
    $smtpHost = config('mail.mailers.smtp.host', '127.0.0.1');
    $smtpPort = config('mail.mailers.smtp.port', 2525);
    $smtpUser = config('mail.mailers.smtp.username');
    $hasPassword = ! empty(config('mail.mailers.smtp.password'));
    $fromAddress = config('mail.from.address');

    $sendResult = null;
    $sendError = null;

    if ($doSend) {
        try {
            Mail::raw("SkillLearner Live Test Email!\n\nIf you see this in your inbox, your SMTP configuration is 100% working!\nDelivered to: ".$recipient."\nMailer Used: ".$mailer."\nTimestamp: ".now()->toDateTimeString(), function ($message) use ($recipient) {
                $message->to($recipient)
                    ->subject('SkillLearner — Live Email Test Successful ✅');
            });
            $sendResult = true;
        } catch (Throwable $e) {
            $sendError = $e->getMessage();
            $sendResult = false;
        }
    }

    // Read last few lines of laravel.log
    $logFile = storage_path('logs/laravel.log');
    $recentLog = '';
    if (file_exists($logFile)) {
        $lines = file($logFile);
        $recentLines = array_slice($lines, -35);
        $recentLog = implode('', $recentLines);
    }

    $isLogMode = ($mailer === 'log');

    $html = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mail Diagnostics & Live Test — SkillLearner</title>
        <style>
            body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #f8fafc; color: #0f172a; margin: 0; padding: 30px 15px; }
            .diag-container { max-width: 760px; margin: 0 auto; }
            .card { background: #ffffff; border-radius: 14px; padding: 28px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; margin-bottom: 24px; }
            .badge { display: inline-block; padding: 6px 14px; border-radius: 999px; font-size: 13px; font-weight: 700; letter-spacing: 0.3px; }
            .badge-warn { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
            .badge-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
            .table-config { width: 100%; border-collapse: collapse; margin-top: 16px; font-size: 14px; }
            .table-config td { padding: 10px 12px; border-bottom: 1px solid #f1f5f9; }
            .table-config td:first-child { font-weight: 600; color: #64748b; width: 35%; }
            .btn { display: inline-block; background: #05B396; color: #ffffff; padding: 12px 24px; border-radius: 8px; font-weight: 700; text-decoration: none; border: none; cursor: pointer; font-size: 15px; }
            .btn:hover { background: #049e84; }
            pre { background: #0f172a; color: #e2e8f0; padding: 16px; border-radius: 8px; font-size: 12px; overflow-x: auto; max-height: 240px; }
            .step-box { background: #f0fdf4; border-left: 4px solid #05B396; padding: 14px 18px; border-radius: 6px; margin-top: 14px; font-size: 14px; line-height: 1.6; }
        </style>
    </head>
    <body>
    <div class="diag-container">
        
        <div style="text-align: center; margin-bottom: 25px;">
            <h1 style="margin: 0 0 6px; color: #00137a; font-size: 26px;">SkillLearner Mail Diagnostics &amp; Live Test</h1>
            <p style="margin: 0; color: #64748b; font-size: 14px;">Diagnose why emails are not reaching your inbox and send live test emails.</p>
        </div>';

    if ($sendResult === true) {
        if ($isLogMode) {
            $html .= '
            <div class="card" style="background: #fffbeb; border-color: #fde68a;">
                <h3 style="margin-top: 0; color: #b45309;">⚠️ Email Processed in "LOG" Mode (Simulated)</h3>
                <p style="margin: 6px 0; color: #92400e; font-size: 14px;">
                    Laravel executed the send command, <strong>BUT your .env file is currently set to <code>MAIL_MAILER=log</code></strong>.<br>
                    Because of this, no email was sent over the internet to Gmail. Instead, the full email was saved to <code>storage/logs/laravel.log</code>.
                </p>
                <p style="margin: 10px 0 0; color: #78350f; font-size: 13px; font-weight: 600;">
                    👉 To receive emails in your REAL Gmail inbox, you must change <code>MAIL_MAILER=smtp</code> in your <code>.env</code> file (see instructions below).
                </p>
            </div>';
        } else {
            $html .= '
            <div class="card" style="background: #f0fdf4; border-color: #86efac; text-align: center;">
                <h3 style="margin-top: 0; color: #15803d; font-size: 22px;">🎉 Real Email Sent Successfully!</h3>
                <p style="margin: 8px 0; color: #166534; font-size: 15px;">
                    Laravel successfully connected to your SMTP server and delivered an email to:<br>
                    <strong style="font-size: 18px; color: #0f172a;">'.e($recipient).'</strong>
                </p>
                <p style="margin: 12px 0 0; color: #4b5563; font-size: 13px;">
                    Please check your Gmail inbox (also check the <strong>Spam</strong> and <strong>Promotions</strong> folders right now)!
                </p>
            </div>';
        }
    } elseif ($sendResult === false) {
        $html .= '
        <div class="card" style="background: #fef2f2; border-color: #fca5a5;">
            <h3 style="margin-top: 0; color: #b91c1c;">❌ SMTP Error: Email Failed to Send</h3>
            <p style="margin: 6px 0; color: #7f1d1d; font-size: 14px;">Your mail server rejected the connection or credentials:</p>
            <pre style="background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; white-space: pre-wrap;">'.e($sendError).'</pre>
            <p style="margin: 12px 0 0; font-size: 13px; color: #374151;">
                <strong>Common Fix:</strong> If you are using Gmail, make sure you use a 16-character <strong>Google App Password</strong> (not your regular Gmail password) and that 2-Step Verification is turned ON.
            </p>
        </div>';
    }

    $html .= '
        <!-- Card 1: Current Configuration -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                <h2 style="font-size: 18px; margin: 0; color: #0f172a;">1. Current Mail Settings (from .env)</h2>
                '.($isLogMode ? '<span class="badge badge-warn">⚠️ LOG MODE (Simulated)</span>' : '<span class="badge badge-success">🟢 SMTP MODE (Real)</span>').'
            </div>
            
            <table class="table-config">
                <tr>
                    <td>MAIL_MAILER (Driver)</td>
                    <td><strong style="color: '.($isLogMode ? '#d97706' : '#05B396').';">'.$mailer.'</strong> '.($isLogMode ? '— <em>(Emails go to storage/logs/laravel.log only)</em>' : '— <em>(Connected to SMTP)</em>').'</td>
                </tr>
                <tr>
                    <td>MAIL_HOST</td>
                    <td><code>'.$smtpHost.'</code></td>
                </tr>
                <tr>
                    <td>MAIL_PORT</td>
                    <td><code>'.$smtpPort.'</code></td>
                </tr>
                <tr>
                    <td>MAIL_USERNAME</td>
                    <td><code>'.($smtpUser ?: '<span style="color: #ef4444;">null / Not Configured</span>').'</code></td>
                </tr>
                <tr>
                    <td>MAIL_PASSWORD</td>
                    <td>'.($hasPassword ? '<span style="color: #05B396; font-weight: 600;">•••••••••••••••• (Set)</span>' : '<span style="color: #ef4444; font-weight: 600;">❌ Not Set (Empty)</span>').'</td>
                </tr>
                <tr>
                    <td>MAIL_FROM_ADDRESS</td>
                    <td><code>'.$fromAddress.'</code></td>
                </tr>
            </table>

            '.($isLogMode ? '
            <div class="step-box" style="background: #fffbeb; border-left-color: #f59e0b; color: #92400e; margin-top: 18px;">
                <strong>Kyu mail nahi aa raha?</strong><br>
                Aapki <code>.env</code> file me <code>MAIL_MAILER=log</code> likha hua hai. Jab tak <code>MAIL_MAILER=smtp</code> aur Google App Password nahi daalenge, tab tak real mail nahi aayega!
            </div>' : '').'
        </div>

        <!-- Card 2: Send Live Test Email -->
        <div class="card">
            <h2 style="font-size: 18px; margin: 0 0 12px; color: #0f172a;">2. Send Live Test Email Now</h2>
            <p style="margin: 0 0 16px; color: #64748b; font-size: 14px;">Enter your email to test whether Laravel can deliver an email right now:</p>
            
            <form method="GET" action="'.url('/test-email').'" style="display: flex; gap: 10px; flex-wrap: wrap;">
                <input type="hidden" name="send" value="1">
                <input type="email" name="to" value="'.e($recipient).'" required placeholder="your-email@gmail.com" style="flex: 1; min-width: 260px; padding: 12px 16px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 15px;">
                <button type="submit" class="btn">🚀 Send Test Email</button>
            </form>
        </div>

        <!-- Card 3: Google App Password Setup Steps -->
        <div class="card">
            <h2 style="font-size: 18px; margin: 0 0 12px; color: #0f172a;">3. Gmail se Real Email bhejne ke 3 Steps</h2>
            <ol style="margin: 0; padding-left: 20px; font-size: 14px; line-height: 1.8; color: #334155;">
                <li>Google Account kholein: <a href="https://myaccount.google.com/security" target="_blank" style="color: #05B396; font-weight: 600;">myaccount.google.com/security</a> aur <strong>2-Step Verification</strong> ON karein.</li>
                <li>Direct link open karein: <a href="https://myaccount.google.com/apppasswords" target="_blank" style="color: #05B396; font-weight: 600;">myaccount.google.com/apppasswords</a></li>
                <li>App name me <code>SkillLearner</code> likhein aur <strong>Create</strong> karein. Google 16-letter ka password dega.</li>
                <li>Apni <code>.env</code> file me ye likhein:
                    <pre style="background: #1e293b; color: #f8fafc; padding: 12px; border-radius: 6px; margin: 8px 0; font-size: 13px;">MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=suraj913708@gmail.com
MAIL_PASSWORD=your_16_digit_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="suraj913708@gmail.com"
MAIL_FROM_NAME="SkillLearner"</pre>
                </li>
                <li>Terminal me command chalayein: <code>php artisan config:clear</code></li>
            </ol>
        </div>

        <!-- Card 4: Recent Log Output -->
        <div class="card">
            <h2 style="font-size: 18px; margin: 0 0 6px; color: #0f172a;">4. Recent Emails in storage/logs/laravel.log</h2>
            <p style="margin: 0 0 12px; color: #64748b; font-size: 13px;">Jab mailer <code>log</code> hota hai, to emails yahan aate hain:</p>
            <pre>'.e($recentLog ?: 'No emails logged yet in storage/logs/laravel.log').'</pre>
            <div style="margin-top: 14px; text-align: right;">
                <a href="'.url('/forgot-password').'" style="color: #05B396; font-weight: 600; text-decoration: none; font-size: 14px;">Go to Forgot Password Form &rarr;</a>
            </div>
        </div>

    </div>
    </body>
    </html>';

    return response($html);
});

// 6. Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout.perform');

// 7. Student Portal & Affiliate Center Routes (Dedicated Controllers & Blade Views)
Route::get('/my-courses', [StudentCourseController::class, 'index'])->name('portal.courses');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('portal.dashboard');
Route::get('/simulate-sale', [DashboardController::class, 'simulateSale'])->name('portal.simulate-sale');
Route::get('/profile', [ProfileController::class, 'index'])->name('portal.profile');
Route::post('/profile', [ProfileController::class, 'update'])->name('portal.profile.update');
Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('portal.profile.password');
Route::get('/social-community', [SocialCommunityController::class, 'index'])->name('portal.community');
Route::get('/kyc', [KycController::class, 'index'])->name('portal.kyc');
Route::post('/kyc', [KycController::class, 'update'])->name('portal.kyc.update');
Route::get('/affiliate-link', [AffiliateLinkController::class, 'index'])->name('portal.affiliate-link');
Route::get('/active-referrals', [ReferralController::class, 'activeReferrals'])->name('portal.active-referrals');
Route::get('/passive-referrals', [ReferralController::class, 'passiveReferrals'])->name('portal.passive-referrals');
Route::get('/active-referral', fn () => redirect()->route('portal.active-referrals'));
Route::get('/passive-referral', fn () => redirect()->route('portal.passive-referrals'));
Route::get('/token-purchases', fn () => redirect()->route('portal.active-referrals'));
Route::get('/certificates', fn () => redirect()->route('portal.courses'));
Route::get('/team-leaderboard', fn () => redirect()->route('portal.leaderboard'));
Route::get('/affiliate-training', [AffiliateTrainingController::class, 'index'])->name('portal.training');
Route::get('/marketing-tool', [MarketingToolController::class, 'index'])->name('portal.marketing');
Route::get('/my-payout', [PayoutController::class, 'index'])->name('portal.payout');
Route::post('/payout-request', [PayoutController::class, 'requestPayout'])->name('portal.payout-request');
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('portal.leaderboard');
Route::get('/qualification', [QualificationController::class, 'index'])->name('portal.qualification');
Route::get('/webinars', function () {
    PortalDataService::ensureUserSession();

    return view('portal.webinars', [
        'active' => 'webinars',
        'webinars' => [],
    ]);
})->name('portal.webinars');
Route::get('/live-offers', function () {
    PortalDataService::ensureUserSession();

    return view('portal.live-offers', [
        'active' => 'live-offers',
        'offers' => [],
    ]);
})->name('portal.live-offers');

// 7.1 Admin & Super Admin Management Routes (Protected by role middleware)
Route::middleware(['role:admin,super_admin'])->prefix('admin')->group(function () {
    // Executive Dashboard (Platform Revenue, Active & Passive Income Breakdown, and Approval Queue)
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    // Commission Payment Verification & Approval Actions
    Route::post('/commissions/{commission}/approve', [AdminController::class, 'approveCommission'])->name('admin.commissions.approve');
    Route::post('/commissions/{commission}/reject', [AdminController::class, 'rejectCommission'])->name('admin.commissions.reject');

    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('admin.users.role');
    Route::post('/users/{user}/toggle-payment', [AdminController::class, 'toggleUserPaymentStatus'])->name('admin.users.toggle-payment');
    Route::post('/users/{user}/industry-revenue', [AdminController::class, 'updateIndustryRevenue'])->name('admin.users.industry-revenue');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/kyc-requests', [AdminController::class, 'kycRequests'])->name('admin.kyc');
    Route::post('/kyc/{kyc}/approve', [AdminController::class, 'approveKyc'])->name('admin.kyc.approve');
    Route::post('/kyc/{kyc}/reject', [AdminController::class, 'rejectKyc'])->name('admin.kyc.reject');
    Route::get('/payout-requests', [AdminController::class, 'payoutRequests'])->name('admin.payouts');
    Route::post('/payout/{payout}/status', [AdminController::class, 'updatePayoutStatus'])->name('admin.payouts.status');

    // Mentor Management Routes (Add, Edit, Block, Delete, Assign Courses, Revenue Share %, KYC, Payouts)
    Route::get('/mentors', [MentorController::class, 'index'])->name('admin.mentors');
    Route::post('/mentors', [MentorController::class, 'store'])->name('admin.mentors.store');
    Route::put('/mentors/{mentor}', [MentorController::class, 'update'])->name('admin.mentors.update');
    Route::post('/mentors/{mentor}/toggle-status', [MentorController::class, 'toggleStatus'])->name('admin.mentors.toggle-status');
    Route::post('/mentors/{mentor}/toggle-featured', [MentorController::class, 'toggleFeatured'])->name('admin.mentors.toggle-featured');
    Route::delete('/mentors/{mentor}', [MentorController::class, 'destroy'])->name('admin.mentors.destroy');
    Route::post('/mentors/{mentor}/kyc', [MentorController::class, 'updateKyc'])->name('admin.mentors.kyc');
    Route::post('/mentors/{mentor}/payouts', [MentorController::class, 'createPayout'])->name('admin.mentors.payouts.store');
    Route::post('/mentors/payouts/{payout}/process', [MentorController::class, 'processPayout'])->name('admin.mentors.payouts.process');
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

    // Offer, Coupon, Flash Sale & 5 Package Management
    Route::get('/offers', [OfferController::class, 'index'])->name('admin.offers');
    Route::post('/offers', [OfferController::class, 'storeOffer'])->name('admin.offers.store');
    Route::put('/offers/{id}', [OfferController::class, 'updateOffer'])->name('admin.offers.update');
    Route::post('/offers/{id}/toggle-status', [OfferController::class, 'toggleOfferStatus'])->name('admin.offers.toggle-status');
    Route::post('/offers/{id}/stop', [OfferController::class, 'stopOffer'])->name('admin.offers.stop');
    Route::delete('/offers/{id}', [OfferController::class, 'destroyOffer'])->name('admin.offers.destroy');

    Route::post('/coupons', [OfferController::class, 'storeCoupon'])->name('admin.coupons.store');
    Route::put('/coupons/{id}', [OfferController::class, 'updateCoupon'])->name('admin.coupons.update');
    Route::post('/coupons/{id}/toggle-status', [OfferController::class, 'toggleCouponStatus'])->name('admin.coupons.toggle-status');
    Route::delete('/coupons/{id}', [OfferController::class, 'destroyCoupon'])->name('admin.coupons.destroy');

    Route::post('/packages/{slug}', [OfferController::class, 'updatePackage'])->name('admin.packages.update');

    // Live Web Migration Runner (Hostinger / cPanel helper)
    Route::get('/run-migrations', [OfferController::class, 'runMigrationsWeb'])->name('admin.run-migrations');

    // Live Web Cache Clear (Hostinger / cPanel helper)
    Route::get('/clear-cache', function () {
        if (! Auth::check() || Auth::user()->role !== 'super_admin') {
            abort(403, 'Unauthorized. Super Admin access required.');
        }

        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');

        return redirect()->back()->with('success', '✅ All live caches (Blade views, application cache, routes) have been cleared successfully!');
    })->name('admin.clear-cache');

    // Super Admin User/Admin Impersonation ("Login As")
    Route::get('/impersonate/{user}', [ImpersonateController::class, 'impersonate'])->name('admin.impersonate');
});

// Public AJAX endpoint to validate and calculate coupon discount at checkout
Route::post('/api/apply-coupon', [OfferController::class, 'applyCouponAjax'])->name('api.apply-coupon');

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

// Dedicated Buy Now Checkout Page (With Differential Upgrade Pricing for Active Students)
Route::get('/buy-now', function (Request $request) {
    $courses = getCourses();
    $packages = getPackages();

    $currentPackageName = null;
    if (Auth::check()) {
        $currentPackageName = Auth::user()->active_package;
    } elseif (session()->has('user.active_package')) {
        $currentPackageName = session('user.active_package');
    }

    $currentPackage = $currentPackageName ? CommissionService::getPackageInfo($currentPackageName) : null;

    $packagesWithUpgrade = array_map(function ($p) use ($currentPackageName) {
        $p['upgrade'] = CommissionService::getUpgradeDetails($currentPackageName, $p['id']);

        return $p;
    }, $packages);

    $courseSlug = $request->query('course');
    $packageId = $request->query('package');

    $selectedCourse = $courses[0];
    $selectedPackage = $packagesWithUpgrade[2]; // Default: Advance Package
    $type = 'package';

    // If logged in student has a current package and no specific package is requested, default to next higher tier
    if ($currentPackage && empty($packageId) && empty($courseSlug)) {
        if (strtolower($currentPackage['id']) === 'advance') {
            $selectedPackage = $packagesWithUpgrade[3]; // Premium Package
        } elseif (strtolower($currentPackage['id']) === 'premium') {
            $selectedPackage = $packagesWithUpgrade[4]; // Infinity Package
        }
    }

    if ($courseSlug) {
        $found = collect($courses)->firstWhere('slug', $courseSlug);
        if ($found) {
            $selectedCourse = $found;
            $type = 'course';
        }
    } elseif ($packageId) {
        $found = collect($packagesWithUpgrade)->first(function ($p) use ($packageId) {
            return strtolower($p['id']) === strtolower($packageId) || strtolower($p['id']) === strtolower(str_replace(' package', '', $packageId)) || strtolower($p['name']) === strtolower($packageId);
        });
        if ($found) {
            $selectedPackage = $found;
            $type = 'package';
        }
    }

    return view('buy-now', [
        'courses' => $courses,
        'packages' => $packagesWithUpgrade,
        'selectedCourse' => $selectedCourse,
        'selectedPackage' => $selectedPackage,
        'currentPackage' => $currentPackage,
        'type' => $type,
    ]);
})->name('buy.now');

// -------------------------------------------------------------
// Checkout & Buy-Now Routes
// -------------------------------------------------------------

// Referral Code Instant Verification API
Route::get('/verify-referral/{code?}', function ($code = null) {
    $code = trim((string) $code);
    if (empty($code) || in_array(strtoupper($code), ['SKL-ADMIN', 'SL-ADMIN', 'ADMIN'])) {
        return response()->json([
            'valid' => true,
            'sponsor_name' => 'SkillLearner Official (Direct)',
            'sponsor_id' => 'SKL-ADMIN',
        ]);
    }

    $sponsor = User::where('affiliate_id', $code)
        ->orWhere('email', $code)
        ->orWhere('phone', $code)
        ->first();

    if ($sponsor) {
        return response()->json([
            'valid' => true,
            'sponsor_name' => $sponsor->name,
            'sponsor_id' => $sponsor->affiliate_id ?? $code,
        ]);
    }

    return response()->json([
        'valid' => false,
        'message' => 'Invalid referral code. Defaulting to SKL-ADMIN.',
        'sponsor_id' => 'SKL-ADMIN',
    ]);
});

Route::post('/checkout/register', function (Request $request) {
    return redirect()->action('process-buy-now');
})->name('checkout.register');

Route::post('/checkout/login', function (Request $request) {
    $request->validate([
        'username' => ['required', 'string'],
        'password' => ['required', 'string'],
        'package' => ['nullable', 'string'],
        'ref' => ['nullable', 'string'],
    ]);

    $username = trim((string) $request->input('username'));
    $password = (string) $request->input('password');
    $packageParam = $request->input('package', 'advance');
    $refParam = $request->input('ref', 'SKL-ADMIN');

    $field = 'email';
    if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $field = 'email';
    } elseif (preg_match('/^[0-9+\s\-]{7,20}$/', $username)) {
        $field = 'phone';
    } elseif (str_starts_with(strtoupper($username), 'SKL-') || str_starts_with(strtoupper($username), 'SL-')) {
        $field = 'affiliate_id';
    } else {
        $matched = User::where('email', $username)->orWhere('affiliate_id', $username)->orWhere('phone', $username)->first();
        if ($matched) {
            $field = 'email';
            $username = $matched->email;
        }
    }

    if (Auth::attempt([$field => $username, 'password' => $password], true)) {
        $user = Auth::user();

        $request->session()->regenerate();

        session(['user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? '',
            'affiliate_id' => $user->affiliate_id ?? ('SKL-'.$user->id),
            'sponsor_id' => $user->sponsor_id ?? $refParam,
            'active_package' => $user->active_package ?? 'Advance Package',
            'wallet_balance' => (float) $user->wallet_balance,
            'today_earning' => (float) $user->today_earning,
            'weekly_earning' => (float) $user->weekly_earning,
            'monthly_earning' => (float) ($user->monthly_earning ?? 0),
            'total_earning' => (float) $user->total_earning,
            'passive_earning' => (float) ($user->passive_earning ?? 0),
            'kyc_status' => $user->kyc_status ?? 'Pending Verification',
            'avatar' => $user->avatar,
            'role' => $user->role ?? 'affiliate',
        ]]);

        return redirect('/dashboard')->with('success', 'Welcome back, '.$user->name.'!');
    }

    return redirect('/buy-now?package='.urlencode($packageParam).'&ref='.urlencode($refParam))
        ->withInput($request->only('username'))
        ->with('error', 'Invalid login credentials. Please check your username/email and password.');
})->name('checkout.login');

// Action: Process Buy Now Form Submission
Route::post('/process-buy-now', function (Request $request) {
    $authUser = Auth::user();
    if (! $authUser && session()->has('user.id')) {
        $authUser = User::find(session('user.id'));
    }

    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'phone' => ['required', 'string', 'max:25'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'password' => [$authUser ? 'nullable' : 'required', 'string'],
        'package' => ['required', 'string'],
        'referral_code' => ['nullable', 'string', 'max:100'],
        'payment_method' => ['nullable', 'string'],
    ]);

    $name = trim((string) $request->input('name'));
    $phone = trim((string) $request->input('phone'));
    $email = strtolower(trim((string) $request->input('email')));
    $password = (string) $request->input('password');
    $packageKey = strtolower(trim((string) $request->input('package', 'advance')));
    $referralCode = trim((string) $request->input('referral_code', ''));
    $paymentMethod = $request->input('payment_method', 'payment_link');

    if (empty($referralCode)) {
        $referralCode = 'SKL-ADMIN';
    }

    // Verify referral code
    $sponsor = User::where('affiliate_id', $referralCode)
        ->orWhere('email', $referralCode)
        ->orWhere('phone', $referralCode)
        ->first();
    $sponsorId = $sponsor ? ($sponsor->affiliate_id ?? $referralCode) : 'SKL-ADMIN';

    $pkg = CommissionService::getPackageInfo($packageKey);
    $activePackageName = $pkg['name'];
    $packagePrice = (float) $pkg['price'];

    // Check for optional Coupon Code discount
    $couponCode = strtoupper(trim((string) $request->input('coupon_code', '')));
    $couponDiscount = 0;
    if (! empty($couponCode)) {
        $couponCheck = PackageService::validateCoupon($couponCode, $packageKey, $packagePrice, $email);
        if (! empty($couponCheck['valid'])) {
            $couponDiscount = (float) $couponCheck['discount_amount'];
            PackageService::recordRedemption([
                'coupon_id' => $couponCheck['coupon_id'] ?? null,
                'user_name' => $name ?: ($authUser?->name ?? 'Student'),
                'user_email' => $email ?: ($authUser?->email ?? ''),
                'user_phone' => $phone ?: ($authUser?->phone ?? ''),
                'package_slug' => $packageKey,
                'package_name' => $activePackageName,
                'code_used' => $couponCode,
                'original_amount' => $packagePrice,
                'discount_amount' => $couponDiscount,
                'final_amount' => max(0, $packagePrice - $couponDiscount),
            ]);
        }
    }

    // If user is already logged in or session matches, perform Differential Upgrade
    if ($authUser && ($authUser->email === $email || empty($email) || (session()->has('user.email') && session('user.email') === $email))) {
        $upgrade = CommissionService::getUpgradeDetails($authUser->active_package, $packageKey);

        if ($upgrade['is_current']) {
            return back()->withInput()->with('error', "Aap pehle se {$activePackageName} par hain.");
        }

        if ($upgrade['is_lower']) {
            return back()->withInput()->with('error', "Aapka vartaman package ({$authUser->active_package}) is se uncha hai.");
        }

        $payablePrice = $upgrade['is_upgrade'] ? $upgrade['payable_price'] : $packagePrice;
        if ($couponDiscount > 0) {
            $payablePrice = max(0, $payablePrice - $couponDiscount);
        }

        // Upgrade user active package
        $authUser->update([
            'active_package' => $activePackageName,
            'name' => $name ?: $authUser->name,
            'phone' => $phone ?: $authUser->phone,
        ]);

        if (session()->has('user')) {
            session(['user.active_package' => $activePackageName]);
        }

        // Ensure newly included courses are available
        $courses = Course::all();
        foreach ($courses as $c) {
            UserCourse::firstOrCreate([
                'user_id' => $authUser->id,
                'course_id' => $c->id,
            ], [
                'progress_percent' => 0,
            ]);
        }

        // Generate unique Order ID
        $orderId = 'SKL-UPG-'.rand(100000, 999999);

        $orderData = [
            'order_id' => $orderId,
            'package_id' => $pkg['id'],
            'package_name' => $activePackageName,
            'amount' => $payablePrice,
            'original_amount' => $packagePrice,
            'discount' => $upgrade['discount'],
            'is_upgrade' => true,
            'previous_package' => $authUser->active_package,
            'transaction_id' => 'PENDING',
            'status' => 'Pending',
            'user_id' => $authUser->id,
            'user_name' => $authUser->name,
            'user_email' => $authUser->email,
            'sponsor_id' => $authUser->sponsor_id ?? $sponsorId,
            'payment_method' => $paymentMethod,
            'created_at' => now()->toDateTimeString(),
        ];

        session(['last_order' => $orderData]);

        // Distribute upgrade commission in 'Pending' state
        CommissionService::processSale(
            $activePackageName,
            $authUser->name,
            $authUser->sponsor_id ?? $sponsorId,
            $authUser,
            initialStatus: 'Pending'
        );

        return redirect('/payment-status')->with('success', "Aapka package {$activePackageName} me upgrade order create ho gaya hai! ₹{$upgrade['discount']} ki chhoot mili hai. Payable: ₹{$payablePrice}.");
    }

    // Check if user already exists (for guest checkout)
    $existingUser = User::where('email', $email)->first();

    if ($existingUser) {
        return back()->withInput()->with('error', 'Is email ke sath account pehle se maujood hai. Kripya pehle Log In karein taaki aapka current package value minus ho sake!');
    }

    // Generate unique affiliate ID
    $affiliateId = 'SKL-'.rand(1000, 9999);
    while (User::where('affiliate_id', $affiliateId)->exists()) {
        $affiliateId = 'SKL-'.rand(1000, 9999);
    }

    // Create user with payment_status = 'paid'
    $user = User::create([
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'password' => Hash::make($password),
        'affiliate_id' => $affiliateId,
        'sponsor_id' => $sponsorId,
        'active_package' => $activePackageName,
        'payment_status' => 'paid',
        'wallet_balance' => 0.00,
        'today_earning' => 0.00,
        'weekly_earning' => 0.00,
        'monthly_earning' => 0.00,
        'total_earning' => 0.00,
        'passive_earning' => 0.00,
        'kyc_status' => 'Pending Verification',
        'role' => 'affiliate',
    ]);

    // Enroll into courses with 0% progress
    $courses = Course::all();
    foreach ($courses as $c) {
        UserCourse::firstOrCreate([
            'user_id' => $user->id,
            'course_id' => $c->id,
        ], [
            'progress_percent' => 0,
        ]);
    }

    // Send branded welcome email notification
    EmailNotificationService::sendAccountCreated($user, $activePackageName);

    // Generate unique Order ID
    $orderId = 'SKL-'.rand(100000, 999999);

    $finalGuestAmount = max(0, $packagePrice - $couponDiscount);

    $orderData = [
        'order_id' => $orderId,
        'package_id' => $pkg['id'],
        'package_name' => $activePackageName,
        'amount' => $finalGuestAmount,
        'original_amount' => $packagePrice,
        'discount' => $couponDiscount,
        'coupon_code' => $couponCode ?: null,
        'transaction_id' => 'PENDING',
        'status' => 'Pending',
        'user_id' => $user->id,
        'user_name' => $user->name,
        'user_email' => $user->email,
        'sponsor_id' => $user->sponsor_id,
        'payment_method' => $paymentMethod,
        'created_at' => now()->toDateTimeString(),
    ];

    session(['last_order' => $orderData]);

    // Distribute 2-Tier commission in 'Pending' state so it appears in Admin Dashboard
    CommissionService::processSale(
        $activePackageName,
        $user->name,
        $user->sponsor_id,
        $user,
        initialStatus: 'Pending'
    );

    // CRITICAL: DO NOT Auth::login($user)! ID stays with Admin until payment verification!

    return redirect('/payment-status')->with('success', 'Order create ho gaya hai! Kripya payment karke UTR submit karein. Admin dwara payment verify hone ke baad hi aapki ID activate hogi aur aap login kar sakenge.');
})->name('process.buynow');

// ==========================================
// CASHFREE PAYMENT GATEWAY INTEGRATION
// ==========================================
Route::post('/payment/cashfree/initiate', [CashfreePaymentController::class, 'initiatePayment'])->name('payment.cashfree.initiate');
Route::get('/payment/cashfree/callback', [CashfreePaymentController::class, 'handleCallback'])->name('payment.cashfree.callback');
Route::post('/payment/cashfree/webhook', [CashfreePaymentController::class, 'handleWebhook'])->name('payment.cashfree.webhook');

// Submit UTR Transaction Reference
Route::post('/submit-utr', function (Request $request) {
    $request->validate([
        'transaction_id' => ['required', 'string', 'min:6', 'max:50'],
    ]);

    $transactionId = trim((string) $request->input('transaction_id'));
    $order = session('last_order', []);

    $order['transaction_id'] = $transactionId;
    $order['status'] = 'Pending';
    session(['last_order' => $order]);

    return back()->with('success', "✅ UTR Reference '{$transactionId}' submit ho gaya hai! Admin ise verify karke aapka account activate karega.");
})->name('payment.submit-utr');

// Dedicated Payment Status Page (Pending & Success States)
Route::get('/payment-status', function (Request $request) {
    $order = session('last_order');

    if ($order && ! empty($order['user_email']) && ($order['payment_method'] ?? '') !== 'cashfree') {
        $buyer = User::where('email', $order['user_email'])->first();
        if ($buyer && $buyer->payment_status === 'paid') {
            $order['status'] = 'Credited';
            session(['last_order' => $order]);
        }
    }

    if (Auth::check() && ($order['payment_method'] ?? '') !== 'cashfree') {
        $user = Auth::user();

        // Check if admin has verified any commission for this student
        $creditedComm = Commission::where('buyer_name', 'like', "%{$user->name}%")
            ->where('status', 'Credited')
            ->latest()
            ->first();

        if ($creditedComm && session()->has('last_order') && ($order['status'] ?? '') !== 'Failed') {
            $order = session('last_order');
            $order['status'] = 'Credited';
            session(['last_order' => $order]);
        }
    }

    if (! $order) {
        $order = [
            'order_id' => 'SKL-'.rand(100000, 999999),
            'package_name' => Auth::user()?->active_package ?? 'Advance Package',
            'amount' => 2499,
            'transaction_id' => 'PENDING',
            'status' => $request->query('status') === 'success' ? 'Credited' : 'Pending',
            'user_name' => Auth::user()?->name ?? session('user.name', 'Student'),
            'user_email' => Auth::user()?->email ?? session('user.email', ''),
        ];
    }

    if ($request->query('status') === 'success') {
        $order['status'] = 'Credited';
    }

    return view('payment-status', [
        'order' => $order,
    ]);
})->name('payment.status');

// ==========================================
// BRANDED EMAIL TEMPLATES PREVIEW (FOR VERIFICATION)
// ==========================================
Route::prefix('/admin/emails-preview')->group(function () {
    Route::get('/passive-referral', function () {
        return new PassiveReferralMail(
            userName: 'Adarsh Pandey',
            amount: 20.00,
            buyerName: 'Rahul Sharma',
            packageName: 'Advance Package'
        );
    })->name('email.preview.passive');

    Route::get('/active-referral', function () {
        return new ActiveReferralMail(
            userName: 'Adarsh Pandey',
            amount: 420.00,
            buyerName: 'Rahul Sharma',
            packageName: 'Basic Package'
        );
    })->name('email.preview.active');

    Route::get('/account-created', function () {
        return new AccountCreatedMail(
            userName: 'Adarsh Pandey',
            email: 'adarsh@example.com',
            affiliateId: 'SKL-9824',
            packageName: 'Advance Package'
        );
    })->name('email.preview.created');

    Route::get('/forgot-password', function () {
        return new ForgotPasswordMail(
            userName: 'Adarsh Pandey',
            resetUrl: url('/reset-password/sample-token?email=adarsh@example.com')
        );
    })->name('email.preview.forgot');
});

// Interactive Web Email Testing Tool
Route::match(['get', 'post'], '/admin/send-test-email', function (Request $request) {
    $to = $request->input('to', config('mail.from.address', 'info@skilllearner.org'));
    $type = $request->input('type', 'passive');
    $result = null;
    $error = null;

    if ($request->isMethod('post') || $request->boolean('send')) {
        try {
            $mailable = match ($type) {
                'active' => new ActiveReferralMail('Adarsh Pandey', 420.00, 'Rahul Sharma', 'Basic Package'),
                'created', 'welcome' => new AccountCreatedMail('Adarsh Pandey', $to, 'SKL-9824', 'Advance Package'),
                'forgot' => new ForgotPasswordMail('Adarsh Pandey', url('/reset-password/sample-token?email='.urlencode($to))),
                default => new PassiveReferralMail('Adarsh Pandey', 20.00, 'Rahul Sharma', 'Advance Package'),
            };

            Mail::to($to)->send($mailable);
            $result = "✅ Success! [{$type}] test email dispatched to {$to} via driver '".config('mail.default')."'. Check your inbox / spam!";
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }
    }

    $mailer = config('mail.default');
    $host = config('mail.mailers.smtp.host');
    $port = config('mail.mailers.smtp.port');
    $user = config('mail.mailers.smtp.username');

    $html = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>Skilllearner Email Testing Tool</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #0f172a; color: #f8fafc; padding: 30px 16px; margin: 0; }
        .box { max-width: 600px; margin: 0 auto; background: #1e293b; border-radius: 16px; padding: 28px; box-shadow: 0 10px 30px rgba(0,0,0,0.4); border: 1px solid #334155; }
        h1 { color: #05B396; font-size: 22px; margin-top: 0; }
        .config-box { background: #0b132b; border-radius: 8px; padding: 12px 16px; font-size: 13px; color: #94a3b8; margin-bottom: 20px; line-height: 1.6; }
        .config-box strong { color: #f1f5f9; }
        .alert-success { background: #064e3b; border: 1px solid #059669; color: #a7f3d0; padding: 12px 16px; border-radius: 8px; margin-bottom: 18px; font-size: 14px; }
        .alert-error { background: #7f1d1d; border: 1px solid #dc2626; color: #fecaca; padding: 12px 16px; border-radius: 8px; margin-bottom: 18px; font-size: 14px; }
        label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #cbd5e1; }
        input, select { width: 100%; box-sizing: border-box; padding: 10px 12px; border-radius: 8px; border: 1px solid #475569; background: #0f172a; color: #fff; font-size: 14px; margin-bottom: 16px; }
        button { width: 100%; background: #05B396; color: #fff; border: 0; padding: 13px; border-radius: 8px; font-weight: 700; font-size: 15px; cursor: pointer; transition: 0.2s; }
        button:hover { background: #048a74; }
        .links { margin-top: 24px; padding-top: 18px; border-top: 1px solid #334155; display: flex; flex-wrap: wrap; gap: 8px; }
        .links a { background: #334155; color: #38bdf8; text-decoration: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .links a:hover { background: #475569; color: #fff; }
    </style>
</head>
<body>
    <div class="box">
        <h1>🚀 Skilllearner Email Testing Tool</h1>
        <div class="config-box">
            <strong>Mailer:</strong> {$mailer} | <strong>Host:</strong> {$host}:{$port}<br>
            <strong>Username:</strong> {$user}
        </div>

HTML;

    if ($result) {
        $html .= '<div class="alert-success">'.e($result).'</div>';
    }
    if ($error) {
        $html .= '<div class="alert-error"><strong>❌ Error:</strong> '.e($error).'<br><small style="margin-top:6px;display:block;">Tip: Verify that MAIL_PASSWORD in your .env matches your Hostinger email password.</small></div>';
    }

    $html .= <<<HTML
        <form method="POST" action="/admin/send-test-email">
            <input type="hidden" name="_token" value="{$request->session()->token()}">
            <label>Recipient Email Address (Where to send test email):</label>
            <input type="email" name="to" value="{$to}" required placeholder="your-email@gmail.com">

            <label>Select Template Type:</label>
            <select name="type">
                <option value="passive">Passive Referral (20.00 INR)</option>
                <option value="active">Active Referral (420.00 INR)</option>
                <option value="welcome">Account Created / Welcome</option>
                <option value="forgot">Forgot Password</option>
            </select>

            <button type="submit">Send Test Email Now &rarr;</button>
        </form>

        <div class="links">
            <span style="font-size: 12px; color: #94a3b8; width: 100%;">Direct In-Browser Previews (No SMTP needed):</span>
            <a href="/admin/emails-preview/passive-referral" target="_blank">👁️ Preview Passive Referral</a>
            <a href="/admin/emails-preview/active-referral" target="_blank">👁️ Preview Active Referral</a>
            <a href="/admin/emails-preview/account-created" target="_blank">👁️ Preview Welcome / Account</a>
            <a href="/admin/emails-preview/forgot-password" target="_blank">👁️ Preview Forgot Password</a>
        </div>
    </div>
</body>
</html>
HTML;

    return response($html);
})->name('admin.send-test-email');
