<?php

namespace App\Models\Appeal;

use App\Classes\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appeal extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'appeal__appeals';

    protected $fillable = [
        'office',
        'comment',
        'sender_id',
        'status_id',
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
        return $this->belongsTo(Them::class, 'them_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'appeal_id');
    }
}
