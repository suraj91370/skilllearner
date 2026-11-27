<?php

namespace App\Services;

use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PortalDataService
{
    public static function getDemoUserData(): array
    {
        return [
            'name' => 'Demo User',
            'email' => 'user@skilllearner.com',
            'phone' => '+91 98765 43210',
            'affiliate_id' => 'SL-1001',
            'sponsor_id' => 'SL-ADMIN',
            'active_package' => 'Advance Package',
            'wallet_balance' => 0,
            'pending_withdrawal' => 0,
            'today_earning' => 0,
            'weekly_earning' => 0,
            'monthly_earning' => 0,
            'total_earning' => 0,
            'passive_earning' => 0,
            'industry_revenue' => 0,
            'kyc_status' => 'Pending',
            'holder_name' => '',
            'upi_id' => '',
            'bank_name' => '',
            'account_number' => '',
            'ifsc_code' => '',
            'role' => 'user',
            'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80',
        ];
    }

    public static function ensureUserSession(): void
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();

            $isAdminOrStaff = in_array($user->role, ['super_admin', 'admin']) || (bool) $user->is_staff;
            $isPaid = strtolower((string) $user->payment_status) === 'paid';

            if ($user->is_blocked || (! $isAdminOrStaff && ! $isPaid)) {
                Auth::logout();
                session()->forget('user');
                session()->invalidate();
                session()->regenerateToken();

                return;
            }

            $earnings = CommissionService::calculateUserEarnings($user);
            $kyc = $user->kyc;
            $pendingWithdrawal = $user->payouts()->whereIn('status', ['Pending', 'Processing'])->sum('amount');
            $industryRevenue = (float) ($user->industry_revenue ?? 0.00);
            if ($industryRevenue == 0.00 && (float) $earnings['total'] > 0) {
                $industryRevenue = (float) $earnings['total'];
            }
            session(['user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '+91 98765 43210',
                'affiliate_id' => $user->affiliate_id ?? 'SL-'.$user->id,
                'sponsor_id' => $user->sponsor_id ?? 'SL-ADMIN',
                'active_package' => $user->active_package ?? 'Advance Package',
                'wallet_balance' => (float) $user->wallet_balance,
                'pending_withdrawal' => (float) $pendingWithdrawal,
                'today_earning' => (float) $earnings['today'],
                'weekly_earning' => (float) $earnings['weekly'],
                'monthly_earning' => (float) $earnings['monthly'],
                'total_earning' => (float) $earnings['total'],
                'passive_earning' => (float) $earnings['passive'],
                'industry_revenue' => $industryRevenue,
                'kyc_status' => $user->kyc_status ?? ($kyc?->status === 'Approved' ? 'Verified ✅' : ($kyc ? $kyc->status : 'Pending')),
                'holder_name' => $kyc?->holder_name ?? session('user.holder_name', ''),
                'upi_id' => $kyc?->upi_id ?? session('user.upi_id', ''),
                'bank_name' => $kyc?->bank_name ?? session('user.bank_name', ''),
                'account_number' => $kyc?->account_number ?? session('user.account_number', ''),
                'ifsc_code' => $kyc?->ifsc_code ?? session('user.ifsc_code', ''),
                'avatar' => $user->avatar ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80',
                'role' => $user->role ?? 'user',
            ]]);
        } elseif (! session()->has('user')) {
            $demoUser = User::where('email', 'vansh@skilllearner.com')->first();
            if ($demoUser) {
                Auth::login($demoUser);
                self::ensureUserSession();

                return;
            }
            session(['user' => self::getDemoUserData()]);
        }
        self::initDefaultCommissions();
    }

    public static function initDefaultCommissions(): void
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            $commissions = $user->commissions()->get();
            session(['commissions' => $commissions->map(function ($c) {
                return [
                    'name' => $c->buyer_name,
                    'package' => $c->package_name,
                    'amount' => (float) $c->amount,
                    'type' => $c->commission_type,
                    'time' => $c->created_at ? $c->created_at->diffForHumans() : 'Recently',
                    'status' => $c->status,
                ];
            })->toArray()]);

            $payouts = $user->payouts()->get();
            session(['payouts' => $payouts->map(function ($p) {
                return [
                    'id' => $p->payout_code,
                    'amount' => (float) $p->amount,
                    'method' => $p->payment_method,
                    'status' => $p->status,
                    'date' => $p->created_at ? $p->created_at->format('Y-m-d') : date('Y-m-d'),
                ];
            })->toArray()]);

            return;
        }

        if (! session()->has('commissions')) {
            session(['commissions' => []]);
        }

        if (! session()->has('payouts')) {
            session(['payouts' => []]);
        }
    }

    public static function getEnrolledCourses(bool $onlyVisible = true): array
    {
        $courses = [
            [
                'id' => 1,
                'slug' => 'reel-mastery-by-canva',
                'title' => 'Reel Mastery by Canva',
                'banner_title' => 'REEL MASTERY COURSE',
                'banner_tag' => 'Create Viral High-Ticket Reels in Canva',
                'instructor' => 'Priya Sharma',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&auto=format&fit=crop&q=80',
                'accent' => '#f59e0b',
                'gradient' => 'linear-gradient(135deg, #0a1128 0%, #1e3a8a 60%, #030712 100%)',
                'lessons' => 4,
                'duration' => '1h 15m',
                'category' => 'Video Editing & Reels',
                'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw',
                'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw',
                'is_visible' => true,
                'lessons_list' => [
                    ['id' => 1, 'title' => 'Reels Mastery Intro', 'duration' => '12m 45s', 'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw', 'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw'],
                    ['id' => 2, 'title' => 'Reels Mastery Part 1', 'duration' => '16m 20s', 'video_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4', 'embed_url' => 'https://www.youtube-nocookie.com/embed/ScMzIvxBSi4'],
                    ['id' => 3, 'title' => 'Reels Mastery Part 2', 'duration' => '19m 50s', 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'embed_url' => 'https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ'],
                    ['id' => 4, 'title' => 'Reels Mastery Part 3', 'duration' => '24m 10s', 'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw', 'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw'],
                ],
            ],
            [
                'id' => 2,
                'slug' => 'canva-graphic-designing',
                'title' => 'Canva Graphic Designing',
                'banner_title' => 'GRAPHIC DESIGNING COURSE',
                'banner_tag' => 'Learn • Create • Inspire • Succeed',
                'instructor' => 'Kunal Sharma',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80',
                'accent' => '#06b6d4',
                'gradient' => 'linear-gradient(135deg, #09090b 0%, #1e1b4b 50%, #4c1d95 100%)',
                'lessons' => 4,
                'duration' => '1h 30m',
                'category' => 'Graphic Design',
                'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw',
                'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw',
                'is_visible' => true,
                'lessons_list' => [
                    ['id' => 1, 'title' => 'Canva Graphic Designing Intro', 'duration' => '14m 10s', 'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw', 'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw'],
                    ['id' => 2, 'title' => 'Canva Graphic Designing Part 1', 'duration' => '18m 30s', 'video_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4', 'embed_url' => 'https://www.youtube-nocookie.com/embed/ScMzIvxBSi4'],
                    ['id' => 3, 'title' => 'Canva Graphic Designing Part 2', 'duration' => '21m 45s', 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'embed_url' => 'https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ'],
                    ['id' => 4, 'title' => 'Canva Graphic Designing Part 3', 'duration' => '25m 00s', 'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw', 'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw'],
                ],
            ],
            [
                'id' => 3,
                'slug' => 'e-mail-marketing',
                'title' => 'E-mail Marketing',
                'banner_title' => 'EMAIL MARKETING COURSE',
                'banner_tag' => 'Learn • Engage • Convert • Grow',
                'instructor' => 'Aman Rawat',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80',
                'accent' => '#10b981',
                'gradient' => 'linear-gradient(135deg, #070d1e 0%, #0f172a 45%, #0e7490 100%)',
                'lessons' => 4,
                'duration' => '1h 20m',
                'category' => 'Email Marketing',
                'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw',
                'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw',
                'is_visible' => true,
                'lessons_list' => [
                    ['id' => 1, 'title' => 'E-mail Marketing Intro', 'duration' => '11m 30s', 'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw', 'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw'],
                    ['id' => 2, 'title' => 'E-mail Marketing Part 1', 'duration' => '17m 15s', 'video_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4', 'embed_url' => 'https://www.youtube-nocookie.com/embed/ScMzIvxBSi4'],
                    ['id' => 3, 'title' => 'E-mail Marketing Part 2', 'duration' => '20m 40s', 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'embed_url' => 'https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ'],
                    ['id' => 4, 'title' => 'E-mail Marketing Part 3', 'duration' => '22m 10s', 'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw', 'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw'],
                ],
            ],
            [
                'id' => 4,
                'slug' => 'youtube-mastery',
                'title' => 'Youtube Mastery',
                'banner_title' => 'YOUTUBE MASTERY COURSE',
                'banner_tag' => 'Channel Growth, Thumbnails & Monetization',
                'instructor' => 'Rohan Sen',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80',
                'accent' => '#ef4444',
                'gradient' => 'linear-gradient(135deg, #180324 0%, #3b0764 50%, #701a75 100%)',
                'lessons' => 4,
                'duration' => '1h 45m',
                'category' => 'YouTube Monetization',
                'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw',
                'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw',
                'is_visible' => true,
                'lessons_list' => [
                    ['id' => 1, 'title' => 'Youtube Mastery Intro', 'duration' => '15m 00s', 'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw', 'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw'],
                    ['id' => 2, 'title' => 'Youtube Mastery Part 1', 'duration' => '20m 10s', 'video_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4', 'embed_url' => 'https://www.youtube-nocookie.com/embed/ScMzIvxBSi4'],
                    ['id' => 3, 'title' => 'Youtube Mastery Part 2', 'duration' => '23m 30s', 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'embed_url' => 'https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ'],
                    ['id' => 4, 'title' => 'Youtube Mastery Part 3', 'duration' => '26m 45s', 'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw', 'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw'],
                ],
            ],
            [
                'id' => 5,
                'slug' => 'video-marketing',
                'title' => 'Video Marketing',
                'banner_title' => 'VIDEO MARKETING COURSE',
                'banner_tag' => 'Camera Confidence, Hooks & Conversion Systems',
                'instructor' => 'Vikram Malhotra',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&auto=format&fit=crop&q=80',
                'accent' => '#8b5cf6',
                'gradient' => 'linear-gradient(135deg, #050510 0%, #1e103a 50%, #311054 100%)',
                'lessons' => 4,
                'duration' => '1h 25m',
                'category' => 'Video Production',
                'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw',
                'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw',
                'is_visible' => true,
                'lessons_list' => [
                    ['id' => 1, 'title' => 'Video Marketing Intro', 'duration' => '13m 20s', 'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw', 'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw'],
                    ['id' => 2, 'title' => 'Video Marketing Part 1', 'duration' => '18m 05s', 'video_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4', 'embed_url' => 'https://www.youtube-nocookie.com/embed/ScMzIvxBSi4'],
                    ['id' => 3, 'title' => 'Video Marketing Part 2', 'duration' => '21m 15s', 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'embed_url' => 'https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ'],
                    ['id' => 4, 'title' => 'Video Marketing Part 3', 'duration' => '24m 50s', 'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw', 'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw'],
                ],
            ],
            [
                'id' => 6,
                'slug' => 'vn-editing-course',
                'title' => 'VN Editing Course',
                'banner_title' => 'VN EDITING COURSE',
                'banner_tag' => 'Complete Smartphone Video Editing Masterclass',
                'instructor' => 'Kunal Sharma',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80',
                'accent' => '#0284c7',
                'gradient' => 'linear-gradient(135deg, #020617 0%, #172554 60%, #1e3a8a 100%)',
                'lessons' => 4,
                'duration' => '1h 10m',
                'category' => 'Mobile Video Editing',
                'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw',
                'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw',
                'is_visible' => true,
                'lessons_list' => [
                    ['id' => 1, 'title' => 'VN Editing Intro', 'duration' => '10m 50s', 'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw', 'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw'],
                    ['id' => 2, 'title' => 'VN Editing Part 1', 'duration' => '15m 40s', 'video_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4', 'embed_url' => 'https://www.youtube-nocookie.com/embed/ScMzIvxBSi4'],
                    ['id' => 3, 'title' => 'VN Editing Part 2', 'duration' => '19m 10s', 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'embed_url' => 'https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ'],
                    ['id' => 4, 'title' => 'VN Editing Part 3', 'duration' => '22m 30s', 'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw', 'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw'],
                ],
            ],
            [
                'id' => 7,
                'slug' => 'sales-mastery',
                'title' => 'Sales Mastery',
                'banner_title' => 'SALES MASTERY COURSE',
                'banner_tag' => 'High-Ticket Objection Handling & 1-Call Closing',
                'instructor' => 'Aryan Verma',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=100&auto=format&fit=crop&q=80',
                'accent' => '#d97706',
                'gradient' => 'linear-gradient(135deg, #0c0a09 0%, #291505 50%, #7c2d12 100%)',
                'lessons' => 4,
                'duration' => '1h 35m',
                'category' => 'Sales & Closing',
                'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw',
                'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw',
                'is_visible' => true,
                'lessons_list' => [
                    ['id' => 1, 'title' => 'Sales Mastery Intro', 'duration' => '14m 30s', 'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw', 'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw'],
                    ['id' => 2, 'title' => 'Sales Mastery Part 1', 'duration' => '19m 20s', 'video_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4', 'embed_url' => 'https://www.youtube-nocookie.com/embed/ScMzIvxBSi4'],
                    ['id' => 3, 'title' => 'Sales Mastery Part 2', 'duration' => '22m 45s', 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'embed_url' => 'https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ'],
                    ['id' => 4, 'title' => 'Sales Mastery Part 3', 'duration' => '25m 15s', 'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw', 'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw'],
                ],
            ],
            [
                'id' => 8,
                'slug' => 'communication-skill',
                'title' => 'Communication Skill',
                'banner_title' => 'COMMUNICATION SKILLS COURSE',
                'banner_tag' => 'Influential Public Speaking & Rapport Building',
                'instructor' => 'Pooja Singhal',
                'instructor_avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=100&auto=format&fit=crop&q=80',
                'accent' => '#a855f7',
                'gradient' => 'linear-gradient(135deg, #180324 0%, #4a044e 50%, #86198f 100%)',
                'lessons' => 4,
                'duration' => '1h 20m',
                'category' => 'Soft Skills',
                'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw',
                'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw',
                'is_visible' => true,
                'lessons_list' => [
                    ['id' => 1, 'title' => 'Communication Skill Intro', 'duration' => '12m 15s', 'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw', 'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw'],
                    ['id' => 2, 'title' => 'Communication Skill Part 1', 'duration' => '16m 50s', 'video_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4', 'embed_url' => 'https://www.youtube-nocookie.com/embed/ScMzIvxBSi4'],
                    ['id' => 3, 'title' => 'Communication Skill Part 2', 'duration' => '20m 10s', 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'embed_url' => 'https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ'],
                    ['id' => 4, 'title' => 'Communication Skill Part 3', 'duration' => '23m 40s', 'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw', 'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw'],
                ],
            ],
        ];

        // Also check if database has courses with is_visible condition
        if (class_exists(Course::class)) {
            $dbQuery = Course::query();
            if ($onlyVisible) {
                $dbQuery->where('is_visible', true);
            }
            $dbCourses = $dbQuery->get();
            if ($dbCourses->isNotEmpty()) {
                foreach ($dbCourses as $dbc) {
                    // Check if already in array
                    $exists = collect($courses)->firstWhere('slug', $dbc->slug);
                    if ($exists) {
                        // Update visibility from DB
                        foreach ($courses as &$cRef) {
                            if ($cRef['slug'] === $dbc->slug) {
                                $cRef['is_visible'] = (bool) $dbc->is_visible;
                                $cRef['id'] = $dbc->id;
                            }
                        }
                    } else {
                        $courses[] = [
                            'id' => $dbc->id,
                            'slug' => $dbc->slug,
                            'title' => $dbc->title,
                            'banner_title' => $dbc->banner_title ?: strtoupper($dbc->title),
                            'banner_tag' => $dbc->banner_tag ?: 'Master this skill step-by-step',
                            'instructor' => $dbc->instructor ?: 'SkillLearner Mentor',
                            'instructor_avatar' => $dbc->instructor_avatar ?: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100',
                            'accent' => $dbc->accent ?: '#0284c7',
                            'gradient' => $dbc->gradient ?: 'linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%)',
                            'lessons' => $dbc->lessons ?: 4,
                            'duration' => $dbc->duration ?: '1h 30m',
                            'category' => $dbc->category ?: 'Masterclass',
                            'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw',
                            'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw',
                            'is_visible' => (bool) $dbc->is_visible,
                            'lessons_list' => [
                                ['id' => 1, 'title' => $dbc->title.' Intro', 'duration' => '12m 00s', 'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw', 'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw'],
                                ['id' => 2, 'title' => $dbc->title.' Part 1', 'duration' => '15m 00s', 'video_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4', 'embed_url' => 'https://www.youtube-nocookie.com/embed/ScMzIvxBSi4'],
                                ['id' => 3, 'title' => $dbc->title.' Part 2', 'duration' => '18m 00s', 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'embed_url' => 'https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ'],
                                ['id' => 4, 'title' => $dbc->title.' Part 3', 'duration' => '20m 00s', 'video_url' => 'https://www.youtube.com/watch?v=0VKDTph4Kqw', 'embed_url' => 'https://www.youtube-nocookie.com/embed/0VKDTph4Kqw'],
                            ],
                        ];
                    }
                }
            }
        }

        if ($onlyVisible) {
            $courses = array_values(array_filter($courses, fn ($c) => ! empty($c['is_visible'])));
        }

        return $courses;
    }

    /**
     * Get a single course by slug with its lesson list for the player.
     */
    public static function getCourseBySlug(string $slug, bool $onlyVisible = false): array
    {
        $all = self::getEnrolledCourses(false);
        $course = collect($all)->firstWhere('slug', $slug);

        if (! $course) {
            $course = $all[0];
        }

        return $course;
    }
}
