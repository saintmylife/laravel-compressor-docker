<?php

namespace App\Modules\User;

use App\Modules\Base\BaseDto;

class UserDto extends BaseDto
{
    protected $id;
    protected $email;
    protected $password;
    protected $roles;
}
