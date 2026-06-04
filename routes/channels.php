<?php

use App\Models\Base\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('appeal.{appealId}', function (User $user, $appealId) {
    // DEV дописать логику проверки
    return true;
});
