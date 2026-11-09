<?php

namespace App\Http\Controllers\Appeal;

use App\Http\Controllers\Controller;
use App\Http\Resources\Appeal\SenderResource;
use App\Models\Appeal\Appeal;
use App\Models\Base\User;

class SendersApiController extends Controller
{
    public function index()
    {
        return SenderResource::collection(
            User::whereIn('id', Appeal::select('sender_id')->distinct()->pluck('sender_id'))
                ->filter()
                ->paginate(25)
        );
    }
}
