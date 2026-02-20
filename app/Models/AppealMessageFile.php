<?php

namespace App\Models;

use App\Classes\BaseModel;
use App\Traits\ThisFileModel;

class AppealMessageFile extends BaseModel
{
    use ThisFileModel;

    ### Настройки
    ##################################################
    protected $table = 'appeal__message_file';

    protected $fillable = [
        'message_id',
        'file_id'
    ];
}
