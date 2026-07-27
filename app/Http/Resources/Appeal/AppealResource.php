<?php

namespace App\Http\Resources\Appeal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created' => $this->created_at->format('d.m.Y'),
            'comment' => $this->comment,
            'chat_id' => $this->chat_id,
            'them' => [
                'id' => $this->them->id,
                'name' => $this->them->name,
                'group' => [
                    'name' => $this->them->group->name
                ]
            ],
            'sender' => [
                'id'        => $this->sender->id,
                'full_name' => $this->sender->full_name
            ],
            'worker' => $this->worker !== null
            ? [
                'id'        => $this->worker->id,
                'full_name' => $this->worker->full_name
            ]
            : [],
            'status' => [
                'code' => $this->status->code,
                'name' => $this->status->name
            ],
        ];
    }
}
