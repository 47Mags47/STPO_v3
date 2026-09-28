<?php

namespace App\Http\Requests\Veteran;

use App\Models\Administrate\Division;
use App\Models\Base\User;
use Illuminate\Foundation\Http\FormRequest;

class ReportStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'start_at'      => ['required', 'date_format:Y-m-d'],
            'is_active'      => ['nullable', 'boolean']
        ];
    }
}
