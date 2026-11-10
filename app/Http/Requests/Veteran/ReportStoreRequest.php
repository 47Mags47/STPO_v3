<?php

namespace App\Http\Requests\Veteran;

use Illuminate\Foundation\Http\FormRequest;

class ReportStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'all'       => ['required', 'integer', 'min:0'],
            'online'    => ['required', 'integer', 'min:0'],
            'MFC'       => ['required', 'integer', 'min:0'],
        ];
    }
}
