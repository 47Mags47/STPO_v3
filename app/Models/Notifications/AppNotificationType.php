<?php

namespace App\Models\Notifications;

use App\Classes\BaseModel;

class AppNotificationType extends BaseModel
{
    //

    ### Настройки
    ##################################################
    protected $table = '';

    protected $fillable = ['code', 'name', 'status_id', 'status'];

    ### Методы
    ##################################################
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    ### Связи
    ##################################################
    //
}
