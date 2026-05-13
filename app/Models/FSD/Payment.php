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
        'first_name',
        'last_name',
        'middle_name',
        'amount',
        'SNILS',
        'file_id',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            // Проверка на наличие дубликата в файле
            if (self::query()
                ->where('SNILS', $model->SNILS)
                ->where('amount', $model->amount)
                ->where('file_id', $model->file_id)
                ->exists()
            )
                return false;

            // Проверка на наличие дубликата в рамках месяца
            if (self::query()
                ->where('SNILS', $model->SNILS)
                ->where('amount', $model->amount)
                ->whereHas('PaymentFile', fn($query) => $query->where('in_month', $model->PaymentFile->in_month))
                ->exists()
            )
                return false;
        });
    }

    ### Связи
    ##################################################
    public function PaymentFile(): BelongsTo
    {
        return $this->belongsTo(PaymentFile::class, 'file_id');
    }
}
