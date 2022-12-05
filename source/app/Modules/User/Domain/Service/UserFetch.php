<?php

namespace App\Modules\User\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\User\userDto;
use App\Modules\User\Repository\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * User delete
 */
class UserFetch extends BaseService
{
    private $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function __invoke(int $id): Payload
    {
        try {
            $data = $this->userRepo->find($id);
            $data->getAllPermissions();
            return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }
    }
}
