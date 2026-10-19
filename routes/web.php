<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Helper to guarantee default session data for instant testing
function initCareerFixxSession() {
    if (!session()->has('user')) {
        session(['user' => [
            'name' => 'Suraj Sharma',
            'email' => 'suraj@careerfixx.test',
            'phone' => '+91 98765 43210',
            'affiliate_id' => 'CFX-8821',
            'sponsor_id' => 'CFX-ADMIN',
            'active_package' => 'Prime Package',
            'wallet_balance' => 14200,
            'today_earning' => 2200,
            'weekly_earning' => 7400,
            'total_earning' => 48600,
            'kyc_status' => 'Verified ✅'
        ]]);
    }

    if (!session()->has('commissions')) {
        session(['commissions' => [
            ['name' => 'Amit Verma', 'package' => 'Prime Package', 'amount' => 2200, 'type' => 'Direct (Tier-1)', 'time' => '10 mins ago', 'status' => 'Credited'],
            ['name' => 'Priya Nair', 'package' => 'Standard Package', 'amount' => 1200, 'type' => 'Direct (Tier-1)', 'time' => '2 hours ago', 'status' => 'Credited'],
            ['name' => 'Karan Joshi', 'package' => 'Legacy Package', 'amount' => 800, 'type' => 'Passive (Tier-2)', 'time' => 'Yesterday', 'status' => 'Credited'],
            ['name' => 'Sneha Patel', 'package' => 'Mini Package', 'amount' => 500, 'type' => 'Direct (Tier-1)', 'time' => '2 days ago', 'status' => 'Credited']
        ]]);
    }

    if (!session()->has('payouts')) {
        session(['payouts' => [
            ['id' => 'PAY-1082', 'amount' => 5000, 'method' => 'UPI (suraj@okaxis)', 'status' => 'Transferred', 'date' => date('Y-m-d', strtotime('-3 days'))],
            ['id' => 'PAY-1049', 'amount' => 10000, 'method' => 'HDFC Bank (A/C ...4819)', 'status' => 'Transferred', 'date' => date('Y-m-d', strtotime('-10 days'))]
        ]]);
    }
}

// Packages Data
function getPackages() {
    return [
        [
            'id' => 'mini',
            'name' => 'Mini Package',
            'price' => 999,
            'old_price' => 1999,
            'direct_comm' => 500,
            'passive_comm' => 100,
            'badge' => 'BEGINNER',
            'featured' => false,
            'courses_included' => ['Canva Pro Mastery', 'MS Excel Essentials', 'Basic Spoken English']
        ],
        [
            'id' => 'basic',
            'name' => 'Basic Package',
            'price' => 1499,
            'old_price' => 2999,
            'direct_comm' => 800,
            'passive_comm' => 150,
            'badge' => 'STARTER',
            'featured' => false,
            'courses_included' => ['All Mini Courses', 'Social Media Growth', 'Content Creation Secrets']
        ],
        [
            'id' => 'standard',
            'name' => 'Standard Package',
            'price' => 1999,
            'old_price' => 3999,
            'direct_comm' => 1200,
            'passive_comm' => 200,
            'badge' => 'POPULAR',
            'featured' => false,
            'courses_included' => ['All Basic & Mini Courses', 'Video Editing (Premiere & CapCut)', 'Instagram Growth Formula', 'Organic Lead Generation']
        ],
        [
            'id' => 'prime',
            'name' => 'Prime Package',
            'price' => 3499,
            'old_price' => 6999,
            'direct_comm' => 2200,
            'passive_comm' => 400,
            'badge' => 'MOST POPULAR (BEST VALUE)',
            'featured' => true,
            'courses_included' => ['All Standard & Mini Courses', 'Facebook & Instagram Paid Ads', 'AI & ChatGPT Monetization Kit', 'WordPress Web Development', 'High-Converting Sales Funnel Script']
        ],
        [
            'id' => 'infinity',
            'name' => 'Infinity Package',
            'price' => 4999,
            'old_price' => 9999,
            'direct_comm' => 3200,
            'passive_comm' => 600,
            'badge' => 'ADVANCED PRO',
            'featured' => false,
            'courses_included' => ['All Prime Courses', 'Complete Funnel Building', 'High-Ticket Sales Closing', 'Google & YouTube Ads']
        ],
        [
            'id' => 'legacy',
            'name' => 'Legacy Package',
            'price' => 6999,
            'old_price' => 13999,
            'direct_comm' => 4500,
            'passive_comm' => 800,
            'badge' => 'ALL ACCESS LIFETIME',
            'featured' => false,
            'courses_included' => ['Full Lifetime Access Pass', 'UI/UX Design Masterclass', '1-on-1 Mentorship & Weekly Live Masterminds', 'Highest 70% Commission Tier', 'Instant Fast-Track Bank Payouts']
        ]
    ];
}

