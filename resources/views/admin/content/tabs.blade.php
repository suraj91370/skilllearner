<div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 0.6rem; margin-bottom: 1.8rem; display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
    <a href="{{ route('admin.content.categories') }}" 
       style="display: inline-flex; align-items: center; gap: 6px; padding: 0.55rem 1rem; border-radius: 10px; font-size: 0.86rem; font-weight: 700; text-decoration: none; transition: all 0.2s; {{ $tab === 'categories' ? 'background: #05B396; color: #ffffff;' : 'background: #f8fafc; color: #475569;' }}">
        <span>📁 Categories &amp; Sub-Categories</span>
    </a>
    <a href="{{ route('admin.content.homepage') }}" 
       style="display: inline-flex; align-items: center; gap: 6px; padding: 0.55rem 1rem; border-radius: 10px; font-size: 0.86rem; font-weight: 700; text-decoration: none; transition: all 0.2s; {{ $tab === 'homepage' ? 'background: #05B396; color: #ffffff;' : 'background: #f8fafc; color: #475569;' }}">
        <span>🏠 Banners &amp; Homepage Sections</span>
    </a>
    <a href="{{ route('admin.content.testimonials') }}" 
       style="display: inline-flex; align-items: center; gap: 6px; padding: 0.55rem 1rem; border-radius: 10px; font-size: 0.86rem; font-weight: 700; text-decoration: none; transition: all 0.2s; {{ $tab === 'testimonials' ? 'background: #05B396; color: #ffffff;' : 'background: #f8fafc; color: #475569;' }}">
        <span>⭐ Testimonials</span>
    </a>
    <a href="{{ route('admin.content.faqs') }}" 
       style="display: inline-flex; align-items: center; gap: 6px; padding: 0.55rem 1rem; border-radius: 10px; font-size: 0.86rem; font-weight: 700; text-decoration: none; transition: all 0.2s; {{ $tab === 'faqs' ? 'background: #05B396; color: #ffffff;' : 'background: #f8fafc; color: #475569;' }}">
        <span>❓ FAQs</span>
    </a>
    <a href="{{ route('admin.content.blogs') }}" 
       style="display: inline-flex; align-items: center; gap: 6px; padding: 0.55rem 1rem; border-radius: 10px; font-size: 0.86rem; font-weight: 700; text-decoration: none; transition: all 0.2s; {{ $tab === 'blogs' ? 'background: #05B396; color: #ffffff;' : 'background: #f8fafc; color: #475569;' }}">
        <span>📢 Blog &amp; Announcements</span>
    </a>
    <a href="{{ route('admin.content.certificate') }}" 
       style="display: inline-flex; align-items: center; gap: 6px; padding: 0.55rem 1rem; border-radius: 10px; font-size: 0.86rem; font-weight: 700; text-decoration: none; transition: all 0.2s; {{ $tab === 'certificate' ? 'background: #05B396; color: #ffffff;' : 'background: #f8fafc; color: #475569;' }}">
        <span>🎖️ Certificate Template</span>
    </a>
</div>

