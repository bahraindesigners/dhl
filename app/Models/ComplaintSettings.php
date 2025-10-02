<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintSettings extends Model
{
    protected $fillable = [
        'form_enabled',
        'admin_emails',
    ];

    protected $casts = [
        'form_enabled' => 'boolean',
        'admin_emails' => 'array',
    ];

    public static function current(): self
    {
        return static::first() ?? static::create([
            'form_enabled' => true,
            'admin_emails' => [],
        ]);
    }

    public function getEnabledAttribute(): bool
    {
        return $this->form_enabled;
    }

    public function getAdminEmailsListAttribute(): array
    {
        return $this->admin_emails ?? [];
    }
}