// Courses Data
function getCourses() {
    return [
        ['id' => 1, 'title' => 'High-Ticket Affiliate Marketing Masterclass', 'cat' => 'Affiliate Business', 'lessons' => 18, 'duration' => '6h 40m', 'icon' => '🚀'],
        ['id' => 2, 'title' => 'AI, ChatGPT & Automation Cashflow', 'cat' => 'Artificial Intelligence', 'lessons' => 14, 'duration' => '5h 15m', 'icon' => '🤖'],
        ['id' => 3, 'title' => 'Short-Form Video Editing (CapCut & Premiere Pro)', 'cat' => 'Video & Media', 'lessons' => 22, 'duration' => '8h 20m', 'icon' => '🎬'],
        ['id' => 4, 'title' => 'Meta Ads Mastery: Facebook & Instagram Leads', 'cat' => 'Performance Marketing', 'lessons' => 16, 'duration' => '5h 50m', 'icon' => '📈'],
        ['id' => 5, 'title' => 'WordPress & Landing Page Design No-Code', 'cat' => 'Web Design', 'lessons' => 20, 'duration' => '7h 30m', 'icon' => '💻'],
        ['id' => 6, 'title' => 'Personal Branding & Instagram Reel Blueprint', 'cat' => 'Social Media', 'lessons' => 12, 'duration' => '4h 10m', 'icon' => '⭐']
    ];
}

// --- Application Routes ---

// 1. Homepage
Route::get('/', function () {
    initCareerFixxSession();
    return view('home', [
        'packages' => getPackages(),
        'courses' => getCourses()
    ]);
});

// 2. Packages & Pricing Page (also supports /programs)
Route::get('/plans', function () {
    initCareerFixxSession();
    return view('plans', [
        'packages' => getPackages()
    ]);
});
Route::get('/programs', function () {
    return redirect('/plans');
});

// 3. About Us Page
Route::get('/about', function () {
    initCareerFixxSession();
    return view('home', [
        'packages' => getPackages(),
        'courses' => getCourses()
    ]);
});

// 4. Contact Us Page
Route::get('/contact', function () {
    initCareerFixxSession();
    return view('home', [
        'packages' => getPackages(),
        'courses' => getCourses()
    ]);
});

// 5. Affiliate Command Center / Dashboard
Route::get('/dashboard', function () {
    initCareerFixxSession();
    return view('dashboard', [
        'commissions' => session('commissions', []),
        'payouts' => session('payouts', [])
    ]);
});

// 6. Video Classroom (LMS)
Route::get('/classroom', function () {
    initCareerFixxSession();
    return view('classroom');
});

// 7. Registration Page
Route::get('/register', function () {
    initCareerFixxSession();
    return view('register');
});

// 8. Action: Simulate Sale (+₹2,200)
Route::get('/simulate-sale', function () {
    initCareerFixxSession();
    $saleAmount = 2200;
    
    $user = session('user');
    $user['wallet_balance'] += $saleAmount;
    $user['today_earning'] += $saleAmount;
    $user['weekly_earning'] += $saleAmount;
    $user['total_earning'] += $saleAmount;
    session(['user' => $user]);

    $commissions = session('commissions', []);
    $names = ['Rohan Das', 'Ananya Gupta', 'Vikas Reddy', 'Manish Mehra', 'Deepak Soni'];
    array_unshift($commissions, [
        'name' => $names[array_rand($names)],
        'package' => 'Prime Package',
        'amount' => $saleAmount,
        'type' => 'Direct (Tier-1)',
        'time' => 'Just now',
        'status' => 'Credited'
    ]);
    session(['commissions' => $commissions]);

    return redirect('/dashboard')->with('alert', 'sale_added');
});

// 9. Action: Payout Request
Route::post('/payout-request', function (Request $request) {
    initCareerFixxSession();
    $amount = (float)$request->input('payout_amount', 0);
    $details = htmlspecialchars($request->input('payout_details', ''));

    $user = session('user');
    if ($amount >= 500 && $amount <= $user['wallet_balance']) {
        $user['wallet_balance'] -= $amount;
        session(['user' => $user]);

        $payouts = session('payouts', []);
        array_unshift($payouts, [
            'id' => 'PAY-' . rand(2000, 9999),
            'amount' => $amount,
            'method' => $details,
            'status' => 'Processing (Under 24h)',
            'date' => date('Y-m-d H:i')
        ]);
        session(['payouts' => $payouts]);

        return redirect('/dashboard')->with('alert', 'payout_success');
    }

    return redirect('/dashboard')->with('alert', 'payout_error');
});

// 10. Action: Register User
Route::post('/register-user', function (Request $request) {
    session(['user' => [
        'name' => $request->input('name', 'New Affiliate'),
        'email' => $request->input('email', 'student@example.com'),
        'phone' => $request->input('phone', '+91 90000 00000'),
        'affiliate_id' => 'CFX-' . rand(1000, 9999),
        'sponsor_id' => $request->input('sponsor_id', 'CFX-ADMIN'),
        'active_package' => $request->input('package', 'Prime Package'),
        'wallet_balance' => 0,
        'today_earning' => 0,
        'weekly_earning' => 0,
        'total_earning' => 0,
        'kyc_status' => 'Pending Verification'
    ]]);

    return redirect('/dashboard')->with('alert', 'welcome');
});

// 11. Action: Reset Demo
Route::get('/reset-demo', function () {
    session()->forget(['user', 'commissions', 'payouts']);
    return redirect('/')->with('alert', 'welcome');
});
