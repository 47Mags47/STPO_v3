<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\Base\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function readAll(){
        Notification::where('recipient_id', user()->id)->update(['is_readed' => true]);

        return response(null);
    }

    public function read(Request $request){
        Notification::where('id', $request->input('id'))
            ->where('recipient_id', user()->id)
            ->update([
                'is_readed' => true
            ]);

        return response(null);
    }
}
