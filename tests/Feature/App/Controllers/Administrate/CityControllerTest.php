<?php

namespace Tests\Feature\App\Controllers\Administrate;

use Inertia\Testing\AssertableInertia as Assert;
use App\Models\Administrate\City;
use Illuminate\Support\Collection;
use Tests\TestCase;


class CityControllerTest extends TestCase
{
    private static $MODEL_CLASS = 'App\Models\Administrate\City';
    private ?Collection $records;

    protected function setUp(): void
    {
        parent::setUp();

        $this->records = self::$MODEL_CLASS::factory(3)->create();
    }

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
        $response = $this->get(route('administrate.cities.index'));

        $response->assertInertia();
    }

    public function test_index_return_necessary_props()
    {
        $response = $this->get(route('administrate.cities.index'));

        $response->assertInertia(
            $this->withNecessaryProps(
                component: 'administrate/cities/index',
                props: ['cities']
            )
        );
    }

    public function test_create_return_page()
    {
        $response = $this->get(route('administrate.cities.create'));

        $response->assertInertia();
    }

    public function test_create_return_necessary_props()
    {
        $response = $this->get(route('administrate.cities.create'));

        $response->assertInertia(
            $this->withNecessaryProps(
                component: 'administrate/cities/create',
                props: []
            )
        );
    }

    public function test_store_request_exist()
    {
        $this->assertTrue(self::$MODEL_CLASS::getGuessNames('storeRequest') !== false);
    }

    public function test_edit_return_page()
    {
        $city = City::factory()->create();

        $response = $this->get(route('administrate.cities.edit', ['city' => $city->id]));

        $response->assertInertia();
    }

    public function test_edit_return_necessary_props()
    {
        $city = City::factory()->create();
        $response = $this->get(route('administrate.cities.edit', ['city' => $city->id]));

        $response->assertInertia(
            $this->withNecessaryProps(
                component: 'administrate/cities/edit',
                props: ['city']
            )
        );
    }

    public function test_update_return_redirect_status_302()
    {
        $city = City::factory()->create();
        $data = City::factory()->make()->toArray();

        $response = $this->put(route('administrate.cities.update', ['city' => $city->id]), $data);

        $response->assertStatus(302);
    }

    public function test_update_return_redirect_to_index()
    {
        $city = City::factory()->create();
        $data = City::factory()->make()->toArray();

        $response = $this->put(route('administrate.cities.update', ['city' => $city->id]), $data);

        $response->assertRedirect((route('administrate.cities.index')));
    }

    public function test_destroy_return_redirect_status_302()
    {
        $city = City::factory()->create();

        $response = $this->delete(route('administrate.cities.destroy', ['city' => $city->id]));

        $response->assertStatus(302);
    }

    public function test_destroy_return_redirect_to_back()
    {
        $city = City::factory()->create();

        $response = $this->delete(route('administrate.cities.destroy', ['city' => $city->id]));

        $response->assertRedirectBack();
    }
}
