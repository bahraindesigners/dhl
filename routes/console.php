<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');

// run queued jobs and stop when empty
Artisan::command('queue:work-once', function () {
    $this->comment('Starting queue worker to process jobs until the queue is empty...');

    Artisan::call('queue:work', [
        '--stop-when-empty' => true,
        '--tries' => 3,
    ]);

    $this->comment('Queue worker has stopped after processing all jobs.');
})->describe('Process queued jobs until the queue is empty');
