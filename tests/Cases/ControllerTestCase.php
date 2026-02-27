<?php

namespace Tests\Cases;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

abstract class ControllerTestCase extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;
    public bool $auth = false;

    public string $controller;
    public string $routeName;
    public string $model;
    public string $routeKey;
    public string $pageComponentPath;
    public string $propKey;
    public $response;

    public $methods = [
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        if ($this->auth)
            $this->actingAs($this->getUser());
    }

    public function getPayload(): array
    {
        $fillable = (new $this->model)->getFillable();
        $data = $this->model::factory()->make()->toArray();

        return array_intersect_key($data, array_flip($fillable));
    }

    protected function checkMethodExistance(string $method)
    {
        if (!in_array($method, $this->methods))
            $this->markTestSkipped('Метод пропущен');

        $this->assertTrue(method_exists($this->controller, $method), 'Контроллер не имеет метода ' . $method);
    }

    public function sendIndexRequest(array $params = []): TestResponse
    {
        return $this->get(route($this->routeName . '.index', $params));
    }

    public function sendCreateRequest(): TestResponse
    {
        return $this->get(route($this->routeName . '.create'));
    }

    public function sendStoreRequest(?array $payload = null): TestResponse
    {
        return $this->post(route($this->routeName . '.store'), $payload ?? $this->getPayload());
    }

    public function sendShowRequest($recordKeyValue): TestResponse
    {
        return $this->get(route($this->routeName . '.show', [$this->routeKey => $recordKeyValue]));
    }

    public function sendEditRequest($recordKeyValue): TestResponse
    {
        return $this->get(route($this->routeName . '.edit', [$this->routeKey => $recordKeyValue]));
    }

    public function sendUpdateRequest($recordKeyValue, ?array $payload = null): TestResponse
    {
        return $this->put(route($this->routeName . '.update', [$this->routeKey => $recordKeyValue]), $payload ?? $this->getPayload());
    }

    public function sendDeleteRequest($recordKeyValue): TestResponse
    {
        return $this->delete(route($this->routeName . '.destroy', [$this->routeKey => $recordKeyValue]));
    }

    public function getIndexResponse(array $params = []): TestResponse
    {
        return $this->sendIndexRequest($params);
    }

    public function getCreateResponse(): TestResponse
    {
        return $this->sendCreateRequest();
    }

    public function getStoreResponse(?array $payload = null): TestResponse
    {
        return $this->sendStoreRequest($payload);
    }

    public function getShowResponse($recordKeyValue): TestResponse
    {
        return $this->sendShowRequest($recordKeyValue);
    }

    public function getEditResponse($recordKeyValue): TestResponse
    {
        return $this->sendEditRequest($recordKeyValue);
    }

    public function getUpdateResponse($recordKeyValue, ?array $payload = null): TestResponse
    {
        return $this->sendUpdateRequest($recordKeyValue, $payload);
    }

    public function getDeleteResponse($recordKeyValue): TestResponse
    {
        return $this->sendDeleteRequest($recordKeyValue);
    }

    public function getUser(): User
    {
        return User::whereKey(1)->first();
    }
}
