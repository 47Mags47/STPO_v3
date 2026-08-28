<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Base\User;

class AppealControllerTest extends TestCase
{
    // public function test_index(): void
    // {
    //     $user = User::with('roles', 'divisions')->firstOrFail();

    //     $this->actingAs($user);

    //     if ($user->divisions->isNotEmpty()) {
    //         $this->withSession([
    //             'current_division_id' => $user->divisions->first()->id,
    //         ]);
    //     }

    //     $response = $this->get(route('appeal.appeals.index'));

    //     $response->assertOk();

    //     $response->assertInertia(
    //         fn($page) =>
    //         $page
    //             ->component('appeal/appeals/index')
    //             ->has('appeals')
    //             ->has('senders')
    //             ->has('themes')
    //             ->has('statuses')
    //     );
    // }
}
