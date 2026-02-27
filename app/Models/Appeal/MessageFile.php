<?php

namespace App\Models\Appeal;

use App\Classes\BaseModel;
use App\Traits\ThisFileModel;

class MessageFile extends BaseModel
{
    use ThisFileModel;

    ### Настройки
    ##################################################
    protected $table = 'appeal__message_files';

    protected $fillable = [
        'message_id',
        'file_id'
    ];
}
