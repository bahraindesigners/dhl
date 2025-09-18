<?php

namespace App\Http\Controllers;

use App\Models\HomeSlider;
use Illuminate\Http\Request;
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
                    'title' => $slider->title,
                    'subtitle' => $slider->subtitle,
                    'button_text' => $slider->button_text,
                    'button_url' => $slider->button_url,
                    'desktop_image' => $slider->getDesktopImageUrl(),
                    'mobile_image' => $slider->getMobileImageUrl(),
                    'sort_order' => $slider->sort_order,
                ];
            });

        return Inertia::render('welcome', [
            'sliders' => $sliders,
        ]);
    }
}
