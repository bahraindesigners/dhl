<?php

namespace App\Models;

use App\Events\MemberProfileCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MemberProfile extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'user_id',
        'cpr_number',
        'staff_number',
        'nationality',
        'gender',
        'marital_status',
        'date_of_joining',
        'position',
        'department',
        'section',
        'working_place_address',
        'office_phone',
        'education_qualification',
        'mobile_number',
        'home_phone',
        'permanent_address',
        'profile_status',
    ];

    protected $casts = [
        'date_of_joining' => 'date',
        'profile_status' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_photo')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->singleFile();

        $this->addMediaCollection('signature')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->singleFile();

        $this->addMediaCollection('additional_files')
            ->acceptsMimeTypes([
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'image/jpeg',
                'image/png',
                'image/webp',
                'text/plain',
            ]);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10)
            ->performOnCollections('profile_photo')
            ->nonQueued();

        $this->addMediaConversion('signature_thumb')
            ->width(200)
            ->height(100)
            ->sharpen(10)
            ->performOnCollections('signature')
            ->nonQueued();
    }

    public static function getGenderOptions(): array
    {
        return [
            'male' => 'Male',
            'female' => 'Female',
        ];
    }

    public static function getMaritalStatusOptions(): array
    {
        return [
            'single' => 'Single',
            'married' => 'Married',
            'divorced' => 'Divorced',
            'widow' => 'Widow',
        ];
    }

    public static function getNationalityOptions(): array
    {
        return [
            'Bahraini' => 'Bahraini',
            'Saudi Arabian' => 'Saudi Arabian',
            'Emirati' => 'Emirati',
            'Kuwaiti' => 'Kuwaiti',
            'Qatari' => 'Qatari',
            'Omani' => 'Omani',
            'Other' => 'Other',
        ];
    }

    public static function getEducationQualificationOptions(): array
    {
        return [
            'High School' => 'High School',
            'Diploma' => 'Diploma',
            'Bachelors Degree' => 'Bachelors Degree',
            'Masters Degree' => 'Masters Degree',
            'PhD' => 'PhD',
            'Other' => 'Other',
        ];
    }

    /**
     * Get the user that owns the member profile.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Boot the model to register event listeners.
     */
    protected static function booted(): void
    {
        static::created(function (MemberProfile $memberProfile) {
            MemberProfileCreated::dispatch($memberProfile);
        });
    }
}
