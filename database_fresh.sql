-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: careerfixx-db.cz280oamo2x8.ap-southeast-2.rds.amazonaws.com    Database: careerfixx_db
-- ------------------------------------------------------
-- Server version	8.4.11

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commissions`
--

DROP TABLE IF EXISTS `commissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `buyer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `commission_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Direct (Tier-1)',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Credited',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commissions_user_id_foreign` (`user_id`),
  CONSTRAINT `commissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commissions`
--

LOCK TABLES `commissions` WRITE;
/*!40000 ALTER TABLE `commissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `commissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `package_id` bigint unsigned DEFAULT NULL,
  `package_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `badge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instructor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instructor_avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_tag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accent` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gradient` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lessons` int NOT NULL DEFAULT '0',
  `duration` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `old_price` decimal(10,2) DEFAULT NULL,
  `tagline` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,1,'Basic Package','basic-business-automation','Basic Business Automation','Automation & Productivity',NULL,'Aman Rawat','https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80','BASIC BUSINESS AUTOMATION','All About Automation — Work Smarter, Not Harder','#06b6d4','linear-gradient(135deg, #070d1e 0%, #0f172a 45%, #0e7490 100%)',16,'4h 30m',999.00,2499.00,'Automate everyday repetitive workflows with free digital tools.','Master simple business automations, Google Sheets scripts, and task workflows to save 10+ hours weekly.',0,NULL,NULL,NULL,'2026-10-22 11:30:56','2026-10-28 07:50:27'),(2,3,'Premium Package','basic-facebook-ads-course','Basic Facebook ADs course','Performance Marketing',NULL,'Prateek Garg','https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=100&auto=format&fit=crop&q=80','BASIC FACEBOOK ADS COURSE','Run High-Converting Ads — Zero Prior Experience','#8b5cf6','linear-gradient(135deg, #09090b 0%, #1e1b4b 50%, #4c1d95 100%)',14,'5h 15m',1499.00,3999.00,'Create profitable Meta ads for lead generation and brand awareness.','Complete beginner guide to running Facebook and Instagram ads with minimal daily ad spend.',0,NULL,NULL,NULL,'2026-10-22 11:30:57','2026-11-05 19:33:41'),(3,1,'Basic Package','canva-pro-mastery','Canva Pro','Graphic Design',NULL,'Kunal Sharma','https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80','CANVA MASTERY COURSE','Design Like A Pro — 50+ Ready Social Templates','#d946ef','linear-gradient(135deg, #18052e 0%, #3b0764 50%, #701a75 100%)',12,'3h 45m',799.00,1999.00,'Create professional posters, thumbnails, and presentations in minutes.','Everything you need to master Canva for personal branding, freelancing, and digital products.',0,NULL,NULL,NULL,'2026-10-22 11:30:58','2026-11-05 19:33:42'),(4,2,'Advance Package','capcut-mobile-editing','Capcut Mobile Editing','Video Editing',NULL,'Kunal Sharma','https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80','CAPCUT MOBILE VIDEO EDITING','From Beginner to Pro Editor — Mobile Friendly','#a855f7','linear-gradient(135deg, #050510 0%, #1e103a 50%, #311054 100%)',18,'6h 10m',1299.00,3499.00,'Edit viral reels directly from your phone.','Step-by-step masterclass in kinetic captions, sound effects, cuts, and viral hooks on CapCut mobile.',0,NULL,NULL,NULL,'2026-10-22 11:30:59','2026-11-05 19:33:44'),(5,2,'Advance Package','content-creation-mastery','Content Creation Mastery Course','Content Strategy',NULL,'Rohan Sen','https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80','CONTENT CREATION MASTERY COURSE','Viral Short Video Formats for Instagram & YouTube','#818cf8','linear-gradient(135deg, #0f0a28 0%, #2e1065 60%, #4338ca 100%)',20,'7h 20m',1499.00,3999.00,'Master scripting, camera presence, and distribution.','Grow an engaged audience across Instagram, YouTube Shorts, and LinkedIn using proven viral frameworks.',0,NULL,NULL,NULL,'2026-10-22 11:31:01','2026-11-05 19:33:35'),(6,3,'Premium Package','meta-ads-mastery','Meta Ads Mastery: Facebook & Instagram Leads','Performance Marketing',NULL,'Prateek Garg','https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=100&auto=format&fit=crop&q=80','META ADS MASTERY','High Return On Ad Spend & Custom Audience Secrets','#38bdf8','linear-gradient(135deg, #020617 0%, #172554 60%, #1e3a8a 100%)',16,'5h 50m',1699.00,4499.00,'Scale client leads with precision targeting and custom events.','Complete blueprint for setting up pixels, CBO campaigns, instant lead forms, and agency pitch decks.',0,NULL,NULL,NULL,'2026-10-22 11:31:02','2026-11-05 19:34:01'),(7,2,'Advance Package','instagram-growth-mastery','Instagram Growth Mastery','Social Media',NULL,'Vikram Malhotra','https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&auto=format&fit=crop&q=80','INSTAGRAM GROWTH MASTERY','From Zero to Influencer — Complete Organic Blueprint','#c084fc','linear-gradient(135deg, #110726 0%, #2e1065 50%, #581c87 100%)',15,'4h 50m',999.00,2499.00,'Build high-converting authority on Instagram organically.','Niche selection, algorithm triggers, daily story funnels, and DM strategies to land paid sponsors and clients.',0,NULL,NULL,NULL,'2026-10-22 11:31:03','2026-11-05 19:33:58'),(8,4,'Growth Package','lead-generation-mastery','Lead Generation Mastery Course','Sales & Growth',NULL,'Aryan Verma','https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=100&auto=format&fit=crop&q=80','LEAD GENERATION MASTERY COURSE','Organic & Paid High-Ticket Lead Closing Formulas','#f97316','linear-gradient(135deg, #0c0a09 0%, #291505 50%, #7c2d12 100%)',12,'4h 10m',1499.00,3999.00,'Consistent flow of qualified inbound buyers.','Inbound DM scripts, LinkedIn lead generation, WhatsApp automation sequences, and high-ticket qualification calls.',0,NULL,NULL,NULL,'2026-10-22 11:31:04','2026-11-05 19:33:55'),(9,4,'Growth Package','sales-funnel-mastery','High-Converting Sales Funnel','Funnel Architecture',NULL,'Aryan Verma','https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=100&auto=format&fit=crop&q=80','SALES FUNNEL BLUEPRINT','Landing Pages, WhatsApp Automation & High Conversions','#10b981','linear-gradient(135deg, #022c22 0%, #064e3b 50%, #047857 100%)',14,'5h 00m',1799.00,4999.00,'Build automated funnel machines that generate sales 24/7.','Opt-in landing pages, VSL pages, order bumps, upsells, and payment integrations with Razorpay and Stripe.',0,NULL,NULL,NULL,'2026-10-22 11:31:06','2026-11-05 19:33:50'),(10,2,'Advance Package','premiere-pro-video-editing','Premiere Pro Video Editing','Video Production',NULL,'Rohan Sen','https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80','PREMIERE PRO MASTERY','Cinematic Transitions, SFX & Viral Reels Workflow','#38bdf8','linear-gradient(135deg, #020617 0%, #0c4a6e 60%, #0284c7 100%)',22,'8h 15m',1999.00,4999.00,'Industry-standard desktop video editing for premium clients.','Color grading, multi-track audio mastering, green screen, motion graphics, and high-speed editing shortcuts.',0,NULL,NULL,NULL,'2026-10-22 11:31:07','2026-11-05 19:33:51'),(11,3,'Premium Package','chatgpt-ai-automation','AI & ChatGPT Monetization Kit','Artificial Intelligence',NULL,'Aman Rawat','https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80','AI & CHATGPT AUTOMATION','Automate Marketing, Copywriting & Workflows with AI','#ec4899','linear-gradient(135deg, #180324 0%, #4a044e 50%, #86198f 100%)',11,'3h 30m',1299.00,3499.00,'Harness generative AI to deliver paid freelance work 10x faster.','Advanced prompts for ChatGPT, Midjourney, Claude, ElevenLabs voice cloning, and Zapier no-code automations.',0,NULL,NULL,NULL,'2026-10-22 11:31:08','2026-11-05 19:33:52'),(12,2,'Advance Package','affiliate-marketing-masterclass','High-Ticket Affiliate Blueprint','Affiliate Marketing',NULL,'Kunal Joshi','https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=100&auto=format&fit=crop&q=80','AFFILIATE BLUEPRINT','Scale Your Commissions to 70%+ Passive Direct Income','#f59e0b','linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%)',18,'6h 40m',1499.00,3999.00,'Step-by-step blueprint to generate ₹50,000+ monthly via organic affiliate leads.','Find high-converting offers, build automated lead funnels without ads, and close WhatsApp sales.',0,NULL,NULL,NULL,'2026-10-22 11:31:09','2026-11-05 19:33:53'),(13,NULL,NULL,'test-show-hide-course','Test Show Hide Course','Marketing',NULL,NULL,NULL,NULL,NULL,NULL,NULL,10,'2h 30m',0.00,NULL,NULL,NULL,0,NULL,NULL,NULL,'2026-10-28 07:30:12','2026-11-05 19:33:49');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kyc_verifications`
--

DROP TABLE IF EXISTS `kyc_verifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kyc_verifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `aadhar_number` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_number` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc_code` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upi_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kyc_verifications_user_id_unique` (`user_id`),
  CONSTRAINT `kyc_verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kyc_verifications`
--

LOCK TABLES `kyc_verifications` WRITE;
/*!40000 ALTER TABLE `kyc_verifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `kyc_verifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_10_22_071812_add_portal_fields_to_users_table',1),(5,'2026_10_22_071823_create_packages_table',1),(6,'2026_10_22_071833_create_courses_table',1),(7,'2026_10_22_071843_create_user_courses_table',1),(8,'2026_10_22_071853_create_commissions_table',1),(9,'2026_10_22_071901_create_payouts_table',1),(10,'2026_10_22_071909_create_kyc_verifications_table',1),(11,'2026_10_28_064930_create_videos_table',2),(12,'2026_10_28_071837_add_is_visible_to_courses_table',3),(13,'2026_10_29_101906_add_monthly_and_passive_earning_to_users_table',4),(14,'2026_11_02_112027_create_settings_table',5),(15,'2026_11_04_123641_add_payment_status_to_users_table',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `packages`
--

DROP TABLE IF EXISTS `packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `badge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `courses_included` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `packages_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `packages`
--

