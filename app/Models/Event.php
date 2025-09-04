<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Event extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'start_date',
        'end_date',
        'timezone',
        'status',
        'priority',
        'featured',
        'location',
        'location_details',
        'capacity',
        'registered_count',
        'registration_enabled',
        'registration_starts_at',
        'registration_ends_at',
        'price',
        'meta_title',
        'meta_description',
        'organizer',
        'organizer_details',
        'published_at',
        'author',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'registration_starts_at' => 'datetime',
        'registration_ends_at' => 'datetime',
        'published_at' => 'datetime',
        'featured' => 'boolean',
        'registration_enabled' => 'boolean',
        'price' => 'decimal:2',
    ];

    public array $translatable = [
        'title',
        'slug',
        'description',
        'content',
        'meta_title',
        'meta_description',
        'location_details',
        'organizer',
        'organizer_details',
        'author',
    ];

    // Relationships
    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function confirmedRegistrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class)->where('status', 'confirmed');
    }

    // Media Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']);

        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']);

        $this->addMediaCollection('content_images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
    }

    // Media Conversions
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(200)
            ->quality(95)
            ->nonQueued();

        $this->addMediaConversion('featured')
            ->width(1200)
            ->height(630)
            ->quality(95)
            ->nonQueued();

        $this->addMediaConversion('high-quality')
            ->width(2400)
            ->height(1600)
            ->quality(95)
            ->nonQueued();
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }

    public function scopeOngoing($query)
    {
        return $query->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    // Helper Methods
    public function isUpcoming(): bool
    {
        return $this->start_date > now();
    }

    public function isOngoing(): bool
    {
        return $this->start_date <= now() && $this->end_date >= now();
    }

    public function isPast(): bool
    {
        return $this->end_date < now();
    }

    public function canRegister(): bool
    {
        if (! $this->registration_enabled) {
            return false;
        }

        if ($this->registration_starts_at && $this->registration_starts_at > now()) {
            return false;
        }

        if ($this->registration_ends_at && $this->registration_ends_at < now()) {
            return false;
        }

        if ($this->capacity && $this->registered_count >= $this->capacity) {
            return false;
        }

        return $this->status === 'published' && $this->isUpcoming();
    }

    public function spotsRemaining(): ?int
    {
        if (! $this->capacity) {
            return null;
        }

        return max(0, $this->capacity - $this->registered_count);
    }

    public function getDurationInHours(): float
    {
        return $this->start_date->diffInHours($this->end_date);
    }

    public function getDurationInDays(): int
    {
        return $this->start_date->diffInDays($this->end_date->endOfDay());
    }
}
