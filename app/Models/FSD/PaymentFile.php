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
        'in_month',
        'file_id',
        'type_id'
    ];

    public string|null $StorageFileDisk = 'fsd';
    public string|null $StorageFilePath = 'payment';


    protected function casts(): array
    {
        return [
            'in_month' => 'date',
        ];
    }

    ### Связи
    ##################################################
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'file_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class, 'type_id');
    }
}
