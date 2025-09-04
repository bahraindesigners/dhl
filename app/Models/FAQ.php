<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class FAQ extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'question',
        'answer',
        'category',
        'sort_order',
        'is_featured',
        'status',
        'meta_title',
        'meta_description',
        'slug',
        'published_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public array $translatable = [
        'question',
        'answer',
        'meta_title',
        'meta_description',
    ];

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    // Accessors
    public function getIsPublishedAttribute(): bool
    {
        return $this->published_at && $this->published_at <= now();
    }

    // Available categories
    public static function getCategories(): array
    {
        return [
            'general' => 'General',
            'events' => 'Events',
            'registration' => 'Registration',
            'payment' => 'Payment',
            'technical' => 'Technical Support',
            'account' => 'Account',
            'policies' => 'Policies',
        ];
    }

    // Boot method to set slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($faq) {
            if (empty($faq->slug)) {
                $faq->slug = str($faq->getTranslation('question', 'en', false))->slug();
            }
        });
    }
}
