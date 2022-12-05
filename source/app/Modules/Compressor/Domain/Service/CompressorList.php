<?php

namespace App\Modules\Compressor\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Compressor\Repository\CompressorRepositoryInterface;

/**
 * CompressorList service
 */
class CompressorList extends BaseService
{
    private $compressorRepo;

    public function __construct(CompressorRepositoryInterface $compressorRepo)
    {
        $this->compressorRepo = $compressorRepo;
    }

    public function __invoke($request)
    {
        $data = $this->compressorRepo->paginate(isset($request['per_page']) ? $request['per_page'] : 100);
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
