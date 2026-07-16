<?php

namespace App\Models\Payment;

use App\Classes\BaseModel;
use App\Models\Administrate\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'payment__events';

    protected $fillable = [
        'in_day',
        'payment_id'
    ];

    protected function casts(): array
    {
        return [
            'in_day' => 'date',
        ];
    }

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}
