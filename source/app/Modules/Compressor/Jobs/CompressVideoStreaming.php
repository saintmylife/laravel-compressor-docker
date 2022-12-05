<?php

namespace App\Modules\Compressor\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class CompressVideoStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $filename;
    protected $fileExt;
    public $timeout = 900;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filename, $fileExt)
    {
        $this->filename = $filename;
        $this->fileExt = $fileExt;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $width = 720;
        $height = 1280;
        $newName = Arr::first(explode($this->fileExt, $this->filename)) . '.m3u8';

        $lowBitrateFormat  = (new \FFMpeg\Format\Video\X264)->setKiloBitrate(250);
        $midBitrateFormat  = (new \FFMpeg\Format\Video\X264)->setKiloBitrate(500);
        $highBitrateFormat  = (new \FFMpeg\Format\Video\X264)->setKiloBitrate(1000);

        FFMpeg::open('public/upload/' . $this->filename)
            ->exportForHLS()
            ->setSegmentLength(10)
            ->setKeyFrameInterval(48)
            ->addFormat($lowBitrateFormat, function ($media) use ($width, $height) {
                $media->resize($width, $height);
            })
            ->addFormat($midBitrateFormat, function ($media) use ($width, $height) {
                $media->resize($width, $height);
            })
            ->addFormat($highBitrateFormat, function ($media) use ($width, $height) {
                $media->resize($width, $height);
            })
            ->save('public/compressed/' . $newName);
        FFMpeg::cleanupTemporaryFiles();
        Storage::delete('public/upload/' . $this->filename);
    }
}
