<?php

namespace App\Models;

use App\Classes\BaseModel;
use App\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModulGroup extends BaseModel
{
    use HasFactory, HasCode;

    ### Настройки
    ##################################################
    protected $table = 'base__modul_groups';

    protected $fillable = [
        'code',
        'name',
    ];

    ### Связи
    ##################################################
    public function moduls(): HasMany
    {
        return $this->hasMany(Modul::class, 'group_id');
    }
}
