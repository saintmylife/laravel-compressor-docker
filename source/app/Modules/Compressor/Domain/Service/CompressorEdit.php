<?php

namespace App\Modules\Compressor\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Compressor\CompressorDto;
use App\Modules\Compressor\Domain\CompressorFilter;
use App\Modules\Compressor\Repository\CompressorRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Auth\Access\AuthorizationException;

/**
 * CompressorEdit service
 */
class CompressorEdit extends BaseService
{
    private $filter;
    private $compressorRepo;

    public function __construct(CompressorFilter $filter, CompressorRepositoryInterface $compressorRepo)
    {
        $this->filter = $filter;
        $this->compressorRepo = $compressorRepo;
    }

    public function __invoke(int $id, array $data): Payload
    {
        $compressorDto = $this->makeDto($data, new CompressorDto);
        $compressorDto->id = $id;

        try {
             $compressor = $this->compressorRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }
        try{
            Gate::authorize('owner', $compressor->user_id);
        } catch (AuthorizationException $e){
            return $this->newPayload(Payload::STATUS_UNAUTHORIZED);
        }

        if (! $this->filter->forUpdate($compressorDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }

        $dataForDb = $compressorDto->getData();

        $update = $this->compressorRepo->update($dataForDb, $id);

        return $this->newPayload(Payload::STATUS_UPDATED, compact('data'));
    }
}
