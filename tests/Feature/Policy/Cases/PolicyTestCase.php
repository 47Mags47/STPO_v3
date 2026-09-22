<?php

namespace Tests\Feature\Policy\Cases;

use App\Classes\BaseModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Policy\Interfaces\PolicyTestCaseInterface;
use Tests\Feature\Policy\Traits\PolicyRESTAccepts;
use Tests\Feature\Policy\Traits\PolicyRESTCan;
use Tests\Feature\Policy\Traits\PolicyRESTHTTPStatus;
use Tests\Feature\Policy\Traits\PolicyRESTMethodExist;
use Tests\Feature\TestCase;

abstract class PolicyTestCase
extends TestCase
implements PolicyTestCaseInterface
{
    use RefreshDatabase;

    use PolicyRESTMethodExist;
    use PolicyRESTAccepts;
    use PolicyRESTCan;
    use PolicyRESTHTTPStatus;

    ### Settings
    ##################################################
    // requeried
    public string $policyClass = '';
    public string $controllerClass = '';
    public array $permissions = [
        'viewAny' => [],
        'create' => [],
        'view' => [],
        'update' => [],
        'delete' => [],
        'restore' => [],
        'forceDelete' => [],
    ];

    // nullable
    public ?string $route;

    public bool $hasViewAny = true;
    public bool $hasView = true;
    public bool $hasCreate = true;
    public bool $hasUpdate = true;
    public bool $hasDelete = true;
    public bool $hasRestore = true;
    public bool $hasForceDelete = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->policyClass = $this->modelClass::getGuessNames('policy');
        $this->controllerClass = $this->modelClass::getGuessNames('controller');
    }

    ### Methods
    ##################################################
    /**
     * Проверяет существование политики
     *
     * @return boolean
     */
    public function checkPolicyExist(): bool
    {
        return class_exists($this->modelClass::getGuessNames('policy'));
    }

    protected function createTestRecord(): BaseModel
    {
        return $this->modelClass::factory()->create();
    }

    /**
     * Проверяет существование метода в политике
     *
     * @return boolean
     */
    public function checkPolicyMethodExist(string $method): bool
    {
        return method_exists($this->policyClass, $method);
    }

    public function checkViewAnyExist(): bool
    {
        if (!$this->hasViewAny)
            $this->markTestSkipped('Пропуск проверки viewAny метода');

        return $this->hasViewAny;
    }

    public function checkViewExist(): bool
    {
        if (!$this->hasView)
            $this->markTestSkipped('Пропуск проверки view метода');

        return $this->hasView;
    }

    public function checkCreateExist(): bool
    {
        if (!$this->hasCreate)
            $this->markTestSkipped('Пропуск проверки create метода');

        return $this->hasCreate;
    }

    public function checkUpdateExist(): bool
    {
        if (!$this->hasUpdate)
            $this->markTestSkipped('Пропуск проверки update метода');

        return $this->hasUpdate;
    }

    public function checkDeleteExist(): bool
    {
        if (!$this->hasDelete)
            $this->markTestSkipped('Пропуск проверки delete метода');

        return $this->hasDelete;
    }

    public function checkRestoreExist(): bool
    {
        if (!$this->hasRestore)
            $this->markTestSkipped('Пропуск проверки restore метода');

        return $this->hasRestore;
    }

    public function checkForceDeleteExist(): bool
    {
        if (!$this->hasForceDelete)
            $this->markTestSkipped('Пропуск проверки forceDelete метода');

        return $this->hasForceDelete;
    }

    /**
     * Проверяет наличие заполненного $route
     *
     * @return boolean
     */
    public function checkRouteNotNull(): bool
    {
        $result = $this->route !== null;
        if (!$result)
            $this->markTestSkipped('Route не задан');

        return $result;
    }

    /**
     * Возвращает имя route параметра по модели
     *
     * @return string
     */
    protected function getRouteParameterName(): string
    {
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', class_basename($this->modelClass))), '_');
    }

    ### Tests
    ##################################################
    public function test_policy_exist()
    {
        return $this->assertTrue($this->checkPolicyExist());
    }
}
