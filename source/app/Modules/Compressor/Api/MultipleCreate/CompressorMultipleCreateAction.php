<?php

namespace App\Modules\Compressor\Api\MultipleCreate;

use App\Http\Controllers\Controller;
use App\Modules\Compressor\Domain\Service\CompressorMultipleCreate;
use Illuminate\Http\Request;

/**
 * CompressorMultipleCreateAction
 */
class CompressorMultipleCreateAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(CompressorMultipleCreate $domain, CompressorMultipleCreateResponder $responder)
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
