<?php

namespace App\Models\Veteran;

use App\Classes\BaseModel;
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
        'report_id'
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
}
