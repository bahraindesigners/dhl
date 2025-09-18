<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Blog extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug', 
        'excerpt',
        'content',
        'meta_title',
        'meta_description',
        'author',
        'status',
        'featured',
        'show_as_urgent_news',
        'published_at',
        'views_count',
        'reading_time',
        'blog_category_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'featured' => 'boolean',
        'show_as_urgent_news' => 'boolean',
        'views_count' => 'integer',
        'reading_time' => 'integer',
    ];

    // Define translatable fields
    public array $translatable = [
        'title',
        'slug',
        'excerpt', 
        'content',
        'meta_title',
        'meta_description',
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    // Media Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif']);

        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif']);

        $this->addMediaCollection('blog-attachments')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'application/pdf', 'text/plain']);

        $this->addMediaCollection('attachments');
    }

    // Media Conversions
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->quality(95)
            ->sharpen(10)
            ->performOnCollections('featured_image', 'gallery', 'blog-attachments');

        $this->addMediaConversion('featured')
            ->width(1200)
            ->height(800)
            ->quality(95)
            ->optimize()
            ->performOnCollections('featured_image')
            ->nonQueued();

        $this->addMediaConversion('content')
            ->width(1920)
            ->height(1080)
            ->quality(95)
            ->optimize()
            ->performOnCollections('blog-attachments')
            ->nonQueued();
        
        $this->addMediaConversion('high-quality')
            ->width(2400)
            ->height(1600)
            ->quality(90)
            ->performOnCollections('featured_image', 'gallery', 'blog-attachments')
            ->nonQueued();
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('blog_category_id', $categoryId);
    }

    // Helpers
    public function getFeaturedImageUrl(): ?string
    {
        return $this->getFirstMediaUrl('featured_image');
    }

    public function getCalculatedReadingTimeAttribute(): ?int
    {
        if ($this->reading_time) {
            return $this->reading_time;
        }

        // Calculate reading time (average 200 words per minute)
        $content = strip_tags($this->getTranslation('content', app()->getLocale()));
        $wordCount = str_word_count($content);
        return max(1, ceil($wordCount / 200));
    }
}
