<?php

namespace App\Http\Resources\Base;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UploadFileResource extends JsonResource
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
            'config' => [
                'chunkSize' => return_bytes(config('filesystems.max_file_size')),
            ],
            'chunks' => $this->chunks->map(fn($chunk) => [
                'id' => $chunk->id,
                'npp' => $chunk->npp,
            ]),
        ];
    }
}
