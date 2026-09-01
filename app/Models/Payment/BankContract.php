<?php

namespace App\Models\Payment;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankContract extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'payment__bank_contracts';

    protected $fillable = [
        'number',
        'signed_at',
        'bank_id',
        'template_id',
    ];

    protected function casts(): array
    {
        return [
            'signed_at' => 'date',
        ];
    }

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    //
}
