<?php

use App\Models\Base\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('appeal.{appealId}', function (User $user, $appealId) {
    // DEV дописать логику проверки
    return true;
});

Broadcast::channel('sfr.fsd.sfr-files', function (User $user) {
    // DEV дописать логику проверки
    return true;
});

Broadcast::channel('sfr.fsd.result-files', function (User $user) {
    // DEV дописать логику проверки
    return true;
});

Broadcast::channel('sfr.fsd.payment-files', function (User $user) {
    // DEV дописать логику проверки
    return true;
});

Broadcast::channel('sfr.fsd.transit-files', function (User $user) {
    // DEV дописать логику проверки
    return true;
});

Broadcast::channel('user.{userId}.notifications', function (User $user, int $userId) {
    return $user->id === $userId;
});


