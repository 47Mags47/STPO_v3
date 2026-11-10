<?php

namespace App\Models\Auth;

use App\Classes\BasePivotModel;
use App\Models\Administrate\Division;
use App\Models\Base\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPermission extends BasePivotModel
{
    ### Настройки
    ##################################################
    protected $table = 'auth__user_pivot_permission';

    protected $fillable = [
        'user_id',
        'permission_id',
        'division_id'
    ];

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
