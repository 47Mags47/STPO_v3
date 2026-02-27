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
        Status::create(['code' => 'new',        'name' => 'Новая']);
        Status::create(['code' => 'in_work',    'name' => 'В работе']);
        Status::create(['code' => 'pending',    'name' => 'Ожидание ответа']);
        Status::create(['code' => 'closed',     'name' => 'Закрыта']);

        Status::create(['code' => 'in_revision', 'name' => 'В доработке']);
    }
}
