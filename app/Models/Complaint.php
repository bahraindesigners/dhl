<?php

namespace App\Models;

use App\Events\ComplaintCreated;
use App\Events\ComplaintUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'member_profile_id',
        'subject',
        'description',
        'status',
        'priority',
        'admin_notes',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Complaint $complaint) {
            if (! $complaint->ticket_id) {
                $complaint->ticket_id = 'CMP-'.strtoupper(Str::random(8));
            }
        });

        static::created(function (Complaint $complaint) {
            // Dispatch event for email notifications
            ComplaintCreated::dispatch($complaint);
        });

        static::updated(function (Complaint $complaint) {
            // Only dispatch event if meaningful fields changed (not just ticket_id)
            if ($complaint->wasChanged(['subject', 'description', 'status', 'priority', 'admin_notes', 'resolved_at'])) {
                ComplaintUpdated::dispatch($complaint);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function memberProfile(): BelongsTo
    {
        return $this->belongsTo(MemberProfile::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'in_progress' => 'info',
            'resolved' => 'success',
            'closed' => 'secondary',
            default => 'secondary',
        };
    }

    public function getPriorityColorAttribute(): string
    {
        return match ($this->priority) {
            'low' => 'success',
            'medium' => 'warning',
            'high' => 'danger',
            'urgent' => 'danger',
            default => 'secondary',
        };
    }
}
