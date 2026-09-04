<?php

namespace App\Models\Base;

use App\Classes\BaseModel;
use App\Models\Base\NotificationType;
use App\Models\Base\User;
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
        'sender_id',
        'is_readed',
        'context',
    ];

    protected function casts(): array
    {
        return [
            'is_readed' => 'boolean',
            'context'   => 'array',
        ];
    }

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    public function type()
    {
        return $this->belongsTo(NotificationType::class);
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
