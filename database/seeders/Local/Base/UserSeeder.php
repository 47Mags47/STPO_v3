<?php

namespace Database\Seeders\Local\Base;

use App\Models\Administrate\Division;
use App\Models\Base\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(5)->create();

        $users->each(fn($user) =>
            $user->divisions()->attach(Division::randomOrCreate()->id)
        );
    }
}
