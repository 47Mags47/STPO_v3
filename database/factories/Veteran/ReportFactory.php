<?php

namespace Database\Factories\Veteran;

use App\Models\Administrate\Division;
use App\Models\Auth\Permission;
use App\Models\Base\User;
use App\Models\Veteran\Date;
use App\Models\Veteran\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::randomOrCreate();
        $division = Division::randomOrCreate();

        $user->divisions()->attach($division->id);
        $user->permissions()->attach(Permission::byCode('veteran_worker')->id);

        return [
            'all'           => $this->faker->numberBetween(0, 1000),
            'online'        => $this->faker->numberBetween(0, 1000),
            'MFC'           => $this->faker->numberBetween(0, 1000),

            'date_id'       => Date::randomOrCreate()->id,
            'user_id'       => $user->id,
            'division_id'   => $division->id
        ];
    }
}
