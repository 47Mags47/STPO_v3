<?php

namespace App\Models\Administrate;

use App\Classes\BaseModel;
use App\Models\Auth\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Modul extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'administrate__modules';

    protected $fillable = [
        'name',
        'route_name',
        'group_id',
        'in_production',
    ];

    ### Методы
    ##################################################
    public function hasAccess(): bool
    {
        return $this->permissions()->count() > 0
            ? $this->permissions->intersect(user()->permissions)->count() > 0
            : true;
    }

    ### Связи
    ##################################################
    public function group(): BelongsTo
    {
        return $this->belongsTo(ModulGroup::class, 'group_id');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'administrate__module_pivot_permission', 'modul_id', 'permission_id');
    }
}
