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

    public function test_policy_accept_user_and_model_view()
    {
        $this->checkViewExist();
        $this->runProdSeeder();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();
        $record = $this->createTestRecord();

        $this->assertIsBool($policy->view($user, $record));
    }

    public function test_policy_accept_user_and_model_update()
    {
        $this->checkUpdateExist();
        $this->runProdSeeder();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();
        $record = $this->createTestRecord();

        $this->assertIsBool($policy->update($user, $record));
    }

    public function test_policy_accept_user_and_model_delete()
    {
        $this->checkDeleteExist();
        $this->runProdSeeder();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();
        $record = $this->createTestRecord();

        $this->assertIsBool($policy->delete($user, $record));
    }

    public function test_policy_accept_user_and_model_restore()
    {
        $this->checkRestoreExist();
        $this->runProdSeeder();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();
        $record = $this->createTestRecord();

        $this->assertIsBool($policy->restore($user, $record));
    }

    public function test_policy_accept_user_and_model_forceDelete()
    {
        $this->checkForceDeleteExist();
        $this->runProdSeeder();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();
        $record = $this->createTestRecord();

        $this->assertIsBool($policy->forceDelete($user, $record));
    }
}
