<?php

namespace Database\Factories\Appeal;

use App\Models\Appeal\Status;
use App\Models\Appeal\Them;
use App\Models\Base\Chat;
use App\Models\Base\User;
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
            'comment' => $this->faker->text(250),

            'chat_id'  => Chat::randomOrCreate()->id,
            'sender_id' => User::randomOrCreate()->id,
            'worker_id' => User::randomOrCreate()->id,
            'them_id' => Them::randomOrCreate()->id,
            'status_id' => Status::randomOrCreate()->id,
        ];
    }
}
