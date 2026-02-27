<?php

namespace Database\Factories\Appeal;

use App\Models\Appeal\Status;
use App\Models\Appeal\Them;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appeal\Appeal>
 */
class AppealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'office' => $this->faker->numerify('###'),
            'comment' => $this->faker->paragraph(),

            'sender_id' => User::randomOrCreate()->id,
            'them_id' => Them::randomOrCreate()->id,
            'status_id' => Status::randomOrCreate()->id,
        ];
    }
}
