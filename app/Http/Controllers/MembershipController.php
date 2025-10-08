<?php

namespace App\Http\Controllers;

use App\Http\Requests\MembershipApplicationRequest;
use App\Models\MemberProfile;
use App\Models\MembershipPage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class MembershipController extends Controller
{
    public function index(): Response
    {
        $page = MembershipPage::getSingleton();

        // Get translations and convert content from TipTap JSON to text
        $howToJoinTranslations = $page->getTranslations('how_to_join');
        $unionBenefitsTranslations = $page->getTranslations('union_benefits');

        $processedHowToJoin = [];
        $processedUnionBenefits = [];

        foreach ($howToJoinTranslations as $locale => $content) {
            if (is_array($content)) {
                $processedHowToJoin[$locale] = $this->extractTextFromTipTap($content);
            } else {
                $processedHowToJoin[$locale] = $content;
            }
        }

        foreach ($unionBenefitsTranslations as $locale => $content) {
            if (is_array($content)) {
                $processedUnionBenefits[$locale] = $this->extractTextFromTipTap($content);
            } else {
                $processedUnionBenefits[$locale] = $content;
            }
        }

        return Inertia::render('Membership/membership', [
            'page' => [
                'how_to_join' => $processedHowToJoin,
                'union_benefits' => $processedUnionBenefits,
            ],
            'membershipSettings' => [
                'enable_member_form' => (bool) $page->enable_member_form,
            ],
        ]);
    }

    /**
     * Store a new membership application
     */
    public function store(MembershipApplicationRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                // Use the authenticated user
                $user = Auth::user();

                // Create member profile
                $memberProfile = MemberProfile::create([
                    'user_id' => $user->id,
                    'cpr_number' => $request->cpr_number,
                    'staff_number' => $request->staff_number,
                    'nationality' => $request->nationality,
                    'gender' => $request->gender,
                    'marital_status' => $request->marital_status,
                    'date_of_joining' => $request->date_of_joining,
                    'position' => $request->position,
                    'department' => $request->department,
                    'section' => $request->section,
                    'working_place_address' => $request->working_place_address,
                    'office_phone' => $request->office_phone,
                    'education_qualification' => $request->education_qualification,
                    'mobile_number' => $request->mobile_number,
                    'home_phone' => $request->home_phone,
                    'permanent_address' => $request->permanent_address,
                    'profile_status' => false, // Pending approval
                ]);

                // Handle employee image upload
                if ($request->hasFile('employee_image')) {
                    $memberProfile
                        ->addMediaFromRequest('employee_image')
                        ->toMediaCollection('employee_image');
                }

                // Handle signature upload
                if ($request->hasFile('signature')) {
                    $memberProfile
                        ->addMediaFromRequest('signature')
                        ->toMediaCollection('signature');
                }

                // Handle withdrawal letter file upload
                if ($request->hasFile('withdrawal_letter')) {
                    $memberProfile
                        ->addMediaFromRequest('withdrawal_letter')
                        ->toMediaCollection('withdrawal_letters');
                }
            });

            return redirect()->back()->with('success', 'Your membership application has been submitted successfully! We will review your application and contact you soon.');
        } catch (\Exception $e) {
            Log::error('Membership application error: '.$e->getMessage());

            return redirect()->back()->with('error', 'There was an error submitting your application. Please try again.');
        }
    }

    /**
     * Extract plain text from TipTap JSON format
     */
    private function extractTextFromTipTap(array $content): string
    {
        $text = '';

        if (isset($content['content']) && is_array($content['content'])) {
            foreach ($content['content'] as $node) {
                $text .= $this->extractTextFromNode($node);
            }
        }

        return trim($text);
    }

    /**
     * Recursively extract text from TipTap node
     */
    private function extractTextFromNode(array $node): string
    {
        $text = '';

        if (isset($node['type'])) {
            if ($node['type'] === 'text' && isset($node['text'])) {
                $text .= $node['text'];
            } elseif ($node['type'] === 'paragraph') {
                if (isset($node['content']) && is_array($node['content'])) {
                    foreach ($node['content'] as $childNode) {
                        $text .= $this->extractTextFromNode($childNode);
                    }
                }
                $text .= "\n";
            } elseif (isset($node['content']) && is_array($node['content'])) {
                // Handle other node types with content
                foreach ($node['content'] as $childNode) {
                    $text .= $this->extractTextFromNode($childNode);
                }
            }
        }

        return $text;
    }
}