LOCK TABLES `packages` WRITE;
/*!40000 ALTER TABLE `packages` DISABLE KEYS */;
INSERT INTO `packages` VALUES (1,'basic','Basic Package',1499.00,2999.00,'STARTER',0,'Foundational skill track to get started in the digital economy with Canva, Excel, English and Social Media basics.','images/packages/basic.jpg','[\"Canva Pro Mastery\", \"MS Excel Essentials\", \"Basic Spoken English\", \"Social Media Fundamentals\"]','2026-10-22 11:30:50','2026-10-22 11:30:50'),(2,'advance','Advance Package',2499.00,4999.00,'MOST POPULAR',1,'Our flagship bundle unlocking high-ticket video editing, Instagram organic growth formulas, and 70% direct referral commission rights.','images/packages/advance.jpg','[\"All Basic Courses\", \"Video Editing (Premiere & CapCut)\", \"Instagram Growth Formula\", \"Organic Lead Generation Blueprint\"]','2026-10-22 11:30:51','2026-10-22 11:30:51'),(3,'premium','Premium Package',3999.00,7999.00,'BEST VALUE',0,'High-yield monetization bundle with Facebook & Instagram paid ads, AI ChatGPT automation kit, and no-code WordPress design.','images/packages/premium.jpg','[\"All Advance Courses\", \"Facebook & Instagram Paid Ads\", \"AI & ChatGPT Monetization Kit\", \"WordPress Web Development\"]','2026-10-22 11:30:52','2026-10-22 11:30:52'),(4,'growth','Growth Package',5999.00,11999.00,'HIGH GROWTH',0,'Scale your revenue with high-ticket sales closing, complete sales funnel architecture, and Google & YouTube advertising.','images/packages/growth.jpg','[\"All Premium Courses\", \"Complete Funnel Building\", \"High-Ticket Sales Closing\", \"Google & YouTube Ads\"]','2026-10-22 11:30:53','2026-10-22 11:30:53'),(5,'infinity','Infinity Package',9999.00,19999.00,'ALL ACCESS LIFETIME',0,'VIP pass granting unlimited lifetime access to all current and future masterclasses, 1-on-1 mentorship, and weekly mastermind sessions.','images/packages/infinity.jpg','[\"Full Lifetime Access Pass\", \"UI/UX Design Masterclass\", \"1-on-1 Mentorship & Weekly Live Masterminds\", \"VIP Community & Support\"]','2026-10-22 11:30:55','2026-10-22 11:30:55');
/*!40000 ALTER TABLE `packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payouts`
--

DROP TABLE IF EXISTS `payouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payouts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `payout_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `processed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payouts_payout_code_unique` (`payout_code`),
  KEY `payouts_user_id_foreign` (`user_id`),
  CONSTRAINT `payouts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payouts`
--

LOCK TABLES `payouts` WRITE;
/*!40000 ALTER TABLE `payouts` DISABLE KEYS */;
/*!40000 ALTER TABLE `payouts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'login_video_url','https://youtu.be/0VKDTph4Kqw?si=T7r0ira8-vQd-lUc','2026-11-02 11:23:46','2026-11-02 11:37:36'),(2,'login_video_title','Welcome to SkillLearner! Watch This First','2026-11-02 11:23:46','2026-11-02 11:23:46'),(3,'login_video_description','Get started with your courses, explore your affiliate dashboard, and maximize your learning journey.','2026-11-02 11:23:46','2026-11-02 11:23:46'),(4,'login_video_enabled','1','2026-11-02 11:23:46','2026-11-02 11:23:46'),(5,'platform_name','SkillLearner EdTech','2026-11-02 11:23:46','2026-11-02 11:23:46'),(6,'tier1_commission','70','2026-11-02 11:23:46','2026-11-02 11:23:46'),(7,'tier2_commission','10','2026-11-02 11:23:46','2026-11-02 11:23:46'),(8,'min_payout_amount','1000','2026-11-02 11:23:46','2026-11-02 11:23:46');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_courses`
--

DROP TABLE IF EXISTS `user_courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_courses`
--

LOCK TABLES `user_courses` WRITE;
/*!40000 ALTER TABLE `user_courses` DISABLE KEYS */;
INSERT INTO `user_courses` VALUES (1,1,1,0,NULL,NOW(),NOW()),(2,1,2,0,NULL,NOW(),NOW()),(3,1,3,0,NULL,NOW(),NOW()),(4,1,4,0,NULL,NOW(),NOW()),(5,1,5,0,NULL,NOW(),NOW()),(6,1,6,0,NULL,NOW(),NOW()),(7,1,7,0,NULL,NOW(),NOW()),(8,1,8,0,NULL,NOW(),NOW()),(9,1,9,0,NULL,NOW(),NOW()),(10,1,10,0,NULL,NOW(),NOW()),(11,1,11,0,NULL,NOW(),NOW()),(12,1,12,0,NULL,NOW(),NOW()),(13,1,13,0,NULL,NOW(),NOW());
/*!40000 ALTER TABLE `user_courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affiliate_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sponsor_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'SL-ADMIN',
  `active_package` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Advance Package',
  `payment_status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'paid',
  `wallet_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `today_earning` decimal(10,2) NOT NULL DEFAULT '0.00',
  `weekly_earning` decimal(10,2) NOT NULL DEFAULT '0.00',
  `monthly_earning` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_earning` decimal(10,2) NOT NULL DEFAULT '0.00',
  `passive_earning` decimal(10,2) NOT NULL DEFAULT '0.00',
  `kyc_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending Verification',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'affiliate',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_affiliate_id_unique` (`affiliate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super Admin','superadmin@skilllearner.com','+91 99999 00001','SL-SUPER','SL-MASTER','Infinity Package','paid',0.00,0.00,0.00,0.00,0.00,0.00,'Verified ✅','https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80','super_admin',NULL,'$2y$12$6HQPU33FI/wSM85bYySUbut3JXj4imaxLZEFs.kIObD.0gHNbq/Ni',NULL,NOW(),NOW());
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `videos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Training',
  `badge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `views_count` int unsigned NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
INSERT INTO `videos` VALUES (1,'01. Introduction to High-Ticket Affiliate Funnels','Comprehensive orientation on setting up affiliate links, understanding tier commissions, and mapping out your first ₹50,000 month.','https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4','https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80','18m 40s','Affiliate Training','Essential',1,1420,1,'2026-10-28 06:52:54','2026-10-28 06:52:54'),(2,'02. Setting Up an Instagram Bio That Converts','A step-by-step masterclass on optimizing your social profile bio, highlights, and link-in-bio for maximum inbound student inquiries.','https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4','https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=800&auto=format&fit=crop&q=80','24m 15s','Organic Growth','High Converting',1,980,2,'2026-10-28 06:52:55','2026-10-28 06:52:55'),(3,'03. The 30-Second Reel Script Formula','The viral short-video hook script used by top affiliates to generate 100,000+ views organically without paid advertising.','https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4','https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?w=800&auto=format&fit=crop&q=80','14m 50s','Video Editing & Reels','Viral Strategy',1,2150,3,'2026-10-28 06:52:57','2026-10-28 06:52:57'),(6,'Toggle Visibility Test Video',NULL,'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',NULL,NULL,'Training',NULL,1,0,0,'2026-10-28 07:03:19','2026-10-28 07:03:22'),(7,'Visible Student Video 12345',NULL,'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',NULL,NULL,'Training',NULL,1,0,0,'2026-10-28 07:03:28','2026-10-28 07:03:28'),(8,'Hidden Secret Video 98765',NULL,'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4',NULL,NULL,'Training',NULL,0,0,0,'2026-10-28 07:03:28','2026-10-28 07:03:28'),(9,'Test Automated Video Creation','Test description for video management','https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4','https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80','10m 00s','Affiliate Training','New',1,0,0,'2026-10-28 07:05:02','2026-10-28 07:05:02'),(10,'Toggle Visibility Test Video',NULL,'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',NULL,NULL,'Training',NULL,1,0,0,'2026-10-28 07:05:07','2026-10-28 07:05:10'),(11,'Visible Student Video 12345',NULL,'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',NULL,NULL,'Training',NULL,0,0,0,'2026-10-28 07:05:16','2026-10-28 07:13:16'),(12,'Hidden Secret Video 98765',NULL,'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4',NULL,NULL,'Training',NULL,0,0,0,'2026-10-28 07:05:17','2026-10-28 07:08:55'),(13,'Test Automated Video Creation','Test description for video management','https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4','https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80','10m 00s','Affiliate Training','New',1,0,0,'2026-10-28 07:37:44','2026-10-28 07:37:44'),(14,'Toggle Visibility Test Video',NULL,'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',NULL,NULL,'Training',NULL,1,0,0,'2026-10-28 07:37:50','2026-10-28 07:37:53'),(15,'Visible Student Video 12345',NULL,'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',NULL,NULL,'Training',NULL,1,1,0,'2026-10-28 07:37:59','2026-10-28 08:08:31'),(17,'Test Automated Video Creation','Test description for video management','https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4','https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80','10m 00s','Affiliate Training','New',1,0,0,'2026-10-28 08:08:42','2026-10-28 08:08:42'),(18,'Toggle Visibility Test Video',NULL,'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',NULL,NULL,'Training',NULL,1,0,0,'2026-10-28 08:08:47','2026-10-28 08:08:50'),(19,'Visible Student Video 12345',NULL,'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',NULL,NULL,'Training',NULL,1,0,0,'2026-10-28 08:08:56','2026-10-28 08:08:56'),(20,'Hidden Secret Video 98765',NULL,'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4',NULL,NULL,'Training',NULL,0,0,0,'2026-10-28 08:08:56','2026-10-28 08:08:56'),(21,'Spoken  English  Part 1',NULL,'https://youtu.be/0VKDTph4Kqw?si=T7r0ira8-vQd-lUc','https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80','05:56','Affiliate Training',NULL,1,2,0,'2026-10-28 08:19:16','2026-11-03 18:49:24'),(22,'testing vides',NULL,'https://youtu.be/0VKDTph4Kqw?si=T7r0ira8-vQd-lUc','https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80',NULL,'Sales Closing',NULL,1,1,0,'2026-10-28 08:20:23','2026-10-29 09:09:59'),(23,'Test Automated Video Creation','Test description for video management','https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4','https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80','10m 00s','Affiliate Training','New',1,0,0,'2026-10-28 08:44:16','2026-10-28 08:44:16'),(24,'Test Automated Video Creation','Test description for video management','https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4','https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80','10m 00s','Affiliate Training','New',1,1,0,'2026-10-28 08:46:05','2026-11-01 10:52:02');
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-09 15:28:22
