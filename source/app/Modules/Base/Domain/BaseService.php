<?php

namespace App\Modules\Base\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Common\Domain\Payload;

/**
 * Base service
 */
class BaseService
{
    public function makeDto(array $data, BaseDto $dto)
    {
        $dto->setData($data);
        return $dto;
    }

    public function newPayload(string $status, array $result = []) : Payload
    {
        return new Payload($status, $result);
    }
}
