<?php

namespace App\Console\Commands;

use Database\Seeders\MediaSeeder;
use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ReseedMediaCommand extends Command
{
    protected $signature = 'media:reseed {--clear : Clear existing media files first}';
    
    protected $description = 'Re-seed the media library with sample files';

    public function handle(): void
    {
        if ($this->option('clear')) {
            $this->info('Clearing existing media files...');
            
            // Delete all files and directories
            $mediaFiles = Media::all();
            foreach ($mediaFiles as $media) {
                if (file_exists($media->getPath())) {
                    unlink($media->getPath());
                }
                
                $dir = dirname($media->getPath());
                if (file_exists($dir) && count(scandir($dir)) == 2) {
                    rmdir($dir);
                }
            }
            
            // Clear database records
            Media::truncate();
            $this->info('Existing media files cleared.');
        }

        $this->info('Seeding media files...');
        $seeder = new MediaSeeder();
        $seeder->setCommand($this);
        $seeder->run();
        
        $this->info('Media re-seeding completed!');
    }
}
