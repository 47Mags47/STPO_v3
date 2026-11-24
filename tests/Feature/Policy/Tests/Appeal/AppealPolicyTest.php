<?php

namespace Tests\Feature\Policy\Tests\Appeal;

use App\Models\Appeal\Appeal;
use Override;
use Tests\Feature\Policy\Cases\PolicyTestCase;
use App\Models\Auth\Permission;

class AppealPolicyTest
extends PolicyTestCase
{
    public string $modelClass = Appeal::class;

    public array $permissions = [];

    public bool $hasUpdate = false;
    public bool $hasDelete = false;
    public bool $hasForceDelete = false;
    public bool $hasRestore = false;

    public ?string $route = 'appeal.appeals';

    #[Override]
    public function test_policy_user_can_view(){
        $this->checkViewExist();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();
        $record = $this->createTestRecord();

        $this->assertFalse($policy->view($user, $record), 'Пользователь имеет доступ к чужому view');
    }
}
