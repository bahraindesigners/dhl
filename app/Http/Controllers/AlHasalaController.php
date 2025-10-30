<?php

namespace App\Http\Controllers;

use App\LoanStatus;
use App\Models\AlHasala;
use App\Models\AlHasalaSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AlHasalaController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();
        $memberProfile = $user->activeMemberProfile;

        // Get user's Al Hasala history
        $alHasalas = AlHasala::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($alHasala) {
                return [
                    'id' => $alHasala->id,
                    'monthly_amount' => $alHasala->monthly_amount,
                    'total_amount' => $alHasala->total_amount,
                    'months' => $alHasala->months,
                    'status' => $alHasala->status->value,
                    'status_label' => $alHasala->status->label(),
                    'note' => $alHasala->note,
                    'rejected_reason' => $alHasala->rejected_reason,
                    'created_at' => $alHasala->created_at->format('Y-m-d H:i:s'),
                    'created_at_human' => $alHasala->created_at->diffForHumans(),
                ];
            });

        // Get Al Hasala settings
        $settings = AlHasalaSettings::getActiveSettings();

        return Inertia::render('al-hasala/index', [
            'alHasalas' => $alHasalas,
            'settings' => $settings ? [
                'max_months' => $settings->max_months,
                'min_monthly_payment' => $settings->min_monthly_payment,
                'is_active' => $settings->is_active,
            ] : null,
            'memberProfile' => $memberProfile ? [
                'staff_number' => $memberProfile->staff_number,
                'position' => $memberProfile->position,
                'department' => $memberProfile->department,
            ] : null,
        ]);
    }

    public function create(): Response
    {
        $settings = AlHasalaSettings::getActiveSettings();

        if (! $settings || ! $settings->is_active) {
            abort(403, 'Al Hasala applications are currently disabled.');
        }

        return Inertia::render('al-hasala/create', [
            'settings' => [
                'max_months' => $settings->max_months,
                'min_monthly_payment' => $settings->min_monthly_payment,
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        // Check if applications are enabled
        $settings = AlHasalaSettings::getActiveSettings();
        if (! $settings || ! $settings->is_active) {
            return back()->withErrors(['error' => 'Al Hasala applications are currently disabled.']);
        }

        $validated = $request->validate([
            'monthly_amount' => "required|numeric|min:{$settings->min_monthly_payment}",
            'months' => "required|integer|min:1|max:{$settings->max_months}",
            'note' => 'nullable|string|max:1000',
        ]);

        $alHasala = AlHasala::create([
            'user_id' => Auth::id(),
            'monthly_amount' => $validated['monthly_amount'],
            'months' => $validated['months'],
            'status' => LoanStatus::Pending,
            'note' => $validated['note'],
        ]);

        // TODO: Send notification to receivers
        // $this->sendAlHasalaApplicationNotification($alHasala, $settings->receivers);

        return redirect()->route('al-hasala.index')->with('success', 'Al Hasala application submitted successfully.');
    }

    public function show(AlHasala $alHasala): Response
    {
        // Ensure user can only view their own Al Hasala applications
        if ($alHasala->user_id !== Auth::id()) {
            abort(403);
        }

        // Load the relationships
        $alHasala->load(['user', 'memberProfile']);

        return Inertia::render('al-hasala/show', [
            'alHasala' => [
                'id' => $alHasala->id,
                'user_id' => $alHasala->user_id,
                'monthly_amount' => $alHasala->monthly_amount,
                'total_amount' => $alHasala->total_amount,
                'months' => $alHasala->months,
                'status' => $alHasala->status->value,
                'note' => $alHasala->note,
                'rejected_reason' => $alHasala->rejected_reason,
                'created_at' => $alHasala->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $alHasala->updated_at->format('Y-m-d H:i:s'),
                'user' => [
                    'id' => $alHasala->user->id,
                    'name' => $alHasala->user->name,
                    'email' => $alHasala->user->email,
                ],
                'member_profile' => $alHasala->memberProfile ? [
                    'id' => $alHasala->memberProfile->id,
                    'member_number' => $alHasala->memberProfile->member_number,
                    'full_name' => $alHasala->memberProfile->full_name,
                    'phone' => $alHasala->memberProfile->phone,
                ] : null,
            ],
        ]);
    }
}
