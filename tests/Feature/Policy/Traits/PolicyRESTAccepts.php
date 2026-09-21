<?php

namespace Tests\Feature\Policy\Traits;

trait PolicyRESTAccepts
{
    public function test_policy_accept_user_viewAny()
    {
        $this->checkViewAnyExist();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();

        $this->assertIsBool($policy->viewAny($user));
    }

    public function test_policy_accept_user_create()
    {
        $this->checkCreateExist();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();

        $this->assertIsBool($policy->create($user));
    }

    public function test_policy_accept_user__and_model_view()
    {
        $this->checkViewExist();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();
        $record = $this->modelClass::factory()->create();

        $this->assertIsBool($policy->view($user, $record));
    }

    public function test_policy_accept_user__and_model_update()
    {
        $this->checkUpdateExist();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();
        $record = $this->modelClass::factory()->create();

        $this->assertIsBool($policy->update($user, $record));
    }

    public function test_policy_accept_user__and_model_delete()
    {
        $this->checkDeleteExist();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();
        $record = $this->modelClass::factory()->create();

        $this->assertIsBool($policy->delete($user, $record));
    }

    public function test_policy_accept_user__and_model_restore()
    {
        $this->checkRestoreExist();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();
        $record = $this->modelClass::factory()->create();

        $this->assertIsBool($policy->restore($user, $record));
    }

    public function test_policy_accept_user__and_model_forceDelete()
    {
        $this->checkForceDeleteExist();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();
        $record = $this->modelClass::factory()->create();

        $this->assertIsBool($policy->forceDelete($user, $record));
    }
}
