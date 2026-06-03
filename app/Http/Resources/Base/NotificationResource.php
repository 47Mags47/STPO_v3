<?php

namespace App\Http\Resources\Base;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'message'       => $this->message,
            'is_readed'     => $this->is_readed,
            'type'          => [
                'code'  => $this->type->code,
                'name'  => $this->type->name,
            ],
        ];
    }
}
