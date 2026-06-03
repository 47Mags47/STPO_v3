<?php

namespace App\Models\Base;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    ### Методы
    ##################################################
    public function deleteInStorage(){
        return Storage::disk($this->disk)->delete($this->path . '/' . $this->name);
    }

    public function addError(string $error){
        $this->errors()->create(['error' => $error]);
    }

    ### Аттрибуты
    ##################################################
    protected function hasToStorage(): Attribute
    {
        return new Attribute(
            get: fn() => Storage::disk($this->disk)->has($this->path . '/' . $this->name),
        );
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
