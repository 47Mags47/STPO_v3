<?php

namespace App\Models\FSD;

use App\Classes\FileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SFRFile extends FileModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'fsd__sfr_files';

    protected $fillable = [
        'in_date',
        'file_id',

        'date_start',
        'date_end',
    ];

    protected function casts(): array
    {
        return [
            'in_date'       => 'date',
            'date_start'    => 'date',
            'date_end'      => 'date',
        ];
    }

    public static string|null $storage_file_disk = 'fsd';
    public static string|null $storage_file_path = 'sfr';
}
