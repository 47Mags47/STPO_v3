<?php

namespace App\Http\Resources\FSD;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SFRFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'region_code'   => $this->region_code,
            'sign_code'     => $this->sign_code,
            'in_date'       => $this->in_date,
            'npp_for_month' => $this->npp_for_month,
            'file' => [
                'name' => $this->file->origin_name,
                'errors' => $this->file->errors,
            ]
        ];
    }
}
