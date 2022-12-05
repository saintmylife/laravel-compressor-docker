<?php

namespace App\Modules\Compressor\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Support\Facades\Storage;

class CompressImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $filename;
    protected $type;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filename, $type = 0)
    {
        $this->filename = $filename;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $imgPath = public_path('storage/upload/' . $this->filename);
        $img = ImageManagerStatic::make($imgPath);
        if ($this->type) {
            $img->fit(1080, 1920);
        } else {
            $img->fit(720, 1280);
        }
        $img->save(public_path('storage/compressed/' . $this->filename), 60);
        Storage::delete('public/upload/' . $this->filename);
    }
}
