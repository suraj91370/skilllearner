<?php

namespace App\Services;

class PortalDataService
{
    public static function getDemoUserData(): array
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
        ];
    }

    public static function ensureUserSession(): void
    {
        if (! session()->has('user')) {
            session(['user' => self::getDemoUserData()]);
        }
        self::initDefaultCommissions();
    }

    public static function initDefaultCommissions(): void
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

    public static function getEnrolledCourses(): array
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
