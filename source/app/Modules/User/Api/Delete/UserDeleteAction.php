<?php

namespace App\Modules\User\Api\Delete;

use App\Http\Controllers\Controller;
use App\Modules\User\Domain\Service\UserDelete;

/**
 * UserDelete action
 */
class UserDeleteAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(UserDelete $domain, UserDeleteResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(int $id)
    {
        $payload = $this->domain->__invoke($id);
        return $this->responder->__invoke($payload);
    }
}
