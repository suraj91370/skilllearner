<?php

namespace App\Http\Controllers;

use App\Models\AffiliateTraining;
use App\Services\PortalDataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AffiliateTrainingController extends Controller
{
    /**
     * User / Student / Affiliate Portal: View & Watch Affiliate Trainings
     */
    public function index(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $this->ensureSampleTrainings();

        $search = trim((string) $request->query('search', ''));
        $categoryFilter = $request->query('category', 'all');
        $watchId = $request->query('watch');

        $query = AffiliateTraining::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc');

        if ($categoryFilter !== 'all' && ! empty($categoryFilter)) {
            $query->where('category', $categoryFilter);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('badge', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $trainings = $query->get();

        // Determine active training video to play
        $activeTraining = null;
        if (! empty($watchId)) {
            $activeTraining = $trainings->firstWhere('id', (int) $watchId)
                ?? AffiliateTraining::where('is_active', true)->find((int) $watchId);
        }

        if (! $activeTraining && $trainings->isNotEmpty()) {
            $activeTraining = $trainings->first();
        }

        if ($activeTraining) {
            $activeTraining->increment('views_count');
        }

        $categories = AffiliateTraining::where('is_active', true)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        return view('portal.training', [
            'trainings' => $trainings,
            'activeTraining' => $activeTraining,
            'categories' => $categories,
            'categoryFilter' => $categoryFilter,
            'search' => $search,
            'active' => 'training',
        ]);
    }

    /**
     * Admin: Display & Manage All Affiliate Trainings
     */
    public function adminIndex(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $this->ensureSampleTrainings();

        $statusFilter = $request->query('status', 'all');
        $search = trim((string) $request->query('search', ''));

        $query = AffiliateTraining::query()
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc');

        if ($statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($statusFilter === 'hidden') {
            $query->where('is_active', false);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('badge', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $trainings = $query->paginate(15)->withQueryString();

        $counts = [
            'total' => AffiliateTraining::count(),
            'active' => AffiliateTraining::where('is_active', true)->count(),
            'hidden' => AffiliateTraining::where('is_active', false)->count(),
            'views' => (int) AffiliateTraining::sum('views_count'),
        ];

        return view('admin.affiliate-training', [
            'trainings' => $trainings,
            'counts' => $counts,
            'statusFilter' => $statusFilter,
            'search' => $search,
            'active' => 'admin-training',
        ]);
    }

    /**
     * Admin: Store Newly Created Affiliate Training
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'youtube_url' => 'required|string|max:500',
            'photo' => 'nullable|string|max:500',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,svg|max:10240',
            'category' => 'nullable|string|max:100',
            'badge' => 'nullable|string|max:60',
            'duration' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $photo = $validated['photo'] ?? null;

        if ($request->hasFile('photo_file')) {
            $file = $request->file('photo_file');
            $destPath = public_path('uploads/training');
            if (! file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $filename = 'training_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move($destPath, $filename);
            $photo = 'uploads/training/'.$filename;
        }

        AffiliateTraining::create([
            'title' => $validated['title'],
            'youtube_url' => $validated['youtube_url'],
            'photo' => $photo,
            'category' => ! empty($validated['category']) ? trim($validated['category']) : 'Affiliate Mastery',
            'badge' => $validated['badge'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ]);

        return back()->with('success', "Affiliate training module '{$validated['title']}' added successfully!");
    }

    /**
     * Admin: Update Existing Affiliate Training
     */
    public function update(Request $request, AffiliateTraining $affiliateTraining): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'youtube_url' => 'required|string|max:500',
            'photo' => 'nullable|string|max:500',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,svg|max:10240',
            'category' => 'nullable|string|max:100',
            'badge' => 'nullable|string|max:60',
            'duration' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $photo = $affiliateTraining->photo;

        if ($request->hasFile('photo_file')) {
            $file = $request->file('photo_file');
            $destPath = public_path('uploads/training');
            if (! file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $filename = 'training_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move($destPath, $filename);

            if ($affiliateTraining->photo && str_starts_with($affiliateTraining->photo, 'uploads/training/') && file_exists(public_path($affiliateTraining->photo))) {
                @unlink(public_path($affiliateTraining->photo));
            }

            $photo = 'uploads/training/'.$filename;
        } elseif ($request->filled('photo')) {
            $photo = $validated['photo'];
        }

        $affiliateTraining->update([
            'title' => $validated['title'],
            'youtube_url' => $validated['youtube_url'],
            'photo' => $photo,
            'category' => ! empty($validated['category']) ? trim($validated['category']) : $affiliateTraining->category,
            'badge' => $validated['badge'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => (int) ($validated['sort_order'] ?? $affiliateTraining->sort_order),
        ]);

        return back()->with('success', "Affiliate training module '{$affiliateTraining->title}' updated successfully!");
    }

    /**
     * Admin: Toggle Visibility Status (Active <-> Hidden)
     */
    public function toggleVisibility(AffiliateTraining $affiliateTraining): JsonResponse|RedirectResponse
    {
        $affiliateTraining->is_active = ! $affiliateTraining->is_active;
        $affiliateTraining->save();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => $affiliateTraining->is_active,
                'message' => 'Status updated successfully.',
            ]);
        }

        $label = $affiliateTraining->is_active ? 'activated' : 'hidden';

        return back()->with('success', "Affiliate training '{$affiliateTraining->title}' has been {$label}.");
    }

    /**
     * Admin: Delete Training Record
     */
    public function destroy(AffiliateTraining $affiliateTraining): RedirectResponse
    {
        $title = $affiliateTraining->title;

        if ($affiliateTraining->photo && str_starts_with($affiliateTraining->photo, 'uploads/training/') && file_exists(public_path($affiliateTraining->photo))) {
            @unlink(public_path($affiliateTraining->photo));
        }

        $affiliateTraining->delete();

        return back()->with('success', "Affiliate training '{$title}' deleted successfully.");
    }

    /**
     * Seed initial sample affiliate training modules if table is empty
     */
    protected function ensureSampleTrainings(): void
    {
        if (AffiliateTraining::count() > 0) {
            return;
        }

        $samples = [
            [
                'title' => 'Orientation: Affiliate Journey & 30-Day Growth Roadmap',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'photo' => null,
                'category' => 'Getting Started',
                'badge' => 'STEP 1',
                'duration' => '24 Mins',
                'description' => 'Complete beginner walkthrough of the platform, payout mechanism, affiliate link generation, and milestone roadmap to reach ₹50,000 monthly income.',
                'views_count' => 520,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Instagram Organic Growth & Viral Reel Scripting',
                'youtube_url' => 'https://www.youtube.com/watch?v=jNQXAC9IVRw',
                'photo' => null,
                'category' => 'Traffic & Content',
                'badge' => 'STEP 2',
                'duration' => '32 Mins',
                'description' => 'How to optimize your Instagram profile, create high-converting 9:16 reels, hook viewers in 3 seconds, and turn followers into paying course leads.',
                'views_count' => 418,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'WhatsApp Lead Nurturing & Status Story Funnels',
                'youtube_url' => 'https://www.youtube.com/watch?v=L_LUpnjgPso',
                'photo' => null,
                'category' => 'Lead Generation',
                'badge' => 'STEP 3',
                'duration' => '28 Mins',
                'description' => 'Proven WhatsApp status sequences, broadcast guidelines, and warm conversation templates to convert inquiries into active course enrollments.',
                'views_count' => 389,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'High-Ticket Sales Closing & Objection Handling Secrets',
                'youtube_url' => 'https://www.youtube.com/watch?v=kJQP7kiw5Fk',
                'photo' => null,
                'category' => 'Sales Mastery',
                'badge' => 'STEP 4',
                'duration' => '38 Mins',
                'description' => 'Overcoming common buyer objections like "Is this genuine?", "No money right now", and how to guide prospects to make confident online enrollment decisions.',
                'views_count' => 610,
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($samples as $sample) {
            AffiliateTraining::create($sample);
        }
    }
}
