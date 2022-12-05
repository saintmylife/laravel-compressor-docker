<?php

namespace App\Modules\Compressor\Api\CreateBulk;

use App\Http\Controllers\Controller;
use App\Modules\Compressor\Domain\Service\CompressorCreateBulk;
use Illuminate\Http\Request;

/**
 * CompressorCreateBulkAction
 */
class CompressorCreateBulkAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(CompressorCreateBulk $domain, CompressorCreateBulkResponder $responder)
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
