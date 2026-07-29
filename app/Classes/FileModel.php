<?php

namespace App\Classes;

use App\Events\Base\FileChangeStatusEvent;
use App\Models\Base\File;
use App\Models\Base\FileStatus;
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
        self::creating(function($model){
            if($model::$createInStorage && $model->file_id === null){
                $model->file_id = File::factory()->create([
                    'disk' => self::$storage_file_disk,
                    'path' => self::$storage_file_path,
                ])->id;
            }

            return $model;
        });

        self::deleted(function ($model) {
            if($model::$deleteInStorage)
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

    ### Методы
    ##################################################
    /**
     * Return local path
     * @return string
     */
    public function getLocalPath(): string
    {
        return $this->file->getLocalPath();
    }

    /**
     * Return full path
     * @return string
     */
    public function getFullPath(): string
    {
        return $this->file->getFullPath();
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
     * Adds an error to the record
     * @param string $error
     */
    public function addError(string $error): self
    {
        $this->file->addError($error);

        return $this;
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
    public function download(): StreamedResponse {
        return $this->file->download();
    }

    /**
     * Set file status
     *
     * @param FileStatus|string $status
     * @return bool
     */
    public function setStatus(FileStatus|string $status): bool{
        if(is_string($status))
            $status = FileStatus::byCode($status);

        $is_updated = $this->file->update([
            'status_id' => $status->id,
        ]);

        if($is_updated === false)
            return false;

        if($this::$channel !== null)
            FileChangeStatusEvent::dispatch($this);

        return true;
    }

    /**
     * Set file disabled
     *
     * @param bool $disabled
     * @return bool
     */
    public function setDisabled(bool $disabled = true): bool{
        return $this->file->update([
            'is_disabled' => $disabled,
        ]);
    }

    ### Связи
    ##################################################
    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
