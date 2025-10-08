<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ContactSetting extends Model
{
    /** @use HasFactory<\Database\Factories\ContactSettingFactory> */
    use HasFactory, HasTranslations;

    public array $translatable = [
        'office_address',
        'phone_numbers',
        'office_hours',
        'content',
    ];

    protected $fillable = [
        'notification_emails',
        'instagram_url',
        'linkedin_url',
        'x_url',
        'office_address',
        'phone_numbers',
        'office_hours',
        'content',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'notification_emails' => 'array',
        ];
    }

    public static function getSettings(): ?self
    {
        return self::first();
    }

    public static function getSingleton(): self
    {
        return self::firstOrCreate([], [
            'notification_emails' => [],
            'instagram_url' => null,
            'linkedin_url' => null,
            'x_url' => null,
            'office_address' => null,
            'phone_numbers' => null,
            'office_hours' => null,
            'content' => null,
            'is_active' => true,
        ]);
    }

    protected static function booted(): void
    {
        // Prevent creating multiple records
        static::creating(function ($model) {
            if (self::exists()) {
                throw new \Exception('Only one Contact Setting record is allowed. Please edit the existing record.');
            }
        });
    }
}
