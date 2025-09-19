<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Download extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'category',
        'download_category_id',
        'access_level',
        'is_active',
        'sort_order',
        'download_count',
        'file_size',
        'file_type',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'download_count' => 'integer',
        'file_size' => 'integer',
    ];

    public $translatable = [
        'title',
        'description',
    ];

    // Media Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('downloads')
            ->acceptsMimeTypes([
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'text/plain',
                'text/csv',
                'image/jpeg',
                'image/png',
                'image/gif',
                'image/webp',
                'application/zip',
                'application/x-rar-compressed',
            ])
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10)
            ->performOnCollections('downloads')
            ->nonQueued();
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

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopePublic($query)
    {
        return $query->where('access_level', 'public');
    }

    public function scopeMembersOnly($query)
    {
        return $query->where('access_level', 'members');
    }

    // Relationships
    public function downloadCategory()
    {
        return $this->belongsTo(DownloadCategory::class);
    }

    // Helpers
    public function getFileUrl(): ?string
    {
        return $this->getFirstMediaUrl('downloads');
    }

    public function getFileName(): ?string
    {
        $media = $this->getFirstMedia('downloads');

        if (! $media) {
            return null;
        }

        // Return name with extension for better user experience
        if ($media->name && $media->extension) {
            return $media->name.'.'.$media->extension;
        }

        // Fallback to file_name if name is not available
        return $media->file_name;
    }

    public function getFileExtension(): ?string
    {
        $media = $this->getFirstMedia('downloads');

        return $media?->extension;
    }

    public function hasFile(): bool
    {
        return $this->hasMedia('downloads');
    }

    public function incrementDownloadCount(): void
    {
        $this->increment('download_count');
    }

    public function getFileSizeFormatted(): string
    {
        if (! $this->file_size) {
            return 'Unknown';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = $this->file_size;

        for ($i = 0; $bytes >= 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2).' '.$units[$i];
    }

    public function getCategoryLabel(): string
    {
        $categories = [
            'forms' => 'Forms & Documents',
            'policies' => 'Policies & Procedures',
            'handbooks' => 'Employee Handbooks',
            'training' => 'Training Materials',
            'reports' => 'Reports & Analytics',
            'guides' => 'User Guides',
            'templates' => 'Templates',
            'other' => 'Other Resources',
        ];

        return $categories[$this->category] ?? ucfirst($this->category);
    }

    public function getAccessLevelLabel(): string
    {
        $levels = [
            'public' => 'Public Access',
            'members' => 'Members Only',
        ];

        return $levels[$this->access_level] ?? ucfirst($this->access_level);
    }

    // Boot method for automatic file info extraction
    protected static function booted()
    {
        static::saved(function ($download) {
            if ($download->hasFile()) {
                $media = $download->getFirstMedia('downloads');
                $download->updateQuietly([
                    'file_size' => $media->size,
                    'file_type' => $media->mime_type,
                ]);
            }
        });
    }
}
