<?php

namespace App\Models\Appeal;

use App\Classes\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends BaseModel
{
    ### Настройки
    ##################################################
    protected $table = 'appeal__messages';

    protected $fillable = [
        'message',
        'readed',
        'appeal_id',
        'sender_id',
    ];

    protected function casts(): array
    {
        return [
            'readed' => 'boolean',
        ];
    }

    ### Связи
    ##################################################
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(MessageFile::class, 'message_id');
    }
}
