<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    /**
     * Display a listing of events
     */
    public function index(Request $request)
    {
        // Build the query
        $query = Event::with(['eventCategory', 'media'])
            ->published()
            ->orderBy('start_date', 'asc');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title->en', 'like', "%{$search}%")
                  ->orWhere('title->ar', 'like', "%{$search}%")
                  ->orWhere('description->en', 'like', "%{$search}%")
                  ->orWhere('description->ar', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('event_category_id', $request->category);
        }

        // Status filter (upcoming, ongoing, past)
        if ($request->filled('status')) {
            $status = $request->get('status');
            switch ($status) {
                case 'upcoming':
                    $query->upcoming();
                    break;
                case 'ongoing':
                    $query->ongoing();
                    break;
                case 'past':
                    $query->where('end_date', '<', now());
                    break;
            }
        } else {
            // Default to show upcoming and ongoing events
            $query->where('end_date', '>=', now());
        }

        // Featured filter
        if ($request->filled('featured')) {
            $query->where('featured', $request->boolean('featured'));
        }

        // Sort filter
        $sortBy = $request->get('sort', 'date');
        switch ($sortBy) {
            case 'date':
                $query->orderBy('start_date', 'asc');
                break;
            case 'alphabetical':
                $query->orderBy('title->en', 'asc');
                break;
            case 'featured':
                $query->orderBy('featured', 'desc')
                      ->orderBy('start_date', 'asc');
                break;
        }

        // Paginate results
        $events = $query->paginate(12)->withQueryString();

        // Transform event data
        $events->getCollection()->transform(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'slug' => $event->slug,
                'description' => $event->description,
                'start_date' => $event->start_date?->toISOString(),
                'end_date' => $event->end_date?->toISOString(),
                'location' => $event->location,
                'featured' => $event->featured,
                'featured_image' => $event->getFirstMediaUrl('featured_image'),
                'registration_enabled' => $event->registration_enabled,
                'capacity' => $event->capacity,
                'registered_count' => $event->registered_count,
                'can_register' => $event->canRegister(),
                'spots_remaining' => $event->spotsRemaining(),
                'event_category' => $event->eventCategory ? [
                    'id' => $event->eventCategory->id,
                    'name' => $event->eventCategory->name,
                    'color' => $event->eventCategory->color,
                ] : null,
            ];
        });

        // Get all categories for filter dropdown
        $categories = EventCategory::active()
            ->orderBy('name->en')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'color' => $category->color,
                ];
            });

        return Inertia::render('Event/index', [
            'events' => $events,
            'categories' => $categories,
            'filters' => [
                'search' => $request->get('search', ''),
                'category' => $request->get('category', ''),
                'status' => $request->get('status', ''),
                'featured' => $request->get('featured', ''),
                'sort' => $request->get('sort', 'date'),
            ],
        ]);
    }

    /**
     * Display the specified event
     */
    public function show(Request $request, Event $event)
    {
        // Get related events (same category, excluding current)
        $relatedEvents = Event::published()
            ->where('id', '!=', $event->id)
            ->where('event_category_id', $event->event_category_id)
            ->with(['eventCategory', 'media'])
            ->where('end_date', '>=', now()) // Only upcoming/ongoing events
            ->orderBy('start_date', 'asc')
            ->limit(3)
            ->get()
            ->map(function ($relatedEvent) {
                return [
                    'id' => $relatedEvent->id,
                    'title' => $relatedEvent->title,
                    'slug' => $relatedEvent->slug,
                    'description' => $relatedEvent->description,
                    'start_date' => $relatedEvent->start_date?->toISOString(),
                    'end_date' => $relatedEvent->end_date?->toISOString(),
                    'location' => $relatedEvent->location,
                    'featured_image' => $relatedEvent->getFirstMediaUrl('featured_image'),
                    'event_category' => $relatedEvent->eventCategory ? [
                        'id' => $relatedEvent->eventCategory->id,
                        'name' => $relatedEvent->eventCategory->name,
                        'color' => $relatedEvent->eventCategory->color,
                    ] : null,
                ];
            });

        // Transform event data
        $eventData = [
            'id' => $event->id,
            'title' => $event->title,
            'slug' => $event->slug,
            'description' => $event->description,
            'content' => $event->content,
            'start_date' => $event->start_date?->toISOString(),
            'end_date' => $event->end_date?->toISOString(),
            'timezone' => $event->timezone,
            'location' => $event->location,
            'location_details' => $event->location_details,
            'organizer' => $event->organizer,
            'organizer_details' => $event->organizer_details,
            'featured' => $event->featured,
            'featured_image' => $event->getFirstMediaUrl('featured_image'),
            'capacity' => $event->capacity,
            'registered_count' => $event->registered_count,
            'registration_enabled' => $event->registration_enabled,
            'registration_starts_at' => $event->registration_starts_at?->toISOString(),
            'registration_ends_at' => $event->registration_ends_at?->toISOString(),
            'price' => $event->price,
            'can_register' => $event->canRegister(),
            'spots_remaining' => $event->spotsRemaining(),
            'is_upcoming' => $event->isUpcoming(),
            'is_ongoing' => $event->isOngoing(),
            'is_past' => $event->isPast(),
            'duration_in_hours' => $event->getDurationInHours(),
            'duration_in_days' => $event->getDurationInDays(),
            'gallery' => $event->getMedia('gallery')->map(function ($media) {
                $width = 1200;
                $height = 800;
                
                // Try to get actual image dimensions
                if (in_array($media->mime_type, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
                    $imagePath = $media->getPath();
                    if (file_exists($imagePath)) {
                        $imageSize = getimagesize($imagePath);
                        if ($imageSize) {
                            $width = $imageSize[0];
                            $height = $imageSize[1];
                        }
                    }
                }
                
                return [
                    'id' => $media->id,
                    'url' => $media->getUrl(),
                    'thumb' => $media->getUrl('thumb'),
                    'alt' => $media->getCustomProperty('alt') ?? '',
                    'width' => $media->getCustomProperty('width') ?? $width,
                    'height' => $media->getCustomProperty('height') ?? $height,
                ];
            }),
            'event_category' => $event->eventCategory ? [
                'id' => $event->eventCategory->id,
                'name' => $event->eventCategory->name,
                'color' => $event->eventCategory->color,
            ] : null,
        ];

        return Inertia::render('Event/show', [
            'event' => $eventData,
            'relatedEvents' => $relatedEvents,
        ]);
    }
}