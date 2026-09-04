<?php

use App\Models\Base\User;
use Illuminate\Support\Facades\Broadcast;

### GLOBAL
##################################################
Broadcast::channel('user.{userId}.notifications', function (User $user, int $userId) {
    return $user->id === $userId;
});

### APPEALS
##################################################
Broadcast::channel('appeals', function (User $user) {
    return $user->hasPermission('appeal_work');
});

Broadcast::channel('appeal.{appealId}', function (User $user, $appealId) {
    // DEV дописать логику проверки
    return true;
});

### SFR-FSD
##################################################
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

### PAYMENTS
##################################################
Broadcast::channel('payment.payment-files', function (User $user) {
    // DEV дописать логику проверки
    return true;
});

Broadcast::channel('payment.raports', function (User $user) {
    // DEV дописать логику проверки
    return true;
});

Broadcast::channel('payment.archives', function (User $user) {
    // DEV дописать логику проверки
    return true;
});

