<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrentUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name,
            'middle_name'       => $this->middle_name,
            'full_name'         => $this->full_name,
            'phone'             => $this->phone,
            'phone_dob'         => $this->phone_dob,
            'login'             => $this->login,
            'email'             => $this->email,
            'is_email_verified' => $this->email_verified_at !== null,
            'notifications'     => $this->notifications->toResourceCollection(),
            'permissions'       => $this->getPermissions()->toResourceCollection(),
        ];
    }
}
