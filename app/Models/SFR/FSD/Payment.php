<?php

namespace App\Models\SFR\FSD;

use App\Classes\BaseModel;
use App\Models\Administrate\FinancingType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    public $timestamps = false;

    protected $table = 'sfr__fsd__payments';

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'amount',
        'SNILS',
        'asp_payment_category_id',
        'financing_type_id',
        'file_id',
    ];

    ### Связи
    ##################################################
    public function ASPPaymentCategory(): BelongsTo
    {
        return $this->belongsTo(ASPPaymentCategory::class, 'asp_payment_category_id');
    }

    public function financingType(): BelongsTo
    {
        return $this->belongsTo(FinancingType::class, 'financing_type_id');
    }

    public function paymentFile(): BelongsTo
    {
        return $this->belongsTo(PaymentFile::class, 'file_id');
    }
}
