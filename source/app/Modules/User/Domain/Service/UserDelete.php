<?php

namespace App\Modules\User\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\User\Repository\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * User delete
 */
class UserDelete extends BaseService
{
    private $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function __invoke(int $id): Payload
    {
        try {
            $this->userRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }

        $this->userRepo->delete($id);
        $message = 'User deleted';
        return $this->newPayload(Payload::STATUS_DELETED, compact('message'));
    }
}
