<?php

namespace App\Models\Base;

use App\Classes\FileModel;
use App\Jobs\Base\MoveUploadFileJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class UploadFile extends FileModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'base__file_uploads';

    protected $fillable = [
        'file_id',
        'totalChunks',
    ];

    public static string|null $storage_file_disk = 'uploads';
    public static string|null $storage_file_path = 'files';
    public static bool $deleteInStorage = false;

    ### Методы
    ##################################################
    public static function moveToModel(
        string $uploadFileId,
        string $modelClass,
        ?array $attributes = []
    ): FileModel {
        $uploadFile = UploadFile::find((int) $uploadFileId);

        if ($uploadFile === null)
            abort(404);

        if (!(new $modelClass() instanceof FileModel))
            abort(404);

        $model = $modelClass::create(array_merge($attributes, [
            'file_id'       => $uploadFile->file->id,
        ]));

        MoveUploadFileJob::dispatch($uploadFile, $model);

        return $model;
    }

    public static function emptyFile(): self
    {
        if (!Storage::disk('uploads')->has('empty'))
            Storage::disk('uploads')->put('empty', '');

        if (File::where('origin_name', 'empty')->count() == 0)
            File::factory()->create([
                'disk'          => 'uploads',
                'path'          => '',
                'name'          => 'empty',
                'origin_name'   => 'empty',
                'is_disabled'   => false,
                'status_id'     => FileStatus::byCode('ok'),
            ]);

        $file = File::where('origin_name', 'empty')->get()->first();
        if(self::where('file_id', $file->id)->count() == 0)
            self::create([
                'file_id' => $file->id,
                'totalChunks' => 1
            ]);

        return self::where('file_id', $file->id)->get()->first();
    }

    ### Связи
    ##################################################
    public function chunks(): HasMany
    {
        return $this->hasMany(FileChunk::class, 'upload_file_id')->orderBy('npp');
    }
}
