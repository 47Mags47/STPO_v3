<?php

namespace App\Models\Base;

use App\Classes\BaseModel;
use App\Traits\HasCode;

class FileStatus extends BaseModel
{
    use HasCode;

    ### Настройки
    ##################################################
    protected $table = 'base__file_statuses';

    public $timestamps = false;

    protected $fillable = [
        'code',
        'name',
    ];
}
