<?php

namespace Database\Seeders\Local\Auth;

use App\Models\Auth\Permission;
use App\Models\Base\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testuser = User::firstOrCreate([
            'first_name'        => 'user',
            'last_name'         => null,
            'middle_name'       => null,
            'full_name'         => 'user',
            'login'             => 'user',
            'email'             => null,
            'password_expired'  => false,
        ], [
            'password'          => Hash::make('user'),
            'email_verified_at' => now(),
        ]);

        // Add division
        $testuser->divisions()->attach(1);

        // Add permissions
        $testuser->permissions()->attach(Permission::byCode('nullable_division'));
    }
}
