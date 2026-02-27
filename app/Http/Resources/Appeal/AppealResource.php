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
            'office' => $this->office,
            'them' => [
                'id' => $this->them->id,
                'name' => $this->them->name,
                'group' => [
                    'name' => $this->them->group->name
                ]
            ],
            'sender' => [
                'full_name' => $this->sender->full_name
            ],
            'status' => [
                'name' => $this->status->name
            ]
        ];
    }
}
