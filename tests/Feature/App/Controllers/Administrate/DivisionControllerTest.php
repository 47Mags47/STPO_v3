<?php

namespace Tests\Feature\App\Controllers\Administrate;

use Inertia\Testing\AssertableInertia as Assert;
use App\Models\Administrate\Division;
use Illuminate\Support\Collection;
use Tests\TestCase;


class DivisionControllerTest extends TestCase
{
    private static $MODEL_CLASS = 'App\Models\Administrate\Division';
    private ?Collection $records;

    protected function setUp(): void
    {
        parent::setUp();

        $this->records = self::$MODEL_CLASS::factory(3)->create();
    }

    // Функция для выполнения проверки assertInertia
    // В assertInertia передаём эту функцию с аргументами component и props
    // Здесь props - те пропсы контроллера, которые должны вернуться. Ни больше, ни меньше, имя должно совпадать.
    private function withNecessaryProps(
        string $component,
        array $props
    ): \Closure {
        return function ($page) use ($component, $props) {
            $page->component($component);

            $actualProps = $page->toArray()['props'];
            $sharedProps = array_keys(app(\App\Http\Middleware\HandleInertiaRequests::class)->share(request()));

            $actualProps = array_diff_key(
                $actualProps,
                array_flip($sharedProps)
            );

            $this->assertSame(
                $props,
                array_keys($actualProps)
            );
        };
    }

    public function test_index_return_page()
    {
        $response = $this->get(route('administrate.divisions.index'));

        $response->assertInertia();
    }

    public function test_index_return_necessary_props()
    {
        $response = $this->get(route('administrate.divisions.index'));

        $response->assertInertia(
            $this->withNecessaryProps(
                component: 'administrate/divisions/index',
                props: ['divisions']
            )
        );
    }

    public function test_create_return_page()
    {
        $response = $this->get(route('administrate.divisions.create'));

        $response->assertInertia();
    }

    public function test_create_return_necessary_props()
    {
        $response = $this->get(route('administrate.divisions.create'));

        $response->assertInertia(
            $this->withNecessaryProps(
                component: 'administrate/divisions/create',
                props: ['cities']
            )
        );
    }

    public function test_store_return_redirect_status_302()
    {
        $data = Division::factory()->make()->toArray();

        $response = $this->post(route('administrate.divisions.store'), $data);

        $response->assertStatus(302);
    }

    public function test_store_return_redirect_to_index()
    {
        $data = Division::factory()->make()->toArray();

        $response = $this->post(route('administrate.divisions.store'), $data);

        $response->assertRedirect((route('administrate.divisions.index')));
    }

    public function test_edit_return_page()
    {
        $division = Division::factory()->create();

        $response = $this->get(route('administrate.divisions.edit', ['division' => $division->id]));

        $response->assertInertia();
    }

    public function test_edit_return_necessary_props()
    {
        $division = Division::factory()->create();
        $response = $this->get(route('administrate.divisions.edit', ['division' => $division->id]));

        $response->assertInertia(
            $this->withNecessaryProps(
                component: 'administrate/divisions/edit',
                props: ['division', 'cities'],
            )
        );
    }

    public function test_update_return_redirect_status_302()
    {
        $division = Division::factory()->create();
        $data = Division::factory()->make()->toArray();

        $response = $this->put(route('administrate.divisions.update', ['division' => $division->id]), $data);

        $response->assertStatus(302);
    }

    public function test_update_return_redirect_to_index()
    {
        $division = Division::factory()->create();
        $data = Division::factory()->make()->toArray();

        $response = $this->put(route('administrate.divisions.update', ['division' => $division->id]), $data);

        $response->assertRedirect(route('administrate.divisions.index'));
    }

    public function test_destroy_return_redirect_status_302()
    {
        $division = Division::factory()->create();

        $response = $this->delete(route('administrate.divisions.destroy', ['division' => $division->id]));

        $response->assertStatus(302);
    }

    public function test_destroy_return_redirect_to_back()
    {
        $division = Division::factory()->create();

        $response = $this->delete(route('administrate.divisions.destroy', ['division' => $division->id]));

        $response->assertRedirectBack();
    }
}
