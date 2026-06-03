<?php

namespace App\Models\Base;

use App\Classes\BaseModel;

class FileError extends BaseModel
{
    ### Настройки
    ##################################################
    protected $table = 'base__file_errors';

    public $timestamps = false;

    protected $fillable = [
        'file_id',
        'error'
    ];
}
