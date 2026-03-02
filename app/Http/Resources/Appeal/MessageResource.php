<?php

namespace App\Http\Resources\Appeal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'sender' => [
                'fullName' => $this->sender->full_name,
            ],
            'file' => $this->file_id !== null
                ? [
                    'url' => route('appeal.messages.show', ['appeal' => $this->appeal, 'message' => $this]),
                    'originName' => $this->originName,
                ]
                : null
        ];
    }
}
