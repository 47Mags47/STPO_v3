<?php

namespace Database\Seeders\Local\Auth;

use App\Models\Administrate\Division;
use App\Models\Auth\Permission;
use App\Models\Base\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superuser = User::firstOrCreate([
            'first_name'        => 'root',
            'last_name'         => null,
            'middle_name'       => null,
            'full_name'         => 'root',
            'login'             => 'root',
            'email'             => null,
            'password_expired'  => false,
        ], [
            'password'          => Hash::make('root'),
            'email_verified_at' => now(),
        ]);

        // Add division
        $superuser->divisions()->attach(Division::get('id')->pluck('id'));

        // Add all permissions
        $permission_ids = Permission::get('id')->pluck('id');
        $superuser->permissions()->attach($permission_ids);
    }
}
