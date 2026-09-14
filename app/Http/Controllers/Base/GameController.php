<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\Base\User;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function updateScore(Request $request){
        User::whereKey(user()->id)->update(['gameScore' => $request->input('score')]);

        return response(null);
    }
}
