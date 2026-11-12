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
                ->where('group_id', PermissionGroup::byCode('veteran')->id)
                ->get()
                ->map(
                    function ($permission) {
                        return array_merge(
                            [
                                'division' => $permission->pivot->division !== null
                                    ? [
                                        'id'    => $permission->pivot->division->id,
                                        'name'  => $permission->pivot->division->name
                                    ]
                                    : []
                            ],
                            $permission->toResource()->toArray(request())
                        );
                    }
                )
        ];
    }
}
