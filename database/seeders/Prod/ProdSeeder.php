<?php

namespace Database\Seeders\Prod;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(Auth\RolesAndPermissionsSeeder::class);
        $this->call(Auth\SuperUserSeederSeeder::class);

        $this->call(Base\FileStatusSeeder::class);

        $this->call(Base\TemplateStyleSeeder::class);
        $this->call(Base\TemplateTypeSeeder::class);

        $this->call(Administrate\ModulGroupSeeder::class);
        $this->call(Administrate\ModulSeeder::class);

        $this->call(Appeal\ThemSeeder::class);
        $this->call(Appeal\StatusSeeder::class);

        $this->call(FSD\PaymentTypeSeeder::class);
        $this->call(FSD\TransitCategorySeeder::class);
    }
}
