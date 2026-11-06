<?php

namespace App\Models\Appeal;

use App\Classes\BaseModel;
use App\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThemeGroup extends BaseModel
{
    use HasFactory, HasCode;

    ### Настройки
    ##################################################
    protected $table = 'appeal__theme_groups';

    protected $fillable = [
        'code',
        'name',
    ];

    ### Связи
    ##################################################
    public function themes(): HasMany
    {
        return $this->hasMany(Theme::class, 'group_id');
    }
}
