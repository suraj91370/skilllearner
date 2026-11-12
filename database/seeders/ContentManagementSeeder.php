<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Faq;
use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentManagementSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Categories & Sub-categories
        $categoriesData = [
            [
                'name' => 'Digital Marketing',
                'icon' => '📈',
                'description' => 'Social media marketing, Meta ads, and organic brand scaling.',
                'subcategories' => [
                    ['name' => 'Performance Marketing', 'icon' => '🎯'],
                    ['name' => 'Social Media', 'icon' => '📱'],
                    ['name' => 'Content Strategy', 'icon' => '✍️'],
                ],
            ],
            [
                'name' => 'Video Production',
                'icon' => '🎬',
                'description' => 'Professional video editing, reels, and cinematography tools.',
                'subcategories' => [
                    ['name' => 'Video Editing', 'icon' => '✂️'],
                    ['name' => 'Mobile Video Editing', 'icon' => '📲'],
                    ['name' => 'Motion Graphics', 'icon' => '✨'],
                ],
            ],
            [
                'name' => 'Sales & Business Automation',
                'icon' => '⚡',
                'description' => 'Business process automation, CRM funnels, and high-ticket sales.',
                'subcategories' => [
                    ['name' => 'Automation & Productivity', 'icon' => '🤖'],
                    ['name' => 'Sales & Growth', 'icon' => '💼'],
                    ['name' => 'Funnel Architecture', 'icon' => '🏗️'],
                ],
            ],
            [
                'name' => 'Graphic Design & Creative',
                'icon' => '🎨',
                'description' => 'Visual branding, Canva Pro mastery, and creative advertising assets.',
                'subcategories' => [
                    ['name' => 'Graphic Design', 'icon' => '🖌️'],
                    ['name' => 'Brand Identity', 'icon' => '🏷️'],
                ],
            ],
            [
                'name' => 'AI & Future Technology',
                'icon' => '🧠',
                'description' => 'Prompt engineering, AI automation, and generative AI content workflows.',
                'subcategories' => [
                    ['name' => 'Generative AI', 'icon' => '💡'],
                    ['name' => 'AI Automation Tools', 'icon' => '⚙️'],
                ],
            ],
        ];

        foreach ($categoriesData as $idx => $cat) {
            $parent = CourseCategory::firstOrCreate([
                'slug' => Str::slug($cat['name']),
            ], [
                'name' => $cat['name'],
                'icon' => $cat['icon'],
                'description' => $cat['description'],
                'is_active' => true,
                'sort_order' => $idx + 1,
            ]);

            foreach ($cat['subcategories'] as $sIdx => $sub) {
                CourseCategory::firstOrCreate([
                    'slug' => Str::slug($sub['name']),
                ], [
                    'parent_id' => $parent->id,
                    'name' => $sub['name'],
                    'icon' => $sub['icon'],
                    'description' => $cat['name'].' sub-category',
                    'is_active' => true,
                    'sort_order' => $sIdx + 1,
                ]);
            }
        }

        // Link existing courses to categories
        $courses = Course::all();
        foreach ($courses as $course) {
            if ($course->category) {
                // Find matching subcategory or parent
                $match = CourseCategory::where('name', 'like', "%{$course->category}%")->first();
                if ($match) {
                    if ($match->parent_id) {
                        $course->update([
                            'category_id' => $match->parent_id,
                            'subcategory_id' => $match->id,
                        ]);
                    } else {
                        $course->update([
                            'category_id' => $match->id,
                        ]);
                    }
                }
            }
        }

        // 2. Seed Testimonials
        if (Testimonial::count() === 0) {
            $testimonials = [
                [
                    'name' => 'Vikram Sharma',
                    'role_title' => 'Growth Package Student',
                    'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80',
                    'rating' => 5,
                    'content' => 'SkillLearner completely changed how I look at digital affiliate marketing. The Meta Ads Mastery course helped me generate my first ₹50,000 within 45 days!',
                    'earning_highlight' => '₹50,000 in 45 Days',
                    'is_featured' => true,
                    'sort_order' => 1,
                ],
                [
                    'name' => 'Pooja Verma',
                    'role_title' => 'Advance Package Student',
                    'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150&auto=format&fit=crop&q=80',
                    'rating' => 5,
                    'content' => 'The Premiere Pro and Capcut video editing modules are super practical. Now I edit reels for local business clients and earn ₹25,000+ per month alongside college.',
                    'earning_highlight' => '₹25,000+ / Month',
                    'is_featured' => true,
                    'sort_order' => 2,
                ],
                [
                    'name' => 'Rahul Nair',
                    'role_title' => 'Infinity Package Master',
                    'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',
                    'rating' => 5,
                    'content' => 'The 2-tier affiliate system and high-demand courses make SkillLearner the most transparent platform in India. Same-day payouts and genuine mentorship!',
                    'earning_highlight' => 'Top 5 Leaderboard',
                    'is_featured' => true,
                    'sort_order' => 3,
                ],
            ];

            foreach ($testimonials as $t) {
                Testimonial::create($t);
            }
        }

        // 3. Seed FAQs
        if (Faq::count() === 0) {
            $faqs = [
                [
                    'category' => 'general',
                    'question' => 'What is SkillLearner and how does the platform work?',
                    'answer' => 'SkillLearner is a premier digital skill learning and affiliate education platform. We provide practical, career-oriented video masterclasses in high-income digital skills alongside an affiliate system where students can earn industry-leading commissions by recommending packages.',
                    'sort_order' => 1,
                ],
                [
                    'category' => 'courses',
                    'question' => 'Are course completion certificates provided?',
                    'answer' => 'Yes! Upon 100% video course completion and quiz evaluations, students receive an ISO 9001:2015 accredited digital certificate with a verifiable Certificate ID and QR seal.',
                    'sort_order' => 2,
                ],
                [
                    'category' => 'payment',
                    'question' => 'What payment methods are supported on SkillLearner?',
                    'answer' => 'We support instant online checkout via Cashfree Payment Gateway (UPI, Google Pay, PhonePe, Debit/Credit Cards, Net Banking) as well as direct UPI QR code transfers with automated invoice generation.',
                    'sort_order' => 3,
                ],
                [
                    'category' => 'affiliate',
                    'question' => 'How does the 2-Tier Affiliate Referral Commission work?',
                    'answer' => 'When your referred student purchases a course package, you earn up to 70% direct Tier-1 commission. If that student refers another student, you earn an additional 10% passive Tier-2 commission credited to your wallet.',
                    'sort_order' => 4,
                ],
                [
                    'category' => 'payment',
                    'question' => 'How and when can I withdraw my wallet earnings?',
                    'answer' => 'Once your KYC (Aadhaar & Bank Account/UPI) is verified, you can request a payout anytime with a minimum threshold of ₹1,000. Payouts are processed directly to your registered bank account.',
                    'sort_order' => 5,
                ],
            ];

            foreach ($faqs as $faq) {
                Faq::create($faq);
            }
        }

        // 4. Seed Initial Blog / Announcement
        if (Blog::count() === 0) {
            Blog::create([
                'title' => 'Welcome to the New SkillLearner 2.0 Learning & Affiliate Portal',
                'slug' => 'welcome-to-skilllearner-2-0',
                'category' => 'announcement',
                'thumbnail' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80',
                'excerpt' => 'Explore the upgraded SkillLearner platform with automated Cashfree payments, verified course completion certificates, and high-performance video streaming.',
                'content' => "<h2>Welcome to SkillLearner 2.0! 🎉</h2><p>We are thrilled to launch our upgraded learning infrastructure designed to give every student and affiliate an edge in the modern digital economy.</p><h3>What's New in This Release:</h3><ul><li><strong>Automated Instant Payments:</strong> Integrated Cashfree PG for lightning-fast UPI and card checkouts.</li><li><strong>Verifiable Digital Certificates:</strong> Official ISO-accredited completion certificates with verifiable IDs.</li><li><strong>Live Leaderboard & Rewards:</strong> Weekly and monthly rankings with transparent payout tracking.</li></ul><p>Start exploring your classroom courses and invite friends to earn tier-1 and tier-2 commissions today!</p>",
                'author_name' => 'SkillLearner Editorial',
                'is_published' => true,
                'is_pinned' => true,
                'views_count' => 142,
                'published_at' => now(),
            ]);
        }

        // 5. Seed Certificate Template & Homepage Settings
        Setting::set('cert_title', 'CERTIFICATE OF COMPLETION');
        Setting::set('cert_subtitle', 'SkillLearner ISO 9001:2015 Accredited');
        Setting::set('cert_organization', 'SkillLearner Edutech Private Limited');
        Setting::set('cert_signatory_name', 'Adarsh Pandey');
        Setting::set('cert_signatory_title', 'Founder & Chief Executive Officer');
        Setting::set('cert_theme_color', '#05B396');
        Setting::set('cert_border_style', 'gold_double');

        // Homepage Banner & Section Settings
        Setting::set('home_hero_tag', '✨ NO.1 DIGITAL EDUCATION & AFFILIATE PLATFORM IN INDIA');
        Setting::set('home_hero_title', "Build Skill,\nBuild Future.");
        Setting::set('home_hero_subtitle', 'Master modern video editing, performance Meta ads, business automation, and high-converting funnels with India’s top digital mentors.');
        Setting::set('home_hero_cta_text', '🚀 Explore All Packages');
        Setting::set('home_hero_cta_link', '#packages');
        Setting::set('home_announcement_bar', '🔥 New Flash Sale Live! Get Extra 10% Off with Code: SKILL10');
        Setting::set('home_show_announcement', '1');
        Setting::set('home_show_packages', '1');
        Setting::set('home_show_mentors', '1');
        Setting::set('home_show_why_us', '1');
        Setting::set('home_show_founders', '1');
        Setting::set('home_show_testimonials', '1');
        Setting::set('home_show_faq', '1');
        Setting::set('home_show_cta', '1');
    }
}
