<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\Base\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function download(File $file){
        // HACK добавить механизм проверки доступа к файлу
        return $file->download();
    }

    public function show(File $file){
       dd([
    'db_name' => $file->name,
    'db_path' => $file->path,
    'real_files' => Storage::disk($file->disk)
        ->files($file->path),
]);
        return response()->file($file->getFullPath());
    }
}
