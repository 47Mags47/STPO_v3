<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// DEV
if(config('app.env') === 'local'){
    Route::get('/test', fn() => Inertia::render('test'));
    Route::get('/view', fn() => Inertia::render('view'));
    Route::post('/send-notification', function () {
        $notification = App\Models\Base\Notification::factory()->create([
            'is_readed' => false,
            'recipient_id' => user()->id,
            'created_at' => now(),
        ]);

        App\Events\Base\SendNotificationEvent::dispatch($notification);

        return back()->with('success', 'Оповещение отправлено');
    })->name('send-notification');
}

// FILES
Route::name('upload.')->prefix('/upload')->group(function () {
    Route::post('files/startUpload',    [App\Http\Controllers\Base\UploadController::class, 'startUpload'])->name('startUpload');
    Route::post('chunks/{chunk}',       [App\Http\Controllers\Base\UploadController::class, 'writeChunk'])->name('writeChunk');
    Route::get('/download/{file}',      [App\Http\Controllers\Base\UploadController::class, 'download'])->name('download');
});

### HTTP ERRORS
##################################################
Route::get('/403',        fn() => Inertia::render('httpErrors/403'))->name('forbidden');

### DEFAULT ROUTES
##################################################
Route::get('/', fn() => redirect()->route('fsd.sfr-files.index'))->name('home');

### GUEST
##################################################
Route::middleware('guest')->group(function () {
    Route::get('/login',            fn() => Inertia::render('auth/login'))->name('login');

    Route::name('auth.')->group(function () {
        Route::post('/login',                                       [App\Http\Controllers\Auth\UserController::class,  'login'])    ->name('users.login');
        Route::get('/users/create',                                 [App\Http\Controllers\Auth\UserController::class,  'create'])   ->name('users.create');
        Route::post('/users/create',                                [App\Http\Controllers\Auth\UserController::class,  'store'])    ->name('users.store');
    });
});

### AUTH
##################################################
Route::middleware('auth')->group(function () {
    // SYSTEM
    Route::post('/notification-readed',                             [App\Http\Controllers\Base\NotificationController::class, 'readAll'])->name('notifications-readAll');

    // AUTH
    Route::name('auth.')->group(function () {
        Route::post('/logout',                                      [App\Http\Controllers\Auth\UserController::class,   'logout'])  ->name('logout');
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
        Route::resource('/users',                                   App\Http\Controllers\Administrate\UserController::class)->only(['index', 'destroy']);
        Route::resource('/templates',                               App\Http\Controllers\Administrate\TemplateController::class)->except('show');
        Route::resource('/moduls',                                  App\Http\Controllers\Administrate\ModulController::class)->except('show');
        Route::resource('/modul-groups',                            App\Http\Controllers\Administrate\ModulGroupController::class)->except('show');
        Route::resource('/divisions',                               App\Http\Controllers\Administrate\DivisionController::class)->except('show');
    });

    Route::name('appeal.')->prefix('/appeal')->group(function () {
        Route::resource('/them-groups',                             App\Http\Controllers\Appeal\ThemGroupController::class)->except('show');
        Route::resource('/thems',                                   App\Http\Controllers\Appeal\ThemController::class)->except('show');
        Route::resource('/appeals',                                 App\Http\Controllers\Appeal\AppealController::class)->only(['index', 'create', 'store']);
        Route::resource('/appeals/{appeal}/messages',               App\Http\Controllers\Appeal\MessageController::class)->except(['create', 'destroy']);

        Route::post('/appeals/{appeal}/accept',                     [App\Http\Controllers\Appeal\AppealController::class, 'accept'])->name('accept');
        Route::post('/appeals/{appeal}/close',                      [App\Http\Controllers\Appeal\AppealController::class, 'close'])->name('close');
        Route::post('/appeals/{appeal}/reaccept',                   [App\Http\Controllers\Appeal\AppealController::class, 'reaccept'])->name('reaccept');
    });

    Route::middleware('verified')->name('fsd.')->prefix('/fsd')->group(function () {
        Route::resource('/sfr-files',                               App\Http\Controllers\FSD\SFRFileController::class)->only(['index', 'create', 'store', 'show']);
        Route::resource('/payment-files',                           App\Http\Controllers\FSD\PaymentFileController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::resource('/payment-recipients',                      App\Http\Controllers\FSD\PaymentRecipientController::class)->only(['index']);
        Route::resource('/transit-equivalents',                     App\Http\Controllers\FSD\TransitEquivalentController::class)->only(['index', 'create', 'store']);
        Route::resource('/transit-files',                           App\Http\Controllers\FSD\TransitFileController::class)->only(['index', 'create', 'store']);
    });

    Route::name('payment.')->prefix('/payment')->group(function () {
        Route::resource('/payments',                                App\Http\Controllers\Payment\PaymentController::class)->except('show');
        Route::resource('/events',                                  App\Http\Controllers\Payment\EventController::class)->except('show');
        Route::resource('/banks',                                   App\Http\Controllers\Payment\BankController::class)->except('show');
    });
});
