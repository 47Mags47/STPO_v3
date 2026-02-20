<?php

namespace App\Models;

use App\Classes\BaseModel;
use App\Traits\HasCode;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AppealThemGroup extends BaseModel
{
    use HasCode;

    ### Настройки
    ##################################################
    protected $table = 'appeal__appeal_them_groups';

    protected $fillable = [
        'code',
        'name',
    ];

    ### Связи
    ##################################################
    public function thems(): HasMany
    {
        return $this->hasMany(AppealThem::class, 'group_id');
    }
}
