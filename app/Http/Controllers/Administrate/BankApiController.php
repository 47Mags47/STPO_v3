<?php

namespace App\Http\Controllers\Administrate;

use App\Http\Controllers\Controller;
use App\Models\Administrate\Bank;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BankApiController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Bank::class);
    }

    public function index()
    {
        return Bank::getResource();
    }
}
