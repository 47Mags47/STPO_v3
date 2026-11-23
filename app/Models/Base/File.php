<?php

namespace App\Models\Base;

use App\Classes\BaseModel;
use App\Classes\FileModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class File extends BaseModel
{
    use HasFactory, SoftDeletes;

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

    public static function booted()
    {
        self::deleting(function ($model) {
            Storage::disk($model->disk)->delete($model->localPath);
        });
    }

    ### Аттрибуты
    ##################################################
    protected function mime(): Attribute
    {
        return Attribute::make(
            get: fn() => Storage::disk($this->disk)->mimeType($this->localPath)
        );
    }

    /**
     * Return local path
     * @return Attribute
     */
    protected function localPath(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->path !== null
                ? $this->path . '/' . $this->name
                : $this->name,
        );
    }

    /**
     * Return full path
     * @return Attribute
     */
    protected function fullPath(): Attribute
    {
        return Attribute::make(
            get: fn() => Storage::disk($this->disk)->path($this->localPath),
        );
    }

    ### Методы модели
    ##################################################
    /**
     * Создаёт File и дочернюю модель, проставляя file_id.
     *
     * @param class-string $ownerClass Класс модели-владельца
     * @param array<mixed> $attributes Атрибуты, распределённые между File и владельцем
     * @return FileModel Экземпляр модели-владельца
     */
    public static function createAndLinkToOwner(string $ownerClass, ?array $attributes = []): FileModel
    {
        return DB::transaction(function () use ($ownerClass, $attributes) {
            $fillable = array_flip((new self())->getFillable());
            $childAttributes = array_intersect_key($attributes, $fillable);

            $fileModel = self::createForOwner($ownerClass, $attributes);

            return $ownerClass::create(array_merge([
                'file_id' => $fileModel->id,
            ], $childAttributes));
        });
    }

    /**
     * Создаёт File, подставляя disk/path из класса-владельца.
     *
     * @param class-string $ownerClass Класс модели-владельца
     * @param array<mixed> $attributes Атрибуты File
     * @return self
     */
    public static function createForOwner(string $ownerClass, ?array $attributes = []): self
    {
        $fillable = array_flip((new self())->getFillable());
        $fileAttributes = array_intersect_key($attributes, $fillable);

        $fileModel = self::factory()->create(array_merge([
            'disk' => $ownerClass::$storage_file_disk,
            'path' => $ownerClass::$storage_file_path,
        ], $fileAttributes));

        return $fileModel;
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

    /**
     * Set file status
     *
     * @param FileStatus|string $status
     * @return bool
     */
    public function setStatus(FileStatus|string $status): bool
    {
        if (is_string($status))
            $status = FileStatus::byCode($status);

        $is_updated = $this->update([
            'status_id' => $status->id,
        ]);

        if ($is_updated === false)
            return false;

        return true;
    }

    /**
     * Set file disabled
     *
     * @param bool $disabled
     * @return bool
     */
    public function setDisabled(bool $disabled = true): bool
    {
        return $this->update([
            'is_disabled' => $disabled,
        ]);
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
        $from_path = $this->fullPath;

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
    public function write(string $content, ?string $encoding = 'UTF-8'): bool
    {
        return Storage::disk($this->disk)->put($this->localPath, $encoding === 'UTF-8' ? $content : mb_convert_encoding($content, $encoding, 'UTF-8'));
    }

    /**
     * download file
     * @return StreamedResponse
     */
    public function download(): StreamedResponse
    {
        return Storage::disk($this->disk)->exists($this->localPath)
            ? Storage::disk($this->disk)->download($this->localPath, $this->origin_name)
            : abort(404);
    }

    /**
     * get file content
     * @return string
     */
    public function getContent(): string
    {
        return Storage::disk($this->disk)->get($this->localPath);
    }

    /**
     * Check file exist in storage
     * @return bool
     */
    public function hasInStorage(): bool
    {
        return Storage::disk($this->disk)->has($this->localPath);
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
