<?php

namespace Tests\Feature\Policy\Traits;

use App\Models\Auth\Permission;

trait PolicyRESTCan
{
    ### Methods
    ##################################################
    protected function checkPermissionNotEmpty(string $method): bool
    {
        return in_array($method, array_keys($this->permissions));
    }

    protected function checkViewAnyPermissionNotEmpty()
    {
        $result = $this->checkPermissionNotEmpty('viewAny');

        if (!$result)
            $this->markTestSkipped('не заполнены permissions для viewAny');

        return $result;
    }

    protected function checkCreatePermissionNotEmpty()
    {
        $result = $this->checkPermissionNotEmpty('create');

        if (!$result)
            $this->markTestSkipped('не заполнены permissions для create');

        return $result;
    }

    protected function checkViewPermissionNotEmpty()
    {
        $result = $this->checkPermissionNotEmpty('view');

        if (!$result)
            $this->markTestSkipped('не заполнены permissions для view');

        return $result;
    }

    protected function checkUpdatePermissionNotEmpty()
    {
        $result = $this->checkPermissionNotEmpty('update');

        if (!$result)
            $this->markTestSkipped('не заполнены permissions для update');

        return $result;
    }

    protected function checkDeletePermissionNotEmpty()
    {
        $result = $this->checkPermissionNotEmpty('delete');

        if (!$result)
            $this->markTestSkipped('не заполнены permissions для delete');

        return $result;
    }

    protected function checkRestorePermissionNotEmpty()
    {
        $result = $this->checkPermissionNotEmpty('restore');

        if (!$result)
            $this->markTestSkipped('не заполнены permissions для restore');

        return $result;
    }

    protected function checkForceDeletePermissionNotEmpty()
    {
        $result = $this->checkPermissionNotEmpty('forceDelete');

        if (!$this->checkPermissionNotEmpty('forceDelete'))
            $this->markTestSkipped('не заполнены permissions для forceDelete');

        return $result;
    }

    ### Tests
    ##################################################
    public function test_policy_user_can_viewAny()
    {
        $this->checkViewAnyExist();
        $this->checkViewAnyPermissionNotEmpty();
        $this->runProdSeeder();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();

        foreach ($this->permissions['viewAny'] as $permission) {
            $this->assertFalse($policy->viewAny($user), 'Пользователь без прав имеет доступ к viewAny');
        }

        foreach ($this->permissions['viewAny'] as $permission) {
            $user = $this->createTestUser();
            $user->permissions()->attach([Permission::byCode($permission)->id]);
            $user->load('permissions');

            $this->assertTrue($policy->viewAny($user), 'Пользователь с правом ' . $permission . ' не имеет доступа к viewAny');
        }
    }

    public function test_policy_user_can_create(){
        $this->checkCreateExist();
        $this->checkCreatePermissionNotEmpty();
        $this->runProdSeeder();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();

        foreach ($this->permissions['create'] as $permission) {
            $this->assertFalse($policy->create($user), 'Пользователь без прав имеет доступ к create');
        }

        foreach ($this->permissions['create'] as $permission) {
            $user = $this->createTestUser();
            $user->permissions()->attach([Permission::byCode($permission)->id]);
            $user->load('permissions');

            $this->assertTrue($policy->create($user), 'Пользователь с правом ' . $permission . ' не имеет доступа к create');
        }
    }

    public function test_policy_user_can_view(){
        $this->checkViewExist();
        $this->checkViewPermissionNotEmpty();
        $this->runProdSeeder();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();
        $record = $this->createTestRecord();

        foreach ($this->permissions['view'] as $permission) {
            $this->assertFalse($policy->view($user, $record), 'Пользователь без прав имеет доступ к view');
        }

        foreach ($this->permissions['view'] as $permission) {
            $user = $this->createTestUser();
            $user->permissions()->attach([Permission::byCode($permission)->id]);
            $user->load('permissions');

            $this->assertTrue($policy->view($user, $record), 'Пользователь с правом ' . $permission . ' не имеет доступа к view');
        }
    }

    public function test_policy_user_can_update(){
        $this->checkUpdateExist();
        $this->checkUpdatePermissionNotEmpty();
        $this->runProdSeeder();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();
        $record = $this->createTestRecord();

        foreach ($this->permissions['update'] as $permission) {
            $this->assertFalse($policy->update($user, $record), 'Пользователь без прав имеет доступ к update');
        }

        foreach ($this->permissions['update'] as $permission) {
            $user = $this->createTestUser();
            $user->permissions()->attach([Permission::byCode($permission)->id]);
            $user->load('permissions');

            $this->assertTrue($policy->update($user, $record), 'Пользователь с правом ' . $permission . ' не имеет доступа к update');
        }
    }

    public function test_policy_user_can_delete(){
        $this->checkDeleteExist();
        $this->checkDeletePermissionNotEmpty();
        $this->runProdSeeder();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();
        $record = $this->createTestRecord();

        foreach ($this->permissions['delete'] as $permission) {
            $this->assertFalse($policy->delete($user, $record), 'Пользователь без прав имеет доступ к delete');
        }

        foreach ($this->permissions['delete'] as $permission) {
            $user = $this->createTestUser();
            $user->permissions()->attach([Permission::byCode($permission)->id]);
            $user->load('permissions');

            $this->assertTrue($policy->delete($user, $record), 'Пользователь с правом ' . $permission . ' не имеет доступа к delete');
        }
    }

    public function test_policy_user_can_restore(){
        $this->checkRestoreExist();
        $this->checkRestorePermissionNotEmpty();
        $this->runProdSeeder();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();
        $record = $this->createTestRecord();

        foreach ($this->permissions['restore'] as $permission) {
            $this->assertFalse($policy->restore($user, $record), 'Пользователь без прав имеет доступ к restore');
        }

        foreach ($this->permissions['restore'] as $permission) {
            $user = $this->createTestUser();
            $user->permissions()->attach([Permission::byCode($permission)->id]);
            $user->load('permissions');

            $this->assertTrue($policy->restore($user, $record), 'Пользователь с правом ' . $permission . ' не имеет доступа к restore');
        }
    }

    public function test_policy_user_can_forceDelete(){
        $this->checkForceDeleteExist();
        $this->checkForceDeletePermissionNotEmpty();
        $this->runProdSeeder();

        $policy = new ($this->policyClass)();
        $user = $this->createTestUser();
        $record = $this->createTestRecord();

        foreach ($this->permissions['forceDelete'] as $permission) {
            $this->assertFalse($policy->forceDelete($user, $record), 'Пользователь без прав имеет доступ к forceDelete');
        }

        foreach ($this->permissions['forceDelete'] as $permission) {
            $user = $this->createTestUser();
            $user->permissions()->attach([Permission::byCode($permission)->id]);
            $user->load('permissions');

            $this->assertTrue($policy->forceDelete($user, $record), 'Пользователь с правом ' . $permission . ' не имеет доступа к forceDelete');
        }
    }
}
