<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();
        $memberProfile = $user->activeMemberProfile; // Only get approved profile

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
            ] : null,
        ]);
    }
}
