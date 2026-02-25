<?php

namespace App\Models;

use App\Classes\BaseModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use
        Authenticatable,
        Authorizable,
        CanResetPassword,
        MustVerifyEmail;

    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'auth__users';

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

    ### Связи
    ##################################################
    public function divisions(): BelongsToMany
    {
        return $this->belongsToMany(Division::class, 'auth_user_division');
    }
}
