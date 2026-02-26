<?php

namespace Database\Seeders\Prod\Auth;

use App\Models\Auth\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperUserSeederSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superuser = User::create([
            'first_name'        => 'root',
            'last_name'         => null,
            'middle_name'       => null,
            'full_name'         => 'root',
            'login'             => 'root',
            'password'          => Hash::make('root'),
            'email'             => null,
            'email_verified_at' => now(),
            'password_expired'  => false,
        ]);

        $superuser->roles()->attach(Role::byCode('system_user')->id);
    }
}
