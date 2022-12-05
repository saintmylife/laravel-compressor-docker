<?php

namespace App\Modules\User\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\User\Domain\UserFilter;
use App\Modules\User\Repository\UserRepositoryInterface;
use App\Modules\User\UserDto;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

/**
 * UserCreate domain
 */
class UserCreate extends BaseService
{
    private $filter;
    private $userRepo;

    public function __construct(UserFilter $filter, UserRepositoryInterface $userRepo)
    {
        $this->filter = $filter;
        $this->userRepo = $userRepo;
    }

    public function __invoke(array $data): Payload
    {

        $userDto = $this->makeDto($data, new UserDto);

        if (!$this->filter->forInsert($userDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }

        $userDto->password = Hash::make($userDto->password);
        $create = $this->userRepo->create($userDto->getData());
        $create->syncRoles('Personal');


        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
