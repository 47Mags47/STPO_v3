<?php

namespace App\Models\Payment;

use App\Classes\FileModel;
use App\Models\Administrate\Bank;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BankRaport extends FileModel
{
    ### Настройки
    ##################################################
    protected $table = 'payment__bank_raports';

    protected $fillable = [
        'file_id',
        'bank_id',
        'event_id',
    ];

    public static string|null $storage_file_disk = 'payments';
    public static string|null $storage_file_path = 'raports-to-bank';
    public static string|null $channel = 'payment.raports';

    ### Связи
    ##################################################
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function paymentFiles(): HasMany
    {
        return $this->hasMany(PaymentFile::class, 'raport_id');
    }
}
