<?php

namespace App\Http\Resources\Veteran;

use App\Models\Auth\PermissionGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAccessResource extends JsonResource
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
            'permissions'       => $this->permissions()
                ->where('group_id', PermissionGroup::byCode('veteran_work')->id)
                ->get()
                ->map(fn($permission) => array_merge(
                    ['division_id' => $permission->pivot->division_id],
                    $permission->toResource()->toArray(request())),
                )
        ];
    }
}
