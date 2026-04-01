<?php

namespace App\Models\Base;

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

    ### Методы
    ##################################################
    public function deleteInStorage(){
        return Storage::disk($this->disk)->delete($this->path . '/' . $this->name);
    }

    ### Аттрибуты
    ##################################################
    protected function hasToStorage(): Attribute
    {
        return new Attribute(
            get: fn() => Storage::disk($this->disk)->has($this->path . '/' . $this->name),
        );
    }
}
