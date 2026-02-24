<?php

namespace Database\Seeders\Prod\Base;

use App\Models\ModulGroup;
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
