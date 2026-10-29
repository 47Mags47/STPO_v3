<?php

namespace App\Http\Controllers\Administrate;

use App\Http\Controllers\Controller;
use App\Models\Administrate\Division;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DivisionApiController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Division::class);
    }

    public function index()
    {
        return Division::getResource();
    }
}
