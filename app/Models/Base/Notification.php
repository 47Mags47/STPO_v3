<?php

namespace App\Models\Base;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'base__notifications';

    protected $fillable = [
        'recipient_id',
        'type_id',
        'message',
        'is_readed'
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    public function type(): BelongsTo
    {
        return $this->belongsTo(NotificationType::class);
    }
}
