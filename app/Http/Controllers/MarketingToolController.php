<?php

namespace App\Http\Controllers;

use App\Models\MarketingTool;
use App\Services\PortalDataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MarketingToolController extends Controller
{
    /**
     * User / Student / Affiliate Portal: View Marketing Tools
     */
    public function index(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $this->ensureSampleTools();

        $typeFilter = $request->query('type', 'all');
        $categoryFilter = $request->query('category', 'all');
        $search = trim((string) $request->query('search', ''));

        $query = MarketingTool::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->latest();

        if (in_array($typeFilter, ['video', 'photo'])) {
            $query->where('type', $typeFilter);
        }

        if ($categoryFilter !== 'all' && ! empty($categoryFilter)) {
            $query->where('category', $categoryFilter);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $tools = $query->paginate(12)->withQueryString();

        $categories = MarketingTool::where('is_active', true)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        $counts = [
            'all' => MarketingTool::where('is_active', true)->count(),
            'video' => MarketingTool::where('is_active', true)->where('type', 'video')->count(),
            'photo' => MarketingTool::where('is_active', true)->where('type', 'photo')->count(),
        ];

        return view('portal.marketing', [
            'tools' => $tools,
            'categories' => $categories,
            'counts' => $counts,
            'typeFilter' => $typeFilter,
            'categoryFilter' => $categoryFilter,
            'search' => $search,
            'active' => 'marketing',
        ]);
    }

    /**
     * Download Marketing Tool Asset (Photo or Video)
     */
    public function download(MarketingTool $tool): BinaryFileResponse|RedirectResponse
    {
        $tool->increment('download_count');

        if (! empty($tool->file_path)) {
            $fullPath = public_path($tool->file_path);
            if (file_exists($fullPath)) {
                $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
                $downloadName = Str::slug($tool->title).'.'.$extension;

                return response()->download($fullPath, $downloadName);
            }
        }

        if (! empty($tool->file_url)) {
            return redirect()->away($tool->file_url);
        }

        return back()->with('error', 'File not found on server for download.');
    }

    /**
     * Admin: Display All Marketing Tools
     */
    public function adminIndex(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $this->ensureSampleTools();

        $typeFilter = $request->query('type', 'all');
        $statusFilter = $request->query('status', 'all');
        $search = trim((string) $request->query('search', ''));

        $query = MarketingTool::query()->orderBy('sort_order', 'asc')->latest();

        if (in_array($typeFilter, ['video', 'photo'])) {
            $query->where('type', $typeFilter);
        }

        if ($statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($statusFilter === 'hidden') {
            $query->where('is_active', false);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $tools = $query->paginate(15)->withQueryString();

        $counts = [
            'total' => MarketingTool::count(),
            'video' => MarketingTool::where('type', 'video')->count(),
            'photo' => MarketingTool::where('type', 'photo')->count(),
            'active' => MarketingTool::where('is_active', true)->count(),
            'hidden' => MarketingTool::where('is_active', false)->count(),
            'downloads' => (int) MarketingTool::sum('download_count'),
        ];

        return view('admin.marketing-tools', [
            'tools' => $tools,
            'counts' => $counts,
            'typeFilter' => $typeFilter,
            'statusFilter' => $statusFilter,
            'search' => $search,
            'active' => 'admin-marketing',
        ]);
    }

    /**
     * Admin: Store Newly Created Marketing Tool
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:photo,video',
            'category' => 'nullable|string|max:100',
            'file' => 'nullable|file|max:512000', // 500MB max
            'file_url' => 'nullable|string|max:500',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        if (! $request->hasFile('file') && empty($validated['file_url'])) {
            return back()->with('error', 'Please upload a photo/video file or provide a media URL.')->withInput();
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $type = $validated['type'];
            $folder = $type === 'video' ? 'uploads/marketing/videos' : 'uploads/marketing/photos';
            $destPath = public_path($folder);
            if (! file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $filename = 'marketing_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move($destPath, $filename);
            $filePath = $folder.'/'.$filename;
        }

        $thumbPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbFile = $request->file('thumbnail');
            $thumbFolder = 'uploads/marketing/thumbs';
            $destThumbPath = public_path($thumbFolder);
            if (! file_exists($destThumbPath)) {
                mkdir($destThumbPath, 0755, true);
            }
            $thumbFilename = 'thumb_'.time().'_'.uniqid().'.'.$thumbFile->getClientOriginalExtension();
            $thumbFile->move($destThumbPath, $thumbFilename);
            $thumbPath = $thumbFolder.'/'.$thumbFilename;
        }

        $category = ! empty($validated['category']) ? trim($validated['category']) : ($validated['type'] === 'video' ? 'Shorts & Reels' : 'Posters & Flyers');

        MarketingTool::create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'category' => $category,
            'file_path' => $filePath,
            'file_url' => $validated['file_url'] ?? null,
            'thumbnail_path' => $thumbPath,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ]);

        return back()->with('success', "Marketing tool '{$validated['title']}' added successfully!");
    }

    /**
     * Admin: Update Existing Marketing Tool
     */
    public function update(Request $request, MarketingTool $marketingTool): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:photo,video',
            'category' => 'nullable|string|max:100',
            'file' => 'nullable|file|max:512000',
            'file_url' => 'nullable|string|max:500',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $filePath = $marketingTool->file_path;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $type = $validated['type'];
            $folder = $type === 'video' ? 'uploads/marketing/videos' : 'uploads/marketing/photos';
            $destPath = public_path($folder);
            if (! file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $filename = 'marketing_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move($destPath, $filename);

            // Delete old file if stored locally in uploads/marketing
            if ($marketingTool->file_path && str_starts_with($marketingTool->file_path, 'uploads/marketing/') && file_exists(public_path($marketingTool->file_path))) {
                @unlink(public_path($marketingTool->file_path));
            }

            $filePath = $folder.'/'.$filename;
        } elseif ($request->filled('file_url')) {
            $filePath = null;
        }

        $thumbPath = $marketingTool->thumbnail_path;
        if ($request->hasFile('thumbnail')) {
            $thumbFile = $request->file('thumbnail');
            $thumbFolder = 'uploads/marketing/thumbs';
            $destThumbPath = public_path($thumbFolder);
            if (! file_exists($destThumbPath)) {
                mkdir($destThumbPath, 0755, true);
            }
            $thumbFilename = 'thumb_'.time().'_'.uniqid().'.'.$thumbFile->getClientOriginalExtension();
            $thumbFile->move($destThumbPath, $thumbFilename);

            if ($marketingTool->thumbnail_path && str_starts_with($marketingTool->thumbnail_path, 'uploads/marketing/') && file_exists(public_path($marketingTool->thumbnail_path))) {
                @unlink(public_path($marketingTool->thumbnail_path));
            }

            $thumbPath = $thumbFolder.'/'.$thumbFilename;
        }

        $category = ! empty($validated['category']) ? trim($validated['category']) : $marketingTool->category;

        $marketingTool->update([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'category' => $category,
            'file_path' => $filePath,
            'file_url' => $validated['file_url'] ?? $marketingTool->file_url,
            'thumbnail_path' => $thumbPath,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => (int) ($validated['sort_order'] ?? $marketingTool->sort_order),
        ]);

        return back()->with('success', "Marketing tool '{$marketingTool->title}' updated successfully!");
    }

    /**
     * Admin: Toggle Visibility Status (Active <-> Hidden)
     */
    public function toggleVisibility(MarketingTool $marketingTool): JsonResponse|RedirectResponse
    {
        $marketingTool->is_active = ! $marketingTool->is_active;
        $marketingTool->save();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => $marketingTool->is_active,
                'message' => 'Status updated successfully.',
            ]);
        }

        $label = $marketingTool->is_active ? 'activated' : 'hidden';

        return back()->with('success', "Marketing tool '{$marketingTool->title}' has been {$label}.");
    }

    /**
     * Admin: Delete Marketing Tool
     */
    public function destroy(MarketingTool $marketingTool): RedirectResponse
    {
        $title = $marketingTool->title;

        if ($marketingTool->file_path && str_starts_with($marketingTool->file_path, 'uploads/marketing/') && file_exists(public_path($marketingTool->file_path))) {
            @unlink(public_path($marketingTool->file_path));
        }

        if ($marketingTool->thumbnail_path && str_starts_with($marketingTool->thumbnail_path, 'uploads/marketing/') && file_exists(public_path($marketingTool->thumbnail_path))) {
            @unlink(public_path($marketingTool->thumbnail_path));
        }

        $marketingTool->delete();

        return back()->with('success', "Marketing tool '{$title}' deleted successfully.");
    }

    /**
     * Seed initial sample marketing tools only once if table is empty
     */
    protected function ensureSampleTools(): void
    {
        if (MarketingTool::count() > 0) {
            return;
        }

        $samples = [
            [
                'title' => 'Viral 9:16 Reel: 3 High-Income Skills in 2026',
                'type' => 'video',
                'category' => 'Shorts & Reels',
                'file_path' => null,
                'file_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4',
                'thumbnail_path' => 'https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7?w=600&auto=format&fit=crop&q=80',
                'description' => "🔥 Stop scrolling! Here are the 3 digital skills that pay the most in 2026. Use this high-converting short video for Instagram Reels, YouTube Shorts, and Facebook Reels. \n\n👉 Join SkillLearner now & link in bio! #affiliatemarketing #skills2026 #onlineincome #skilllearner",
                'download_count' => 148,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Instagram Reel: Student Earned ₹25,000 First Month',
                'type' => 'video',
                'category' => 'Shorts & Reels',
                'file_path' => null,
                'file_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerJoyBlazes.mp4',
                'thumbnail_path' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=600&auto=format&fit=crop&q=80',
                'description' => "Real student breakthrough story! Post this reel to build massive social proof on your profile.\n\nDM 'GROWTH' to start your learning journey today! 🚀 #studentearning #digitalmarketing #skilllearner",
                'download_count' => 212,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Official SkillLearner VIP Launch Poster (HD)',
                'type' => 'photo',
                'category' => 'Posters & Flyers',
                'file_path' => null,
                'file_url' => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=1080&auto=format&fit=crop&q=80',
                'thumbnail_path' => null,
                'description' => "Official HD Poster for WhatsApp Status, Telegram groups, and Instagram feed. Designed for maximum click-through rate!\n\n✨ Certified Courses + Daily Mentorship + Lifetime Community Access. DM for details!",
                'download_count' => 389,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'WhatsApp Status Swipe: Daily Motivation & Action',
                'type' => 'photo',
                'category' => 'WhatsApp Stories',
                'file_path' => null,
                'file_url' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=1080&auto=format&fit=crop&q=80',
                'thumbnail_path' => null,
                'description' => 'Upload this high-vibe creative to your WhatsApp Status every morning between 8 AM - 10 AM for highest views and incoming inquiries.',
                'download_count' => 456,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Leaderboard & Commission Showcase Banner',
                'type' => 'photo',
                'category' => 'Banners & Creatives',
                'file_path' => null,
                'file_url' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=1080&auto=format&fit=crop&q=80',
                'thumbnail_path' => null,
                'description' => 'Perfect square banner (1:1) showcasing learning rewards and affiliate commission milestones. Add your affiliate link or QR code on top!',
                'download_count' => 294,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($samples as $item) {
            MarketingTool::create($item);
        }
    }
}
