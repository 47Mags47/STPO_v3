<?php

namespace App\Models\Base;

use App\Classes\BaseModel;
use App\Events\Base\SendNotificationEvent;
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
        'message',
        'context',
        'is_readed',
        'recipient_id',
        'sender_id',
        'type_id',
    ];

    protected function casts(): array
    {
        return [
            'context'   => 'array',
            'is_readed' => 'boolean',
            'is_system' => 'boolean',
        ];
    }

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    public static function booted()
    {
        self::created(function ($model) {
            broadcast(new SendNotificationEvent($model));
        });
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
