<?php

namespace Database\Factories\Appeal;

use App\Models\Appeal\Appeal;
use App\Models\Appeal\Status;
use App\Models\Appeal\Theme;
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

            'sender_id' => User::randomOrCreate()->id,
            'worker_id' => User::randomOrCreate()->id,
            'theme_id' => Theme::randomOrCreate()->id,
            'status_id' => Status::randomOrCreate()->id,
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Appeal $appeal) {
            if ($appeal->chat_id == null) {
                $chat = Chat::factory()->create();
                $appeal->chat_id = $chat->id;
            }
        });
    }
}
