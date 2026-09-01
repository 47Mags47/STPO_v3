<?php

namespace App\Models\Administrate;

use App\Classes\FileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Template extends FileModel
{
    use HasFactory;

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
    public function writeTemplate(){
        dd(new ($this->writer)());
        if($this->writer !== null)
            new ($this->writer)();
    }

    ### Связи
    ##################################################
    //
}
