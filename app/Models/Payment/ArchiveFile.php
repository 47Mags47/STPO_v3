<?php

namespace App\Models\Payment;

use App\Classes\FileModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArchiveFile extends FileModel
{
    ### Настройки
    ##################################################
    protected $table = 'payment__archive_files';

    protected $fillable = [
        'file_id',
        'archive_id',
        'npp'
    ];

    public static string|null $storage_file_disk = 'temp';

    ### Связи
    ##################################################
    public function archive(): BelongsTo
    {
        return $this->belongsTo(Archive::class, 'archive_id');
    }
}
