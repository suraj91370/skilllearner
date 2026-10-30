<?php

namespace Database\Seeders;

use App\Models\Commission;
use App\Models\Course;
use App\Models\KycVerification;
use App\Models\Package;
use App\Models\Payout;
use App\Models\User;
use App\Models\UserCourse;
use App\Models\Video;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Packages
        $packagesData = [
            [
                'slug' => 'basic',
                'name' => 'Basic Package',
                'price' => 1499,
                'old_price' => 2999,
                'image' => 'images/packages/basic.png',
                'badge' => '',
                'featured' => false,
                'color' => '#A855F7',
                'border_color' => 'rgba(168, 85, 247, 0.45)',
                'bg_gradient' => 'linear-gradient(180deg, #1b0c33 0%, #0d0519 100%)',
                'description' => 'Foundational skill track to get started in the digital economy with Canva, Excel, English and Social Media basics.',
                'courses_included' => ['Canva Pro Mastery', 'MS Excel Essentials', 'Basic Spoken English', 'Social Media Fundamentals'],
            ],
            [
                'slug' => 'growth',
                'name' => 'Growth Package',
                'price' => 5999,
                'old_price' => 11999,
                'image' => 'images/packages/growth.png',
                'badge' => '',
                'featured' => false,
                'color' => '#10B981',
                'border_color' => 'rgba(16, 185, 129, 0.45)',
                'bg_gradient' => 'linear-gradient(180deg, #063124 0%, #021711 100%)',
                'description' => 'Scale your revenue with high-ticket sales closing, complete sales funnel architecture, and Google & YouTube advertising.',
                'courses_included' => ['All Premium Courses', 'Complete Funnel Building', 'High-Ticket Sales Closing', 'Google & YouTube Ads'],
            ],
            [
                'slug' => 'advance',
                'name' => 'Advance Package',
                'price' => 2499,
                'old_price' => 4999,
                'image' => 'images/packages/advance.png',
                'badge' => '',
                'featured' => false,
                'color' => '#0284C7',
                'border_color' => 'rgba(2, 132, 199, 0.45)',
                'bg_gradient' => 'linear-gradient(180deg, #07263e 0%, #021320 100%)',
                'description' => 'Our flagship bundle unlocking high-ticket video editing, Instagram organic growth formulas, and 70% direct referral commission rights.',
                'courses_included' => ['All Basic Courses', 'Video Editing (Premiere & CapCut)', 'Instagram Growth Formula', 'Organic Lead Generation Blueprint'],
            ],
            [
                'slug' => 'premium',
                'name' => 'Premium Package',
                'price' => 3999,
                'old_price' => 7999,
                'image' => 'images/packages/premium.png',
                'badge' => '',
                'featured' => false,
                'color' => '#F59E0B',
                'border_color' => 'rgba(245, 158, 11, 0.45)',
                'bg_gradient' => 'linear-gradient(180deg, #331c02 0%, #150a00 100%)',
                'description' => 'High-yield monetization bundle with Facebook & Instagram paid ads, AI ChatGPT automation kit, and no-code WordPress design.',
                'courses_included' => ['All Advance Courses', 'Facebook & Instagram Paid Ads', 'AI & ChatGPT Monetization Kit', 'WordPress Web Development'],
            ],
            [
                'slug' => 'infinity',
                'name' => 'Infinity Package',
                'price' => 9999,
                'old_price' => 19999,
                'image' => 'images/packages/infinity.png',
                'badge' => '',
                'featured' => false,
                'color' => '#EF4444',
                'border_color' => 'rgba(239, 68, 68, 0.45)',
                'bg_gradient' => 'linear-gradient(180deg, #330606 0%, #160202 100%)',
                'description' => 'VIP pass granting unlimited lifetime access to all current and future masterclasses, 1-on-1 mentorship, and weekly mastermind sessions.',
                'courses_included' => ['Full Lifetime Access Pass', 'UI/UX Design Masterclass', '1-on-1 Mentorship & Weekly Live Masterminds', 'VIP Community & Support'],
            ],
        ];

        $packageModels = [];
        foreach ($packagesData as $pkg) {
            $packageModels[$pkg['slug']] = Package::updateOrCreate(['slug' => $pkg['slug']], $pkg);
        }

        // 2. Seed Courses
        $coursesData = [
            [
                'package_id' => $packageModels['basic']->id,
                'package_name' => 'Basic Package',
                'slug' => 'basic-business-automation',
                'title' => 'Basic Business Automation',
                'category' => 'Automation & Productivity',
                'instructor' => 'Aman Rawat',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'BASIC BUSINESS AUTOMATION',
                'banner_tag' => 'All About Automation — Work Smarter, Not Harder',
                'accent' => '#06b6d4',
                'gradient' => 'linear-gradient(135deg, #070d1e 0%, #0f172a 45%, #0e7490 100%)',
                'lessons' => 16,
                'duration' => '4h 30m',
                'price' => 999,
                'old_price' => 2499,
                'tagline' => 'Automate everyday repetitive workflows with free digital tools.',
                'description' => 'Master simple business automations, Google Sheets scripts, and task workflows to save 10+ hours weekly.',
            ],
            [
                'package_id' => $packageModels['premium']->id,
                'package_name' => 'Premium Package',
                'slug' => 'basic-facebook-ads-course',
                'title' => 'Basic Facebook ADs course',
                'category' => 'Performance Marketing',
                'instructor' => 'Prateek Garg',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'BASIC FACEBOOK ADS COURSE',
                'banner_tag' => 'Run High-Converting Ads — Zero Prior Experience',
                'accent' => '#8b5cf6',
                'gradient' => 'linear-gradient(135deg, #09090b 0%, #1e1b4b 50%, #4c1d95 100%)',
                'lessons' => 14,
                'duration' => '5h 15m',
                'price' => 1499,
                'old_price' => 3999,
                'tagline' => 'Create profitable Meta ads for lead generation and brand awareness.',
                'description' => 'Complete beginner guide to running Facebook and Instagram ads with minimal daily ad spend.',
            ],
            [
                'package_id' => $packageModels['basic']->id,
                'package_name' => 'Basic Package',
                'slug' => 'canva-pro-mastery',
                'title' => 'Canva Pro',
                'category' => 'Graphic Design',
                'instructor' => 'Kunal Sharma',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'CANVA MASTERY COURSE',
                'banner_tag' => 'Design Like A Pro — 50+ Ready Social Templates',
                'accent' => '#d946ef',
                'gradient' => 'linear-gradient(135deg, #18052e 0%, #3b0764 50%, #701a75 100%)',
                'lessons' => 12,
                'duration' => '3h 45m',
                'price' => 799,
                'old_price' => 1999,
                'tagline' => 'Create professional posters, thumbnails, and presentations in minutes.',
                'description' => 'Everything you need to master Canva for personal branding, freelancing, and digital products.',
            ],
            [
                'package_id' => $packageModels['advance']->id,
                'package_name' => 'Advance Package',
                'slug' => 'capcut-mobile-editing',
                'title' => 'Capcut Mobile Editing',
                'category' => 'Video Editing',
                'instructor' => 'Kunal Sharma',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'CAPCUT MOBILE VIDEO EDITING',
                'banner_tag' => 'From Beginner to Pro Editor — Mobile Friendly',
                'accent' => '#a855f7',
                'gradient' => 'linear-gradient(135deg, #050510 0%, #1e103a 50%, #311054 100%)',
                'lessons' => 18,
                'duration' => '6h 10m',
                'price' => 1299,
                'old_price' => 3499,
                'tagline' => 'Edit viral reels directly from your phone.',
                'description' => 'Step-by-step masterclass in kinetic captions, sound effects, cuts, and viral hooks on CapCut mobile.',
            ],
            [
                'package_id' => $packageModels['advance']->id,
                'package_name' => 'Advance Package',
                'slug' => 'content-creation-mastery',
                'title' => 'Content Creation Mastery Course',
                'category' => 'Content Strategy',
                'instructor' => 'Rohan Sen',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'CONTENT CREATION MASTERY COURSE',
                'banner_tag' => 'Viral Short Video Formats for Instagram & YouTube',
                'accent' => '#818cf8',
                'gradient' => 'linear-gradient(135deg, #0f0a28 0%, #2e1065 60%, #4338ca 100%)',
                'lessons' => 20,
                'duration' => '7h 20m',
                'price' => 1499,
                'old_price' => 3999,
                'tagline' => 'Master scripting, camera presence, and distribution.',
                'description' => 'Grow an engaged audience across Instagram, YouTube Shorts, and LinkedIn using proven viral frameworks.',
            ],
            [
                'package_id' => $packageModels['premium']->id,
                'package_name' => 'Premium Package',
                'slug' => 'meta-ads-mastery',
                'title' => 'Meta Ads Mastery: Facebook & Instagram Leads',
                'category' => 'Performance Marketing',
                'instructor' => 'Prateek Garg',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'META ADS MASTERY',
                'banner_tag' => 'High Return On Ad Spend & Custom Audience Secrets',
                'accent' => '#38bdf8',
                'gradient' => 'linear-gradient(135deg, #020617 0%, #172554 60%, #1e3a8a 100%)',
                'lessons' => 16,
                'duration' => '5h 50m',
                'price' => 1699,
                'old_price' => 4499,
                'tagline' => 'Scale client leads with precision targeting and custom events.',
                'description' => 'Complete blueprint for setting up pixels, CBO campaigns, instant lead forms, and agency pitch decks.',
            ],
            [
                'package_id' => $packageModels['advance']->id,
                'package_name' => 'Advance Package',
                'slug' => 'instagram-growth-mastery',
                'title' => 'Instagram Growth Mastery',
                'category' => 'Social Media',
                'instructor' => 'Vikram Malhotra',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'INSTAGRAM GROWTH MASTERY',
                'banner_tag' => 'From Zero to Influencer — Complete Organic Blueprint',
                'accent' => '#c084fc',
                'gradient' => 'linear-gradient(135deg, #110726 0%, #2e1065 50%, #581c87 100%)',
                'lessons' => 15,
                'duration' => '4h 50m',
                'price' => 999,
                'old_price' => 2499,
                'tagline' => 'Build high-converting authority on Instagram organically.',
                'description' => 'Niche selection, algorithm triggers, daily story funnels, and DM strategies to land paid sponsors and clients.',
            ],
            [
                'package_id' => $packageModels['growth']->id,
                'package_name' => 'Growth Package',
                'slug' => 'lead-generation-mastery',
                'title' => 'Lead Generation Mastery Course',
                'category' => 'Sales & Growth',
                'instructor' => 'Aryan Verma',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'LEAD GENERATION MASTERY COURSE',
                'banner_tag' => 'Organic & Paid High-Ticket Lead Closing Formulas',
                'accent' => '#f97316',
                'gradient' => 'linear-gradient(135deg, #0c0a09 0%, #291505 50%, #7c2d12 100%)',
                'lessons' => 12,
                'duration' => '4h 10m',
                'price' => 1499,
                'old_price' => 3999,
                'tagline' => 'Consistent flow of qualified inbound buyers.',
                'description' => 'Inbound DM scripts, LinkedIn lead generation, WhatsApp automation sequences, and high-ticket qualification calls.',
            ],
            [
                'package_id' => $packageModels['growth']->id,
                'package_name' => 'Growth Package',
                'slug' => 'sales-funnel-mastery',
                'title' => 'High-Converting Sales Funnel',
                'category' => 'Funnel Architecture',
                'instructor' => 'Aryan Verma',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'SALES FUNNEL BLUEPRINT',
                'banner_tag' => 'Landing Pages, WhatsApp Automation & High Conversions',
                'accent' => '#10b981',
                'gradient' => 'linear-gradient(135deg, #022c22 0%, #064e3b 50%, #047857 100%)',
                'lessons' => 14,
                'duration' => '5h 00m',
                'price' => 1799,
                'old_price' => 4999,
                'tagline' => 'Build automated funnel machines that generate sales 24/7.',
                'description' => 'Opt-in landing pages, VSL pages, order bumps, upsells, and payment integrations with Razorpay and Stripe.',
            ],
            [
                'package_id' => $packageModels['advance']->id,
                'package_name' => 'Advance Package',
                'slug' => 'premiere-pro-video-editing',
                'title' => 'Premiere Pro Video Editing',
                'category' => 'Video Production',
                'instructor' => 'Rohan Sen',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'PREMIERE PRO MASTERY',
                'banner_tag' => 'Cinematic Transitions, SFX & Viral Reels Workflow',
                'accent' => '#38bdf8',
                'gradient' => 'linear-gradient(135deg, #020617 0%, #0c4a6e 60%, #0284c7 100%)',
                'lessons' => 22,
                'duration' => '8h 15m',
                'price' => 1999,
                'old_price' => 4999,
                'tagline' => 'Industry-standard desktop video editing for premium clients.',
                'description' => 'Color grading, multi-track audio mastering, green screen, motion graphics, and high-speed editing shortcuts.',
            ],
            [
                'package_id' => $packageModels['premium']->id,
                'package_name' => 'Premium Package',
                'slug' => 'chatgpt-ai-automation',
                'title' => 'AI & ChatGPT Monetization Kit',
                'category' => 'Artificial Intelligence',
                'instructor' => 'Aman Rawat',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'AI & CHATGPT AUTOMATION',
                'banner_tag' => 'Automate Marketing, Copywriting & Workflows with AI',
                'accent' => '#ec4899',
                'gradient' => 'linear-gradient(135deg, #180324 0%, #4a044e 50%, #86198f 100%)',
                'lessons' => 11,
                'duration' => '3h 30m',
                'price' => 1299,
                'old_price' => 3499,
                'tagline' => 'Harness generative AI to deliver paid freelance work 10x faster.',
                'description' => 'Advanced prompts for ChatGPT, Midjourney, Claude, ElevenLabs voice cloning, and Zapier no-code automations.',
            ],
            [
                'package_id' => $packageModels['advance']->id,
                'package_name' => 'Advance Package',
                'slug' => 'affiliate-marketing-masterclass',
                'title' => 'High-Ticket Affiliate Blueprint',
                'category' => 'Affiliate Marketing',
                'instructor' => 'Kunal Joshi',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=100&auto=format&fit=crop&q=80',
                'banner_title' => 'AFFILIATE BLUEPRINT',
                'banner_tag' => 'Scale Your Commissions to 70%+ Passive Direct Income',
                'accent' => '#f59e0b',
                'gradient' => 'linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%)',
                'lessons' => 18,
                'duration' => '6h 40m',
                'price' => 1499,
                'old_price' => 3999,
                'tagline' => 'Step-by-step blueprint to generate ₹50,000+ monthly via organic affiliate leads.',
                'description' => 'Find high-converting offers, build automated lead funnels without ads, and close WhatsApp sales.',
            ],
        ];

        $courseModels = [];
        foreach ($coursesData as $course) {
            $courseModels[$course['slug']] = Course::updateOrCreate(['slug' => $course['slug']], $course);
        }

        // 3. Seed Users with 3 Distinct Roles (Super Admin, Admin, and User/Affiliate)
        $usersData = [
            [
                'email' => 'superadmin@skilllearner.com',
                'name' => 'Alex Rivera',
                'phone' => '+91 99999 00001',
                'password' => Hash::make('password123'),
                'affiliate_id' => 'SL-SUPER',
                'sponsor_id' => 'SL-FOUNDER',
                'active_package' => 'Infinity Package',
                'wallet_balance' => 95000.00,
                'today_earning' => 12000.00,
                'weekly_earning' => 35000.00,
                'monthly_earning' => 98000.00,
                'total_earning' => 185000.00,
                'passive_earning' => 38500.00,
                'kyc_status' => 'Verified ✅',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80',
                'role' => 'super_admin',
            ],
            [
                'email' => 'admin@skilllearner.com',
                'name' => 'Pooja Sharma',
                'phone' => '+91 99999 00002',
                'password' => Hash::make('password123'),
                'affiliate_id' => 'SL-ADMIN01',
                'sponsor_id' => 'SL-SUPER',
                'active_package' => 'Premium Package',
                'wallet_balance' => 42000.00,
                'today_earning' => 4500.00,
                'weekly_earning' => 16000.00,
                'monthly_earning' => 48000.00,
                'total_earning' => 92000.00,
                'passive_earning' => 18200.00,
                'kyc_status' => 'Verified ✅',
                'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100&auto=format&fit=crop&q=80',
                'role' => 'admin',
            ],
            [
                'email' => 'vansh@skilllearner.com',
                'name' => 'Vansh Tandon',
                'phone' => '+91 98765 43210',
                'password' => Hash::make('password123'),
                'affiliate_id' => 'SL-8821',
                'sponsor_id' => 'SL-ADMIN',
                'active_package' => 'Advance Package',
                'wallet_balance' => 14200.00,
                'today_earning' => 2200.00,
                'weekly_earning' => 7400.00,
                'monthly_earning' => 21500.00,
                'total_earning' => 48600.00,
                'passive_earning' => 8400.00,
                'kyc_status' => 'Verified ✅',
                'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80',
                'role' => 'user',
            ],
            [
                'email' => 'user@skilllearner.com',
                'name' => 'Vansh Tandon',
                'phone' => '+91 98765 43211',
                'password' => Hash::make('password123'),
                'affiliate_id' => 'SL-7719',
                'sponsor_id' => 'SL-ADMIN',
                'active_package' => 'Advance Package',
                'wallet_balance' => 8400.00,
                'today_earning' => 1400.00,
                'weekly_earning' => 5200.00,
                'monthly_earning' => 15800.00,
                'total_earning' => 31200.00,
                'passive_earning' => 4600.00,
                'kyc_status' => 'Verified ✅',
                'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80',
                'role' => 'user',
            ],
        ];

        $seededUsers = [];
        foreach ($usersData as $uData) {
            $seededUsers[] = User::updateOrCreate(['email' => $uData['email']], $uData);
        }

        $user = $seededUsers[2]; // Default student user

        // 4. Enroll All Users in Courses
        $progressMap = [
            'basic-business-automation' => 65,
            'basic-facebook-ads-course' => 40,
            'canva-pro-mastery' => 100,
            'capcut-mobile-editing' => 85,
            'content-creation-mastery' => 30,
            'meta-ads-mastery' => 10,
            'instagram-growth-mastery' => 90,
            'lead-generation-mastery' => 50,
            'sales-funnel-mastery' => 25,
            'premiere-pro-video-editing' => 75,
            'chatgpt-ai-automation' => 95,
            'affiliate-marketing-masterclass' => 100,
        ];

        foreach ($seededUsers as $u) {
            foreach ($courseModels as $slug => $cModel) {
                $progress = $progressMap[$slug] ?? 20;
                UserCourse::updateOrCreate(
                    ['user_id' => $u->id, 'course_id' => $cModel->id],
                    [
                        'progress_percent' => $progress,
                        'completed_at' => $progress >= 100 ? now()->subDays(rand(2, 20)) : null,
                    ]
                );
            }
        }

        // 5. Seed Commissions for User
        Commission::where('user_id', $user->id)->delete();
        $commissions = [
            ['buyer_name' => 'Amit Verma', 'package_name' => 'Advance Package', 'amount' => 2200.00, 'commission_type' => 'Direct (Tier-1)', 'status' => 'Credited', 'created_at' => now()->subMinutes(10)],
            ['buyer_name' => 'Priya Nair', 'package_name' => 'Basic Package', 'amount' => 1200.00, 'commission_type' => 'Direct (Tier-1)', 'status' => 'Credited', 'created_at' => now()->subHours(2)],
            ['buyer_name' => 'Karan Joshi', 'package_name' => 'Infinity Package', 'amount' => 800.00, 'commission_type' => 'Passive (Tier-2)', 'status' => 'Credited', 'created_at' => now()->subDay()],
            ['buyer_name' => 'Sneha Patel', 'package_name' => 'Growth Package', 'amount' => 500.00, 'commission_type' => 'Direct (Tier-1)', 'status' => 'Credited', 'created_at' => now()->subDays(2)],
        ];

        foreach ($commissions as $comm) {
            Commission::create([
                'user_id' => $user->id,
                'buyer_name' => $comm['buyer_name'],
                'package_name' => $comm['package_name'],
                'amount' => $comm['amount'],
                'commission_type' => $comm['commission_type'],
                'status' => $comm['status'],
                'created_at' => $comm['created_at'],
                'updated_at' => $comm['created_at'],
            ]);
        }

        // 6. Seed Payouts for User
        Payout::where('user_id', $user->id)->delete();
        $payouts = [
            ['payout_code' => 'PAY-1082', 'amount' => 5000.00, 'payment_method' => 'UPI (suraj@okaxis)', 'status' => 'Transferred', 'processed_at' => now()->subDays(3), 'created_at' => now()->subDays(3)],
            ['payout_code' => 'PAY-1049', 'amount' => 10000.00, 'payment_method' => 'HDFC Bank (A/C ...4819)', 'status' => 'Transferred', 'processed_at' => now()->subDays(10), 'created_at' => now()->subDays(10)],
        ];

        foreach ($payouts as $pay) {
            Payout::create([
                'user_id' => $user->id,
                'payout_code' => $pay['payout_code'],
                'amount' => $pay['amount'],
                'payment_method' => $pay['payment_method'],
                'status' => $pay['status'],
                'processed_at' => $pay['processed_at'],
                'created_at' => $pay['created_at'],
                'updated_at' => $pay['created_at'],
            ]);
        }

        // 7. Seed KYC for User
        KycVerification::updateOrCreate(
            ['user_id' => $user->id],
            [
                'aadhar_number' => 'XXXXXXXX4892',
                'pan_number' => 'ABCDE1234F',
                'bank_name' => 'HDFC Bank',
                'account_number' => 'XXXXXX4819',
                'ifsc_code' => 'HDFC0001234',
                'upi_id' => 'suraj@okaxis',
                'status' => 'Verified',
                'remarks' => 'Documents verified by admin on '.now()->subDays(30)->format('d M Y'),
            ]
        );

        // 8. Seed Videos with Show / Hide state
        $videos = [
            [
                'title' => '01. Introduction to High-Ticket Affiliate Funnels',
                'description' => 'Comprehensive orientation on setting up affiliate links, understanding tier commissions, and mapping out your first ₹50,000 month.',
                'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80',
                'duration' => '18m 40s',
                'category' => 'Affiliate Training',
                'badge' => 'Essential',
                'is_visible' => true,
                'views_count' => 1420,
                'sort_order' => 1,
            ],
            [
                'title' => '02. Setting Up an Instagram Bio That Converts',
                'description' => 'A step-by-step masterclass on optimizing your social profile bio, highlights, and link-in-bio for maximum inbound student inquiries.',
                'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=800&auto=format&fit=crop&q=80',
                'duration' => '24m 15s',
                'category' => 'Organic Growth',
                'badge' => 'High Converting',
                'is_visible' => true,
                'views_count' => 980,
                'sort_order' => 2,
            ],
            [
                'title' => '03. The 30-Second Reel Script Formula',
                'description' => 'The viral short-video hook script used by top affiliates to generate 100,000+ views organically without paid advertising.',
                'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?w=800&auto=format&fit=crop&q=80',
                'duration' => '14m 50s',
                'category' => 'Video Editing & Reels',
                'badge' => 'Viral Strategy',
                'is_visible' => true,
                'views_count' => 2150,
                'sort_order' => 3,
            ],
            [
                'title' => '04. WhatsApp DM Closing Scripts for Beginners',
                'description' => 'Exact word-for-word conversational scripts and voice-note templates to turn warm leads into enrolled students effortlessly.',
                'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1577563908411-5077b6dc7624?w=800&auto=format&fit=crop&q=80',
                'duration' => '28m 30s',
                'category' => 'Sales Closing',
                'badge' => 'Top Rated',
                'is_visible' => true,
                'views_count' => 3400,
                'sort_order' => 4,
            ],
            [
                'title' => '05. Secret Super Admin 6-Figure Scaling Blueprint',
                'description' => 'Advanced strategies for scaling beyond ₹2,00,000/month with team duplication and automated follow-up funnels. Hidden by default for exclusive access.',
                'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/TearsOfSteel.mp4',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=800&auto=format&fit=crop&q=80',
                'duration' => '36m 10s',
                'category' => 'Pro Masterclass',
                'badge' => 'Hidden (Demo)',
                'is_visible' => false,
                'views_count' => 120,
                'sort_order' => 5,
            ],
        ];

        foreach ($videos as $v) {
            Video::updateOrCreate(['title' => $v['title']], $v);
        }
    }
}
