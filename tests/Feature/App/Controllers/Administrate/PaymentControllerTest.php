<?php

namespace Tests\Feature\App\Models\Administrate;

use Illuminate\Support\Collection;
use App\Models\Administrate\Payment;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    private static $MODEL_CLASS = 'App\Models\Administrate\Payment';
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
        $response = $this->get(route('administrate.payments.index'));

        $response->assertInertia();
    }

    public function test_index_return_necessary_props()
    {
        $response = $this->get(route('administrate.payments.index'));

        $response->assertInertia(
            $this->withNecessaryProps(
                component: 'administrate/payments/index',
                props: ['payments']
            )
        );
    }

    public function test_create_return_page()
    {
        $response = $this->get(route('administrate.payments.create'));

        $response->assertInertia();
    }

    public function test_create_return_necessary_props()
    {
        $response = $this->get(route('administrate.payments.create'));

        $response->assertInertia(
            $this->withNecessaryProps(
                component: 'administrate/payments/create',
                props: []
            )
        );
    }

    public function test_store_return_redirect_status_302()
    {
        $data = Payment::factory()->make()->toArray();

        $response = $this->post(route('administrate.payments.store'), $data);

        $response->assertStatus(302);
    }

    public function test_store_return_redirect_to_index()
    {
        $data = Payment::factory()->make()->toArray();

        $response = $this->post(route('administrate.payments.store'), $data);

        $response->assertRedirect((route('administrate.payments.index')));
    }

    public function test_edit_return_page()
    {
        $payment = Payment::factory()->create();

        $response = $this->get(route('administrate.payments.edit', ['payment' => $payment->id]));

        $response->assertInertia();
    }

    public function test_edit_return_necessary_props()
    {
        $payment = Payment::factory()->create();
        $response = $this->get(route('administrate.payments.edit', ['payment' => $payment->id]));

        $response->assertInertia(
            $this->withNecessaryProps(
                component: 'administrate/payments/edit',
                props: ['payment'],
            )
        );
    }

    public function test_update_return_redirect_status_302()
    {
        $record = Payment::factory()->create();
        $data = Payment::factory()->make()->toArray();

        $response = $this->put(route('administrate.payments.update', ['payment' => $record->id]), $data);

        $response->assertStatus(302);
    }

    public function test_update_return_redirect_to_index()
    {
        $record = Payment::factory()->create();
        $data = Payment::factory()->make()->toArray();

        $response = $this->put(route('administrate.payments.update', ['payment' => $record->id]), $data);

        $response->assertRedirect(route('administrate.payments.index'));
    }

    public function test_destroy_return_redirect_status_302()
    {
        $record = Payment::factory()->create();

        $response = $this->delete(route('administrate.payments.destroy', ['payment' => $record->id]));

        $response->assertStatus(302);
    }

    public function test_destroy_return_redirect_to_back()
    {
        $record = Payment::factory()->create();

        $response = $this->delete(route('administrate.payments.destroy', ['payment' => $record->id]));

        $response->assertRedirectBack();
    }
}
