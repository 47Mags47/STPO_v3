<?php

namespace App\Models\Appeal;

use App\Classes\BaseModel;
use App\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThemGroup extends BaseModel
{
    use HasFactory, HasCode;

    ### Настройки
    ##################################################
    protected $table = 'appeal__them_groups';

    protected $fillable = [
        'code',
        'name',
    ];

    ### Связи
    ##################################################
    public function thems(): HasMany
    {
        return $this->hasMany(Them::class, 'group_id');
    }
}
