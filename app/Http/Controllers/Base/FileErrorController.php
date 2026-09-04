<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\Base\File;
use Inertia\Inertia;

class FileErrorController extends Controller
{
    public function index(File $file)
    {
        return Inertia::render('base/file-errors/index', [
            'errors' => fn() => $file->errors()->paginate(getRequestPaginate())->toResourceCollection()
        ]);
    }
}
