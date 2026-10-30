<?php

namespace Tests\Feature;

use App\Classes\BaseModel;
use App\Http\Middleware\CurrentDivisionMiddleware;
use App\Models\Base\User;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    ##################################################
    ### ROUTE PARAMS
    ##################################################
    /**
     * Возвращает имя route параметра из модели
     *
     * @return string
     */
    protected function getRouteParameterName(): string
    {
        return snakeCase(class_basename($this->modelClass));
    }

    /**
     * Устанавливает параметры маршрута по умолчанию
     *
     * @param array|null $params - Текущие параметры
     *      Для index, create, store - Пустые
     *      Для show, edit, update, destroy - Параметр модели
     * @return array
     */
    public function modifyRouteParams(?array $params = [], ?Model $record = null): array
    {
        return $params;
    }

    /**
     * Изменяет параметры index маршрута
     *
     * @param array|null $params
     * @return array
     */
    public function modifyIndexRouteParams(?array $params = []): array
    {
        return $params;
    }

    /**
     * Изменяет параметры create маршрута
     *
     * @param array|null $params
     * @return array
     */
    public function modifyCreateRouteParams(?array $params = []): array
    {
        return $params;
    }

    /**
     * Изменяет параметры store маршрута
     *
     * @param array|null $params
     * @return array
     */
    public function modifyStoreRouteParams(?array $params = []): array
    {
        return $params;
    }

    /**
     * Изменяет параметры show маршрута
     *
     * @param array|null $params
     * @return array
     */
    public function modifyShowRouteParams(?array $params = [], ?Model $record = null): array
    {
        return $params;
    }

    /**
     * Изменяет параметры edit маршрута
     *
     * @param array|null $params
     * @return array
     */
    public function modifyEditRouteParams(?array $params = [], ?Model $record = null): array
    {
        return $params;
    }

    /**
     * Изменяет параметры update маршрута
     *
     * @param array|null $params
     * @return array
     */
    public function modifyUpdateRouteParams(?array $params = [], ?Model $record = null): array
    {
        return $params;
    }

    /**
     * Изменяет параметры destroy маршрута
     *
     * @param array|null $params
     * @return array
     */
    public function modifyDestroyRouteParams(?array $params = [], ?Model $record = null): array
    {
        return $params;
    }

    /**
     * Изменяет параметры force delete маршрута
     *
     * @param array|null $params
     * @return array
     */
    public function modifyForceDeleteRouteParams(?array $params = [], ?Model $record = null): array
    {
        return $params;
    }



    /**
     * Изменяет параметры restore маршрута
     *
     * @param array|null $params
     * @return array
     */
    public function modifyRestoreRouteParams(?array $params = [], ?Model $record = null): array
    {
        return $params;
    }

    protected function getIndexRouteParams(): array
    {
        return $this->modifyIndexRouteParams($this->modifyRouteParams());
    }

    protected function getCreateRouteParams(): array
    {
        return $this->modifyCreateRouteParams($this->modifyRouteParams());
    }

    protected function getStoreRouteParams(): array
    {
        return $this->modifyStoreRouteParams($this->modifyRouteParams());
    }

    protected function getShowRouteParams(?Model $record = null): array
    {
        return $this->modifyShowRouteParams($this->modifyRouteParams(
            [
                $this->getRouteParameterName() => $record->id ?? $this->createTestRecord()->id,
            ],
            $record
        ));
    }

    protected function getEditRouteParams(?Model $record = null): array
    {
        return $this->modifyEditRouteParams($this->modifyRouteParams(
            [
                $this->getRouteParameterName() => $record->id ?? $this->createTestRecord()->id,
            ],
            $record
        ));
    }

    protected function getUpdateRouteParams(?Model $record = null): array
    {
        return $this->modifyUpdateRouteParams($this->modifyRouteParams(
            [
                $this->getRouteParameterName() => $record->id ?? $this->createTestRecord()->id,
            ],
            $record
        ));
    }

    protected function getDestroyRouteParams(?Model $record = null): array
    {
        return $this->modifyDestroyRouteParams($this->modifyRouteParams(
            [
                $this->getRouteParameterName() => $record->id ?? $this->createTestRecord()->id,
            ],
            $record
        ));
    }

    protected function getRestoreRouteParams(?Model $record = null): array
    {
        $record = $record ?? $this->createTestRecord();
        $record->delete();
        $record->fresh();

        return $this->modifyDestroyRouteParams($this->modifyRouteParams(
            [
                $this->getRouteParameterName() => $record->id,
            ],
            $record
        ));
    }

    protected function getForceDeleteRouteParams(?Model $record = null): array
    {
        return $this->modifyForceDeleteRouteParams($this->modifyRouteParams(
            [
                $this->getRouteParameterName() => $record->id ?? $this->createTestRecord()->id,
            ],
            $record
        ));
    }

    ##################################################
    ### DATA
    ##################################################
    public function modifySendData(array $data): array
    {
        return $data;
    }

    public function modifyCheckData(array $data): array
    {
        return $data;
    }

    protected function createTestUser(): User
    {
        return User::factory()->create();
    }

    protected function createTestRecord(): BaseModel
    {
        if (!method_exists($this->modelClass, 'factory'))
            $this->markTestSkipped($this->modelClass . ' не имеет метода factory');

        if ($this->modelClass::getGuessNames('factory'))
            $this->markTestSkipped('Не найдена фабрика для ' . $this->modelClass);

        return $this->modelClass::factory()->create();
    }

    protected function createTestData(): array
    {
        if (!method_exists($this->modelClass, 'factory'))
            $this->markTestSkipped($this->modelClass . ' не имеет метода factory');

        if ($this->modelClass::getGuessNames('factory'))
            $this->markTestSkipped('Не найдена фабрика для ' . $this->modelClass);


        return $this->modifySendData($this->modelClass::factory()->make()->getAttributes());
    }

    ##################################################
    ### MIDDLEWARE
    ##################################################
    protected function disableMiddleware(array $middlewares)
    {
        foreach ($middlewares as $middleware) {
            $this->withoutMiddleware($middleware);
        }
    }

    protected function disableAuthMiddleware()
    {
        $this->disableMiddleware([
            CurrentDivisionMiddleware::class,
            Authenticate::class,
            Authorize::class,
        ]);
    }

    ##################################################
    ### SEEDERS
    ##################################################
    protected function runSeeder(string $seeder)
    {
        $this->seed($seeder);
    }

    protected function runProdSeeder()
    {
        $this->runSeeder(\Database\Seeders\Prod\ProdSeeder::class);
    }
}
