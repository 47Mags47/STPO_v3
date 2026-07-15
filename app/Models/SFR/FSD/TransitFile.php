<?php

namespace App\Models\SFR\FSD;

use App\Classes\FileModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransitFile extends FileModel
{
    ### Настройки
    ##################################################
    protected $table = 'sfr__fsd__transit_files';

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

    public static string|null $storage_file_disk = 'fsd';
    public static string|null $storage_file_path = 'transit';
    public static string|null $channel = 'sfr.fsd.transit-files';

    ### Связи
    ##################################################
    public function recipients(): HasMany
    {
        return $this->hasMany(TransitRecipient::class, 'file_id');
    }
}
