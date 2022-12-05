<?php

namespace App\Modules\Compressor\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Compressor\CompressorDto;
use App\Modules\Compressor\Domain\CompressorFilter;
use App\Modules\Compressor\Jobs\CompressAudio;
use App\Modules\Compressor\Jobs\CompressImage;
use App\Modules\Compressor\Jobs\CompressVideo;
use App\Modules\Compressor\Jobs\CompressVideoStreaming;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 * CompressorCreate domain
 */
class CompressorCreate extends BaseService
{
    private $filter;

    public function __construct(CompressorFilter $filter)
    {
        $this->filter = $filter;
    }

    public function __invoke(array $data): Payload
    {
        $compressorDto = $this->makeDto($data, new CompressorDto);

        if (!$this->filter->forInsert($compressorDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }
        $getFileExt = '.' . $compressorDto->media->getClientOriginalExtension();
        $filename = Str::slug(Arr::first(explode($getFileExt, $compressorDto->media->getClientOriginalName()))) . $getFileExt;
        Storage::putFileAs('public/upload', $compressorDto->media, $filename);
        if ($compressorDto->media->getClientMimeType() === 'image/jpeg') {
            CompressImage::dispatch($filename, $compressorDto->options['type']);
        } elseif ($compressorDto->media->getClientMimeType() === 'audio/mpeg') {
            CompressAudio::dispatch($filename);
        } else {
            if ($compressorDto->options['quality'] == 'stream') {
                CompressVideoStreaming::dispatch($filename, $getFileExt);
            } else {
                CompressVideo::dispatch($filename, $getFileExt, $compressorDto->options['quality']);
            }
        }

        $create = "file $filename on Compression progress";

        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
