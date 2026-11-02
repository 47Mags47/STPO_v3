<?php

namespace App\Http\Controllers\Administrate;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Administrate\Payment;

class PaymentApiController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Payment::class);
    }

    public function index()
    {
        return Payment::getResource();
    }
}
