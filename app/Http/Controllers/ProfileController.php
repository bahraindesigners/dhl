<?php

namespace App\Http\Controllers;

use App\Models\MembershipPage;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();
        $memberProfile = $user->activeMemberProfile; // Only get approved profile
        $membershipPage = MembershipPage::getSingleton();

        return Inertia::render('profile', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'created_at' => $user->created_at,
            ],
            'memberProfile' => $memberProfile ? [
                'id' => $memberProfile->id,
                'cpr_number' => $memberProfile->cpr_number,
                'staff_number' => $memberProfile->staff_number,
                'nationality' => $memberProfile->nationality,
                'gender' => $memberProfile->gender,
                'marital_status' => $memberProfile->marital_status,
                'date_of_joining' => $memberProfile->date_of_joining?->format('Y-m-d'),
                'position' => $memberProfile->position,
                'department' => $memberProfile->department,
                'section' => $memberProfile->section,
                'working_place_address' => $memberProfile->working_place_address,
                'office_phone' => $memberProfile->office_phone,
                'education_qualification' => $memberProfile->education_qualification,
                'mobile_number' => $memberProfile->mobile_number,
                'home_phone' => $memberProfile->home_phone,
                'permanent_address' => $memberProfile->permanent_address,
                'profile_status' => $memberProfile->profile_status,
                'created_at' => $memberProfile->created_at,
                'updated_at' => $memberProfile->updated_at,
                // Add media URLs
                'employee_image_url' => $memberProfile->getFirstMediaUrl('employee_image'),
                'signature_url' => $memberProfile->getFirstMediaUrl('signature'),
                'withdrawal_letters' => $memberProfile->getMedia('withdrawal_letters')->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'name' => $media->name,
                        'file_name' => $media->file_name,
                        'mime_type' => $media->mime_type,
                        'size' => $media->size,
                        'human_readable_size' => $media->human_readable_size,
                        'url' => $media->getUrl(),
                    ];
                }),
                'additional_files' => $memberProfile->getMedia('additional_files')->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'name' => $media->name,
                        'file_name' => $media->file_name,
                        'mime_type' => $media->mime_type,
                        'size' => $media->size,
                        'human_readable_size' => $media->human_readable_size,
                        'url' => $media->getUrl(),
                    ];
                }),
            ] : null,
            'membershipSettings' => [
                'enable_member_form' => (bool) $membershipPage->enable_member_form,
            ],
        ]);
    }
}
