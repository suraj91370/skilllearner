<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Faq;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Services\PortalDataService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ContentManagementController extends Controller
{
    /**
     * 1. Course Categories & Sub-Categories Management
     */
    public function categoriesIndex(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $categories = CourseCategory::with(['subcategories' => function ($q) {
            $q->withCount('courses')->orderBy('sort_order');
        }])
            ->withCount('courses')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        $allParents = CourseCategory::whereNull('parent_id')->orderBy('name')->get();

        return view('admin.content.categories', [
            'categories' => $categories,
            'allParents' => $allParents,
            'active' => 'admin-content-categories',
        ]);
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'parent_id' => ['nullable', 'exists:course_categories,id'],
            'icon' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $count = 1;
        while (CourseCategory::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-".($count++);
        }

        CourseCategory::create([
            'parent_id' => $validated['parent_id'] ?: null,
            'name' => $validated['name'],
            'slug' => $slug,
            'icon' => $validated['icon'] ?: ($validated['parent_id'] ? '📌' : '📁'),
            'description' => $validated['description'] ?? null,
            'is_active' => true,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ]);

        return back()->with('success', "Category '{$validated['name']}' created successfully.");
    }

    public function updateCategory(Request $request, CourseCategory $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'parent_id' => ['nullable', 'exists:course_categories,id'],
            'icon' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        // Prevent self-parenting
        if (! empty($validated['parent_id']) && (int) $validated['parent_id'] === (int) $category->id) {
            return back()->with('error', 'A category cannot be its own parent.');
        }

        $category->update([
            'name' => $validated['name'],
            'parent_id' => $validated['parent_id'] ?: null,
            'icon' => $validated['icon'] ?: $category->icon,
            'description' => $validated['description'] ?? $category->description,
            'is_active' => $request->has('is_active'),
            'sort_order' => (int) ($validated['sort_order'] ?? $category->sort_order),
        ]);

        return back()->with('success', "Category '{$category->name}' updated successfully.");
    }

    public function deleteCategory(CourseCategory $category): RedirectResponse
    {
        $name = $category->name;
        // Unlink courses before deleting
        Course::where('category_id', $category->id)->update(['category_id' => null]);
        Course::where('subcategory_id', $category->id)->update(['subcategory_id' => null]);

        $category->delete();

        return back()->with('success', "Category '{$name}' deleted successfully.");
    }

    /**
     * 2. Homepage Banners & Sections Management
     */
    public function homepageIndex(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $settings = Setting::allSettings();

        return view('admin.content.homepage', [
            'settings' => $settings,
            'active' => 'admin-content-homepage',
        ]);
    }

    public function updateHomepageContent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'home_hero_tag' => ['nullable', 'string', 'max:255'],
            'home_hero_title' => ['required', 'string', 'max:255'],
            'home_hero_subtitle' => ['required', 'string', 'max:1000'],
            'home_hero_cta_text' => ['required', 'string', 'max:100'],
            'home_hero_cta_link' => ['required', 'string', 'max:255'],
            'home_announcement_bar' => ['nullable', 'string', 'max:255'],
            'home_show_announcement' => ['nullable'],
            'home_show_packages' => ['nullable'],
            'home_show_mentors' => ['nullable'],
            'home_show_why_us' => ['nullable'],
            'home_show_founders' => ['nullable'],
            'home_show_testimonials' => ['nullable'],
            'home_show_faq' => ['nullable'],
            'home_show_cta' => ['nullable'],
        ]);

        Setting::set('home_hero_tag', $validated['home_hero_tag'] ?? '');
        Setting::set('home_hero_title', $validated['home_hero_title']);
        Setting::set('home_hero_subtitle', $validated['home_hero_subtitle']);
        Setting::set('home_hero_cta_text', $validated['home_hero_cta_text']);
        Setting::set('home_hero_cta_link', $validated['home_hero_cta_link']);
        Setting::set('home_announcement_bar', $validated['home_announcement_bar'] ?? '');

        // Toggles
        $toggles = [
            'home_show_announcement', 'home_show_packages', 'home_show_mentors',
            'home_show_why_us', 'home_show_founders', 'home_show_testimonials',
            'home_show_faq', 'home_show_cta',
        ];

        foreach ($toggles as $toggle) {
            Setting::set($toggle, $request->has($toggle) ? '1' : '0');
        }

        return back()->with('success', 'Homepage banners and section settings saved successfully.');
    }

    /**
     * 3. Testimonials Management
     */
    public function testimonialsIndex(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $testimonials = Testimonial::orderBy('sort_order')->latest()->get();

        return view('admin.content.testimonials', [
            'testimonials' => $testimonials,
            'active' => 'admin-content-testimonials',
        ]);
    }

    public function storeTestimonial(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'role_title' => ['nullable', 'string', 'max:150'],
            'avatar' => ['nullable', 'string', 'max:500'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'content' => ['required', 'string', 'max:1000'],
            'earning_highlight' => ['nullable', 'string', 'max:100'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        Testimonial::create([
            'name' => $validated['name'],
            'role_title' => $validated['role_title'] ?? 'Verified Student',
            'avatar' => $validated['avatar'] ?: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&auto=format&fit=crop&q=80',
            'rating' => (int) $validated['rating'],
            'content' => $validated['content'],
            'earning_highlight' => $validated['earning_highlight'] ?? null,
            'is_featured' => $request->has('is_featured'),
            'is_active' => true,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ]);

        return back()->with('success', 'New testimonial added successfully.');
    }

    public function updateTestimonial(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'role_title' => ['nullable', 'string', 'max:150'],
            'avatar' => ['nullable', 'string', 'max:500'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'content' => ['required', 'string', 'max:1000'],
            'earning_highlight' => ['nullable', 'string', 'max:100'],
            'is_featured' => ['nullable'],
            'is_active' => ['nullable'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $testimonial->update([
            'name' => $validated['name'],
            'role_title' => $validated['role_title'] ?? $testimonial->role_title,
            'avatar' => $validated['avatar'] ?: $testimonial->avatar,
            'rating' => (int) $validated['rating'],
            'content' => $validated['content'],
            'earning_highlight' => $validated['earning_highlight'] ?? null,
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active'),
            'sort_order' => (int) ($validated['sort_order'] ?? $testimonial->sort_order),
        ]);

        return back()->with('success', "Testimonial of '{$testimonial->name}' updated.");
    }

    public function deleteTestimonial(Testimonial $testimonial): RedirectResponse
    {
        $name = $testimonial->name;
        $testimonial->delete();

        return back()->with('success', "Testimonial of '{$name}' deleted.");
    }

    /**
     * 4. FAQ Management
     */
    public function faqsIndex(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $category = $request->query('category', 'all');
        $query = Faq::query()->orderBy('sort_order');

        if ($category !== 'all' && in_array($category, ['general', 'courses', 'affiliate', 'payment'])) {
            $query->where('category', $category);
        }

        $faqs = $query->get();

        return view('admin.content.faqs', [
            'faqs' => $faqs,
            'currentCategory' => $category,
            'active' => 'admin-content-faqs',
        ]);
    }

    public function storeFaq(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => ['required', 'in:general,courses,affiliate,payment'],
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        Faq::create([
            'category' => $validated['category'],
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => true,
        ]);

        return back()->with('success', 'FAQ question created successfully.');
    }

    public function updateFaq(Request $request, Faq $faq): RedirectResponse
    {
        $validated = $request->validate([
            'category' => ['required', 'in:general,courses,affiliate,payment'],
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable'],
        ]);

        $faq->update([
            'category' => $validated['category'],
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'sort_order' => (int) ($validated['sort_order'] ?? $faq->sort_order),
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'FAQ item updated successfully.');
    }

    public function deleteFaq(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return back()->with('success', 'FAQ item removed.');
    }

    /**
     * 5. Blog & Announcements Management
     */
    public function blogsIndex(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $category = $request->query('category', 'all');
        $query = Blog::query()->orderByDesc('is_pinned')->latest();

        if ($category !== 'all' && in_array($category, ['announcement', 'training', 'update', 'success_story'])) {
            $query->where('category', $category);
        }

        $blogs = $query->paginate(15)->withQueryString();

        return view('admin.content.blogs', [
            'blogs' => $blogs,
            'currentCategory' => $category,
            'active' => 'admin-content-blogs',
        ]);
    }

    public function storeBlog(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:announcement,training,update,success_story'],
            'thumbnail' => ['nullable', 'string', 'max:500'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'author_name' => ['nullable', 'string', 'max:100'],
            'is_published' => ['nullable'],
            'is_pinned' => ['nullable'],
        ]);

        $slug = Str::slug($validated['title']);
        if (Blog::where('slug', $slug)->exists()) {
            $slug .= '-'.Str::random(4);
        }

        Blog::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'thumbnail' => $validated['thumbnail'] ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80',
            'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160),
            'content' => $validated['content'],
            'author_name' => $validated['author_name'] ?: 'SkillLearner Team',
            'is_published' => $request->has('is_published'),
            'is_pinned' => $request->has('is_pinned'),
            'published_at' => $request->has('is_published') ? now() : null,
        ]);

        return back()->with('success', 'Article / Announcement posted successfully.');
    }

    public function updateBlog(Request $request, Blog $blog): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:announcement,training,update,success_story'],
            'thumbnail' => ['nullable', 'string', 'max:500'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'author_name' => ['nullable', 'string', 'max:100'],
            'is_published' => ['nullable'],
            'is_pinned' => ['nullable'],
        ]);

        $wasPublished = $blog->is_published;
        $isNowPublished = $request->has('is_published');

        $blog->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'thumbnail' => $validated['thumbnail'] ?: $blog->thumbnail,
            'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160),
            'content' => $validated['content'],
            'author_name' => $validated['author_name'] ?: $blog->author_name,
            'is_published' => $isNowPublished,
            'is_pinned' => $request->has('is_pinned'),
            'published_at' => (! $wasPublished && $isNowPublished) ? now() : $blog->published_at,
        ]);

        return back()->with('success', "Post '{$blog->title}' updated successfully.");
    }

    public function deleteBlog(Blog $blog): RedirectResponse
    {
        $title = $blog->title;
        $blog->delete();

        return back()->with('success', "Post '{$title}' removed.");
    }

    /**
     * 6. Certificate Template Management
     */
    public function certificateTemplateIndex(Request $request): View
    {
        PortalDataService::ensureUserSession();

        $template = [
            'cert_title' => Setting::get('cert_title', 'CERTIFICATE OF COMPLETION'),
            'cert_subtitle' => Setting::get('cert_subtitle', 'SkillLearner ISO 9001:2015 Accredited'),
            'cert_organization' => Setting::get('cert_organization', 'SkillLearner Edutech Private Limited'),
            'cert_signatory_name' => Setting::get('cert_signatory_name', 'Adarsh Pandey'),
            'cert_signatory_title' => Setting::get('cert_signatory_title', 'Founder & Chief Executive Officer'),
            'cert_theme_color' => Setting::get('cert_theme_color', '#05B396'),
            'cert_border_style' => Setting::get('cert_border_style', 'gold_double'),
            'cert_statement' => Setting::get('cert_statement', 'For successfully completing all video lectures, practical evaluations, quizzes, and projects for the masterclass program in'),
        ];

        return view('admin.content.certificate-template', [
            'template' => $template,
            'active' => 'admin-content-certificate',
        ]);
    }

    public function updateCertificateTemplate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cert_title' => ['required', 'string', 'max:255'],
            'cert_subtitle' => ['required', 'string', 'max:255'],
            'cert_organization' => ['required', 'string', 'max:255'],
            'cert_signatory_name' => ['required', 'string', 'max:255'],
            'cert_signatory_title' => ['required', 'string', 'max:255'],
            'cert_theme_color' => ['required', 'string', 'max:50'],
            'cert_border_style' => ['required', 'in:gold_double,emerald_modern,royal_purple'],
            'cert_statement' => ['required', 'string', 'max:500'],
        ]);

        foreach ($validated as $key => $val) {
            Setting::set($key, $val);
        }

        return back()->with('success', 'Official Certificate Template updated successfully!');
    }

    /**
     * Public Student Blog & Announcement Routes
     */
    public function publicBlogs(Request $request): View
    {
        $category = $request->query('category', 'all');
        $query = Blog::published();

        if ($category !== 'all' && in_array($category, ['announcement', 'training', 'update', 'success_story'])) {
            $query->where('category', $category);
        }

        $blogs = $query->paginate(9)->withQueryString();
        $pinned = Blog::published()->pinned()->first();

        return view('blogs', [
            'blogs' => $blogs,
            'pinned' => $pinned,
            'currentCategory' => $category,
        ]);
    }

    public function publicBlogShow(string $slug): View
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $blog->increment('views_count');

        $recent = Blog::published()->where('id', '!=', $blog->id)->limit(4)->get();

        return view('blog-detail', [
            'blog' => $blog,
            'recent' => $recent,
        ]);
    }
}
