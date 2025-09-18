<?php

namespace App\Console\Commands;

use App\Models\About;
use Illuminate\Console\Command;

class EnsureSingleAboutPage extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'about:ensure-single';

    /**
     * The console command description.
     */
    protected $description = 'Ensure there is only one About page in the database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $aboutPages = About::all();

        if ($aboutPages->count() === 0) {
            // Create the default About page if none exists
            About::create([
                'title' => [
                    'en' => 'About Us',
                    'ar' => 'معلومات عنا',
                ],
                'content' => [
                    'en' => '<p>Welcome to our organization.</p>',
                    'ar' => '<p>مرحباً بكم في منظمتنا.</p>',
                ],
                'show_board_section' => false,
                'is_active' => true,
                'sort_order' => 1,
            ]);

            $this->info('Created default About page.');
        } elseif ($aboutPages->count() > 1) {
            // Keep the first one and delete the rest
            $mainAbout = $aboutPages->first();
            About::where('id', '!=', $mainAbout->id)->delete();

            $this->info('Removed duplicate About pages. Kept the first one (ID: '.$mainAbout->id.').');
        } else {
            $this->info('Exactly one About page exists. No action needed.');
        }
    }
}
