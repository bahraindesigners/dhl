<?php

namespace App\Http\Controllers;

use App\Models\BoardMember;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BoardMemberController extends Controller
{
    /**
     * Display the specified board member
     */
    public function show(BoardMember $boardMember)
    {
        // Load the board member with media
        $boardMember->load('media');

        // Format board member data for frontend - Spatie Translatable will automatically
        // return content in current locale (set by SetLocale middleware)
        $memberData = [
            'id' => $boardMember->id,
            'name' => $boardMember->name, // Automatically translated by Spatie
            'position' => $boardMember->position, // Automatically translated by Spatie
            'description' => $boardMember->description, // Automatically translated by Spatie
            'sort_order' => $boardMember->sort_order,
            'is_active' => $boardMember->is_active,
            'avatar_url' => $boardMember->getFirstMediaUrl('avatar'),
            'avatar_thumb_url' => $boardMember->getFirstMediaUrl('avatar', 'thumb'),
            'avatar_medium_url' => $boardMember->getFirstMediaUrl('avatar', 'medium'),
        ];

        // Get other board members for navigation
        $otherMembers = BoardMember::active()
            ->where('id', '!=', $boardMember->id)
            ->ordered()
            ->get(['id', 'name', 'position'])
            ->map(function ($member) {
                return [
                    'id' => $member->id,
                    'name' => $member->name, // Automatically translated by Spatie
                    'position' => $member->position, // Automatically translated by Spatie
                    'slug' => $member->id, // Using ID as slug for now
                ];
            });

        return Inertia::render('BoardMember/show', [
            'boardMember' => $memberData,
            'otherMembers' => $otherMembers,
        ]);
    }
}
