<?php

namespace App\Modules\Compressor\Api\Delete;

use App\Http\Controllers\Controller;
use App\Modules\Compressor\Domain\Service\CompressorDelete;

/**
 * Compressor action
 */
class CompressorDeleteAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(CompressorDelete $domain, CompressorDeleteResponder $responder)
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
