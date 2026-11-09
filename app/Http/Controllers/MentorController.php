<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Mentor;
use App\Models\MentorPayout;
use App\Services\PortalDataService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MentorController extends Controller
{
    /**
     * Display Mentor Management Dashboard
     */
    public function index(Request $request): View
    {
        PortalDataService::ensureUserSession();

        // Seed or update the 4 core mentors from homepage display
        $this->ensureSampleMentors();

        $search = trim((string) $request->query('search', ''));
        $statusFilter = $request->query('status', 'all');
        $kycFilter = $request->query('kyc_status', 'all');
        $featuredFilter = $request->query('featured', 'all');
        $activeTab = $request->query('tab', 'mentors');

        $query = Mentor::with('payouts')->latest();

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('expertise', 'like', "%{$search}%")
                    ->orWhere('designation', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        if ($kycFilter && $kycFilter !== 'all') {
            $query->where('kyc_status', $kycFilter);
        }

        if ($featuredFilter === 'yes') {
            $query->where('is_featured', true);
        } elseif ($featuredFilter === 'no') {
            $query->where('is_featured', false);
        }

        $mentors = $query->paginate(15)->withQueryString();

        $payouts = MentorPayout::with('mentor')->latest()->paginate(15, ['*'], 'payouts_page')->withQueryString();

        $courses = Course::select(['id', 'title', 'category', 'instructor'])->orderBy('title')->get();

        $stats = [
            'total_mentors' => Mentor::count(),
            'active_mentors' => Mentor::where('status', 'active')->count(),
            'blocked_mentors' => Mentor::where('status', 'blocked')->count(),
            'featured_mentors' => Mentor::where('is_featured', true)->count(),
            'pending_kyc' => Mentor::where('kyc_status', 'pending')->count(),
            'pending_payouts' => MentorPayout::where('status', 'pending')->count(),
            'total_paid' => MentorPayout::where('status', 'approved')->sum('amount'),
        ];

        return view('admin.mentors', [
            'mentors' => $mentors,
            'payouts' => $payouts,
            'courses' => $courses,
            'stats' => $stats,
            'search' => $search,
            'statusFilter' => $statusFilter,
            'kycFilter' => $kycFilter,
            'featuredFilter' => $featuredFilter,
            'activeTab' => $activeTab,
            'active' => 'admin-mentors',
        ]);
    }

    /**
     * Store newly created Mentor
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:mentors,email',
            'phone' => 'nullable|string|max:50',
            'photo' => 'nullable|string|max:500',
            'bio' => 'nullable|string',
            'expertise' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:100',
            'qualification' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'badge' => 'nullable|string|max:255',
            'commission_percentage' => 'nullable|numeric|min:0|max:100',
            'assigned_courses' => 'nullable|array',
            'is_featured' => 'nullable|boolean',
            'linkedin' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'github' => 'nullable|string|max:255',
            'pan_number' => 'nullable|string|max:30',
            'aadhar_number' => 'nullable|string|max:30',
            'bank_name' => 'nullable|string|max:255',
            'holder_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:30',
            'upi_id' => 'nullable|string|max:255',
        ]);

        $socialLinks = [
            'linkedin' => $validated['linkedin'] ?? '',
            'youtube' => $validated['youtube'] ?? '',
            'twitter' => $validated['twitter'] ?? '',
            'github' => $validated['github'] ?? '',
        ];

        $photo = $validated['photo'] ?? null;
        if (empty($photo)) {
            $photo = 'https://ui-avatars.com/api/?name='.urlencode($validated['name']).'&background=7c3aed&color=ffffff&bold=true';
        }

        Mentor::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'photo' => $photo,
            'bio' => $validated['bio'] ?? null,
            'expertise' => $validated['expertise'] ?? null,
            'experience' => $validated['experience'] ?? null,
            'qualification' => $validated['qualification'] ?? null,
            'designation' => $validated['designation'] ?? null,
            'badge' => $validated['badge'] ?? null,
            'commission_percentage' => $validated['commission_percentage'] ?? 15.00,
            'assigned_courses' => $validated['assigned_courses'] ?? [],
            'is_featured' => $request->boolean('is_featured'),
            'social_links' => $socialLinks,
            'status' => 'active',
            'kyc_status' => 'approved',
            'pan_number' => $validated['pan_number'] ?? null,
            'aadhar_number' => $validated['aadhar_number'] ?? null,
            'bank_name' => $validated['bank_name'] ?? null,
            'holder_name' => $validated['holder_name'] ?? $validated['name'],
            'account_number' => $validated['account_number'] ?? null,
            'ifsc_code' => $validated['ifsc_code'] ?? null,
            'upi_id' => $validated['upi_id'] ?? null,
        ]);

        return back()->with('success', "Mentor '{$validated['name']}' added successfully!");
    }

    /**
     * Update Mentor Profile
     */
    public function update(Request $request, Mentor $mentor): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:mentors,email,'.$mentor->id,
            'phone' => 'nullable|string|max:50',
            'photo' => 'nullable|string|max:500',
            'bio' => 'nullable|string',
            'expertise' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:100',
            'qualification' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'badge' => 'nullable|string|max:255',
            'commission_percentage' => 'nullable|numeric|min:0|max:100',
            'assigned_courses' => 'nullable|array',
            'is_featured' => 'nullable|boolean',
            'linkedin' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'github' => 'nullable|string|max:255',
            'pan_number' => 'nullable|string|max:30',
            'aadhar_number' => 'nullable|string|max:30',
            'bank_name' => 'nullable|string|max:255',
            'holder_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:30',
            'upi_id' => 'nullable|string|max:255',
        ]);

        $socialLinks = [
            'linkedin' => $validated['linkedin'] ?? ($mentor->social_links['linkedin'] ?? ''),
            'youtube' => $validated['youtube'] ?? ($mentor->social_links['youtube'] ?? ''),
            'twitter' => $validated['twitter'] ?? ($mentor->social_links['twitter'] ?? ''),
            'github' => $validated['github'] ?? ($mentor->social_links['github'] ?? ''),
        ];

        $mentor->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? $mentor->phone,
            'photo' => ! empty($validated['photo']) ? $validated['photo'] : $mentor->photo,
            'bio' => $validated['bio'] ?? $mentor->bio,
            'expertise' => $validated['expertise'] ?? $mentor->expertise,
            'experience' => $validated['experience'] ?? $mentor->experience,
            'qualification' => $validated['qualification'] ?? $mentor->qualification,
            'designation' => $validated['designation'] ?? $mentor->designation,
            'badge' => $validated['badge'] ?? $mentor->badge,
            'commission_percentage' => isset($validated['commission_percentage']) ? (float) $validated['commission_percentage'] : $mentor->commission_percentage,
            'assigned_courses' => $validated['assigned_courses'] ?? $mentor->assigned_courses,
            'is_featured' => $request->boolean('is_featured'),
            'social_links' => $socialLinks,
            'pan_number' => $validated['pan_number'] ?? $mentor->pan_number,
            'aadhar_number' => $validated['aadhar_number'] ?? $mentor->aadhar_number,
            'bank_name' => $validated['bank_name'] ?? $mentor->bank_name,
            'holder_name' => $validated['holder_name'] ?? $mentor->holder_name,
            'account_number' => $validated['account_number'] ?? $mentor->account_number,
            'ifsc_code' => $validated['ifsc_code'] ?? $mentor->ifsc_code,
            'upi_id' => $validated['upi_id'] ?? $mentor->upi_id,
        ]);

        return back()->with('success', "Mentor '{$mentor->name}' profile updated successfully!");
    }

    /**
     * Toggle whether mentor is featured on the homepage Expert Team & Mentors section
     */
    public function toggleFeatured(Mentor $mentor): RedirectResponse
    {
        $newFeatured = ! $mentor->is_featured;
        $mentor->update(['is_featured' => $newFeatured]);

        $label = $newFeatured ? 'added to' : 'removed from';

        return back()->with('success', "Mentor '{$mentor->name}' has been {$label} the homepage display!");
    }

    /**
     * Toggle Mentor Status (Active <-> Blocked)
     */
    public function toggleStatus(Mentor $mentor): RedirectResponse
    {
        $newStatus = ($mentor->status === 'active') ? 'blocked' : 'active';
        $mentor->update(['status' => $newStatus]);

        $label = ($newStatus === 'active') ? 'activated' : 'blocked';

        return back()->with('success', "Mentor '{$mentor->name}' has been {$label}.");
    }

    /**
     * Update Mentor KYC Verification
     */
    public function updateKyc(Request $request, Mentor $mentor): RedirectResponse
    {
        $action = $request->input('action', 'approve'); // approve or reject
        $newStatus = ($action === 'approve') ? 'approved' : 'rejected';

        $mentor->update([
            'kyc_status' => $newStatus,
            'pan_number' => $request->input('pan_number', $mentor->pan_number),
            'aadhar_number' => $request->input('aadhar_number', $mentor->aadhar_number),
            'bank_name' => $request->input('bank_name', $mentor->bank_name),
            'holder_name' => $request->input('holder_name', $mentor->holder_name),
            'account_number' => $request->input('account_number', $mentor->account_number),
            'ifsc_code' => $request->input('ifsc_code', $mentor->ifsc_code),
            'upi_id' => $request->input('upi_id', $mentor->upi_id),
        ]);

        return back()->with('success', "Mentor '{$mentor->name}' KYC has been {$newStatus}!");
    }

    /**
     * Approve or Reject Mentor Payout
     */
    public function processPayout(Request $request, MentorPayout $payout): RedirectResponse
    {
        $action = $request->input('action', 'approve');
        $transactionId = $request->input('transaction_id', 'TXN-'.strtoupper(uniqid()));

        if ($action === 'approve') {
            $payout->update([
                'status' => 'approved',
                'transaction_id' => $transactionId,
                'processed_at' => now(),
            ]);

            // Increment mentor total_earned
            $payout->mentor?->increment('total_earned', $payout->amount);

            return back()->with('success', 'Payout #'.$payout->id.' approved successfully!');
        }

        $payout->update([
            'status' => 'rejected',
            'notes' => $request->input('notes', 'Rejected by admin'),
            'processed_at' => now(),
        ]);

        return back()->with('info', 'Payout #'.$payout->id.' has been rejected.');
    }

    /**
     * Create Payout Request for Mentor
     */
    public function createPayout(Request $request, Mentor $mentor): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:100',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        MentorPayout::create([
            'mentor_id' => $mentor->id,
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        return back()->with('success', "Payout request of ₹{$validated['amount']} created for {$mentor->name}.");
    }

    /**
     * Delete Mentor
     */
    public function destroy(Mentor $mentor): RedirectResponse
    {
        $name = $mentor->name;
        $mentor->delete();

        return back()->with('success', "Mentor '{$name}' has been deleted.");
    }

    /**
     * Ensure realistic mentors exist on first load
     */
    protected function ensureSampleMentors(): void
    {
        $coreMentors = [
            [
                'name' => 'Adarsh Pandey',
                'email' => 'adarsh.pandey@skilllearner.com',
                'phone' => '+91 98765 00001',
                'photo' => 'images/founder.jpg',
                'designation' => 'Founder & CEO – Skilllearner',
                'badge' => '★ FOUNDER & CEO',
                'bio' => 'Founder and CEO with 5+ years of experience in Digital Marketing and Online Business, bringing deep expertise in digital growth and branding.',
                'expertise' => 'Digital Marketing, Online Business, Growth & Branding',
                'experience' => '5+ Years',
                'qualification' => 'Founder & CEO, Digital Growth Strategist',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com',
                    'youtube' => 'https://youtube.com',
                    'twitter' => '',
                    'github' => '',
                ],
                'commission_percentage' => 25.00,
                'assigned_courses' => [],
                'status' => 'active',
                'is_featured' => true,
                'kyc_status' => 'approved',
                'pan_number' => 'ADRSH1234F',
                'aadhar_number' => '9876 5432 1001',
                'bank_name' => 'HDFC Bank',
                'holder_name' => 'Adarsh Pandey',
                'account_number' => '50100458923001',
                'ifsc_code' => 'HDFC0001234',
                'upi_id' => 'adarsh@hdfcbank',
                'total_earned' => 145000.00,
                'wallet_balance' => 24500.00,
            ],
            [
                'name' => 'Ravi Gond',
                'email' => 'ravi.gond@skilllearner.com',
                'phone' => '+91 98765 00002',
                'photo' => 'images/co-founder.jpg',
                'designation' => 'Co-Founder – Skilllearner',
                'badge' => '★ CO-FOUNDER',
                'bio' => 'Co-Founder with 4+ years of experience in Digital Marketing and Online Business, specializing in sales strategies and online branding.',
                'expertise' => 'Sales Strategies, Online Branding, Business Scaling',
                'experience' => '4+ Years',
                'qualification' => 'Co-Founder, Sales & Brand Specialist',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com',
                    'youtube' => 'https://youtube.com',
                    'twitter' => '',
                    'github' => '',
                ],
                'commission_percentage' => 20.00,
                'assigned_courses' => [],
                'status' => 'active',
                'is_featured' => true,
                'kyc_status' => 'approved',
                'pan_number' => 'RAVIG5678Y',
                'aadhar_number' => '9876 5432 1002',
                'bank_name' => 'ICICI Bank',
                'holder_name' => 'Ravi Gond',
                'account_number' => '189201928002',
                'ifsc_code' => 'ICIC0001892',
                'upi_id' => 'ravi@icici',
                'total_earned' => 98000.00,
                'wallet_balance' => 18200.00,
            ],
            [
                'name' => 'Pavan Prajapati',
                'email' => 'pavan.prajapati@skilllearner.com',
                'phone' => '+91 98765 00003',
                'photo' => 'images/mentor-1.jpg',
                'designation' => 'SkillLearner EdTech',
                'badge' => '★ PAVAN PRAJAPATI',
                'bio' => 'Dedicated mentor offering practical guidance, hands-on masterclasses, and career coaching to help learners achieve measurable digital growth.',
                'expertise' => 'Practical Masterclasses, Career Coaching, Digital Growth',
                'experience' => '4+ Years',
                'qualification' => 'Expert Mentor, Career Coach',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com',
                    'youtube' => 'https://youtube.com',
                    'twitter' => '',
                    'github' => '',
                ],
                'commission_percentage' => 15.00,
                'assigned_courses' => [],
                'status' => 'active',
                'is_featured' => true,
                'kyc_status' => 'approved',
                'pan_number' => 'PAVAN9012P',
                'aadhar_number' => '9876 5432 1003',
                'bank_name' => 'State Bank of India',
                'holder_name' => 'Pavan Prajapati',
                'account_number' => '309823478003',
                'ifsc_code' => 'SBIN0004321',
                'upi_id' => 'pavan@sbi',
                'total_earned' => 45000.00,
                'wallet_balance' => 9500.00,
            ],
            [
                'name' => 'Soumyadip Pania',
                'email' => 'soumyadip.pania@skilllearner.com',
                'phone' => '+91 98765 00004',
                'photo' => 'images/mentor-2.jpg',
                'designation' => 'SkillLearner EdTech',
                'badge' => '★ SOUMYADIP PANIA',
                'bio' => 'Empowering students with actionable digital skills, real-time problem solving, and proven strategies to succeed in competitive markets.',
                'expertise' => 'Digital Skills, Problem Solving, Market Strategy',
                'experience' => '3+ Years',
                'qualification' => 'Expert Mentor, Digital Strategist',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com',
                    'youtube' => 'https://youtube.com',
                    'twitter' => '',
                    'github' => '',
                ],
                'commission_percentage' => 15.00,
                'assigned_courses' => [],
                'status' => 'active',
                'is_featured' => true,
                'kyc_status' => 'approved',
                'pan_number' => 'SOUMY3456K',
                'aadhar_number' => '9876 5432 1004',
                'bank_name' => 'Axis Bank',
                'holder_name' => 'Soumyadip Pania',
                'account_number' => '918020038004',
                'ifsc_code' => 'UTIB0000123',
                'upi_id' => 'soumyadip@axisbank',
                'total_earned' => 38000.00,
                'wallet_balance' => 7800.00,
            ],
        ];

        foreach ($coreMentors as $data) {
            Mentor::updateOrCreate(
                ['email' => $data['email']],
                $data
            );
        }

        $courseIds = Course::pluck('id')->take(3)->toArray();

        // Additional sample mentors if none exist
        if (Mentor::where('email', 'rahul.verma@example.com')->doesntExist()) {
            $m1 = Mentor::create([
                'name' => 'Rahul Verma',
                'email' => 'rahul.verma@example.com',
                'phone' => '+91 98765 43210',
                'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=160&auto=format&fit=crop&q=80',
                'bio' => 'Senior Full Stack & AI Architect with 8+ years experience guiding over 12,000 students in modern software engineering.',
                'expertise' => 'Full Stack Web Dev, Python AI, React',
                'experience' => '8+ Years',
                'qualification' => 'B.Tech CSE, AWS Certified Solutions Architect',
                'designation' => 'Senior Software Architect',
                'badge' => '★ SENIOR MENTOR',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/rahulverma',
                    'youtube' => 'https://youtube.com/@rahulcodes',
                    'twitter' => 'https://twitter.com/rahulverma',
                    'github' => 'https://github.com/rahulverma',
                ],
                'commission_percentage' => 20.00,
                'assigned_courses' => array_slice($courseIds, 0, 2),
                'status' => 'active',
                'is_featured' => false,
                'kyc_status' => 'approved',
                'pan_number' => 'ABCDE1234F',
                'aadhar_number' => '9876 5432 1098',
                'bank_name' => 'HDFC Bank',
                'holder_name' => 'Rahul Verma',
                'account_number' => '50100458923412',
                'ifsc_code' => 'HDFC0001234',
                'upi_id' => 'rahul@hdfcbank',
                'total_earned' => 84500.00,
                'wallet_balance' => 12400.00,
            ]);

            // Sample payouts
            MentorPayout::create([
                'mentor_id' => $m1->id,
                'amount' => 25000.00,
                'payment_method' => 'Bank Transfer (IMPS)',
                'status' => 'approved',
                'transaction_id' => 'IMPS9283019284',
                'notes' => 'Monthly revenue share payout for October',
                'processed_at' => now()->subDays(5),
            ]);
        }
    }
}
