<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintSettings;
use App\Models\MemberProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ComplaintController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();

        $complaints = Complaint::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($complaint) {
                return [
                    'id' => $complaint->id,
                    'ticket_id' => $complaint->ticket_id,
                    'subject' => $complaint->subject,
                    'description' => $complaint->description,
                    'status' => $complaint->status,
                    'priority' => $complaint->priority,
                    'admin_notes' => $complaint->admin_notes,
                    'resolved_at' => $complaint->resolved_at?->format('Y-m-d H:i:s'),
                    'created_at' => $complaint->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $complaint->updated_at->format('Y-m-d H:i:s'),
                ];
            });

        return Inertia::render('complaints/index', [
            'complaints' => $complaints,
        ]);
    }

    public function create(): Response|RedirectResponse
    {
        $user = Auth::user();
        $memberProfile = MemberProfile::where('user_id', $user->id)->first();

        if (! $memberProfile) {
            return redirect()->route('membership')->with('error', 'You must complete your membership profile before submitting a complaint.');
        }

        // Check if complaints are enabled
        $settings = ComplaintSettings::current();
        if (! $settings->form_enabled) {
            return redirect()->route('home')->with('error', 'Complaint submission is currently disabled.');
        }

        return Inertia::render('complaints/create');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $memberProfile = MemberProfile::where('user_id', $user->id)->first();

        if (! $memberProfile) {
            return redirect()->route('membership')->with('error', 'You must complete your membership profile before submitting a complaint.');
        }

        // Check if complaints are enabled
        $settings = ComplaintSettings::current();
        if (! $settings->form_enabled) {
            return redirect()->route('home')->with('error', 'Complaint submission is currently disabled.');
        }

        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $complaint = Complaint::create([
            'user_id' => $user->id,
            'member_profile_id' => $memberProfile->id,
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'status' => 'pending',
        ]);

        return redirect()->route('complaints.show', $complaint)->with('success', 'Your complaint has been submitted successfully. Ticket ID: '.$complaint->ticket_id);
    }

    public function show(Complaint $complaint): Response
    {
        // Check if the user owns this complaint
        if ($complaint->user_id !== Auth::id()) {
            abort(403, 'You can only view your own complaints.');
        }

        return Inertia::render('complaints/show', [
            'complaint' => [
                'id' => $complaint->id,
                'ticket_id' => $complaint->ticket_id,
                'subject' => $complaint->subject,
                'description' => $complaint->description,
                'status' => $complaint->status,
                'priority' => $complaint->priority,
                'admin_notes' => $complaint->admin_notes,
                'resolved_at' => $complaint->resolved_at?->format('Y-m-d H:i:s'),
                'created_at' => $complaint->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $complaint->updated_at->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
