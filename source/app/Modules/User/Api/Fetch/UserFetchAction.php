<?php

namespace App\Modules\User\Api\Fetch;

use App\Http\Controllers\Controller;
use App\Modules\User\Domain\Service\UserFetch;
use Illuminate\Http\Request;

/**
 * UserFetch action
 */
class UserFetchAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(UserFetch $domain, UserFetchResponder $responder)
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
