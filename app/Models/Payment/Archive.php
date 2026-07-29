<?php

namespace App\Models\Payment;

use App\Classes\FileModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Archive extends FileModel
{
    ### Настройки
    ##################################################
    protected $table = 'payment__archives';

    protected $fillable = [
        'file_id',
        'event_id',
    ];

    public static string|null $storage_file_disk = 'payments';
    public static string|null $storage_file_path = 'archives-to-bank';
    public static string|null $channel = 'payment.archives';

    ### Связи
    ##################################################
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function paymentFiles(): HasMany
    {
        return $this->hasMany(PaymentFile::class, 'raport_id');
    }
}
