<?php

namespace App\Models\SFR\FSD;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ASPPaymentCategory extends BaseModel
{
    ### Настройки
    ##################################################
    protected $table = 'sfr__fsd__asp_payment_categories';

    protected $fillable = [
        'name',
        'sfr_payment_category_id',
    ];

    ### Связи
    ##################################################
    public function SFRCategory(): BelongsTo
    {
        return $this->belongsTo(SFRPaymentCategory::class, 'sfr_payment_category_id');
    }
}
