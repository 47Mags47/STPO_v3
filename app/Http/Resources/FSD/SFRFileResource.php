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
            'id' => $this->id,
            'file' => [
                'name' => $this->file->origin_name,
                'errors' => $this->file->errors,
            ],
            'recipients' => [
                'count' => $this->recipients()->count(),
                'min_date_start' => $this->recipients()->min('date_start'),
                'max_date_start' => $this->recipients()->max('date_end'),
            ],
            'upload_at' => $this->created_at
        ];
    }
}
