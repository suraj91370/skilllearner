-- =====================================================================
-- SkillLearner Clean Production Database Export
-- Generated for Live Server Deployment (Hostinger / cPanel / hPanel)
-- Generated on: 2026-11-11 17:49:23 UTC
-- Application: SkillLearner EdTech Platform (Laravel 12 / PHP 8.3)
-- Schema Version: 21 Migrations Complete
-- Super Admin Account: superadmin@skilllearne.org (Role: super_admin)
-- =====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- -----------------------------------------------------
-- Table structure for `migrations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `migrations` (21 rows)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_10_22_071812_add_portal_fields_to_users_table', 1),
(5, '2026_10_22_071823_create_packages_table', 1),
(6, '2026_10_22_071833_create_courses_table', 1),
(7, '2026_10_22_071843_create_user_courses_table', 1),
(8, '2026_10_22_071853_create_commissions_table', 1),
(9, '2026_10_22_071901_create_payouts_table', 1),
(10, '2026_10_22_071909_create_kyc_verifications_table', 1),
(11, '2026_10_28_064930_create_videos_table', 2),
(12, '2026_10_28_071837_add_is_visible_to_courses_table', 3),
(13, '2026_10_29_101906_add_monthly_and_passive_earning_to_users_table', 4),
(14, '2026_11_02_112027_create_settings_table', 5),
(15, '2026_11_04_123641_add_payment_status_to_users_table', 6),
(16, '2026_11_10_012000_add_holder_name_to_kyc_verifications_table', 7),
(17, '2026_11_09_205358_create_mentors_and_mentor_payouts_tables', 8),
(18, '2026_11_09_210851_add_display_and_designation_to_mentors_table', 9),
(19, '2026_11_09_213000_add_badge_to_mentors_table', 10),
(20, '2026_11_10_223000_create_offers_and_coupons_tables', 11),
(21, '2026_11_11_212245_add_industry_revenue_to_users_table', 12);

-- -----------------------------------------------------
-- Table structure for `packages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packages`;
CREATE TABLE `packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `active_income` decimal(10,2) NOT NULL DEFAULT '0.00',
  `passive_income` decimal(10,2) NOT NULL DEFAULT '0.00',
  `old_price` decimal(10,2) DEFAULT NULL,
  `badge` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `courses_included` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `packages_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `packages` (5 rows)
INSERT INTO `packages` (`id`, `slug`, `name`, `price`, `active_income`, `passive_income`, `old_price`, `badge`, `featured`, `description`, `image`, `courses_included`, `created_at`, `updated_at`) VALUES
(1, 'basic', 'Basic Package', '599.00', '420.00', '50.00', '1199.00', 'STARTER', 0, 'Foundational digital skillset covering Affiliate Marketing basics, spoken English fluency, and high-impact communication.', 'images/packages/basic.jpg', '[\"Canva Pro Mastery\", \"MS Excel Essentials\", \"Basic Spoken English\", \"Social Media Fundamentals\"]', '2026-10-22 17:00:50', '2026-11-11 02:03:52'),
(2, 'advance', 'Advance Package', '2499.00', '1900.00', '200.00', '4999.00', 'MOST POPULAR', 1, 'High-converting mastery bundle with Email Marketing automation, Sales Closing mastery, and Video Marketing frameworks.', 'images/packages/advance.jpg', '[\"All Basic Courses\", \"Video Editing (Premiere & CapCut)\", \"Instagram Growth Formula\", \"Organic Lead Generation Blueprint\"]', '2026-10-22 17:00:51', '2026-11-11 02:03:59'),
(3, 'premium', 'Premium Package', '4999.00', '3800.00', '400.00', '9999.00', 'BEST VALUE', 0, 'High-ticket authority skills including full YouTube channel monetization, Meta Facebook advertising, and professional web design.', 'images/packages/premium.jpg', '[\"All Advance Courses\", \"Facebook & Instagram Paid Ads\", \"AI & ChatGPT Monetization Kit\", \"WordPress Web Development\"]', '2026-10-22 17:00:52', '2026-11-11 02:04:28'),
(4, 'growth', 'Growth Package', '1199.00', '840.00', '100.00', '2499.00', 'FAST TRACK', 0, 'Accelerate your creative monetization with Canva graphic design, viral reel workflows, and VN mobile video editing.', 'images/packages/growth.jpg', '[\"All Premium Courses\", \"Complete Funnel Building\", \"High-Ticket Sales Closing\", \"Google & YouTube Ads\"]', '2026-10-22 17:00:53', '2026-11-11 02:03:56'),
(5, 'infinity', 'Infinity Package', '7999.00', '5500.00', '500.00', '15999.00', 'VIP ALL ACCESS', 0, 'VIP flagship bundle mastering 0 to Hero AI Content Creation, Artificial Intelligence tools, and Stock Market wealth generation.', 'images/packages/infinity.jpg', '[\"Full Lifetime Access Pass\", \"UI/UX Design Masterclass\", \"1-on-1 Mentorship & Weekly Live Masterminds\", \"VIP Community & Support\"]', '2026-10-22 17:00:55', '2026-11-11 02:04:31');

-- -----------------------------------------------------
-- Table structure for `courses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `package_id` bigint unsigned DEFAULT NULL,
  `package_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `badge` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instructor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instructor_avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_tag` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accent` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gradient` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lessons` int NOT NULL DEFAULT '0',
  `duration` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `old_price` decimal(10,2) DEFAULT NULL,
  `tagline` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `what_you_learn` json DEFAULT NULL,
  `modules` json DEFAULT NULL,
  `requirements` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `courses_slug_unique` (`slug`),
  KEY `courses_package_id_foreign` (`package_id`),
  CONSTRAINT `courses_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `courses` (13 rows)
