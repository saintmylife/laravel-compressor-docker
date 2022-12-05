<?php

namespace App\Modules\User\Api\Edit;

use App\Http\Controllers\Controller;
use App\Modules\User\Domain\Service\UserEdit;
use Illuminate\Http\Request;

/**
 * UserEdit action
 */
class UserEditAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(UserEdit $domain, UserEditResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request, int $id)
    {
        $payload = $this->domain->__invoke($id, $request->all());
        return $this->responder->__invoke($payload);
    }
}
