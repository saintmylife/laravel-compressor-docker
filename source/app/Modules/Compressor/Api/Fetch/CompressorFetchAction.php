<?php

namespace App\Modules\Compressor\Api\Fetch;

use App\Http\Controllers\Controller;
use App\Modules\Compressor\Domain\Service\CompressorFetch;
use Illuminate\Http\Request;

/**
 * CompressorFetchAction
 */
class CompressorFetchAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(CompressorFetch $domain, CompressorFetchResponder $responder)
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
