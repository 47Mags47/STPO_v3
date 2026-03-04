<?php

namespace App\Http\Controllers\FSD;

use App\Http\Controllers\Controller;
use App\Models\FSD\SFRFile;
use Inertia\Inertia;

class RecipientController extends Controller
{
    public function index(SFRFile $file){
        return Inertia::render('fsd/SFRFiles/index', [
            'recipients' => fn() => $file->recipients->toResourceCollection(),
        ]);
    }
}
