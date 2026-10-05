<?php

namespace App\Models\Base;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Base\ChatMessage;
use App\Models\Appeal\Appeal;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Chat extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'base__chat';

    protected $fillable = [
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'chat_id');
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'base__chat_subscribers', 'chat_id', 'user_id');
    }

    public function appeal(): HasOne
    {
        return $this->hasOne(Appeal::class, 'chat_id');
    }
}
