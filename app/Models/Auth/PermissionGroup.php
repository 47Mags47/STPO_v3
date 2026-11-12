<?php

namespace App\Models\Auth;

use App\Classes\BaseModel;
use App\Traits\HasCode;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PermissionGroup extends BaseModel
{
    use HasCode;

    ### Настройки
    ##################################################
    protected $table = 'auth__permission_groups';

    protected $fillable = [
        'code',
        'name',
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, 'group_id');
    }
}
