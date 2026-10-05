<?php

namespace Database\Factories\Base;

use App\Models\Base\ChatMessage;
use App\Models\Base\ChatMessageAttachment;
use App\Models\Base\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ChatMessageAttachment>
 */
class ChatMessageAttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_image' => false,
            'message_id' => ChatMessage::randomOrCreate()->id,
            'file_id' => File::randomOrCreate()->id,
        ];
    }
}
