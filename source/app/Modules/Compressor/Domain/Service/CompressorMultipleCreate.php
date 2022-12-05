<?php

namespace App\Modules\Compressor\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Compressor\CompressorDto;
use App\Modules\Compressor\Domain\CompressorFilter;
use App\Modules\Compressor\Jobs\CompressMultipleImage;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 * CompressorCreate domain
 */
class CompressorMultipleCreate extends BaseService
{
    private $filter;

    public function __construct(CompressorFilter $filter)
    {
        $this->filter = $filter;
    }

    public function __invoke(array $data): Payload
    {
        $compressorDto = $this->makeDto($data, new CompressorDto);

        if (!$this->filter->forMultipleInsert($compressorDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }
        $create = [];
        foreach ($compressorDto->media as $media) {
            $filename = $media->getClientOriginalName();
            Storage::putFileAs('public/upload', $media, $filename);
            CompressMultipleImage::dispatch($filename);
            $create[] = "file $filename on Compression progress";
        }

        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
