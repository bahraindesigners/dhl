# Spatie Media Library Integration Guide

## Overview

Your DHL website now includes a complete media management system using Spatie Media Library integrated with Filament admin panel.

## Features Implemented

### 1. Media Library Management
- **Location**: Admin Panel → Content Management → Media Library
- **URL**: http://dhl.test/admin/media
- **Features**:
  - View all uploaded media files
  - Preview images directly in the table
  - Filter by collection and file type
  - View file details (name, size, type, upload date)
  - See which models files are attached to
  - Delete media files

### 2. Post Management (Demo)
- **Location**: Admin Panel → Content Management → Posts
- **URL**: http://dhl.test/admin/posts
- **Purpose**: Demonstrates how models can use media library
- **Features**:
  - Sample posts with attached media
  - Shows relationship between content and media

## How to Use Media Library in Your Models

### 1. Implement HasMedia Interface
```php
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class YourModel extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    // Optional: Define media conversions
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10);
    }
}
```

### 2. Add Media to Models
```php
// Add from file upload
$model->addMediaFromRequest('file')
    ->toMediaCollection('gallery');

// Add from existing file
$model->addMedia($pathToFile)
    ->usingName('Custom Name')
    ->toMediaCollection('documents');

// Add to specific collection
$model->addMedia($pathToFile)
    ->toMediaCollection('featured_images');
```

### 3. Retrieve Media
```php
// Get all media
$allMedia = $model->getMedia();

// Get media from specific collection
$galleryImages = $model->getMedia('gallery');

// Get first media from collection
$featuredImage = $model->getFirstMedia('featured_images');

// Get media URL
$url = $model->getFirstMediaUrl('gallery');
```

### 4. In Filament Forms (Future Enhancement)
```php
// Note: This would require proper form implementation in Filament v4
SpatieMediaLibraryFileUpload::make('gallery')
    ->collection('gallery')
    ->multiple()
    ->image()
    ->imageEditor();
```

## Available Collections

Based on the Post model example:
- `featured` - For featured/hero images
- `gallery` - For image galleries
- `documents` - For PDF and document files
- `default` - Default collection

## Media Table Structure

The media library uses these key fields:
- `name` - Display name for the file
- `file_name` - Actual file name on disk
- `mime_type` - File type (image/jpeg, application/pdf, etc.)
- `collection_name` - Logical grouping of files
- `custom_properties` - JSON field for additional metadata
- `size` - File size in bytes

## Admin Panel Navigation

The media management is organized under "Content Management":
- **Media Library** - Manage all uploaded files
- **Posts** - Example model showing media integration

## Next Steps

1. **Add File Upload Forms**: Implement proper file upload forms in your existing models
2. **Image Conversions**: Set up automatic image resizing and optimization
3. **Custom Collections**: Define specific collections for different types of content
4. **File Validation**: Add validation rules for file types and sizes
5. **Storage Configuration**: Configure cloud storage (S3, etc.) if needed

## Technical Notes

- Media files are stored in the `storage/app` directory by default
- Database relationships are automatically managed
- File URLs can be generated with signed URLs for security
- Image processing requires GD or ImageMagick extension
- Large file uploads may require PHP configuration adjustments

## Sample Data

The system includes sample posts with attached media files to demonstrate functionality. You can view these in the admin panel to understand how the media library works.
