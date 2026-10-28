<?php

namespace App\Http\Controllers;

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

        $query = Video::query()->orderBy('sort_order')->latest();

        if ($filter === 'visible') {
            $query->where('is_visible', true);
        } elseif ($filter === 'hidden') {
            $query->where('is_visible', false);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $videos = $query->get();

        $counts = [
            'total' => Video::count(),
            'visible' => Video::where('is_visible', true)->count(),
            'hidden' => Video::where('is_visible', false)->count(),
        ];

        return view('admin.videos', [
            'videos' => $videos,
            'counts' => $counts,
            'currentFilter' => $filter,
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
            'is_visible' => ['nullable', 'boolean'],
        ]);

        $validated['is_visible'] = $request->boolean('is_visible', true);
        $validated['category'] = $validated['category'] ?? 'Training';
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
            'is_visible' => ['nullable', 'boolean'],
        ]);

        $validated['is_visible'] = $request->boolean('is_visible', false);
        $validated['thumbnail_url'] = ($validated['thumbnail_url'] ?? null) ?: $video->thumbnail_url;

        $video->update($validated);

        return back()->with('success', "Video '{$video->title}' updated successfully.");
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
     * Display visible videos for Users / Students in the Student Portal.
     */
    public function userIndex(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $category = $request->query('category', 'all');
        $videoId = $request->query('v');

        $query = Video::visible()->orderBy('sort_order')->latest();

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

        $categories = Video::visible()->distinct()->pluck('category')->filter()->values();

        return view('portal.videos', [
            'videos' => $videos,
            'activeVideo' => $activeVideo,
            'categories' => $categories,
            'currentCategory' => $category,
            'active' => 'videos',
        ]);
    }
}
