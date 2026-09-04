<?php

namespace App\Models\Payment;

use App\Classes\FileModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankRaportFile extends FileModel
{
    ### Настройки
    ##################################################
    protected $table = 'payment__bank_raport_files';

    protected $fillable = [
        'file_id',
        'raport_id',
        'npp'
    ];

    public static string|null $storage_file_disk = 'temp';

    ### Связи
    ##################################################
    public function raport(): BelongsTo
    {
        return $this->belongsTo(BankRaport::class, 'raport_id');
    }
}
