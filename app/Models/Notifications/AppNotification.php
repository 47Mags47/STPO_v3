<?php

namespace App\Models\Notifications;

use App\Classes\BaseModel;

class AppNotification extends BaseModel
{
    //

    ### Настройки
    ##################################################
    protected $table = 'notifications';

    protected $fillable = [
        'recipient_id',
        'type_id',
        'message',
        'readed'
    ];

    protected $casts = [
        'readed' => 'boolean'
    ];

    ### Методы
    ##################################################
    public function type()
    {
        return $this->belongsTo(NotificationType::class);
    }

    ### Связи
    ##################################################
    //
}
