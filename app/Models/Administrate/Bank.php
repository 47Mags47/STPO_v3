<?php

namespace App\Models\Administrate;


use App\Classes\BaseModel;
use App\Models\Administrate\Template;
use App\Models\Payment\BankContract;
use App\Models\Payment\PaymentFile;
use App\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Bank extends BaseModel
{
    use HasCode, HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'administrate__banks';

    protected $fillable = [
        'code',
        'name',
        'number'
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    // Payment
    public function payment_paymentFiles(): HasMany
    {
        return $this->hasMany(PaymentFile::class, 'bank_id');
    }

    public function payment_template(): HasOneThrough{
        return $this->hasOneThrough(Template::class, BankContract::class, 'bank_id', 'id', 'id', 'template_id');
    }

    public function payment_contract(): HasOne
    {
        return $this->hasOne(BankContract::class, 'bank_id');
    }
}
