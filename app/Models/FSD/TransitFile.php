<?php

namespace App\Models\FSD;

use App\Classes\FileModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransitFile extends FileModel
{
    ### Настройки
    ##################################################
    protected $table = 'fsd__transit_files';

    protected $fillable = [
        'file_id',
        'date_start',
        'date_end',
    ];

    protected function casts(): array
    {
        return [
            'date_start' => 'date',
            'date_end' => 'date',
        ];
    }

    public string|null $StorageFileDisk = 'fsd';
    public string|null $StorageFilePath = 'transit';

    ### Связи
    ##################################################
    public function recipients(): HasMany
    {
        return $this->hasMany(TransitRecipient::class, 'file_id');
    }
}
