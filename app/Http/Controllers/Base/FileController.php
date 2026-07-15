<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\Base\File;

class FileController extends Controller
{
    public function download(File $file){
        // HACK добавить механизм проверки доступа к файлу
        return $file->download();
    }
}
