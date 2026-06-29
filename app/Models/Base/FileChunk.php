<?php

namespace App\Models\Base;

use App\Classes\FileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileChunk extends FileModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'base__file_chunks';

    protected $fillable = [
        'upload_file_id',
        'file_id',
        'uploaded',
        'npp',
    ];

    protected function casts(): array
    {
        return [
            'uploaded' => 'bool',
        ];
    }

    public static string|null $storage_file_disk = 'uploads';
    public static string|null $storage_file_path = 'chunks';

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    public function uploadFile(): BelongsTo
    {
        return $this->belongsTo(UploadFile::class, 'upload_file_id');
    }
}
