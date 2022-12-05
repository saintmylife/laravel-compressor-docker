<?php

namespace App\Modules\Base\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Common\Entity\EntityInterface;
use Illuminate\Support\Facades\Validator;

/**
 * Base filter
 */
class BaseFilter
{
    protected $rules;
    protected $messages;

    public function getMessages()
    {
        return $this->messages;
    }

    public function forInsert(BaseDto $data): bool
    {
        $this->messages = [];
        $this->setBasicRule();
        return $this->basic($data);
    }

    public function forUpdate(BaseDto $data): bool
    {
        return $this->forInsert($data);
    }

    protected function basic(BaseDto $data): bool
    {
        $this->validate($data);
        return $this->isValid();
    }

    protected function validate(BaseDto $data)
    {
        $validator = Validator::make($data->getData(), $this->rules);
        $this->messages = $validator->errors();
    }

    protected function isValid(): bool
    {
        return $this->messages->isEmpty();
    }
}
