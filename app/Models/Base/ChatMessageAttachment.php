<?php

namespace App\Models\Base;

use App\Classes\FileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatMessageAttachment extends FileModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'base__chat_attachments';

    protected $fillable = [
        'is_image',
        'message_id',
        'file_id'
    ];
}
