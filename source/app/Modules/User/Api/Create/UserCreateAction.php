<?php

namespace App\Modules\User\Api\Create;

use App\Http\Controllers\Controller;
use App\Modules\User\Domain\Service\UserCreate;
use Illuminate\Http\Request;

/**
 * UserCreate action
 */
class UserCreateAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(UserCreate $domain, UserCreateResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request)
    {
        $payload = $this->domain->__invoke($request->all());
        return $this->responder->__invoke($payload);
    }
}
