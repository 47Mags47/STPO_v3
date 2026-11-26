<?php

namespace App\Models\SFR\FSD;

use App\Classes\BaseModel;
use App\Models\Administrate\FinancingType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

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
        'file_in_date',
        'asp_payment_category_id',
        'financing_type_id',
        'file_id',
        'hash'
    ];

    protected function casts(): array
    {
        return [
            'file_in_date' => 'date',
        ];
    }

    protected function fileInDate(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::make($value),
            set: fn (string $value) => Carbon::make($value)->startOfMonth()->format('Y-m-d'),
        );
    }

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
