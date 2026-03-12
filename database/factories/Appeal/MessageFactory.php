<?php

namespace Database\Factories\Appeal;

use App\Models\Appeal\Appeal;
use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appeal\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $appeal = Appeal::randomOrCreate();
        $file = rand(0, 1)
            ? File::factory()->create([
                'disk' => 'appeals',
                'path' => 'messages/' . $appeal->id
            ])
            : null;

        return [
            'message' => $this->faker->text(250),
            'readed' => $this->faker->boolean(),
            'file_id' => $file?->id,
            'sender_id' => User::randomOrCreate()->id,
            'appeal_id' => $appeal->id,
        ];
    }
}
