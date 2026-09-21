<?php

namespace Tests\Feature;

use App\Classes\BaseModel;
use App\Http\Middleware\CurrentDivisionMiddleware;
use App\Models\Base\User;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\Authorize;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function createTestUser(): User
    {
        return User::factory()->create();
    }

    protected function createTestRecord(): BaseModel
    {
        return $this->modelClass::factory()->create();
    }

    protected function createTestData(): array
    {
        return $this->modelClass::factory()->make()->toArray();
    }

    protected function disableMiddleware(array $middlewares){
        foreach ($middlewares as $middleware) {
            $this->withoutMiddleware($middleware);
        }
    }

    protected function disableAuthMiddleware(){
        $this->disableMiddleware([
            CurrentDivisionMiddleware::class,
            Authenticate::class,
            Authorize::class,
        ]);
    }

    protected function runSeeder(string $seeder)
    {
        $this->seed($seeder);
    }

    protected function runProdSeeder() {
        $this->runSeeder(\Database\Seeders\Prod\ProdSeeder::class);
    }
}
