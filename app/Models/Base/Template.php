<?php

namespace App\Models\Base;

use App\Classes\FileModel;

class Template extends FileModel
{
    ### Настройки
    ##################################################
    protected $table = 'base__templates';

    protected $fillable = [
        'writer',
        'description',
        'file_id',
    ];

    public static string|null $storage_file_disk = 'templates';
    public static string|null $storage_file_path = 'payment';
    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    //
}
