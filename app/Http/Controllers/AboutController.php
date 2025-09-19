<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\BoardMember;
use Inertia\Inertia;

class AboutController extends Controller
{
    /**
     * Display the about page with dynamic content
     */
    public function index()
    {
        // Get the main about page content
        $about = About::getMainAboutPage();
        
        if (!$about) {
            // Create default about page if none exists
            $about = About::getSingleInstance();
        }

        // Format about data for frontend
        $aboutData = [
            'id' => $about->id,
            'title' => $about->title,
            'content' => $about->content,
            'show_board_section' => $about->show_board_section,
            'board_section_title' => $about->board_section_title,
            'board_section_description' => $about->board_section_description,
        ];

        // Get board members if board section is enabled
        $boardMembers = [];
        if ($about->show_board_section) {
            $boardMembers = BoardMember::active()
                ->ordered()
                ->with('media')
                ->get()
                ->map(function ($member) {
                    return [
                        'id' => $member->id,
                        'name' => $member->name,
                        'position' => $member->position,
                        'description' => $member->description,
                        'sort_order' => $member->sort_order,
                        'avatar_url' => $member->getFirstMediaUrl('avatar'),
                        'avatar_thumb_url' => $member->getFirstMediaUrl('avatar', 'thumb'),
                        'avatar_medium_url' => $member->getFirstMediaUrl('avatar', 'medium'),
                    ];
                });
        }

        return Inertia::render('About/about', [
            'about' => $aboutData,
            'boardMembers' => $boardMembers,
        ]);
    }
}