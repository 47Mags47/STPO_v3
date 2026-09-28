<?php

namespace App\Models\Veteran;

use App\Classes\BaseModel;
use App\Models\Administrate\Division;
use App\Models\Base\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Record extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'veteran__records';

    protected $fillable = [
        'amount',
        'online_form',
        'MFC',
        'report_id',
        'user_id',
        'division_id'
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class, 'report_id');
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
