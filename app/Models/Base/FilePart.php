<?php

namespace App\Models\Base;

use App\Classes\FileModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FilePart extends FileModel
{
    ### Настройки
    ##################################################
    protected $table = 'base__file_parts';

    protected $fillable = [
        'npp',
        'file_id',
        'parent_id'
    ];

    public array $searchCollumns = [];

    public static string|null $storage_file_disk = 'parts';

    ### Связи
    ##################################################
    public function parent(): BelongsTo
    {
        return $this->belongsTo(File::class, 'parent_id');
    }
}
