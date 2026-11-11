<?php

namespace Database\Factories\Base;

use App\Models\Appeal\Appeal;
use App\Models\Base\File;
use App\Models\Base\Notification;
use App\Models\Base\NotificationType;
use App\Models\Base\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Notification>
 */
class NotificationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'message'      => null,
            'context'      => [],

            'is_readed'    => $this->faker->boolean(),

            'recipient_id' => User::randomOrCreate()->id,
            'type_id'      => NotificationType::get()->random()->id,
            'sender_id'    => null,
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Notification $notification) {
            $type = NotificationType::find($notification->type_id);

            $hasUserContext = !empty($notification->context);

            switch ($type->code) {
                case 'file':
                    if (!$hasUserContext) {
                        $file = File::randomOrCreate();

                        $notification->message = null;
                        $notification->context = [
                            'file_id'   => $file->id,
                            'file_name' => $file->origin_name,
                        ];
                    }
                    break;

                case 'message':
                    if (!$hasUserContext) {
                        $appeal = Appeal::factory()->create();
                        $appeal->chat->subscribers()->attach($notification->recipient_id);

                        $notification->context = [
                            'target_url' => route('appeal.appeals.show', ['appeal' => $appeal->id]),
                        ];
                    }

                    $notification->message ??= $this->faker->text();
                    break;

                default:
                    $notification->message ??= $this->faker->text();
            }

            $notification->is_system = !in_array($type->code, ['message']);
        });
    }
}
