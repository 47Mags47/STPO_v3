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
            'office' => $this->office,
            'comment' => $this->comment,
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
                'code' => $this->status->code,
                'name' => $this->status->name
            ],
            'actions' => [
                'accept'    => user()->can('accept', $this->resource),
                'goto'      => user()->can('goto', $this->resource),
                'close'     => user()->can('close', $this->resource),
            ]
        ];
    }
}
