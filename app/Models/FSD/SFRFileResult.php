<?php

namespace App\Models\FSD;

use App\Classes\FileModel;

class SFRFileResult extends FileModel
{
    ### Настройки
    ##################################################
    protected $table = 'fsd__sfr_file_results';

    protected $fillable = [
        'file_id'
    ];

    public string|null $StorageFileDisk = 'fsd';
    public string|null $StorageFilePath = 'output';

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    //
}
