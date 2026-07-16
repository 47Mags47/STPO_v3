<?php

namespace App\Models\SFR\FSD;

use App\Classes\FileModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultFile extends FileModel
{
    ### Настройки
    ##################################################
    protected $table = 'sfr__fsd__result_files';

    protected $fillable = [
        'sfr_file_id',
        'file_id',
    ];

    public static string|null $storage_file_disk = 'fsd';
    public static string|null $storage_file_path = 'output';
    public static string|null $channel = 'sfr.fsd.result-files';

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    public function SFRFile(): BelongsTo{
        return $this->belongsTo(SFRFile::class, 'sfr_file_id');
    }
}
