<?php

namespace App\Models\FSD;

use App\Classes\FileModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SFRFileResult extends FileModel
{
    ### Настройки
    ##################################################
    protected $table = 'fsd__sfr_file_results';

    protected $fillable = [
        'sfr_file_id',
        'file_id',
    ];

    public static string|null $storage_file_disk = 'fsd';
    public static string|null $storage_file_path = 'output';

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    public function SFRFile(): BelongsTo{
        return $this->belongsTo(SFRFile::class, 'sfr_file_id');
    }
}
