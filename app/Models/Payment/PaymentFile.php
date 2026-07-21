<?php

namespace App\Models\Payment;

use App\Classes\FileModel;
use App\Models\Administrate\Bank;
use App\Models\Administrate\Division;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentFile extends FileModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'payment__payment_files';

    protected $fillable = [
        'file_id',
        'bank_id',
        'event_id',
        'division_id',
    ];

    public static string|null $storage_file_disk = 'payments';
    public static string|null $storage_file_path = 'payment-files';
    public static string|null $channel = 'payment.payment-files';

    protected function casts(): array
    {
        return [
            'amount' => 'float',
        ];
    }

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function recipients(): HasMany
    {
        return $this->hasMany(Recipient::class, 'file_id');
    }
}
