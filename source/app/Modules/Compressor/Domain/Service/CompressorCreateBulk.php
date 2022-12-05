<?php

namespace App\Modules\Compressor\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Compressor\CompressorDto;
use App\Modules\Compressor\Domain\CompressorFilter;
use App\Modules\Compressor\Jobs\CompressVideo;
use Illuminate\Support\{Arr, Str};
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;

class CompressorCreateBulk extends BaseService
{
    private $filter;
    public function __construct(CompressorFilter $filter)
    {
        $this->filter = $filter;
    }

    public function __invoke(array $data): Payload
    {
        $compressorDto = $this->makeDto($data, new CompressorDto);
        if (!$this->filter->forBulkInsert($compressorDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }

        $dispatcable = [];

        foreach ($compressorDto->media as $media) {
            $getFileExt = '.' . $media->getClientOriginalExtension();
            $filename = Str::slug(Arr::first(explode($getFileExt, $media->getClientOriginalName()))) . $getFileExt;
            Storage::putFileAs('public/upload', $media, $filename);
            array_push($dispatcable, new CompressVideo($filename, $getFileExt, $compressorDto->options['quality'] ?? 250));
        }

        Bus::chain($dispatcable)->dispatch();

        $create = 'Bulk Compression on progress';
        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
