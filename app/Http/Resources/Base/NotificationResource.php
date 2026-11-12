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
            'message'       => $this->message,
            'context'       => $this->context,
            'created_at'    => $this->created_at,
            'is_readed'     => $this->is_readed,
            'is_system'     => $this->is_system,
            'type'          => [
                'code'  => $this->type->code,
                'name'  => $this->type->name,
            ],
            'sender' => $this->sender !== null
                ? [
                    'full_name' => $this->sender->full_name,
                ]
                : []
        ];
    }
}
