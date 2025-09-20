<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class MembershipPage extends Model
{
    /** @use HasFactory<\Database\Factories\MembershipPageFactory> */
    use HasFactory, HasTranslations;

    public array $translatable = [
        'how_to_join',
        'union_benefits',
    ];

    protected $fillable = [
        'how_to_join',
        'union_benefits',
        'enable_member_form',
        'notification_email',
    ];

    protected function casts(): array
    {
        return [
            'enable_member_form' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the single membership page instance (singleton pattern)
     */
    public static function getSingleton(): self
    {
        return self::firstOrCreate([], [
            'how_to_join' => [
                'en' => '<h2>How to Join Our Union</h2><p>Welcome to the DHL Bahrain Trade Union! Joining our union is simple and beneficial.</p>',
                'ar' => '<h2>كيفية الانضمام إلى نقابتنا</h2><p>مرحباً بكم في نقابة موظفي دي إتش إل البحرين! الانضمام إلى نقابتنا بسيط ومفيد.</p>',
            ],
            'union_benefits' => [
                'en' => '<h2>Union Benefits</h2><p>As a member, you will enjoy various benefits and protections.</p>',
                'ar' => '<h2>مزايا النقابة</h2><p>كعضو، ستستفيد من مزايا وحماية متنوعة.</p>',
            ],
            'enable_member_form' => true,
            'notification_email' => null,
            'is_active' => true,
        ]);
    }

    protected static function booted(): void
    {
        // Prevent creating multiple records
        static::creating(function ($model) {
            if (self::exists()) {
                throw new \Exception('Only one Membership Page record is allowed. Please edit the existing record.');
            }
        });
    }
}
