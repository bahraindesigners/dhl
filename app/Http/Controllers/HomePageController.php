<?php

namespace App\Http\Controllers;

use App\Models\HomeSlider;
use App\Models\Blog;
use App\Models\Event;
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
            ->limit(3)
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

        // Fetch latest upcoming events
        $events = Event::where('status', 'published')
            ->where('start_date', '>=', now())
            ->with(['eventCategory', 'media'])
            ->orderBy('start_date', 'asc')
            ->limit(6)
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'slug' => $event->slug,
                    'description' => $event->description,
                    'content' => $event->content,
                    'start_date' => $event->start_date?->toISOString(),
                    'end_date' => $event->end_date?->toISOString(),
                    'timezone' => $event->timezone,
                    'status' => $event->status,
                    'priority' => $event->priority,
                    'featured' => $event->featured,
                    'location' => $event->location,
                    'location_details' => $event->location_details,
                    'capacity' => $event->capacity,
                    'registered_count' => $event->registered_count ?? 0,
                    'registration_enabled' => $event->registration_enabled,
                    'registration_starts_at' => $event->registration_starts_at?->toISOString(),
                    'registration_ends_at' => $event->registration_ends_at?->toISOString(),
                    'price' => $event->price,
                    'organizer' => $event->organizer,
                    'organizer_details' => $event->organizer_details,
                    'published_at' => $event->published_at?->toISOString(),
                    'author' => $event->author,
                    'featured_image' => $event->getFirstMediaUrl('featured_image'),
                    'event_category' => $event->eventCategory ? [
                        'id' => $event->eventCategory->id,
                        'name' => $event->eventCategory->name,
                    ] : null,
                ];
            });

        return Inertia::render('Home/welcome', [
            'sliders' => $sliders,
            'news' => $news,
            'events' => $events,
        ]);
    }
}
