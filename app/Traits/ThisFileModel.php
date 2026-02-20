<?php

namespace App\Traits;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

trait ThisFileModel
{
    ### Настройки
    ##################################################
    protected function disk(): Attribute
    {
        return new Attribute(
            get: fn() => $this->file->disk,
        );
    }

    protected function path(): Attribute
    {
        return new Attribute(
            get: fn() => $this->file->path,
        );
    }

    protected function name(): Attribute
    {
        return new Attribute(
            get: fn() => $this->file->name,
        );
    }

    protected function origin_name(): Attribute
    {
        return new Attribute(
            get: fn() => $this->file->origin_name,
        );
    }

    protected function errors(): Attribute
    {
        return new Attribute(
            get: fn() => $this->file->errors,
        );
    }

    protected function mime(): Attribute
    {
        return new Attribute(
            get: fn() => Storage::disk($this->disk)->mimeType($this->getLocalPath())
        );
    }

    protected function hasToStorage(): Attribute
    {
        return new Attribute(
            get: fn() => $this->file->hasToStorage,
        );
    }

    public static function boot()
    {
        parent::boot();

        self::deleted(function ($model) {
            $model->file->delete();
        });
    }

    ### Методы
    ##################################################
    public function getLocalPath()
    {
        return $this->path !== ''
            ? $this->path . '/' . $this->file->name
            : $this->file->name;
    }

    public function getFullPath()
    {
        return Storage::disk($this->disk ?? 'local')->path($this->getLocalPath());
    }

    public function setContent(string $content)
    {
        return Storage::disk($this->disk ?? 'local')->put($this->getLocalPath(), $content);
    }

    public function getContent()
    {
        return Storage::disk($this->disk ?? 'local')->get($this->getLocalPath());
    }

    public function addError(string $error)
    {
        $errors = $this->errors;
        $errors[] = $error;
        $this->errors = $errors;

        return $this;
    }

    public function deleteFromStorage(): self
    {
        Storage::disk($this->disk)->delete($this->path . '/' . $this->name);

        return $this;
    }

    ### Связи
    ##################################################
    public function file(): HasOne
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }

    public function uploaded(): BelongsTo
    {
        return $this->file->belongsTo(User::class, 'upload_at');
    }
}
