<?php

namespace App\Models\Base;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatSubscribers extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'base__chat_subscribers';

    protected $fillable = [
        'chat_id',
        'user_id',
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
