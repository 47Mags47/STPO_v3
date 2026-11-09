<?php

namespace App\Http\Resources\Veteran;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'all'           => $this->all,
            'online'        => $this->online,
            'MFC'           => $this->MFC,
            'division'      => [
                'id'        => $this->division->id,
                'name'      => $this->division->name,
            ]
        ];
    }
}
