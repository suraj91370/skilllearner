<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Package;
use App\Models\Setting;
use App\Models\Video;
use App\Services\PortalDataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VideoController extends Controller
{
    /**
     * Display all videos in the Super Admin Video Management dashboard.
     */
    public function index(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $filter = $request->query('filter', 'all');
        $search = trim((string) $request->query('search', ''));
        $packageFilter = $request->query('package', 'all');

        $query = Video::query()->with('package')->orderBy('sort_order')->latest();

        if ($filter === 'visible') {
            $query->where('is_visible', true);
        } elseif ($filter === 'hidden') {
            $query->where('is_visible', false);
        }

        if ($packageFilter !== 'all') {
            if ($packageFilter === 'universal') {
                $query->whereNull('package_id');
            } else {
                $query->where('package_id', (int) $packageFilter);
            }
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $videos = $query->get();
        $packages = Package::orderBy('price', 'asc')->get();

        $counts = [
            'total' => Video::count(),
            'visible' => Video::where('is_visible', true)->count(),
            'hidden' => Video::where('is_visible', false)->count(),
        ];

        $welcomeVideo = [
            'title' => Setting::get('login_video_title', 'Welcome to SkillLearner! Watch This First'),
            'url' => Setting::get('login_video_url', 'https://youtu.be/0VKDTph4Kqw?si=T7r0ira8-vQd-lUc'),
            'embed_url' => Setting::formatEmbedUrl(Setting::get('login_video_url', 'https://youtu.be/0VKDTph4Kqw?si=T7r0ira8-vQd-lUc')),
            'description' => Setting::get('login_video_description', 'Get started with your courses, explore your affiliate dashboard, and maximize your learning journey.'),
            'enabled' => (string) Setting::get('login_video_enabled', '1') === '1',
        ];

        return view('admin.videos', [
            'videos' => $videos,
            'packages' => $packages,
            'counts' => $counts,
            'welcomeVideo' => $welcomeVideo,
            'currentFilter' => $filter,
            'currentPackageFilter' => $packageFilter,
            'search' => $search,
            'active' => 'admin-videos',
        ]);
    }

    /**
     * Store a newly created video (Super Admin only).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'video_url' => ['required', 'url', 'max:500'],
            'description' => ['nullable', 'string', 'max:2000'],
            'thumbnail_url' => ['nullable', 'url', 'max:500'],
            'duration' => ['nullable', 'string', 'max:50'],
            'category' => ['nullable', 'string', 'max:100'],
            'badge' => ['nullable', 'string', 'max:50'],
            'package_id' => ['nullable', 'integer', 'exists:packages,id'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        $validated['is_visible'] = $request->boolean('is_visible', true);
        $validated['category'] = $validated['category'] ?? 'Training';
        $validated['package_id'] = ! empty($validated['package_id']) ? (int) $validated['package_id'] : null;
        $validated['thumbnail_url'] = ($validated['thumbnail_url'] ?? null) ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80';

        Video::create($validated);

        return back()->with('success', "Video '{$validated['title']}' created successfully.");
    }

    /**
     * Update an existing video (Super Admin only).
     */
    public function update(Request $request, Video $video): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'video_url' => ['required', 'url', 'max:500'],
            'description' => ['nullable', 'string', 'max:2000'],
            'thumbnail_url' => ['nullable', 'url', 'max:500'],
            'duration' => ['nullable', 'string', 'max:50'],
            'category' => ['nullable', 'string', 'max:100'],
            'badge' => ['nullable', 'string', 'max:50'],
            'package_id' => ['nullable', 'integer', 'exists:packages,id'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        $validated['is_visible'] = $request->boolean('is_visible', false);
        $validated['package_id'] = ! empty($validated['package_id']) ? (int) $validated['package_id'] : null;
        $validated['thumbnail_url'] = ($validated['thumbnail_url'] ?? null) ?: $video->thumbnail_url;

        $video->update($validated);

        return back()->with('success', "Video '{$video->title}' updated successfully.");
    }

    /**
     * Update Welcome Orientation Video ("Watch This First" Login Popup).
     */
    public function updateWelcomeVideo(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'login_video_title' => ['required', 'string', 'max:255'],
            'login_video_url' => ['required', 'string', 'max:500'],
            'login_video_description' => ['nullable', 'string', 'max:1000'],
            'login_video_enabled' => ['nullable'],
        ]);

        $loginVideoEnabled = $request->boolean('login_video_enabled') ? '1' : '0';

        Setting::set('login_video_title', $validated['login_video_title']);
        Setting::set('login_video_url', $validated['login_video_url']);
        Setting::set('login_video_description', $validated['login_video_description'] ?? '');
        Setting::set('login_video_enabled', $loginVideoEnabled);

        session(['platform_settings' => Setting::allSettings()]);

        ActivityLog::record(
            'SETTINGS_WELCOME_VIDEO_UPDATED',
            'content',
            "Updated Welcome Orientation Video: {$validated['login_video_title']}",
            $validated,
            $request
        );

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Welcome orientation video updated successfully!',
                'data' => [
                    'title' => Setting::get('login_video_title'),
                    'url' => Setting::get('login_video_url'),
                    'embed_url' => Setting::formatEmbedUrl(Setting::get('login_video_url')),
                    'description' => Setting::get('login_video_description'),
                    'enabled' => Setting::get('login_video_enabled') === '1',
                ],
            ]);
        }

        return redirect()->route('admin.videos')->with('success', 'Welcome orientation video updated successfully!');
    }

    /**
     * Toggle Show / Hide visibility for users (Super Admin only).
     */
    public function toggleVisibility(Request $request, Video $video): JsonResponse|RedirectResponse
    {
        $newStatus = ! $video->is_visible;
        $video->update(['is_visible' => $newStatus]);

        $statusText = $newStatus ? 'Visible to Users (Shown)' : 'Hidden from Users';

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'video_id' => $video->id,
                'is_visible' => $newStatus,
                'status_text' => $statusText,
                'message' => "Video '{$video->title}' is now {$statusText}.",
            ]);
        }

        return back()->with('success', "Video '{$video->title}' is now {$statusText}.");
    }

    /**
     * Delete a video (Super Admin only).
     */
    public function destroy(Video $video): RedirectResponse
    {
        $title = $video->title;
        $video->delete();

        return back()->with('success', "Video '{$title}' deleted successfully.");
    }

    /**
     * Display visible videos for Users / Students with Hierarchical Package-Level Access.
     * Higher packages automatically unlock all lower packages.
     */
    public function userIndex(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $category = $request->query('category', 'all');
        $videoId = $request->query('v');

        $user = auth()->user() ?? session('user');
        $isStaffOrAdmin = false;
        if ($user) {
            $role = strtolower((string) ($user->role ?? $user['role'] ?? ''));
            $isStaffOrAdmin = in_array($role, ['super_admin', 'admin', 'staff']) || (! empty($user->is_staff ?? $user['is_staff'] ?? false));
        }

        // All packages in ascending order of price (hierarchy: Basic -> Growth -> Advance -> Premium -> Infinity)
        $allPackages = Package::orderBy('price', 'asc')->get();

        $accessiblePackageIds = [];
        $userPackageName = 'Basic Package';

        if ($isStaffOrAdmin) {
            // Full master access for Admin
            $accessiblePackageIds = $allPackages->pluck('id')->all();
            $userPackageName = 'Master Access (Admin)';
        } else {
            $activePackageRaw = trim((string) ($user->active_package ?? $user['active_package'] ?? 'Basic Package'));
            $userPackageName = $activePackageRaw ?: 'Basic Package';

            // Match package in packages table by name or slug
            $matchedPackage = $allPackages->first(function ($pkg) use ($activePackageRaw) {
                return strtolower(trim($pkg->name)) === strtolower(trim($activePackageRaw))
                    || strtolower(trim($pkg->slug)) === strtolower(trim($activePackageRaw));
            });

            // Default to lowest price package if not matched
            $currentPrice = $matchedPackage ? (float) $matchedPackage->price : (float) ($allPackages->first()->price ?? 0);

            // Hierarchical Access: all packages where price <= current package's price
            $accessiblePackageIds = $allPackages->where('price', '<=', $currentPrice)->pluck('id')->all();
        }

        // Fetch videos accessible to user (their package + lower packages + universal videos)
        $query = Video::visible()
            ->with('package')
            ->where(function ($q) use ($accessiblePackageIds) {
                $q->whereNull('package_id')
                    ->orWhereIn('package_id', $accessiblePackageIds);
            })
            ->orderBy('sort_order')
            ->latest();

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        $videos = $query->get();

        // Increment view count for the active video if requested
        $activeVideo = null;
        if ($videoId) {
            $activeVideo = $videos->firstWhere('id', (int) $videoId);
            if ($activeVideo) {
                $activeVideo->increment('views_count');
            }
        }

        if (! $activeVideo && $videos->isNotEmpty()) {
            $activeVideo = $videos->first();
        }

        $categories = Video::visible()
            ->where(function ($q) use ($accessiblePackageIds) {
                $q->whereNull('package_id')
                    ->orWhereIn('package_id', $accessiblePackageIds);
            })
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        return view('portal.videos', [
            'videos' => $videos,
            'activeVideo' => $activeVideo,
            'categories' => $categories,
            'currentCategory' => $category,
            'userPackageName' => $userPackageName,
            'isStaffOrAdmin' => $isStaffOrAdmin,
            'active' => 'videos',
        ]);
    }
}
