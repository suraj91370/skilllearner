<?php

namespace App\Http\Controllers;

use App\Models\SocialCommunity;
use App\Services\PortalDataService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SocialCommunityController extends Controller
{
    /**
     * User / Student / Affiliate Portal: View Social Communities
     */
    public function index(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $this->ensureSampleCommunities();

        $communities = SocialCommunity::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return view('portal.community', [
            'communities' => $communities,
            'active' => 'community',
        ]);
    }

    /**
     * Admin Panel: Manage Social Communities
     */
    public function adminIndex(Request $request): View
    {
        $this->ensureSampleCommunities();

        $platformFilter = $request->query('platform', 'all');
        $search = trim((string) $request->query('search', ''));

        $query = SocialCommunity::query()->orderBy('sort_order', 'asc')->orderBy('id', 'asc');

        if ($platformFilter !== 'all' && ! empty($platformFilter)) {
            $query->where('platform', $platformFilter);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('subtitle', 'like', "%{$search}%")
                    ->orWhere('url', 'like', "%{$search}%")
                    ->orWhere('platform', 'like', "%{$search}%");
            });
        }

        $communities = $query->paginate(20)->withQueryString();

        $totalCount = SocialCommunity::count();
        $activeCount = SocialCommunity::where('is_active', true)->count();
        $inactiveCount = SocialCommunity::where('is_active', false)->count();

        $presets = SocialCommunity::platformPresets();

        return view('admin.social-communities', compact(
            'communities',
            'totalCount',
            'activeCount',
            'inactiveCount',
            'presets',
            'platformFilter',
            'search'
        ));
    }

    /**
     * Store new social community channel
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'platform' => ['required', 'string', 'in:whatsapp,instagram,youtube,facebook,telegram,discord,twitter,linkedin,other'],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:1000'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'badge' => ['nullable', 'string', 'max:50'],
            'color' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $presets = SocialCommunity::platformPresets();
        $preset = $presets[$validated['platform']] ?? $presets['other'];

        SocialCommunity::create([
            'platform' => $validated['platform'],
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'url' => $validated['url'],
            'button_text' => ! empty($validated['button_text']) ? $validated['button_text'] : ($preset['button_default'] ?? 'Join Now ➔'),
            'badge' => $validated['badge'] ?? null,
            'color' => $validated['color'] ?? null,
            'sort_order' => isset($validated['sort_order']) ? (int) $validated['sort_order'] : (SocialCommunity::max('sort_order') + 1),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.social-communities')->with('success', 'Social Community link created successfully!');
    }

    /**
     * Update existing social community channel
     */
    public function update(Request $request, SocialCommunity $socialCommunity): RedirectResponse
    {
        $validated = $request->validate([
            'platform' => ['required', 'string', 'in:whatsapp,instagram,youtube,facebook,telegram,discord,twitter,linkedin,other'],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:1000'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'badge' => ['nullable', 'string', 'max:50'],
            'color' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $presets = SocialCommunity::platformPresets();
        $preset = $presets[$validated['platform']] ?? $presets['other'];

        $socialCommunity->update([
            'platform' => $validated['platform'],
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'url' => $validated['url'],
            'button_text' => ! empty($validated['button_text']) ? $validated['button_text'] : ($preset['button_default'] ?? 'Join Now ➔'),
            'badge' => $validated['badge'] ?? null,
            'color' => $validated['color'] ?? null,
            'sort_order' => isset($validated['sort_order']) ? (int) $validated['sort_order'] : $socialCommunity->sort_order,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.social-communities')->with('success', 'Social Community link updated successfully!');
    }

    /**
     * Toggle visibility (Active / Inactive)
     */
    public function toggleVisibility(SocialCommunity $socialCommunity): RedirectResponse
    {
        $socialCommunity->update([
            'is_active' => ! $socialCommunity->is_active,
        ]);

        $status = $socialCommunity->is_active ? 'activated and visible' : 'hidden from student portal';

        return back()->with('success', "'{$socialCommunity->title}' is now {$status}.");
    }

    /**
     * Delete community channel
     */
    public function destroy(SocialCommunity $socialCommunity): RedirectResponse
    {
        $title = $socialCommunity->title;
        $socialCommunity->delete();

        return redirect()->route('admin.social-communities')->with('success', "Social Community '{$title}' deleted successfully!");
    }

    /**
     * Seed initial default channels if table is empty
     */
    private function ensureSampleCommunities(): void
    {
        if (SocialCommunity::count() > 0) {
            return;
        }

        $defaults = [
            [
                'platform' => 'whatsapp',
                'title' => 'WhatsApp Channel',
                'subtitle' => 'Instant Updates & Broadcast Alerts',
                'url' => 'https://whatsapp.com/channel/0029VbEHttyHrDZfE7sHaM1f',
                'button_text' => 'Join WhatsApp ➔',
                'badge' => 'OFFICIAL',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'platform' => 'instagram',
                'title' => 'Instagram Official',
                'subtitle' => 'Daily growth reels & stories',
                'url' => 'https://www.instagram.com/skilllearner_official?utm_source=qr&xtok=MTVwcXZiOGd1cTM3bQ==',
                'button_text' => 'Follow on Instagram ➔',
                'badge' => 'OFFICIAL',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'platform' => 'youtube',
                'title' => 'YouTube Channel',
                'subtitle' => 'Weekly webinars & masterclasses',
                'url' => 'https://www.youtube.com/@Skilllearner_official',
                'button_text' => 'Subscribe on YouTube ➔',
                'badge' => 'TRAINING',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'platform' => 'facebook',
                'title' => 'Facebook Community',
                'subtitle' => 'Connect & network with affiliates',
                'url' => 'https://www.facebook.com/share/g/1FFBMXrPmb/',
                'button_text' => 'Join Facebook ➔',
                'badge' => 'COMMUNITY',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($defaults as $item) {
            SocialCommunity::create($item);
        }
    }
}
