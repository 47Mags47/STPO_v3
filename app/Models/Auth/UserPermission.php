<?php

namespace App\Models\Auth;

use App\Classes\BasePivotModel;
use App\Models\Administrate\Division;
use App\Models\Base\Notification;
use App\Models\Base\NotificationType;
use App\Models\Base\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPermission extends BasePivotModel
{
    ### Настройки
    ##################################################
    protected $table = 'auth__user_pivot_permission';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'permission_id',
        'division_id'
    ];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    public static function booted()
    {
        self::created(function ($model) {
            $message = 'Вам добавлено право "' . $model->permission->name . '"';
            if($model->division_id !== null)
                $message .= ' для организации ' . $model->division->name;

            Notification::factory()->create([
                'type_id' => NotificationType::byCode('info'),
                'message' => $message,
                'is_system' => true,
                'recipient_id' => $model->user_id
            ]);
        });

        self::deleted(function ($model) {
            $message = 'Для вас удалено право "' . $model->permission->name . '"';
            if($model->division_id !== null)
                $message .= ' для организации ' . $model->division->name;

            Notification::factory()->create([
                'type_id' => NotificationType::byCode('info'),
                'message' => $message,
                'is_system' => true,
                'recipient_id' => $model->user_id
            ]);
        });
    }

    ### Связи
    ##################################################
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'division_id');
    }
}