INSERT INTO `courses` (`id`, `package_id`, `package_name`, `slug`, `title`, `category`, `badge`, `instructor`, `instructor_avatar`, `banner_title`, `banner_tag`, `accent`, `gradient`, `lessons`, `duration`, `price`, `old_price`, `tagline`, `description`, `is_visible`, `what_you_learn`, `modules`, `requirements`, `created_at`, `updated_at`) VALUES
(1, 1, 'Basic Package', 'basic-business-automation', 'Basic Business Automation', 'Automation & Productivity', NULL, 'Aman Rawat', 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80', 'BASIC BUSINESS AUTOMATION', 'All About Automation — Work Smarter, Not Harder', '#06b6d4', 'linear-gradient(135deg, #070d1e 0%, #0f172a 45%, #0e7490 100%)', 16, '4h 30m', '999.00', '2499.00', 'Automate everyday repetitive workflows with free digital tools.', 'Master simple business automations, Google Sheets scripts, and task workflows to save 10+ hours weekly.', 0, NULL, NULL, NULL, '2026-10-22 17:00:56', '2026-10-28 13:20:27'),
(2, 3, 'Premium Package', 'basic-facebook-ads-course', 'Basic Facebook ADs course', 'Performance Marketing', NULL, 'Prateek Garg', 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=100&auto=format&fit=crop&q=80', 'BASIC FACEBOOK ADS COURSE', 'Run High-Converting Ads — Zero Prior Experience', '#8b5cf6', 'linear-gradient(135deg, #09090b 0%, #1e1b4b 50%, #4c1d95 100%)', 14, '5h 15m', '1499.00', '3999.00', 'Create profitable Meta ads for lead generation and brand awareness.', 'Complete beginner guide to running Facebook and Instagram ads with minimal daily ad spend.', 0, NULL, NULL, NULL, '2026-10-22 17:00:57', '2026-11-06 01:03:41'),
(3, 1, 'Basic Package', 'canva-pro-mastery', 'Canva Pro', 'Graphic Design', NULL, 'Kunal Sharma', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80', 'CANVA MASTERY COURSE', 'Design Like A Pro — 50+ Ready Social Templates', '#d946ef', 'linear-gradient(135deg, #18052e 0%, #3b0764 50%, #701a75 100%)', 12, '3h 45m', '799.00', '1999.00', 'Create professional posters, thumbnails, and presentations in minutes.', 'Everything you need to master Canva for personal branding, freelancing, and digital products.', 0, NULL, NULL, NULL, '2026-10-22 17:00:58', '2026-11-06 01:03:42'),
(4, 2, 'Advance Package', 'capcut-mobile-editing', 'Capcut Mobile Editing', 'Video Editing', NULL, 'Kunal Sharma', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80', 'CAPCUT MOBILE VIDEO EDITING', 'From Beginner to Pro Editor — Mobile Friendly', '#a855f7', 'linear-gradient(135deg, #050510 0%, #1e103a 50%, #311054 100%)', 18, '6h 10m', '1299.00', '3499.00', 'Edit viral reels directly from your phone.', 'Step-by-step masterclass in kinetic captions, sound effects, cuts, and viral hooks on CapCut mobile.', 0, NULL, NULL, NULL, '2026-10-22 17:00:59', '2026-11-06 01:03:44'),
(5, 2, 'Advance Package', 'content-creation-mastery', 'Content Creation Mastery Course', 'Content Strategy', NULL, 'Rohan Sen', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80', 'CONTENT CREATION MASTERY COURSE', 'Viral Short Video Formats for Instagram & YouTube', '#818cf8', 'linear-gradient(135deg, #0f0a28 0%, #2e1065 60%, #4338ca 100%)', 20, '7h 20m', '1499.00', '3999.00', 'Master scripting, camera presence, and distribution.', 'Grow an engaged audience across Instagram, YouTube Shorts, and LinkedIn using proven viral frameworks.', 0, NULL, NULL, NULL, '2026-10-22 17:01:01', '2026-11-06 01:03:35'),
(6, 3, 'Premium Package', 'meta-ads-mastery', 'Meta Ads Mastery: Facebook & Instagram Leads', 'Performance Marketing', NULL, 'Prateek Garg', 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=100&auto=format&fit=crop&q=80', 'META ADS MASTERY', 'High Return On Ad Spend & Custom Audience Secrets', '#38bdf8', 'linear-gradient(135deg, #020617 0%, #172554 60%, #1e3a8a 100%)', 16, '5h 50m', '1699.00', '4499.00', 'Scale client leads with precision targeting and custom events.', 'Complete blueprint for setting up pixels, CBO campaigns, instant lead forms, and agency pitch decks.', 0, NULL, NULL, NULL, '2026-10-22 17:01:02', '2026-11-06 01:04:01'),
(7, 2, 'Advance Package', 'instagram-growth-mastery', 'Instagram Growth Mastery', 'Social Media', NULL, 'Vikram Malhotra', 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&auto=format&fit=crop&q=80', 'INSTAGRAM GROWTH MASTERY', 'From Zero to Influencer — Complete Organic Blueprint', '#c084fc', 'linear-gradient(135deg, #110726 0%, #2e1065 50%, #581c87 100%)', 15, '4h 50m', '999.00', '2499.00', 'Build high-converting authority on Instagram organically.', 'Niche selection, algorithm triggers, daily story funnels, and DM strategies to land paid sponsors and clients.', 0, NULL, NULL, NULL, '2026-10-22 17:01:03', '2026-11-06 01:03:58'),
(8, 4, 'Growth Package', 'lead-generation-mastery', 'Lead Generation Mastery Course', 'Sales & Growth', NULL, 'Aryan Verma', 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=100&auto=format&fit=crop&q=80', 'LEAD GENERATION MASTERY COURSE', 'Organic & Paid High-Ticket Lead Closing Formulas', '#f97316', 'linear-gradient(135deg, #0c0a09 0%, #291505 50%, #7c2d12 100%)', 12, '4h 10m', '1499.00', '3999.00', 'Consistent flow of qualified inbound buyers.', 'Inbound DM scripts, LinkedIn lead generation, WhatsApp automation sequences, and high-ticket qualification calls.', 0, NULL, NULL, NULL, '2026-10-22 17:01:04', '2026-11-06 01:03:55'),
(9, 4, 'Growth Package', 'sales-funnel-mastery', 'High-Converting Sales Funnel', 'Funnel Architecture', NULL, 'Aryan Verma', 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=100&auto=format&fit=crop&q=80', 'SALES FUNNEL BLUEPRINT', 'Landing Pages, WhatsApp Automation & High Conversions', '#10b981', 'linear-gradient(135deg, #022c22 0%, #064e3b 50%, #047857 100%)', 14, '5h 00m', '1799.00', '4999.00', 'Build automated funnel machines that generate sales 24/7.', 'Opt-in landing pages, VSL pages, order bumps, upsells, and payment integrations with Razorpay and Stripe.', 0, NULL, NULL, NULL, '2026-10-22 17:01:06', '2026-11-06 01:03:50'),
(10, 2, 'Advance Package', 'premiere-pro-video-editing', 'Premiere Pro Video Editing', 'Video Production', NULL, 'Rohan Sen', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80', 'PREMIERE PRO MASTERY', 'Cinematic Transitions, SFX & Viral Reels Workflow', '#38bdf8', 'linear-gradient(135deg, #020617 0%, #0c4a6e 60%, #0284c7 100%)', 22, '8h 15m', '1999.00', '4999.00', 'Industry-standard desktop video editing for premium clients.', 'Color grading, multi-track audio mastering, green screen, motion graphics, and high-speed editing shortcuts.', 0, NULL, NULL, NULL, '2026-10-22 17:01:07', '2026-11-06 01:03:51'),
(11, 3, 'Premium Package', 'chatgpt-ai-automation', 'AI & ChatGPT Monetization Kit', 'Artificial Intelligence', NULL, 'Aman Rawat', 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80', 'AI & CHATGPT AUTOMATION', 'Automate Marketing, Copywriting & Workflows with AI', '#ec4899', 'linear-gradient(135deg, #180324 0%, #4a044e 50%, #86198f 100%)', 11, '3h 30m', '1299.00', '3499.00', 'Harness generative AI to deliver paid freelance work 10x faster.', 'Advanced prompts for ChatGPT, Midjourney, Claude, ElevenLabs voice cloning, and Zapier no-code automations.', 0, NULL, NULL, NULL, '2026-10-22 17:01:08', '2026-11-06 01:03:52'),
(12, 2, 'Advance Package', 'affiliate-marketing-masterclass', 'High-Ticket Affiliate Blueprint', 'Affiliate Marketing', NULL, 'Kunal Joshi', 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=100&auto=format&fit=crop&q=80', 'AFFILIATE BLUEPRINT', 'Scale Your Commissions to 70%+ Passive Direct Income', '#f59e0b', 'linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%)', 18, '6h 40m', '1499.00', '3999.00', 'Step-by-step blueprint to generate ₹50,000+ monthly via organic affiliate leads.', 'Find high-converting offers, build automated lead funnels without ads, and close WhatsApp sales.', 0, NULL, NULL, NULL, '2026-10-22 17:01:09', '2026-11-06 01:03:53'),
(13, NULL, NULL, 'test-show-hide-course', 'Test Show Hide Course', 'Marketing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, '2h 30m', '0.00', NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-10-28 13:00:12', '2026-11-06 01:03:49');

-- -----------------------------------------------------
-- Table structure for `videos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `videos`;
CREATE TABLE `videos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `video_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Training',
  `badge` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `views_count` int unsigned NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `videos` (21 rows)
INSERT INTO `videos` (`id`, `title`, `description`, `video_url`, `thumbnail_url`, `duration`, `category`, `badge`, `is_visible`, `views_count`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, '01. Introduction to High-Ticket Affiliate Funnels', 'Comprehensive orientation on setting up affiliate links, understanding tier commissions, and mapping out your first ₹50,000 month.', 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80', '18m 40s', 'Affiliate Training', 'Essential', 1, 1420, 1, '2026-10-28 12:22:54', '2026-10-28 12:22:54'),
(2, '02. Setting Up an Instagram Bio That Converts', 'A step-by-step masterclass on optimizing your social profile bio, highlights, and link-in-bio for maximum inbound student inquiries.', 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4', 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=800&auto=format&fit=crop&q=80', '24m 15s', 'Organic Growth', 'High Converting', 1, 980, 2, '2026-10-28 12:22:55', '2026-10-28 12:22:55'),
(3, '03. The 30-Second Reel Script Formula', 'The viral short-video hook script used by top affiliates to generate 100,000+ views organically without paid advertising.', 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4', 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?w=800&auto=format&fit=crop&q=80', '14m 50s', 'Video Editing & Reels', 'Viral Strategy', 1, 2150, 3, '2026-10-28 12:22:57', '2026-10-28 12:22:57'),
(6, 'Toggle Visibility Test Video', NULL, 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', NULL, NULL, 'Training', NULL, 1, 0, 0, '2026-10-28 12:33:19', '2026-10-28 12:33:22'),
(7, 'Visible Student Video 12345', NULL, 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', NULL, NULL, 'Training', NULL, 1, 0, 0, '2026-10-28 12:33:28', '2026-10-28 12:33:28'),
(8, 'Hidden Secret Video 98765', NULL, 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4', NULL, NULL, 'Training', NULL, 0, 0, 0, '2026-10-28 12:33:28', '2026-10-28 12:33:28'),
(9, 'Test Automated Video Creation', 'Test description for video management', 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80', '10m 00s', 'Affiliate Training', 'New', 1, 0, 0, '2026-10-28 12:35:02', '2026-10-28 12:35:02'),
(10, 'Toggle Visibility Test Video', NULL, 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', NULL, NULL, 'Training', NULL, 1, 0, 0, '2026-10-28 12:35:07', '2026-10-28 12:35:10'),
(11, 'Visible Student Video 12345', NULL, 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', NULL, NULL, 'Training', NULL, 0, 0, 0, '2026-10-28 12:35:16', '2026-10-28 12:43:16'),
(12, 'Hidden Secret Video 98765', NULL, 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4', NULL, NULL, 'Training', NULL, 0, 0, 0, '2026-10-28 12:35:17', '2026-10-28 12:38:55'),
(13, 'Test Automated Video Creation', 'Test description for video management', 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80', '10m 00s', 'Affiliate Training', 'New', 1, 0, 0, '2026-10-28 13:07:44', '2026-10-28 13:07:44'),
(14, 'Toggle Visibility Test Video', NULL, 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', NULL, NULL, 'Training', NULL, 1, 0, 0, '2026-10-28 13:07:50', '2026-10-28 13:07:53'),
(15, 'Visible Student Video 12345', NULL, 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', NULL, NULL, 'Training', NULL, 1, 1, 0, '2026-10-28 13:07:59', '2026-10-28 13:38:31'),
(17, 'Test Automated Video Creation', 'Test description for video management', 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80', '10m 00s', 'Affiliate Training', 'New', 1, 0, 0, '2026-10-28 13:38:42', '2026-10-28 13:38:42'),
(18, 'Toggle Visibility Test Video', NULL, 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', NULL, NULL, 'Training', NULL, 1, 0, 0, '2026-10-28 13:38:47', '2026-10-28 13:38:50'),
(19, 'Visible Student Video 12345', NULL, 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', NULL, NULL, 'Training', NULL, 1, 0, 0, '2026-10-28 13:38:56', '2026-10-28 13:38:56'),
(20, 'Hidden Secret Video 98765', NULL, 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4', NULL, NULL, 'Training', NULL, 0, 0, 0, '2026-10-28 13:38:56', '2026-10-28 13:38:56'),
(21, 'Spoken  English  Part 1', NULL, 'https://youtu.be/0VKDTph4Kqw?si=T7r0ira8-vQd-lUc', 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80', '05:56', 'Affiliate Training', NULL, 1, 2, 0, '2026-10-28 13:49:16', '2026-11-04 00:19:24'),
(22, 'testing vides', NULL, 'https://youtu.be/0VKDTph4Kqw?si=T7r0ira8-vQd-lUc', 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80', NULL, 'Sales Closing', NULL, 1, 1, 0, '2026-10-28 13:50:23', '2026-10-29 14:39:59'),
(23, 'Test Automated Video Creation', 'Test description for video management', 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80', '10m 00s', 'Affiliate Training', 'New', 1, 0, 0, '2026-10-28 14:14:16', '2026-10-28 14:14:16'),
(24, 'Test Automated Video Creation', 'Test description for video management', 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80', '10m 00s', 'Affiliate Training', 'New', 1, 1, 0, '2026-10-28 14:16:05', '2026-11-01 16:22:02');

-- -----------------------------------------------------
-- Table structure for `mentors`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mentors`;
CREATE TABLE `mentors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `expertise` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qualification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `badge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_links` json DEFAULT NULL,
  `assigned_courses` json DEFAULT NULL,
  `commission_percentage` decimal(5,2) NOT NULL DEFAULT '15.00',
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `kyc_status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'approved',
  `pan_number` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar_number` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `holder_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc_code` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upi_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kyc_document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_earned` decimal(10,2) NOT NULL DEFAULT '0.00',
  `wallet_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mentors_email_unique` (`email`),
  KEY `mentors_user_id_foreign` (`user_id`),
  CONSTRAINT `mentors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `mentors` (7 rows)
INSERT INTO `mentors` (`id`, `user_id`, `name`, `email`, `phone`, `photo`, `bio`, `expertise`, `experience`, `qualification`, `designation`, `badge`, `social_links`, `assigned_courses`, `commission_percentage`, `status`, `is_featured`, `kyc_status`, `pan_number`, `aadhar_number`, `bank_name`, `holder_name`, `account_number`, `ifsc_code`, `upi_id`, `kyc_document`, `total_earned`, `wallet_balance`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Rahul Verma', 'rahul.verma@example.com', '+91 98765 43210', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=160&auto=format&fit=crop&q=80', 'Senior Full Stack & AI Architect with 8+ years experience guiding over 12,000 students in modern software engineering.', 'Full Stack Web Dev, Python AI, React', '8+ Years', 'B.Tech CSE, AWS Certified Solutions Architect', 'test123', 'mentor', '{\"github\": \"https://github.com/rahulverma\", \"twitter\": \"https://twitter.com/rahulverma\", \"youtube\": \"https://youtube.com/@rahulcodes\", \"linkedin\": \"https://linkedin.com/in/rahulverma\"}', '[\"1\", \"13\"]', '20.00', 'active', 1, 'approved', 'ABCDE1234F', '9876 5432 1098', 'HDFC Bank', 'Rahul Verma', '50100458923412', 'HDFC0001234', 'rahul@hdfcbank', NULL, '84500.00', '12400.00', '2026-11-09 21:02:26', '2026-11-09 21:31:12'),
(2, NULL, 'Priya Sen', 'priya.sen@example.com', '+91 91234 56789', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=160&auto=format&fit=crop&q=80', 'Digital Growth Strategist and Performance Marketer helping edtech businesses scale profitably.', 'Performance Marketing, SEO, Social Media Ads', '6+ Years', 'MBA Marketing, Google Certified Professional', NULL, NULL, '{\"github\": \"\", \"twitter\": \"\", \"youtube\": \"https://youtube.com/@priyamarketing\", \"linkedin\": \"https://linkedin.com/in/priyasen\"}', '[1]', '15.00', 'active', 0, 'approved', 'PQRSX5678Y', '1234 5678 9012', 'State Bank of India', 'Priya Sen', '309823478912', 'SBIN0004321', 'priya@sbi', NULL, '52000.00', '8500.00', '2026-11-09 21:02:26', '2026-11-09 21:02:26'),
(3, NULL, 'Aman Gupta', 'aman.gupta@example.com', '+91 99887 76655', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=160&auto=format&fit=crop&q=80', 'Data Scientist and Machine Learning practitioner specializing in NLP and LLM deployments.', 'Machine Learning, GenAI, Data Analysis', '4+ Years', 'M.Sc Data Science', NULL, NULL, '{\"github\": \"https://github.com/amangupta\", \"twitter\": \"https://twitter.com/amangupta_ai\", \"youtube\": \"\", \"linkedin\": \"https://linkedin.com/in/amangupta\"}', '[13]', '18.00', 'active', 0, 'pending', 'KLMNO9012P', '4567 8901 2345', 'ICICI Bank', 'Aman Gupta', '189201928374', 'ICIC0001892', 'aman@icici', NULL, '18200.00', '6200.00', '2026-11-09 21:02:26', '2026-11-09 21:02:26'),
(4, NULL, 'Adarsh Pandey', 'adarsh.pandey@skilllearner.com', '+91 98765 00001', 'images/founder.jpg', 'Founder and CEO with 5+ years of experience in Digital Marketing and Online Business, bringing deep expertise in digital growth and branding.', 'Digital Marketing, Online Business, Growth & Branding', '5+ Years', 'Founder & CEO, Digital Growth Strategist', 'Founder & CEO – Skilllearner', '★ FOUNDER & CEO', '{\"github\": \"\", \"twitter\": \"\", \"youtube\": \"https://youtube.com\", \"linkedin\": \"https://linkedin.com\"}', '[]', '25.00', 'active', 1, 'approved', 'ADRSH1234F', '9876 5432 1001', 'HDFC Bank', 'Adarsh Pandey', '50100458923001', 'HDFC0001234', 'adarsh@hdfcbank', NULL, '145000.00', '24500.00', '2026-11-09 21:26:01', '2026-11-11 21:33:35'),
(5, NULL, 'Ravi Gond', 'ravi.gond@skilllearner.com', '+91 98765 00002', 'images/co-founder.jpg', 'Co-Founder with 4+ years of experience in Digital Marketing and Online Business, specializing in sales strategies and online branding.', 'Sales Strategies, Online Branding, Business Scaling', '4+ Years', 'Co-Founder, Sales & Brand Specialist', 'Co-Founder – Skilllearner', '★ CO-FOUNDER', '{\"github\": \"\", \"twitter\": \"\", \"youtube\": \"https://youtube.com\", \"linkedin\": \"https://linkedin.com\"}', '[]', '20.00', 'active', 1, 'approved', 'RAVIG5678Y', '9876 5432 1002', 'ICICI Bank', 'Ravi Gond', '189201928002', 'ICIC0001892', 'ravi@icici', NULL, '98000.00', '18200.00', '2026-11-09 21:26:01', '2026-11-11 21:33:35'),
(6, NULL, 'Pavan Prajapati', 'pavan.prajapati@skilllearner.com', '+91 98765 00003', 'images/mentor-1.jpg', 'Dedicated mentor offering practical guidance, hands-on masterclasses, and career coaching to help learners achieve measurable digital growth.', 'Practical Masterclasses, Career Coaching, Digital Growth', '4+ Years', 'Expert Mentor, Career Coach', 'SkillLearner EdTech', '★ PAVAN PRAJAPATI', '{\"github\": \"\", \"twitter\": \"\", \"youtube\": \"https://youtube.com\", \"linkedin\": \"https://linkedin.com\"}', '[]', '15.00', 'active', 1, 'approved', 'PAVAN9012P', '9876 5432 1003', 'State Bank of India', 'Pavan Prajapati', '309823478003', 'SBIN0004321', 'pavan@sbi', NULL, '45000.00', '9500.00', '2026-11-09 21:26:01', '2026-11-11 21:33:35'),
(7, NULL, 'Soumyadip Pania', 'soumyadip.pania@skilllearner.com', '+91 98765 00004', 'images/mentor-2.jpg', 'Empowering students with actionable digital skills, real-time problem solving, and proven strategies to succeed in competitive markets.', 'Digital Skills, Problem Solving, Market Strategy', '3+ Years', 'Expert Mentor, Digital Strategist', 'SkillLearner EdTech', '★ SOUMYADIP PANIA', '{\"github\": \"\", \"twitter\": \"\", \"youtube\": \"https://youtube.com\", \"linkedin\": \"https://linkedin.com\"}', '[]', '15.00', 'active', 1, 'approved', 'SOUMY3456K', '9876 5432 1004', 'Axis Bank', 'Soumyadip Pania', '918020038004', 'UTIB0000123', 'soumyadip@axisbank', NULL, '38000.00', '7800.00', '2026-11-09 21:26:01', '2026-11-11 21:33:35');

-- -----------------------------------------------------
-- Table structure for `settings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `settings` (8 rows)
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'login_video_url', 'https://youtu.be/0VKDTph4Kqw?si=T7r0ira8-vQd-lUc', '2026-11-02 16:53:46', '2026-11-02 17:07:36'),
(2, 'login_video_title', 'Welcome to SkillLearner! Watch This First', '2026-11-02 16:53:46', '2026-11-02 16:53:46'),
(3, 'login_video_description', 'Get started with your courses, explore your affiliate dashboard, and maximize your learning journey.', '2026-11-02 16:53:46', '2026-11-02 16:53:46'),
(4, 'login_video_enabled', '1', '2026-11-02 16:53:46', '2026-11-02 16:53:46'),
(5, 'platform_name', 'SkillLearner EdTech', '2026-11-02 16:53:46', '2026-11-02 16:53:46'),
(6, 'tier1_commission', '70', '2026-11-02 16:53:46', '2026-11-02 16:53:46'),
(7, 'tier2_commission', '10', '2026-11-02 16:53:46', '2026-11-02 16:53:46'),
(8, 'min_payout_amount', '1000', '2026-11-02 16:53:46', '2026-11-02 16:53:46');

-- -----------------------------------------------------
-- Table structure for `users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affiliate_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sponsor_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'SL-ADMIN',
  `active_package` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Advance Package',
  `payment_status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'paid',
  `wallet_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `today_earning` decimal(10,2) NOT NULL DEFAULT '0.00',
  `weekly_earning` decimal(10,2) NOT NULL DEFAULT '0.00',
  `monthly_earning` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_earning` decimal(10,2) NOT NULL DEFAULT '0.00',
  `passive_earning` decimal(10,2) NOT NULL DEFAULT '0.00',
  `industry_revenue` decimal(12,2) NOT NULL DEFAULT '0.00',
  `kyc_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending Verification',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'affiliate',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_affiliate_id_unique` (`affiliate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping single Super Admin user into `users`
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `affiliate_id`, `sponsor_id`, `active_package`, `payment_status`, `wallet_balance`, `today_earning`, `weekly_earning`, `monthly_earning`, `total_earning`, `passive_earning`, `industry_revenue`, `kyc_status`, `avatar`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin@skilllearne.org', '+91 98765 43210', 'SL-ADMIN', 'SL-ADMIN', 'Infinity Package', 'paid', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Verified ✅', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80', 'super_admin', '2026-10-26 05:44:53', '$2y$10$EUgotE4Zft.esnmIs8id2eXahSDlG3PJZgywBoBahnNtcTv/w30yG', NULL, '2026-10-26 05:44:53', '2026-11-11 17:49:23');

-- -----------------------------------------------------
-- Table structure for `user_courses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user_courses`;
CREATE TABLE `user_courses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `course_id` bigint unsigned NOT NULL,
  `progress_percent` int NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_courses_user_id_course_id_unique` (`user_id`,`course_id`),
  KEY `user_courses_course_id_foreign` (`course_id`),
  CONSTRAINT `user_courses_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_courses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Enrolling Super Admin into all courses (13 courses)
INSERT INTO `user_courses` (`id`, `user_id`, `course_id`, `progress_percent`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 100, NULL, '2026-11-11 17:49:23', '2026-11-11 17:49:23'),
(2, 1, 2, 100, NULL, '2026-11-11 17:49:23', '2026-11-11 17:49:23'),
(3, 1, 3, 100, NULL, '2026-11-11 17:49:23', '2026-11-11 17:49:23'),
(4, 1, 4, 100, NULL, '2026-11-11 17:49:23', '2026-11-11 17:49:23'),
(5, 1, 5, 100, NULL, '2026-11-11 17:49:23', '2026-11-11 17:49:23'),
(6, 1, 6, 100, NULL, '2026-11-11 17:49:23', '2026-11-11 17:49:23'),
(7, 1, 7, 100, NULL, '2026-11-11 17:49:23', '2026-11-11 17:49:23'),
(8, 1, 8, 100, NULL, '2026-11-11 17:49:23', '2026-11-11 17:49:23'),
(9, 1, 9, 100, NULL, '2026-11-11 17:49:23', '2026-11-11 17:49:23'),
(10, 1, 10, 100, NULL, '2026-11-11 17:49:23', '2026-11-11 17:49:23'),
(11, 1, 11, 100, NULL, '2026-11-11 17:49:23', '2026-11-11 17:49:23'),
(12, 1, 12, 100, NULL, '2026-11-11 17:49:23', '2026-11-11 17:49:23'),
(13, 1, 13, 100, NULL, '2026-11-11 17:49:23', '2026-11-11 17:49:23');

-- -----------------------------------------------------
-- Table structure for `kyc_verifications`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kyc_verifications`;
CREATE TABLE `kyc_verifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `aadhar_number` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_number` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `holder_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc_code` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upi_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kyc_verifications_user_id_unique` (`user_id`),
  CONSTRAINT `kyc_verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping default verified KYC record for Super Admin
INSERT INTO `kyc_verifications` (`id`, `user_id`, `aadhar_number`, `pan_number`, `bank_name`, `account_number`, `ifsc_code`, `upi_id`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 'XXXXXXXX1234', 'ABCDE1234F', 'HDFC Bank', 'XXXXXX1234', 'HDFC0001234', 'admin@upi', 'Verified', 'Master Super Admin Account - Verified', '2026-11-11 17:49:23', '2026-11-11 17:49:23');

-- -----------------------------------------------------
-- Table structure for `offers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `offers`;
CREATE TABLE `offers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `offer_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'flash_sale',
  `discount_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'percentage',
  `discount_value` decimal(10,2) NOT NULL DEFAULT '0.00',
  `badge_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_message` text COLLATE utf8mb4_unicode_ci,
  `applicable_packages` json DEFAULT NULL,
  `bundle_buy_package` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bundle_free_package` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_timer` tinyint(1) NOT NULL DEFAULT '1',
  `starts_at` datetime DEFAULT NULL,
  `ends_at` datetime DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `uses_count` int unsigned NOT NULL DEFAULT '0',
  `total_discount_given` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `offers_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Schema only for table `offers` (0 rows)

-- -----------------------------------------------------
-- Table structure for `coupons`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `discount_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'percentage',
  `discount_value` decimal(10,2) NOT NULL DEFAULT '0.00',
  `min_order_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `max_discount_amount` decimal(10,2) DEFAULT NULL,
  `applicable_packages` json DEFAULT NULL,
  `usage_limit` int unsigned DEFAULT NULL,
  `per_user_limit` int unsigned NOT NULL DEFAULT '1',
  `used_count` int unsigned NOT NULL DEFAULT '0',
  `starts_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupons_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Schema only for table `coupons` (0 rows)

-- -----------------------------------------------------
-- Table structure for `offer_redemptions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `offer_redemptions`;
CREATE TABLE `offer_redemptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `coupon_id` bigint unsigned DEFAULT NULL,
  `offer_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `package_slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_used` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original_amount` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `final_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Schema only for table `offer_redemptions` (0 rows)

-- -----------------------------------------------------
-- Table structure for `commissions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `commissions`;
CREATE TABLE `commissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `buyer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `commission_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Direct (Tier-1)',
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Credited',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commissions_user_id_foreign` (`user_id`),
  CONSTRAINT `commissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Schema only for table `commissions` (0 rows)

-- -----------------------------------------------------
-- Table structure for `payouts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `payouts`;
CREATE TABLE `payouts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `payout_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `processed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payouts_payout_code_unique` (`payout_code`),
  KEY `payouts_user_id_foreign` (`user_id`),
  CONSTRAINT `payouts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Schema only for table `payouts` (0 rows)

-- -----------------------------------------------------
-- Table structure for `mentor_payouts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mentor_payouts`;
CREATE TABLE `mentor_payouts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mentor_id` bigint unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Bank Transfer',
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `processed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mentor_payouts_mentor_id_foreign` (`mentor_id`),
  CONSTRAINT `mentor_payouts_mentor_id_foreign` FOREIGN KEY (`mentor_id`) REFERENCES `mentors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Schema only for table `mentor_payouts` (0 rows)

-- -----------------------------------------------------
-- Table structure for `password_reset_tokens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Schema only for table `password_reset_tokens` (0 rows)

-- -----------------------------------------------------
-- Table structure for `sessions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Schema only for table `sessions` (0 rows)

-- -----------------------------------------------------
-- Table structure for `cache`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Schema only for table `cache` (0 rows)

-- -----------------------------------------------------
-- Table structure for `cache_locks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Schema only for table `cache_locks` (0 rows)

-- -----------------------------------------------------
-- Table structure for `jobs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Schema only for table `jobs` (0 rows)

-- -----------------------------------------------------
-- Table structure for `failed_jobs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Schema only for table `failed_jobs` (0 rows)

-- -----------------------------------------------------
-- Table structure for `job_batches`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Schema only for table `job_batches` (0 rows)

-- =====================================================
SET FOREIGN_KEY_CHECKS = 1;
-- ======================== EOF ========================
