<?php

namespace App\Modules\Compressor\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Compressor\Repository\CompressorRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Auth\Access\AuthorizationException;

/**
 * Compressor delete
 */
class CompressorDelete extends BaseService
{
    private $compressorRepo;

    public function __construct(CompressorRepositoryInterface $compressorRepo)
    {
        $this->compressorRepo = $compressorRepo;
    }

    public function __invoke(int $id): Payload
    {
        try {
            $data = $this->compressorRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }
        try {
            Gate::authorize('owner', $data->event->user_id);
        } catch (AuthorizationException $e) {
            return $this->newPayload(Payload::STATUS_UNAUTHORIZED);
        }

        $this->compressorRepo->delete($id);
        $message = 'compressor deleted';
        return $this->newPayload(Payload::STATUS_DELETED, compact('message'));
    }
}
