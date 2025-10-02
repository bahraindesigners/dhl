<?php

namespace App\Models;

use App\Events\EventRegistrationCreated;
use App\Events\EventRegistrationUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'special_requirements',
        'status',
        'registered_at',
        'confirmed_at',
        'cancelled_at',
        'amount_paid',
        'payment_status',
        'payment_method',
        'payment_reference',
        'registration_data',
        'admin_notes',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'amount_paid' => 'decimal:2',
        'registration_data' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        // Fire event when a new registration is created
        static::created(function ($registration) {
            \Illuminate\Support\Facades\Log::info('EventRegistration model observer fired', [
                'registration_id' => $registration->id,
                'trace_id' => uniqid('observer_'),
            ]);
            
            // Load the event and eventCategory relationships before firing the event
            $registration->load(['event.eventCategory']);

            EventRegistrationCreated::dispatch($registration);
        });

        // Fire event when registration is updated (specifically status changes)
        static::updating(function ($registration) {
            // Check if status is changing
            if ($registration->isDirty('status')) {
                $oldStatus = $registration->getOriginal('status');
                $newStatus = $registration->status;

                \Illuminate\Support\Facades\Log::info('EventRegistration status update observer fired', [
                    'registration_id' => $registration->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'trace_id' => uniqid('update_observer_'),
                ]);

                // Load the event relationship before firing the event
                $registration->load(['event.eventCategory']);

                EventRegistrationUpdated::dispatch($registration, $oldStatus, $newStatus);
            }
        });
    }

    // Relationships
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeAttended($query)
    {
        return $query->where('status', 'attended');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    // Helper Methods
    public function getFullNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function hasAttended(): bool
    {
        return $this->status === 'attended';
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function markAsConfirmed(): void
    {
        $this->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }

    public function markAsCancelled(): void
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
    }

    public function markAsAttended(): void
    {
        $this->update([
            'status' => 'attended',
        ]);
    }
}
