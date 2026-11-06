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
            'created_at' => $this->created_at,
            'comment' => $this->comment,
            'chat_id' => $this->chat_id,
            'theme' => [
                'id' => $this->theme->id,
                'name' => $this->theme->name,
                'group' => [
                    'name' => $this->theme->group->name
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
