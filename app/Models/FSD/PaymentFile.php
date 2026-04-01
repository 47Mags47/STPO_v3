<?php

namespace App\Models\FSD;

use App\Classes\FileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentFile extends FileModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'fsd__payment_files';

    protected $fillable = [
        'amount',
        'file_id',
        'sfr_file_id',
        'date_start',
        'date_end'
    ];

    public string|null $StorageFileDisk = 'fsd';
    public string|null $StorageFilePath = 'payment';

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    public function SFRFile(): BelongsTo
    {
        return $this->belongsTo(SFRFile::class, 'sfr_file_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'file_id');
    }
}
