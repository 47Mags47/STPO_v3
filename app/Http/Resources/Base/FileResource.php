<?php

namespace App\Http\Resources\Base;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->origin_name,
            'disabled'  => $this->is_disabled,
            'status'    => $this->status->toResource(),
            'errors'    => $this->errors()->count()
        ];
    }
}
