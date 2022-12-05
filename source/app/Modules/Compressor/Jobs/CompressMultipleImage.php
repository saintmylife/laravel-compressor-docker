<?php

namespace App\Modules\Compressor\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Support\Facades\Storage;

class CompressMultipleImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $filename;
    protected $type;
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
        $newImage = Arr::first(explode('.', $this->filename)) . '.jpg';
        $imgPath = public_path('storage/upload/' . $this->filename);
        $img = ImageManagerStatic::make($imgPath);
        $img->save(public_path('storage/compressed/' . $newImage), 60);
        Storage::delete('public/upload/' . $this->filename);
    }
}
