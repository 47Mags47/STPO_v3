<?php

namespace App\Models\Base;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

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
        'upload_at',
        'status_id',
    ];

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
    public function addError(string $error): bool
    {
        $errors = $this->errors;

        return $this->update(array_merge($errors, [$error]));
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

    ### Связи
    ##################################################


    // ### Методы
    // ##################################################
    // public function deleteInStorage(){
    //     return Storage::disk($this->disk)->delete($this->path . '/' . $this->name);
    // }

    // public function addError(string $error){
    //     $this->errors()->create(['error' => $error]);
    // }

    // ### Аттрибуты
    // ##################################################
    // protected function hasToStorage(): Attribute
    // {
    //     return new Attribute(
    //         get: fn() => Storage::disk($this->disk)->has($this->path . '/' . $this->name),
    //     );
    // }

    // ### Связи
    // ##################################################
    // public function status(): BelongsTo
    // {
    //     return $this->belongsTo(FileStatus::class, 'status_id');
    // }

    // public function errors(): HasMany
    // {
    //     return $this->hasMany(FileError::class, 'file_id');
    // }
}
