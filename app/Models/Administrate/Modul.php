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
        // Если для модуля не указаны требуемые права - возвращаем true
        if($this->permissions()->count() === 0)
            return true;

        $intersectPermissions = user()->permissions->intersect($this->permissions);

        // Проверяем наличие прав без привязки к территории
        // Если есть - возвращаем true
        $flag = true;
        foreach ($intersectPermissions as $permission) {
            if($permission->pivot->division_id !== null)
                $flag = false;
        }
        if($flag)
            return true;

        // Проверяем права с привязкой к территории
        $flag = false;
        foreach ($intersectPermissions as $permission) {
            if($permission->pivot->division_id === user()->getCurrentDivision()->id)
                $flag = true;
        }

        return $flag;
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
