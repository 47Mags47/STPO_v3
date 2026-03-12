<?php

namespace App\Models\FSD;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    public $timestamps = false;

    protected $table = 'fsd__payments';

    protected $fillable = [
        'raport_date',
        'type_number',
        'type_name',
        'amount',
        'amount_other',
        'start_date',
        'end_date',
        'file_id',
        'recipient_id',
        'SNILS',
    ];

    ### Связи
    ##################################################
    public function PaymentFile(): BelongsTo{
        return $this->belongsTo(PaymentFile::class, 'file_id');
    }
}
