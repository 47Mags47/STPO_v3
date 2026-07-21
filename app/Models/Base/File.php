<?php

namespace App\Models\Base;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class File extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'base__files';

    protected $fillable = [
        'disk',
        'path',
        'name',
        'origin_name',
        'is_disabled',
        'status_id',
    ];

    protected function casts(): array
    {
        return [
            'is_disabled' => 'boolean',
        ];
    }

    ### Методы модели
    ##################################################
    public static function createChildren(string $model, ?array $attributes = [])
    {
        $fileAttributes = array_intersect_key($attributes, array_flip(new self()->getFillable()));
        $childAttributes = array_intersect_key($attributes, array_flip(new $model()->getFillable()));

        $fileModel = self::factory()->create(array_merge([
            'disk' => $model::$storage_file_disk,
            'path' => $model::$storage_file_path,
        ], $fileAttributes));

        return $model::create(array_merge([
            'file_id' => $fileModel->id,
        ], $childAttributes));
    }

    /**
     * Adds an error to the record
     * @param string $error
     */
    public function addError(string $error): self
    {
        $error = str_replace(PHP_EOL, '', trim($error));

        $this->errors()->create(
            ['error' => $error]
        );

        return $this;
    }

    ### Методы хранилища
    ##################################################
    /**
     * Return local path
     * @return string
     */
    public function getLocalPath(): string
    {
        return $this->path !== null
            ? $this->path . '/' . $this->name
            : $this->name;
    }

    /**
     * Return full path
     * @return string
     */
    public function getFullPath(): string
    {
        return Storage::disk($this->disk)->path($this->getLocalPath());
    }

    /**
     * Moves the file to the file storage
     *
     * @param  ?string  $newDisk
     * @param  ?string  $newPath
     * @param  ?string  $newName
     * @return bool
     */
    public function move(?string $newName = null, ?string $newPath = null, ?string $newDisk = null): bool
    {
        $from_path = $this->getFullPath();

        $newName = $newName ?? $this->name;
        $newPath = $newPath ?? $this->path;
        $newDisk = $newDisk ?? $this->disk;

        $toPath = Storage::disk($newDisk)->path($newPath !== null ? ($newPath . '/' . $newName) : $newName);

        return Storage::move($from_path, $toPath);
    }

    /**
     * Adds a line to the file
     *
     * @param  ?string  $content
     * @return bool
     */
    public function write(string $content): bool
    {
        return Storage::disk($this->disk)->put($this->getLocalPath(), $content);
    }

    public function download(): StreamedResponse{
        return Storage::disk($this->disk)->download($this->getLocalPath(), $this->origin_name);
    }

    /**
     * get file content
     * @return string
     */
    public function getContent(): string
    {
        return Storage::disk($this->disk)->get($this->getLocalPath());
    }

    ### Связи
    ##################################################
    public function status(): BelongsTo
    {
        return $this->belongsTo(FileStatus::class, 'status_id');
    }

    public function errors(): HasMany
    {
        return $this->hasMany(FileError::class, 'file_id');
    }
}
