<?php

namespace App\Models\Base;

use App\Classes\BaseModel;
use App\Traits\HasCode;

class TemplateType extends BaseModel
{
    use HasCode;

    ### Настройки
    ##################################################
    protected $table = 'base__template_types';

    protected $fillable = [
        'code',
        'name',
    ];
}
