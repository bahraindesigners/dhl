<?php

namespace App\Models;

use App\Events\ContactMessageCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /** @use HasFactory<\Database\Factories\ContactFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'ip_address',
        'user_agent',
        'is_read',
        'read_at',
    ];

    protected static function booted(): void
    {
        static::created(function (Contact $contact) {
            try {
                ContactMessageCreated::dispatch($contact);
                \Illuminate\Support\Facades\Log::info('ContactMessageCreated event dispatched', [
                    'contact_id' => $contact->id,
                    'contact_email' => $contact->email,
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to dispatch ContactMessageCreated event', [
                    'contact_id' => $contact->id,
                    'error' => $e->getMessage(),
                ]);
                // Re-throw the exception so the contact creation fails if event dispatch fails
                throw $e;
            }
        });
    }

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }
}
