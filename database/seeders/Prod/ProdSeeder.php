<?php

namespace Database\Seeders\Prod;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(Auth\RolesAndPermissionsSeeder::class);
        $this->call(Auth\SuperUserSeederSeeder::class);

        $this->call(Base\FileStatusSeeder::class);
        $this->call(Base\TemplateSeeder::class);
        $this->call(Base\NotificationTypeSeeder::class);

        $this->call(Administrate\ModulGroupSeeder::class);
        $this->call(Administrate\ModulSeeder::class);
        $this->call(Administrate\FinancingTypeSeeder::class);

        $this->call(Appeal\ThemSeeder::class);
        $this->call(Appeal\StatusSeeder::class);

        $this->call(SFR\FSD\TransitCategorySeeder::class);
        $this->call(SFR\FSD\TransitEquivalentSeeder::class);
        $this->call(SFR\FSD\SFRPaymentCategorySeeder::class);
        $this->call(SFR\FSD\ASPPaymentCategorySeeder::class);
    }
}
