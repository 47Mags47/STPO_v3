<?php

namespace App\Models\Veteran;

use App\Classes\BaseModel;
use App\Models\Administrate\Division;
use App\Models\Base\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'veteran__reports';

    protected $fillable = [
        'all',
        'online',
        'MFC',

        'user_id',
        'division_id',
        'date_id',
    ];

    ### Связи
    ##################################################
    public function date(): BelongsTo
    {
        return $this->belongsTo(Date::class, 'date_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'division_id');
    }
}
