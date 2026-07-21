<?php

namespace App\Models\Payment;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipient extends BaseModel
{
    /** @use HasFactory<\Database\Factories\Payment\RecipientFactory> */
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'payment__recipients';

    public $timestamps = false;

    protected $fillable = [
        'file_id',
        'first_name',
        'last_name',
        'middle_name',
        'd_rojd',
        'SNILS',
        'account',
        'amount',
        'p_series',
        'p_number',
        'p_date',
        'p_div',
    ];

    ### Связи
    ##################################################
    public function paymentFile(): BelongsTo
    {
        return $this->belongsTo(PaymentFile::class, 'file_id');
    }
}
