<?php

namespace App\Models;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'errors',
        'upload_at',
    ];

    protected function casts(): array
    {
        return [
            'errors' => 'array',
        ];
    }

    public static function boot()
    {
        parent::boot();

        self::deleted(function ($model) {
            $local_path = $model->path !== ''
                ? $model->path . '/' . $model->name
                : $model->name;

            Storage::disk($model->disk)->delete($local_path);
        });
    }

    ### Аттрибуты
    ##################################################
    protected function hasToStorage(): Attribute
    {
        return new Attribute(
            get: fn() => Storage::disk($this->disk)->has($this->path . '/' . $this->name),
        );
    }

    ### Методы
    ##################################################

    ### Связи
    ##################################################
    //
}
