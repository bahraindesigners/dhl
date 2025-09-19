<?php

namespace App\Http\Controllers;

use App\Models\HomeSlider;
use App\Models\Blog;
use Inertia\Inertia;

class HomePageController extends Controller
{
    /**
     * Display the home page with dynamic sliders
     */
    public function index()
    {
        // Fetch active sliders ordered by sort_order
        $sliders = HomeSlider::active()
            ->ordered()
            ->with('media')
            ->get()
            ->map(function ($slider) {
                return [
                    'id' => $slider->id,
                    'title' => $slider->title, // Will use current app locale
                    'subtitle' => $slider->subtitle,
                    'description' => $slider->description,
                    'button_text' => $slider->button_text,
                    'button_url' => $slider->button_url,
                    'desktop_image' => $slider->getDesktopImageUrl(),
                    'mobile_image' => $slider->getMobileImageUrl(),
                    'sort_order' => $slider->sort_order,
                ];
            });

        // Fetch latest published blogs for the news section
        $news = Blog::published()
            ->with(['category', 'media'])
            ->latest('published_at')
            ->limit(6)
            ->get()
            ->map(function ($blog) {
                return [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'slug' => $blog->slug,
                    'excerpt' => $blog->excerpt,
                    'content' => $blog->content,
                    'author' => $blog->author,
                    'status' => $blog->status,
                    'featured' => $blog->featured,
                    'show_as_urgent_news' => $blog->show_as_urgent_news,
                    'published_at' => $blog->published_at?->toISOString(),
                    'views_count' => $blog->views_count ?? 0,
                    'reading_time' => $blog->reading_time ?? 5,
                    'featured_image' => $blog->getFeaturedImageUrl(),
                    'blog_category' => $blog->category ? [
                        'id' => $blog->category->id,
                        'name' => $blog->category->name,
                    ] : null,
                ];
            });

        return Inertia::render('Home/welcome', [
            'sliders' => $sliders,
            'news' => $news,
        ]);
    }
}
