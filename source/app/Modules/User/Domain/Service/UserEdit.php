<?php

namespace App\Modules\User\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\User\Domain\UserFilter;
use App\Modules\User\Repository\UserRepositoryInterface;
use App\Modules\User\UserDto;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

/**
 * UserEdit service
 */
class UserEdit extends BaseService
{
    private $filter;
    private $userRepo;

    public function __construct(UserFilter $filter, UserRepositoryInterface $userRepo)
    {
        $this->filter = $filter;
        $this->userRepo = $userRepo;
    }

    public function __invoke(int $id, array $data): Payload
    {
        $userDto = $this->makeDto($data, new UserDto);
        $userDto->id = $id;
        if (! $this->filter->forUpdate($userDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }

        try {
            $this->userRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }

        $dataForDb = $userDto->getData();
        if (is_null($userDto->password)) {
            unset($dataForDb['password']);
        } else {
            $dataForDb['password'] = Hash::make($dataForDb['password']);
        }

        $update = $this->userRepo->update($dataForDb, $id);
        if (!is_null($update)) {
            $update->syncRoles($userDto->roles);
        }

        return $this->newPayload(Payload::STATUS_UPDATED, compact('data'));
    }
}
