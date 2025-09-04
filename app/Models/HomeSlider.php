<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class HomeSlider extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'button_text',
        'button_url',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Define translatable fields
    public array $translatable = [
        'title',
        'subtitle',
        'description',
        'button_text',
    ];

    // Media Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('desktop_image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('mobile_image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    // Media Conversions
    public function registerMediaConversions(?Media $media = null): void
    {
        // Desktop image conversions
        $this->addMediaConversion('desktop_large')
            ->width(1920)
            ->height(1080)
            ->quality(90)
            ->optimize()
            ->performOnCollections('desktop_image')
            ->nonQueued();

        $this->addMediaConversion('desktop_medium')
            ->width(1440)
            ->height(810)
            ->quality(90)
            ->optimize()
            ->performOnCollections('desktop_image')
            ->nonQueued();

        $this->addMediaConversion('desktop_small')
            ->width(1024)
            ->height(576)
            ->quality(90)
            ->optimize()
            ->performOnCollections('desktop_image')
            ->nonQueued();

        // Mobile image conversions
        $this->addMediaConversion('mobile_large')
            ->width(768)
            ->height(1024)
            ->quality(90)
            ->optimize()
            ->performOnCollections('mobile_image')
            ->nonQueued();

        $this->addMediaConversion('mobile_medium')
            ->width(480)
            ->height(640)
            ->quality(90)
            ->optimize()
            ->performOnCollections('mobile_image')
            ->nonQueued();

        $this->addMediaConversion('mobile_small')
            ->width(320)
            ->height(427)
            ->quality(90)
            ->optimize()
            ->performOnCollections('mobile_image')
            ->nonQueued();

        // Thumbnail for admin panels
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(200)
            ->quality(95)
            ->crop('crop-center')
            ->performOnCollections('desktop_image', 'mobile_image');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    // Helpers
    public function getDesktopImageUrl(string $conversion = ''): ?string
    {
        if ($conversion) {
            return $this->getFirstMediaUrl('desktop_image', $conversion);
        }

        return $this->getFirstMediaUrl('desktop_image');
    }

    public function getMobileImageUrl(string $conversion = ''): ?string
    {
        if ($conversion) {
            return $this->getFirstMediaUrl('mobile_image', $conversion);
        }

        return $this->getFirstMediaUrl('mobile_image');
    }

    public function getImageUrl(string $type = 'desktop', string $conversion = ''): ?string
    {
        if ($type === 'mobile' && $this->hasMedia('mobile_image')) {
            return $this->getMobileImageUrl($conversion);
        }

        return $this->getDesktopImageUrl($conversion);
    }

    public function hasMobileImage(): bool
    {
        return $this->hasMedia('mobile_image');
    }

    public function hasDesktopImage(): bool
    {
        return $this->hasMedia('desktop_image');
    }
}
