<?php

namespace App\Modules\Compressor\Api\Index;

use App\Http\Controllers\Controller;
use App\Modules\Compressor\Domain\Service\CompressorList;
use Illuminate\Http\Request;


/**
 * CompressorIndexAction
 */
class CompressorIndexAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(CompressorList $domain, CompressorIndexResponder $responder)
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
