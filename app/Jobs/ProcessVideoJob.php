<?php

namespace App\Jobs;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ProcessVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function handle()
    {
        $fileBaseName = $this->video->path;
        $path = "media/{$fileBaseName}";
        $format = new X264('aac');
        $sample = FFMpeg::fromDisk('public')
            ->open($path . "/{$fileBaseName}")->resize(100, 100)
            ->export()
            ->inFormat($format)
            ->save($path . "/{$fileBaseName}_100.mp4");

        $addWaterMark = FFMpeg::fromDisk('public')
            ->open($path . "/{$fileBaseName}")
            ->export()
            ->inFormat($format)
            ->addWatermark(function (WatermarkFactory $watermark) {
                $watermark
                    ->fromDisk('local')
                    ->open('media/logo.png')
                    ->right(25)
                    ->bottom(25);
            })
            ->save($path . "/{$fileBaseName}_processed.mp4");
        $thumbnail = FFMpeg::fromDisk('public')
            ->open($path . "/{$fileBaseName}")->getFrameFromSeconds(2)
            ->export()
            ->save($path . "/{$fileBaseName}.png");

        $this->video->status = Video::getStatusAsProcessed();
        $this->video->save();
    }
}
