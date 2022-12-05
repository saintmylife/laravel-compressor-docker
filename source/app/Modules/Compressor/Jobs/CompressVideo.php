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

class CompressVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $filename;
    protected $fileExt;
    protected $quality;
    public $timeout = 900;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filename, $fileExt, $quality = 250)
    {
        $this->filename = $filename;
        $this->fileExt = $fileExt;
        $this->quality = $quality;
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
        $newName = Arr::first(explode($this->fileExt, $this->filename)) . '.mp4';
        $lowBitrateFormat  = (new \FFMpeg\Format\Video\X264)->setKiloBitrate($this->quality);
        FFMpeg::open('public/upload/' . $this->filename)
            ->addFilter(new \FFMpeg\Filters\Audio\SimpleFilter(['-an']))
            ->resize($width, $height)
            ->export()
            ->inFormat($lowBitrateFormat)
            ->save('public/compressed/' . $newName);
        FFMpeg::cleanupTemporaryFiles();
        Storage::delete('public/upload/' . $this->filename);
    }
}
