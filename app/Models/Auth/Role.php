<?php

namespace App\Models\Auth;

use App\Classes\BaseModel;
use App\Traits\HasCode;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends BaseModel
{
    use HasCode;

    ### Настройки
    ##################################################
    protected $table = 'auth__roles';

    protected $fillable = [
        'code',
        'name',
    ];

    ### Методы
    ##################################################
    public static function getId(int|string|Role $role)
    {
        switch (gettype($role)) {
            case 'integer':
                return $role;
                break;

            case 'string':
                return Role::byCode($role)->id;
                break;

            case 'object':
                return $role->id;
                break;

            default:
                return false;
                break;
        }
    }

    ### Связи
    ##################################################
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'auth__roles_pivot_permissions');
    }
}
