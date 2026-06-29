<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\Base\Notification;

class NotificationController extends Controller
{
    public function readAll(){
        Notification::where('recipient_id', user()->id)->update(['is_readed' => true]);

        return response(null);
    }
}
