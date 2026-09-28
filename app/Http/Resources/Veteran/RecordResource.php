<?php

namespace App\Http\Resources\Veteran;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            =>  $this->id,
            'user'          =>  $this->user ? [
                'id'        =>  $this->user->id,
                'full_name' =>  $this->user->full_name
            ] : null,
            'division'      =>  $this->division ? [
                'id'        =>  $this->division->id,
                'name'      =>  $this->division->name
            ] : null,
            'amount'        =>  $this->amount,
            'online_form'   =>  $this->online_form,
            'MFC'           =>  $this->MFC,
        ];
    }
}
