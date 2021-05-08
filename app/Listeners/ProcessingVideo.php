<?php

namespace App\Listeners;

use App\Events\NewVideoUploaded;
use App\Jobs\ProcessVideoJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProcessingVideo implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    public function __construct()
    {

    }
    public function handle(NewVideoUploaded $event)
    {
        ProcessVideoJob::dispatch($event->video);
    }
}
