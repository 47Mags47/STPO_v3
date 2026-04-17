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
        'amount',
        'SNILS',
        'file_id',
    ];

    ### Связи
    ##################################################
    public function PaymentFile(): BelongsTo{
        return $this->belongsTo(PaymentFile::class, 'file_id');
    }
}
