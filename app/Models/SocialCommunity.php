<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialCommunity extends Model
{
    protected $fillable = [
        'platform',
        'title',
        'subtitle',
        'url',
        'button_text',
        'badge',
        'color',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Preset styling metadata for platforms
     */
    public static function platformPresets(): array
    {
        return [
            'whatsapp' => [
                'name' => 'WhatsApp',
                'title_default' => 'WhatsApp Channel',
                'button_default' => 'Join WhatsApp ➔',
                'icon_bg' => '#25d366',
                'card_bg' => '#f0fdf4',
                'border' => '#bbf7d0',
                'title_color' => '#166534',
                'button_bg' => '#16a34a',
                'hover_shadow' => 'rgba(22, 163, 74, 0.18)',
            ],
            'instagram' => [
                'name' => 'Instagram',
                'title_default' => 'Instagram Official',
                'button_default' => 'Follow on Instagram ➔',
                'icon_bg' => 'linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%)',
                'card_bg' => '#fdf2f8',
                'border' => '#fbcfe8',
                'title_color' => '#9d174d',
                'button_bg' => '#db2777',
                'hover_shadow' => 'rgba(219, 39, 119, 0.18)',
            ],
            'youtube' => [
                'name' => 'YouTube',
                'title_default' => 'YouTube Channel',
                'button_default' => 'Subscribe on YouTube ➔',
                'icon_bg' => '#ff0000',
                'card_bg' => '#fef2f2',
                'border' => '#fecaca',
                'title_color' => '#991b1b',
                'button_bg' => '#dc2626',
                'hover_shadow' => 'rgba(220, 38, 38, 0.18)',
            ],
            'facebook' => [
                'name' => 'Facebook',
                'title_default' => 'Facebook Community',
                'button_default' => 'Join Facebook ➔',
                'icon_bg' => '#1877f2',
                'card_bg' => '#eff6ff',
                'border' => '#bfdbfe',
                'title_color' => '#1e40af',
                'button_bg' => '#2563eb',
                'hover_shadow' => 'rgba(37, 99, 235, 0.18)',
            ],
            'telegram' => [
                'name' => 'Telegram',
                'title_default' => 'Telegram Channel',
                'button_default' => 'Join Telegram ➔',
                'icon_bg' => '#229ED9',
                'card_bg' => '#f0f9ff',
                'border' => '#bae6fd',
                'title_color' => '#0369a1',
                'button_bg' => '#0284c7',
                'hover_shadow' => 'rgba(2, 132, 199, 0.18)',
            ],
            'discord' => [
                'name' => 'Discord',
                'title_default' => 'Discord Server',
                'button_default' => 'Join Discord ➔',
                'icon_bg' => '#5865F2',
                'card_bg' => '#f5f3ff',
                'border' => '#ddd6fe',
                'title_color' => '#5b21b6',
                'button_bg' => '#6366f1',
                'hover_shadow' => 'rgba(99, 102, 241, 0.18)',
            ],
            'twitter' => [
                'name' => 'X / Twitter',
                'title_default' => 'Follow on X',
                'button_default' => 'Follow @SkillLearner ➔',
                'icon_bg' => '#0f172a',
                'card_bg' => '#f8fafc',
                'border' => '#e2e8f0',
                'title_color' => '#0f172a',
                'button_bg' => '#0f172a',
                'hover_shadow' => 'rgba(15, 23, 42, 0.18)',
            ],
            'linkedin' => [
                'name' => 'LinkedIn',
                'title_default' => 'LinkedIn Page',
                'button_default' => 'Connect on LinkedIn ➔',
                'icon_bg' => '#0a66c2',
                'card_bg' => '#f0f7ff',
                'border' => '#bfdbfe',
                'title_color' => '#1e3a8a',
                'button_bg' => '#0a66c2',
                'hover_shadow' => 'rgba(10, 102, 194, 0.18)',
            ],
            'other' => [
                'name' => 'Custom Community',
                'title_default' => 'Community Link',
                'button_default' => 'Join Now ➔',
                'icon_bg' => '#6366f1',
                'card_bg' => '#f8fafc',
                'border' => '#e2e8f0',
                'title_color' => '#1e293b',
                'button_bg' => '#4f46e5',
                'hover_shadow' => 'rgba(79, 70, 229, 0.18)',
            ],
        ];
    }

    public function getPresetAttribute(): array
    {
        $presets = self::platformPresets();
        $key = strtolower($this->platform ?? 'other');

        return $presets[$key] ?? $presets['other'];
    }

    public function getIconBgStyleAttribute(): string
    {
        if (! empty($this->color)) {
            return $this->color;
        }

        return $this->preset['icon_bg'];
    }

    public function getCardBgStyleAttribute(): string
    {
        return $this->preset['card_bg'];
    }

    public function getBorderStyleAttribute(): string
    {
        return $this->preset['border'];
    }

    public function getTitleColorStyleAttribute(): string
    {
        return $this->preset['title_color'];
    }

    public function getButtonBgStyleAttribute(): string
    {
        if (! empty($this->color)) {
            return $this->color;
        }

        return $this->preset['button_bg'];
    }

    public function getHoverShadowStyleAttribute(): string
    {
        return $this->preset['hover_shadow'];
    }

    /**
     * Platform Icon SVG snippet
     */
    public function getIconSvgAttribute(): string
    {
        $platform = strtolower($this->platform ?? 'other');

        return match ($platform) {
            'whatsapp' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="#ffffff"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2zm0 18.15c-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.167 8.167 0 01-1.25-4.38c0-4.51 3.67-8.18 8.18-8.18 2.18 0 4.24.85 5.78 2.4 1.55 1.54 2.4 3.6 2.4 5.78 0 4.52-3.67 8.24-8.22 8.24zm4.49-6.16c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.12-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.38-1.72-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.14.17-.25.25-.41.08-.17.04-.31-.02-.43s-.56-1.34-.76-1.84c-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31-.22.25-.86.84-.86 2.05s.88 2.38 1 2.54c.12.17 1.73 2.64 4.2 3.7.59.25 1.05.4 1.41.51.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.17-.48-.29z"/></svg>',

            'instagram' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>',

            'youtube' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="#ffffff"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',

            'facebook' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="#ffffff"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',

            'telegram' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="#ffffff"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.52 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .34z"/></svg>',

            'discord' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="#ffffff"><path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028c.462-.63.874-1.295 1.226-1.994.021-.041.001-.09-.041-.106a13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.929 1.793 8.18 1.793 12.061 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.893.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.028zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/></svg>',

            'twitter' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="#ffffff"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',

            'linkedin' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="#ffffff"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>',

            default => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>',
        };
    }
}
