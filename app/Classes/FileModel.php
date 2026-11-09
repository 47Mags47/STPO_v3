<?php

namespace App\Classes;

use App\Events\Base\FileChangeStatusEvent;
use App\Models\Base\File;
use App\Models\Base\FileStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Symfony\Component\HttpFoundation\StreamedResponse;

abstract class FileModel extends BaseModel
{
    ### Настройки
    ##################################################
    public static string|null $storage_file_disk = 'local';
    public static string|null $storage_file_path = '';
    public static string|null $channel = null;

    public static bool $deleteInStorage = true;
    public static bool $createInStorage = true;

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    public static function booted()
    {
        self::creating(function ($model) {
            if ($model->file_id === null){
                $file = File::createFromChildren($model::class);
                $model->file_id = $file->id;
                $model->setRelation('file', $file);
            }

            if ($model::$createInStorage && !$model->hasInStorage())
                $model->write('');
            return $model;
        });

        self::deleted(function ($model) {
            if ($model::$deleteInStorage)
                $model->file->delete();
        });
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return ($key !== 'id' and in_array($key, new File()->getFillable()))
            ? $this->file->getAttribute($key)
            : $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function __set($key, $value)
    {
        if (in_array($key, new File()->getFillable()))
            $this->file->setAttribute($key, $value);
        else
            parent::setAttribute($key, $value);
    }

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = [])
    {
        $parent_flag = $this->file?->save();
        $child_flag = parent::save($options);

        return $parent_flag and $child_flag;
    }

    ### Аттрибуты
    ##################################################
    /**
     * Return local path
     * @return Attribute
     */
    protected function localPath(): Attribute
    {
        return new Attribute(
            get: fn() => $this->file->localPath,
        );
    }

    /**
     * Return full path
     * @return Attribute
     */
    protected function fullPath(): Attribute
    {
        return new Attribute(
            get: fn() => $this->file->fullPath,
        );
    }

    ### Методы модели
    ##################################################
    /**
     * Adds an error to the record
     * @param string $error
     */
    public function addError(string $error): self
    {
        $this->file->addError($error);

        return $this;
    }

    /**
     * Set file status
     *
     * @param FileStatus|string $status
     * @return bool
     */
    public function setStatus(FileStatus|string $status): bool
    {
        $result = $this->file->setStatus($status);

        if($result and $this::$channel !== null)
            FileChangeStatusEvent::dispatch($this);

        return $result;
    }

    /**
     * Set file disabled
     *
     * @param bool $disabled
     * @return bool
     */
    public function setDisabled(bool $disabled = true): bool
    {
        return $this->file->setDisabled($disabled);
    }

    ### Методы хранилища
    ##################################################
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
        return $this->file->move($newName, $newPath, $newDisk);
    }

    /**
     * Adds a line to the file
     *
     * @param  ?string  $content
     * @return bool
     */
    public function write(string $content, ?string $encoding = 'UTF-8'): bool
    {
        return $this->file->write($content, $encoding);
    }

    /**
     * Return download response
     *
     * @return StreamedResponse
     */
    public function download(): StreamedResponse
    {
        return $this->file->download();
    }

    /**
     * get file content
     * @return string
     */
    public function getContent(): string
    {
        return $this->file->getContent();
    }

    /**
     * Check file exist in storage
     * @return bool
     */
    public function hasInStorage(): bool
    {
        return $this->file->hasInStorage();
    }

    ### Связи
    ##################################################
    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
