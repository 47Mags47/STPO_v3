<?php

namespace App\Models\Base;

use App\Classes\BaseModel;
use App\Traits\HasCode;

class TemplateStyle extends BaseModel
{
    use HasCode;

    ### Настройки
    ##################################################
    protected $table = 'base__template_styles';

    protected $fillable = [
        'code',
        'name',
    ];
}
