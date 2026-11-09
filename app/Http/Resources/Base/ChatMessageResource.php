<?php

namespace App\Http\Resources\Base;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
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
            'message' => $this->message,
            'context' => $this->context,

            'is_readed' => (bool) $this->is_readed,
            'is_system' => (bool) $this->is_system,

            'attachments' => $this->attachments->map(fn($attachment) => $attachment->file)->toResourceCollection(),

            'sender' => $this->sender !== null ?
                [
                    'id' => $this->sender->id,
                    'name' => $this->sender->full_name,
                ]
                : null,

            'chat' => [
                'id' => $this->chat,
            ],
            'created_at' => $this->created_at,
        ];
    }
}
