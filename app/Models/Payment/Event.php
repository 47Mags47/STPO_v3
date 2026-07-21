<?php

namespace App\Models\Payment;

use App\Classes\BaseModel;
use App\Models\Administrate\Bank;
use App\Models\Administrate\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

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

    public function paymentFiles(): HasMany
    {
        return $this->hasMany(PaymentFile::class, 'event_id')->orderBy('created_at', 'desc');
    }

    public function raportsToBank(Bank $bank): HasMany
    {
        return $this->hasMany(RaportToBank::class, 'event_id')->where('bank_id', $bank->id)->orderBy('id', 'desc');
    }
}
