<?php

namespace App\Http\Resources\Base;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessagesResource extends JsonResource
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
            'readed' => (bool) $this->readed,
            'chat_id' => $this->chat_id,
            'context' => $this->context,
            'sender' => [
                'id' => $this->sender->id,
                'name' => $this->sender->full_name,
            ],
            'file' => $this->file_id !== null
                ? $this->file->toResource()
                : null,
            'file_url' => route('files.show', ['file' => $this]),
            'created_at' => $this->created_at,
        ];
    }
}
