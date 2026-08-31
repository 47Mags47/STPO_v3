<?php

namespace Tests\Feature\App\Controllers\Administrate;

use Illuminate\Support\Collection;
use App\Models\Administrate\Bank;
use Tests\TestCase;

class BankControllerTest extends TestCase
{
    private static $MODEL_CLASS = 'App\Models\Administrate\Bank';
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
        $response = $this->get(route('administrate.banks.index'));

        $response->assertInertia();
    }

    public function test_index_return_necessary_props()
    {
        $response = $this->get(route('administrate.banks.index'));

        $response->assertInertia(
            $this->withNecessaryProps(
                component: 'administrate/banks/index',
                props: ['banks']
            )
        );
    }

    public function test_create_return_page()
    {
        $response = $this->get(route('administrate.banks.create'));

        $response->assertInertia();
    }

    public function test_create_return_necessary_props()
    {
        $response = $this->get(route('administrate.banks.create'));

        $response->assertInertia(
            $this->withNecessaryProps(
                component: 'administrate/banks/create',
                props: []
            )
        );
    }

    public function test_store_return_redirect_status_302()
    {
        $data = Bank::factory()->make()->toArray();

        $response = $this->post(route('administrate.banks.store'), $data);

        $response->assertStatus(302);
    }

    public function test_store_return_redirect_to_index()
    {
        $data = Bank::factory()->make()->toArray();

        $response = $this->post(route('administrate.banks.store'), $data);

        $response->assertRedirect((route('administrate.banks.index')));
    }

    public function test_edit_return_page()
    {
        $this->withoutExceptionHandling();

        $bank = Bank::factory()->create();

        $response = $this->get(route('administrate.banks.edit', ['bank' => $bank->id]));

        $response->assertInertia();
    }

    public function test_edit_return_necessary_props()
    {
        $bank = Bank::factory()->create();
        $response = $this->get(route('administrate.banks.edit', ['bank' => $bank->id]));

        $response->assertInertia(
            $this->withNecessaryProps(
                component: 'administrate/banks/edit',
                props: ['bank'],
            )
        );
    }

    public function test_update_return_redirect_status_302()
    {
        $bank = Bank::factory()->create();
        $data = Bank::factory()->make()->toArray();

        $response = $this->put(route('administrate.banks.update', ['bank' => $bank->id]), $data);

        $response->assertStatus(302);
    }

    public function test_update_return_redirect_to_index()
    {
        $bank = Bank::factory()->create();
        $data = Bank::factory()->make()->toArray();

        $response = $this->put(route('administrate.banks.update', ['bank' => $bank->id]), $data);

        $response->assertRedirect(route('administrate.banks.index'));
    }

    public function test_destroy_return_redirect_status_302()
    {
        $bank = Bank::factory()->create();

        $response = $this->delete(route('administrate.banks.destroy', ['bank' => $bank->id]));

        $response->assertStatus(302);
    }

    public function test_destroy_return_redirect_to_back()
    {
        $bank = Bank::factory()->create();

        $response = $this->delete(route('administrate.banks.destroy', ['bank' => $bank->id]));

        $response->assertRedirectBack();
    }
}
