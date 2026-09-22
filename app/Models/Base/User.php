<?php

namespace App\Models\Base;

use App\Classes\BaseModel;
use App\Models\Administrate\Division;
use App\Traits\Permissions;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends BaseModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, MustVerifyEmailContract
{
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use MustVerifyEmail;

    use HasFactory;
    use Permissions;

    use Notifiable;

    ### Настройки
    ##################################################
    protected $table = 'base__users';

    public function sendEmailVerificationNotification()
    {
        // Генерируем стандартную ссылку верификации
        $url = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $this->getKey(), 'hash' => sha1($this->getEmailForVerification())]
        );

        // Отправляем кастомное уведомление
        $this->notify(new CustomVerifyEmail($url));
    }

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'full_name',
        'phone',
        'phone_dob',
        'login',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'password_expired',
        'remember_token',
        'email_verified_at',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'password_expired' => 'boolean',
            'email_verified_at' => 'datetime',
        ];
    }

    ### Методы
    ##################################################
    public function getCurrentDivision(): Division|null
    {
        return session()->get('current_division_id') !== null
            ? $this->divisions()->where('division_id', session()->get('current_division_id'))->get()->first()
            : null;
    }

    ### Связи
    ##################################################
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'recipient_id')->orderBy('created_at');
    }

    public function divisions(): BelongsToMany
    {
        return $this->belongsToMany(Division::class, 'base__user_pivot_division', 'user_id', 'division_id');
    }
}
