<?php

namespace App\Modules\User\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Base\Domain\BaseFilter;
use Illuminate\Validation\Rule;

/**
 * User filter
 */
class UserFilter extends BaseFilter
{
    public function forUpdate(BaseDto $data): bool
    {
        $this->messages = [];
        $this->setBasicRule();
        $this->rules['password'] = 'nullable|min:5';
        return $this->basic($data);
    }

    protected function setBasicRule()
    {
        $this->rules = [
            'email'  => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
        ];
    }
}
