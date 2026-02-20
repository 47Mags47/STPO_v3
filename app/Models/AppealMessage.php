<?php

namespace App\Models;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AppealMessage extends BaseModel
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
        return $this->hasMany(AppealMessageFile::class, 'message_id');
    }
}
