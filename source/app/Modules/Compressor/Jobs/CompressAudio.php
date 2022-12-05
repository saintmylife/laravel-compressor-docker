<?php

namespace App\Modules\Compressor\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Filters\Audio\AudioFilters;
use Illuminate\Support\Facades\Storage;

class CompressAudio implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $filename;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $format = (new \FFMpeg\Format\Audio\Mp3)->setAudioKiloBitrate('128');
        $samplerate = '44100';
        FFMpeg::open('public/upload/' . $this->filename)
            ->export()
            ->inFormat($format)
            ->addFilter(function (AudioFilters $filter) use ($samplerate) {
                $filter->resample($samplerate);
            })
            ->save('public/compressed' . $this->filename);
        FFMpeg::cleanupTemporaryFiles();
        Storage::delete('public/upload/' . $this->filename);
    }
}
