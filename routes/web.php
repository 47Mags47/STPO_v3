<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// DEV
if (config('app.env') === 'local') {
    Route::get('/test', fn() => Inertia::render('test'));
    Route::get('/view', fn() => Inertia::render('view'));
}

### DEFAULT ROUTES
##################################################
Route::get('/', fn() => redirect()->route('appeal.appeals.index'))->name('home');

### FILES
##################################################
Route::name('upload.')->prefix('/upload')->group(function () {
    Route::post('files/startUpload',    [App\Http\Controllers\Base\UploadController::class, 'startUpload'])->name('startUpload');
    Route::post('chunks/{chunk}',       [App\Http\Controllers\Base\UploadController::class, 'writeChunk'])->name('writeChunk');
});

Route::name('files.')->prefix('/files')->group(function () {
    Route::get('/{file}/download',      [App\Http\Controllers\Base\FileController::class, 'download'])->name('download');
    Route::get('/{file}/errors',        [App\Http\Controllers\Base\FileErrorController::class, 'index'])->name('errors');
});

### HTTP ERRORS
##################################################
Route::get('/403',        fn() => Inertia::render('httpErrors/403'))->name('forbidden');


### GUEST
##################################################
Route::middleware('guest')->group(function () {
    Route::get('/login',            fn() => Inertia::render('auth/login'))->name('login');

    Route::name('auth.')->group(function () {
        Route::post('/login',                                       [App\Http\Controllers\Auth\UserController::class,  'login'])->name('users.login');
        Route::get('/users/create',                                 [App\Http\Controllers\Auth\UserController::class,  'create'])->name('users.create');
        Route::post('/users/create',                                [App\Http\Controllers\Auth\UserController::class,  'store'])->name('users.store');
    });
});

### AUTH
##################################################
Route::middleware('auth')->group(function () {
    // SYSTEM
    Route::post('/notification-readed',                             [App\Http\Controllers\Base\NotificationController::class, 'readAll'])->name('notifications-readAll');

    // AUTH
    Route::name('auth.')->group(function () {
        Route::post('/logout',                                      [App\Http\Controllers\Auth\UserController::class,   'logout'])->name('logout');
        Route::resource('/users',                                   App\Http\Controllers\Auth\UserController::class)->only(['edit', 'update', 'show']);
    });

    Route::get('/dashboard', fn() => Inertia::render('dashboard/dashboard'))->name('dashboard');

    // EMAIL
    Route::name('verification.')->prefix('/email')->group(function () {
        // HACK создать страницу "вам необходимо подтвердить Email" маршрут ниже
        Route::get('/verify',                                       [App\Http\Controllers\Auth\EmailController::class, 'notice'])->name('notice');
        Route::get('/verify/{id}/{hash}',                           [App\Http\Controllers\Auth\EmailController::class, 'verify'])->name('verify')->middleware(['signed']);
        Route::get('/verification-notification',                    [App\Http\Controllers\Auth\EmailController::class, 'send'])->name('send')->middleware(['throttle:6,1']);
    });

    Route::name('administrate.')->prefix('/administrate')->group(function () {
        Route::resource('/cities',                                  App\Http\Controllers\Administrate\CityController::class)->except('show');
        Route::resource('/divisions',                               App\Http\Controllers\Administrate\DivisionController::class)->except('show');
        Route::resource('/payments',                                App\Http\Controllers\Administrate\PaymentController::class)->except('show');
        Route::resource('/banks',                                   App\Http\Controllers\Administrate\BankController::class)->except('show');
        Route::resource('/financing-types',                         App\Http\Controllers\Administrate\FinancingTypeController::class)->except('show');
    });

    Route::name('appeal.')->prefix('/appeal')->group(function () {
        Route::resource('/them-groups',                             App\Http\Controllers\Appeal\ThemGroupController::class)->except('show');
        Route::resource('/thems',                                   App\Http\Controllers\Appeal\ThemController::class)->except('show');
        Route::resource('/appeals',                                 App\Http\Controllers\Appeal\AppealController::class)->only(['index', 'create', 'store']);
        Route::prefix('/appeals/{appeal}')->group(function () {
            Route::resource('/messages',               App\Http\Controllers\Appeal\MessageController::class)->except(['create', 'destroy']);
            Route::post('/accept',                     [App\Http\Controllers\Appeal\AppealController::class, 'accept'])->name('accept');
            Route::post('/close',                      [App\Http\Controllers\Appeal\AppealController::class, 'close'])->name('close');
            Route::post('/reaccept',                   [App\Http\Controllers\Appeal\AppealController::class, 'reaccept'])->name('reaccept');
        });
    });

    Route::name('sfr.')->prefix('/sfr')->group(function () {
        Route::name('fsd.')->prefix('/fsd')->group(function () {
            Route::resource('/sfr-files',                               App\Http\Controllers\SFR\FSD\SFRFileController::class)->only(['index', 'create', 'store', 'show']);
            Route::resource('/sfr-files/{SFRFile}/result-files',        App\Http\Controllers\SFR\FSD\ResultFileController::class)->only(['index', 'store', 'show']);
            Route::resource('/payment-files',                           App\Http\Controllers\SFR\FSD\PaymentFileController::class)->only(['index', 'create', 'store', 'destroy']);
            Route::resource('/sfr-payment-categories',                  App\Http\Controllers\SFR\FSD\SFRCategoryController::class)->except(['show']);
            Route::resource('/asp-payment-categories',                  App\Http\Controllers\SFR\FSD\ASPCategoryController::class)->except(['show']);
            Route::resource('/transit-categories',                      App\Http\Controllers\SFR\FSD\TransitCategoryController::class)->except(['show']);
            Route::resource('/transit-equivalents',                     App\Http\Controllers\SFR\FSD\TransitEquivalentController::class)->only(['index', 'create', 'store']);
            Route::resource('/transit-files',                           App\Http\Controllers\SFR\FSD\TransitFileController::class)->only(['index', 'create', 'store']);
        });
    });

    Route::name('payment.')->prefix('/payment')->group(function () {
        Route::resource('/events',                                      App\Http\Controllers\Payment\EventController::class)->except('show');
        Route::prefix('/events/{event}')->group(function () {
            Route::resource('/payment-files',                               App\Http\Controllers\Payment\PaymentFileController::class)->only(['index', 'create', 'store', 'destroy']);
            Route::resource('/payment-files/{paymentFile}/recipients',      App\Http\Controllers\Payment\RecipientController::class)->except('show');
            Route::resource('/banks',                                       App\Http\Controllers\Payment\BankController::class)->only('index');
            Route::resource('/banks/{bank}/raports',                        App\Http\Controllers\Payment\BankRaportController::class)->only(['index', 'store', 'show']);
            Route::resource('/archives',                                    App\Http\Controllers\Payment\ArchiveController::class)->only(['index', 'store', 'show']);
        });
    });
});
