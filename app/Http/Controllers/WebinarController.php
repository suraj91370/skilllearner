<?php

namespace App\Http\Controllers;

use App\Models\Webinar;
use App\Services\PortalDataService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class WebinarController extends Controller
{
    /**
     * User / Student / Affiliate Portal: View Webinars
     */
    public function index(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $this->ensureSampleWebinars();

        $webinars = Webinar::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('webinar_date', 'asc')
            ->get();

        return view('portal.webinars', [
            'webinars' => $webinars,
            'active' => 'webinars',
        ]);
    }

    /**
     * Download Webinar Poster
     */
    public function download(Webinar $webinar): BinaryFileResponse|RedirectResponse
    {
        $webinar->increment('download_count');

        if (! empty($webinar->poster)) {
            $fullPath = public_path($webinar->poster);
            if (file_exists($fullPath)) {
                $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
                $downloadName = Str::slug($webinar->title).'-webinar-poster.'.$extension;

                return response()->download($fullPath, $downloadName);
            }
        }

        if (! empty($webinar->poster_url)) {
            return redirect()->away($webinar->poster_url);
        }

        return back()->with('error', 'Webinar poster not found on server.');
    }

    /**
     * Admin Panel: Manage Webinars
     */
    public function adminIndex(Request $request): View
    {
        $this->ensureSampleWebinars();

        $statusFilter = $request->query('status', 'all');
        $platformFilter = $request->query('platform', 'all');
        $search = trim((string) $request->query('search', ''));

        $query = Webinar::query()->orderBy('sort_order', 'asc')->latest();

        if ($statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($statusFilter === 'hidden') {
            $query->where('is_active', false);
        }

        if ($platformFilter !== 'all' && ! empty($platformFilter)) {
            $query->where('platform', $platformFilter);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('speaker', 'like', "%{$search}%")
                    ->orWhere('speaker_role', 'like', "%{$search}%")
                    ->orWhere('meeting_link', 'like', "%{$search}%");
            });
        }

        $webinars = $query->paginate(15)->withQueryString();

        $counts = [
            'total' => Webinar::count(),
            'active' => Webinar::where('is_active', true)->count(),
            'hidden' => Webinar::where('is_active', false)->count(),
            'downloads' => (int) Webinar::sum('download_count'),
        ];

        return view('admin.webinars', compact('webinars', 'counts', 'statusFilter', 'platformFilter', 'search'));
    }

    /**
     * Store new webinar with poster upload and meeting link
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'speaker' => 'nullable|string|max:255',
            'speaker_role' => 'nullable|string|max:255',
            'meeting_link' => 'required|url|max:1000',
            'platform' => 'required|string|in:zoom,google_meet,youtube_live,other',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'poster_url' => 'nullable|url|max:500',
            'webinar_date' => 'nullable|date',
            'webinar_time' => 'nullable|string|max:100',
            'badge' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $folder = 'uploads/webinars/posters';
            $destPath = public_path($folder);
            if (! file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $filename = 'webinar_poster_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move($destPath, $filename);
            $posterPath = $folder.'/'.$filename;
        }

        Webinar::create([
            'title' => $validated['title'],
            'speaker' => $validated['speaker'] ?? null,
            'speaker_role' => $validated['speaker_role'] ?? null,
            'meeting_link' => $validated['meeting_link'],
            'platform' => $validated['platform'],
            'poster' => $posterPath,
            'poster_url' => $validated['poster_url'] ?? null,
            'webinar_date' => $validated['webinar_date'] ?? Carbon::today(),
            'webinar_time' => $validated['webinar_time'] ?? '8:00 PM IST',
            'badge' => ! empty($validated['badge']) ? strtoupper(trim($validated['badge'])) : 'LIVE WEBINAR',
            'description' => $validated['description'] ?? null,
            'sort_order' => isset($validated['sort_order']) ? (int) $validated['sort_order'] : (Webinar::max('sort_order') + 1),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.webinars')->with('success', 'Live Webinar created successfully with meeting link and poster!');
    }

    /**
     * Update webinar
     */
    public function update(Request $request, Webinar $webinar): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'speaker' => 'nullable|string|max:255',
            'speaker_role' => 'nullable|string|max:255',
            'meeting_link' => 'required|url|max:1000',
            'platform' => 'required|string|in:zoom,google_meet,youtube_live,other',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'poster_url' => 'nullable|url|max:500',
            'webinar_date' => 'nullable|date',
            'webinar_time' => 'nullable|string|max:100',
            'badge' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $posterPath = $webinar->poster;
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $folder = 'uploads/webinars/posters';
            $destPath = public_path($folder);
            if (! file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $filename = 'webinar_poster_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move($destPath, $filename);

            // Clean up old file
            if (! empty($webinar->poster) && file_exists(public_path($webinar->poster))) {
                @unlink(public_path($webinar->poster));
            }

            $posterPath = $folder.'/'.$filename;
        }

        $webinar->update([
            'title' => $validated['title'],
            'speaker' => $validated['speaker'] ?? null,
            'speaker_role' => $validated['speaker_role'] ?? null,
            'meeting_link' => $validated['meeting_link'],
            'platform' => $validated['platform'],
            'poster' => $posterPath,
            'poster_url' => $validated['poster_url'] ?? $webinar->poster_url,
            'webinar_date' => $validated['webinar_date'] ?? $webinar->webinar_date,
            'webinar_time' => $validated['webinar_time'] ?? $webinar->webinar_time,
            'badge' => ! empty($validated['badge']) ? strtoupper(trim($validated['badge'])) : $webinar->badge,
            'description' => $validated['description'] ?? null,
            'sort_order' => isset($validated['sort_order']) ? (int) $validated['sort_order'] : $webinar->sort_order,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.webinars')->with('success', 'Webinar details updated successfully!');
    }

    /**
     * Toggle active/hidden
     */
    public function toggleStatus(Webinar $webinar): RedirectResponse
    {
        $webinar->update([
            'is_active' => ! $webinar->is_active,
        ]);

        $status = $webinar->is_active ? 'active and scheduled' : 'hidden';

        return back()->with('success', "Webinar '{$webinar->title}' is now {$status}.");
    }

    /**
     * Delete webinar
     */
    public function destroy(Webinar $webinar): RedirectResponse
    {
        $title = $webinar->title;

        if (! empty($webinar->poster) && file_exists(public_path($webinar->poster))) {
            @unlink(public_path($webinar->poster));
        }

        $webinar->delete();

        return redirect()->route('admin.webinars')->with('success', "Webinar '{$title}' deleted successfully!");
    }

    /**
     * Seed sample webinars if table is empty
     */
    private function ensureSampleWebinars(): void
    {
        if (Webinar::count() > 0) {
            return;
        }

        Webinar::create([
            'title' => '6-Figure Affiliate Mastery Blueprint & Live Q&A',
            'speaker' => 'SkillLearner Founder & Elite Mentors',
            'speaker_role' => 'Head of Affiliate Growth',
            'meeting_link' => 'https://zoom.us/join',
            'platform' => 'zoom',
            'poster_url' => 'https://images.unsplash.com/photo-1544531585-9847b68c8c86?w=900&auto=format&fit=crop&q=80',
            'webinar_date' => Carbon::today(),
            'webinar_time' => '8:00 PM IST',
            'badge' => '🔴 TODAY LIVE',
            'description' => 'Discover the exact step-by-step conversion framework used by top affiliates to generate ₹50,000+ per month without spending any money on paid advertisements. Live doubt clearing at the end!',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Webinar::create([
            'title' => 'Instagram Reels & Viral Organic Lead Machine Workshop',
            'speaker' => 'Aman Verma',
            'speaker_role' => 'Content & Reel Strategist',
            'meeting_link' => 'https://meet.google.com',
            'platform' => 'google_meet',
            'poster_url' => 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=900&auto=format&fit=crop&q=80',
            'webinar_date' => Carbon::tomorrow(),
            'webinar_time' => '7:30 PM IST',
            'badge' => '✨ UPCOMING WORKSHOP',
            'description' => 'Hands-on practical session: How to script high-retention 30-second reels, camera confidence tips, and setting up automated DM funnels to capture leads 24/7 on autopilot.',
            'sort_order' => 2,
            'is_active' => true,
        ]);
    }
}
