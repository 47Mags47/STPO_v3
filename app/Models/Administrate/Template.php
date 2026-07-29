<?php

namespace App\Models\Administrate;

use App\Classes\FileModel;

class Template extends FileModel
{
    ### Настройки
    ##################################################
    protected $table = 'administrate__templates';

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
