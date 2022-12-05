<?php

namespace App\Modules\Compressor\Api\Edit;

use App\Http\Controllers\Controller;
use App\Modules\Compressor\Domain\Service\CompressorEdit;
use Illuminate\Http\Request;

/**
 * CompressorEditAction
 */
class CompressorEditAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(CompressorEdit $domain, CompressorEditResponder $responder)
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
