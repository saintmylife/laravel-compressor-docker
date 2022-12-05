<?php

namespace App\Modules\Compressor\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Base\Domain\BaseFilter;
use Illuminate\Validation\Rule;

/**
 * Compressor filter
 */
class CompressorFilter extends BaseFilter
{
    public function forMultipleInsert(BaseDto $data): bool
    {
        $this->messages = [];
        $this->rules = [
            'media' => 'required|array|filled|min:1',
            'media.*' => 'image'
        ];
        return $this->basic($data);
    }
    public function forBulkInsert(BaseDto $data): bool
    {
        $this->rules = [
            'media' => ['required', 'min:1', 'array'],
            'media.*' => ['required', 'file', 'mimetypes:application/mp4,video/mp4,video/x-flv,video/webm,video/x-ms-wmv,video/x-msvideo,video/3gpp,video/quicktime'],
            'options' => ['nullable', 'array'],
            'options.quality' => ['nullable', 'integer'],
        ];
        return $this->basic($data);
    }

    protected function setBasicRule()
    {

        $this->rules = [
            'media'  => 'required|file|mimetypes:application/mp4,video/mp4,video/x-flv,video/webm,video/x-ms-wmv,video/x-msvideo,video/3gpp,video/quicktime,image/jpeg,audio/mpeg',
            'options'  => 'nullable|array',
            'options.*.quality' => 'nullable|integer',
            'options.*.type' => 'nullable|in:0,1'
        ];
    }
}
