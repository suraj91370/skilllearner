<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Get a setting by key with an optional default value.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        try {
            return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
                $record = static::where('key', $key)->first();
                if ($record !== null) {
                    return $record->value;
                }

                // Fallback to local json backup if DB record not found
                $json = static::readJsonBackup();
                return $json[$key] ?? $default;
            });
        } catch (\Throwable $e) {
            $json = static::readJsonBackup();
            return $json[$key] ?? session("platform_settings.{$key}", $default);
        }
    }

    /**
     * Set / update a setting value.
     */
    public static function set(string $key, mixed $value): static
    {
        Cache::forget("setting_{$key}");
        Cache::forget('all_platform_settings');

        $valString = is_array($value) ? json_encode($value) : (string) $value;

        // Also update local JSON backup for zero-network resilience
        $json = static::readJsonBackup();
        $json[$key] = $valString;
        static::writeJsonBackup($json);

        try {
            return static::updateOrCreate(
                ['key' => $key],
                ['value' => $valString]
            );
        } catch (\Throwable $e) {
            $inst = new static(['key' => $key, 'value' => $valString]);
            return $inst;
        }
    }

    /**
     * Get all settings as an associative key => value array.
     */
    public static function allSettings(): array
    {
        $defaults = [
            // Branding & General Info
            'site_name' => 'SkillLearner',
            'site_tagline' => "India's No. 1 Digital Education & Affiliate Platform",
            'platform_name' => 'SkillLearner EdTech',
            'site_logo' => 'images/logo.png',
            'site_logo_dark' => 'images/logo.png',
            'site_favicon' => 'favicon.png',
            'contact_email' => 'support@skilllearner.org',
            'contact_phone' => '+91 83183 73108',
            'contact_whatsapp' => '+91 83183 73108',
            'contact_address' => 'Mumbai, Maharashtra, India',
            'social_instagram' => 'https://instagram.com/skilllearner',
            'social_youtube' => 'https://youtube.com/@skilllearner',
            'social_telegram' => 'https://t.me/skilllearner',
            'social_facebook' => 'https://facebook.com/skilllearner',
            'social_linkedin' => 'https://linkedin.com/company/skilllearner',

            // SEO & Tracking
            'seo_meta_title' => 'SkillLearner | Learn High-Income Skills & Build Your Digital Career',
            'seo_meta_description' => 'SkillLearner is India\'s premier digital education and affiliate platform empowering students and professionals with practical high-income skills.',
            'seo_meta_keywords' => 'affiliate marketing, digital courses, online education, career growth, skilllearner, learn and earn',
            'google_analytics_id' => '',
            'meta_pixel_id' => '',
            'header_scripts' => '',

            // Financial & Video
            'tier1_commission' => '70',
            'tier2_commission' => '10',
            'min_payout_amount' => '1000',
            'login_video_url' => 'https://www.youtube.com/watch?v=kJQP7kiw5Fk',
            'login_video_title' => 'Welcome to SkillLearner! Watch This First',
            'login_video_description' => 'Get started with your courses, explore your affiliate dashboard, and maximize your learning journey.',
            'login_video_enabled' => '1',

            // Tax & Invoicing (GST)
            'tax_enabled' => '1',
            'tax_rate' => '18',
            'tax_company_name' => 'SkillLearner EdTech Private Limited',
            'tax_gstin' => '07AABCS1429B1Z2',
            'tax_sac_code' => '999293',
            'tax_invoice_prefix' => 'INV-SKL-',
            'tax_registered_address' => 'Tower B, Sector 62, Noida, Gautam Buddha Nagar, UP - 201301',
            'tax_state_code' => '09 - Uttar Pradesh',
            'tax_invoice_terms' => '1. Computer generated tax invoice, no physical signature required. 2. Educational digital course once activated is non-refundable per terms.',

            // Maintenance Mode
            'maintenance_mode' => '0',
            'maintenance_title' => 'Scheduled Platform Maintenance in Progress',
            'maintenance_message' => 'We are upgrading our platform infrastructure to deliver a faster and smoother learning experience. We will be back online shortly!',
            'maintenance_bypass_key' => 'skl-admin-bypass',
            'maintenance_end_time' => 'Shortly',

            // Email & SMS Notifications Channels
            'mail_from_name' => 'SkillLearner Support',
            'mail_from_address' => 'support@skilllearner.org',
            'sms_enabled' => '0',
            'sms_provider' => 'Fast2SMS',
            'sms_api_key' => '',
            'sms_sender_id' => 'SKLLRN',

            // 1. Welcome & Account Activation Template
            'template_welcome_subject' => '🎉 Welcome to SkillLearner, {name}! Your Account is Active',
            'template_welcome_email' => "Hi {name},\n\nWelcome to SkillLearner! Your account has been successfully created and your enrolled package is **{package}**.\n\nYour Affiliate ID: **{affiliate_id}**\nLogin Portal: {login_url}\n\nWe are excited to have you on board!\nTeam SkillLearner",
            'template_welcome_sms' => 'Welcome to SkillLearner, {name}! Your account is active with {package}. Login: {login_url}',

            // 2. Order Confirmation / Payment Success Template
            'template_order_subject' => '🧾 Payment Received & Order Confirmed #{order_id}',
            'template_order_email' => "Hi {name},\n\nThank you for choosing SkillLearner! We have successfully received your payment of **₹{amount}** for **{package}** (Order #{order_id}).\n\nYour invoice is ready for download in your student portal.\n\nKeep Learning,\nTeam SkillLearner",
            'template_order_sms' => 'SkillLearner: Rs.{amount} payment confirmed for Order #{order_id}. Your {package} is now unlocked! Login: {login_url}',

            // 3. Active Referral Commission Alert Template
            'template_active_referral_subject' => '💰 Direct Commission Credited: ₹{amount} from {buyer_name}',
            'template_active_referral_email' => "Hi {name},\n\nCongratulations! {buyer_name} just purchased **{package}** using your affiliate referral link.\n\nDirect Commission Credited: **₹{amount}**\nYour wallet balance has been updated.\n\nKeep sharing and keep earning!\nTeam SkillLearner",
            'template_active_referral_sms' => 'SkillLearner Alert: You earned Rs.{amount} direct commission from {buyer_name}! Check wallet: {login_url}',

            // 4. Passive Referral Commission Alert Template
            'template_passive_referral_subject' => '✨ Passive Income Credited: ₹{amount} on {package}',
            'template_passive_referral_email' => "Hi {name},\n\nGreat teamwork! A member of your referral team made a sale, and you earned a Tier-2 passive commission of **₹{amount}** on **{package}**.\n\nWallet updated automatically.\nTeam SkillLearner",
            'template_passive_referral_sms' => 'SkillLearner: Rs.{amount} passive team commission credited on {package}! Check wallet: {login_url}',

            // 5. Password Reset Template
            'template_password_reset_subject' => '🔑 Reset Your SkillLearner Password',
            'template_password_reset_email' => "Hi {name},\n\nWe received a request to reset your password. Click the secure link below:\n\n{reset_url}\n\nThis link is valid for 60 minutes. If you did not request this, please ignore this email.\nTeam SkillLearner",
            'template_password_reset_sms' => 'SkillLearner: Use this link to reset your account password: {reset_url}',

            // 6. KYC Status Template
            'template_kyc_subject' => '📄 KYC Verification Update: {kyc_status}',
            'template_kyc_email' => "Hi {name},\n\nYour KYC document verification status has been updated to: **{kyc_status}**.\n\nNote: {kyc_notes}\n\nLog in to your portal to review your payout withdrawal eligibility.\nTeam SkillLearner",
            'template_kyc_sms' => 'SkillLearner: Your KYC status is now {kyc_status}. Check details: {login_url}',
        ];

        try {
            $dbSettings = static::pluck('value', 'key')->toArray();
            return array_merge($defaults, static::readJsonBackup(), $dbSettings);
        } catch (\Throwable $e) {
            return array_merge($defaults, static::readJsonBackup(), session('platform_settings', []));
        }
    }

    /**
     * Helper to convert any YouTube, Vimeo, or web video link into a proper embed URL.
     */
    public static function formatEmbedUrl(?string $url): string
    {
        if (empty($url)) {
            return '';
        }

        $url = trim($url);

        // YouTube: https://www.youtube.com/watch?v=VIDEO_ID or youtu.be/VIDEO_ID or shorts/VIDEO_ID
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|v\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            $videoId = $matches[1];
            return "https://www.youtube.com/embed/{$videoId}?autoplay=1&rel=0&modestbranding=1&playsinline=1";
        }

        // Vimeo: https://vimeo.com/VIDEO_ID
        if (preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/|)(\d+)/', $url, $matches)) {
            $videoId = $matches[1];
            return "https://player.vimeo.com/video/{$videoId}?autoplay=1";
        }

        return $url;
    }

    /**
     * Read local storage JSON backup.
     */
    protected static function readJsonBackup(): array
    {
        $path = storage_path('app/settings.json');
        if (File::exists($path)) {
            try {
                $decoded = json_decode(File::get($path), true);
                return is_array($decoded) ? $decoded : [];
            } catch (\Throwable $e) {
                return [];
            }
        }
        return [];
    }

    /**
     * Write local storage JSON backup.
     */
    protected static function writeJsonBackup(array $data): void
    {
        $dir = storage_path('app');
        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0755, true, true);
        }
        File::put(storage_path('app/settings.json'), json_encode($data, JSON_PRETTY_PRINT));
    }
}
