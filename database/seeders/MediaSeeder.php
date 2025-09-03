<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating sample media files...');

        $posts = Post::all();
        
        if ($posts->isEmpty()) {
            $this->command->warn('No posts found. Creating sample posts first...');
            Post::factory(3)->create();
            $posts = Post::all();
        }

        $this->createSampleImages($posts);
        $this->createSampleDocuments($posts);
        
        $this->command->info('Media seeding completed!');
        $this->command->info('Total media files created: ' . Media::count());
    }

    private function createSampleImages($posts): void
    {
        $imageData = [
            [
                'name' => 'Hero Banner',
                'filename' => 'hero-banner.jpg',
                'collection' => 'featured',
                'color' => '#3B82F6',
                'text' => 'HERO'
            ],
            [
                'name' => 'Product Gallery 1',
                'filename' => 'product-1.jpg',
                'collection' => 'gallery',
                'color' => '#EF4444',
                'text' => 'PROD 1'
            ],
            [
                'name' => 'Product Gallery 2',
                'filename' => 'product-2.jpg',
                'collection' => 'gallery',
                'color' => '#10B981',
                'text' => 'PROD 2'
            ],
            [
                'name' => 'Background Image',
                'filename' => 'background.jpg',
                'collection' => 'backgrounds',
                'color' => '#8B5CF6',
                'text' => 'BG'
            ],
            [
                'name' => 'Thumbnail',
                'filename' => 'thumbnail.jpg',
                'collection' => 'thumbnails',
                'color' => '#F59E0B',
                'text' => 'THUMB'
            ],
        ];

        foreach ($imageData as $index => $imageInfo) {
            $post = $posts[$index % $posts->count()];
            
            // Create a more detailed SVG image
            $svgContent = $this->createSvgImage($imageInfo['color'], $imageInfo['text']);
            
            // Save using the media library properly
            $tempFile = tempnam(sys_get_temp_dir(), 'media_seed');
            file_put_contents($tempFile, $svgContent);
            
            try {
                $media = $post->addMedia($tempFile)
                    ->usingName($imageInfo['name'])
                    ->usingFileName($imageInfo['filename'])
                    ->toMediaCollection($imageInfo['collection']);
                
                $this->command->info("Created image: {$imageInfo['name']} for post: {$post->title}");
            } catch (\Exception $e) {
                $this->command->error("Failed to create {$imageInfo['name']}: " . $e->getMessage());
            }
            
            // Clean up temp file
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
        }
    }

    private function createSampleDocuments($posts): void
    {
        $documentData = [
            [
                'name' => 'User Manual',
                'filename' => 'user-manual.pdf',
                'collection' => 'documents',
                'content' => 'User Manual Content'
            ],
            [
                'name' => 'Terms of Service',
                'filename' => 'terms-of-service.pdf',
                'collection' => 'legal',
                'content' => 'Terms of Service Content'
            ],
            [
                'name' => 'Product Specifications',
                'filename' => 'specifications.txt',
                'collection' => 'documents',
                'content' => 'Product specifications and technical details...'
            ],
        ];

        foreach ($documentData as $index => $docInfo) {
            $post = $posts[$index % $posts->count()];
            
            // Create document content
            $content = $this->createDocumentContent($docInfo['content']);
            
            $tempFile = tempnam(sys_get_temp_dir(), 'doc_seed');
            file_put_contents($tempFile, $content);
            
            try {
                $media = $post->addMedia($tempFile)
                    ->usingName($docInfo['name'])
                    ->usingFileName($docInfo['filename'])
                    ->toMediaCollection($docInfo['collection']);
                
                $this->command->info("Created document: {$docInfo['name']} for post: {$post->title}");
            } catch (\Exception $e) {
                $this->command->error("Failed to create {$docInfo['name']}: " . $e->getMessage());
            }
            
            // Clean up temp file
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
        }
    }

    private function createSvgImage(string $color, string $text): string
    {
        return <<<SVG
<svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:{$color};stop-opacity:1" />
      <stop offset="100%" style="stop-color:{$color};stop-opacity:0.7" />
    </linearGradient>
  </defs>
  <rect width="100%" height="100%" fill="url(#grad)"/>
  <circle cx="200" cy="150" r="50" fill="rgba(255,255,255,0.2)"/>
  <text x="200" y="150" text-anchor="middle" dominant-baseline="middle" 
        fill="white" font-size="24" font-family="Arial, sans-serif" font-weight="bold">
    {$text}
  </text>
  <text x="200" y="280" text-anchor="middle" 
        fill="white" font-size="12" font-family="Arial, sans-serif">
    Sample Media File
  </text>
</svg>
SVG;
    }

    private function createDocumentContent(string $title): string
    {
        return <<<CONTENT
{$title}

This is a sample document created for testing the media library functionality.

Generated on: {now()->format('Y-m-d H:i:s')}

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor 
incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis 
nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore 
eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, 
sunt in culpa qui officia deserunt mollit anim id est laborum.
CONTENT;
    }
}
