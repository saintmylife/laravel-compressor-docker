<?php

namespace App\Modules\Compressor\Api\Create;

use App\Http\Controllers\Controller;
use App\Modules\Compressor\Domain\Service\CompressorCreate;
use Illuminate\Http\Request;

/**
 * CompressorCreateAction
 */
class CompressorCreateAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(CompressorCreate $domain, CompressorCreateResponder $responder)
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
