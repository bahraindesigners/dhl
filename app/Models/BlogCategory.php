<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class BlogCategory extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    // Define translatable fields
    public array $translatable = [
        'name',
        'slug',
        'description',
    ];

    // Relationships
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

    public function publishedBlogs(): HasMany
    {
        return $this->hasMany(Blog::class)->published();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name->en');
    }

    // Helpers
    public function getBlogsCount(): int
    {
        return $this->blogs()->count();
    }

    public function getPublishedBlogsCount(): int
    {
        return $this->publishedBlogs()->count();
    }
}
