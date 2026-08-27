<?php

namespace Database\Seeders\Test\Base;

use App\Models\Base\User;
use App\Models\Administrate\Division;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $divisions = Division::all();

        // 2 дивизиона и 3 пользователя в каждом
        // 1 пользователь с ролью 2
        // 2 пользователя с ролью 3
        foreach ($divisions as $division) {
            foreach ([2, 3, 3] as $roleId) {
                User::factory()
                    ->create([
                        'password' => Hash::make('password'),
                    ])
                    ->roles()->attach($roleId, [
                        'division_id' => $division->id,
                    ]);
            }
        }
    }
}
