<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'content',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        // Disable automatic conversions to avoid processing issues during seeding
        // $this->addMediaConversion('thumb')
        //     ->width(300)
        //     ->height(300)
        //     ->sharpen(10);

        // $this->addMediaConversion('preview')
        //     ->width(500)
        //     ->height(500)
        //     ->nonQueued();
    }
}
