<?php

namespace App\Http\Controllers;

use App\LoanStatus;
use App\Models\UnionLoan;
use App\Models\UnionLoanSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class UnionLoanController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();
        $memberProfile = $user->memberProfile;

        // Get user's loan history
        $loans = UnionLoan::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($loan) {
                return [
                    'id' => $loan->id,
                    'amount' => $loan->amount,
                    'months' => $loan->months,
                    'status' => $loan->status->value,
                    'status_label' => $loan->status->label(),
                    'note' => $loan->note,
                    'rejected_reason' => $loan->rejected_reason,
                    'created_at' => $loan->created_at->format('Y-m-d H:i:s'),
                    'created_at_human' => $loan->created_at->diffForHumans(),
                ];
            });

        // Get loan settings
        $settings = UnionLoanSettings::getActiveSettings();

        return Inertia::render('loans/index', [
            'loans' => $loans,
            'settings' => $settings ? [
                'max_months' => $settings->max_months,
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
        $settings = UnionLoanSettings::getActiveSettings();

        if (! $settings || ! $settings->is_active) {
            abort(403, 'Loan applications are currently disabled.');
        }

        return Inertia::render('loans/create', [
            'settings' => [
                'max_months' => $settings->max_months,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $settings = UnionLoanSettings::getActiveSettings();

        if (! $settings || ! $settings->is_active) {
            return back()->withErrors(['error' => 'Loan applications are currently disabled.']);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:100|max:10000',
            'months' => "required|integer|min:1|max:{$settings->max_months}",
            'note' => 'nullable|string|max:1000',
        ]);

        $loan = UnionLoan::create([
            'user_id' => Auth::id(),
            'amount' => $validated['amount'],
            'months' => $validated['months'],
            'status' => LoanStatus::Pending,
            'note' => $validated['note'],
        ]);

        // TODO: Send notification to receivers
        // $this->sendLoanApplicationNotification($loan, $settings->receivers);

        return redirect()->route('loans.index')->with('success', 'Loan application submitted successfully.');
    }

    public function show(UnionLoan $loan): Response
    {
        // Ensure user can only view their own loans
        if ($loan->user_id !== Auth::id()) {
            abort(403);
        }

        // Load the relationships
        $loan->load(['user', 'memberProfile']);

        return Inertia::render('loans/show', [
            'loan' => [
                'id' => $loan->id,
                'amount' => $loan->amount,
                'months' => $loan->months,
                'status' => $loan->status->value,
                'note' => $loan->note,
                'rejected_reason' => $loan->rejected_reason,
                'created_at' => $loan->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $loan->updated_at->format('Y-m-d H:i:s'),
                'user' => [
                    'id' => $loan->user->id,
                    'name' => $loan->user->name,
                    'email' => $loan->user->email,
                ],
                'member_profile' => $loan->memberProfile ? [
                    'id' => $loan->memberProfile->id,
                    'member_number' => $loan->memberProfile->member_number,
                    'full_name' => $loan->memberProfile->full_name,
                    'phone' => $loan->memberProfile->phone,
                ] : null,
            ],
        ]);
    }
}
