<?php

namespace Database\Seeders\Prod\Appeal;

use App\Models\Appeal\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::firstOrCreate(['code' => 'new',         'name' => 'Новая']);
        Status::firstOrCreate(['code' => 'in_work',     'name' => 'В работе']);
        Status::firstOrCreate(['code' => 'closed',      'name' => 'Закрыта']);
        Status::firstOrCreate(['code' => 'reaccepted',  'name' => 'возобновлено']);
    }
}
