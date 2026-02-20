<?php

namespace App\Models;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appeal extends BaseModel
{
    ### Настройки
    ##################################################
    protected $table = 'appeal__appeals';

    protected $fillable = [
        'office',
        'comment',
        'sender_id',
        'them_id',
    ];

    ### Связи
    ##################################################
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function them(): BelongsTo
    {
        return $this->belongsTo(AppealThem::class, 'them_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(AppealMessage::class, 'appeal_id');
    }
}
