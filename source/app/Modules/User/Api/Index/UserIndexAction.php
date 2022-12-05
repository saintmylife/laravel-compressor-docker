<?php

namespace App\Modules\User\Api\Index;

use App\Http\Controllers\Controller;
use App\Modules\User\Domain\Service\UserList;
use Illuminate\Http\Request;


/**
 * UserIndex action
 */
class UserIndexAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(UserList $domain, UserIndexResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }


    function __invoke(Request $request)
    {
        $payload = $this->domain->__invoke($request->all());
        return $this->responder->__invoke($payload);
    }
}
