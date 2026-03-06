<?php

namespace Database\Seeders\Prod\Administrate;

use App\Models\Administrate\ModulGroup;
use Illuminate\Database\Seeder;

class ModulGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModulGroup::create(['code' => 'administrate', 'name' => 'Администрирование']);
    }
}
