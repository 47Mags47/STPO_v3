<?php

namespace Tests\Feature\Policy\Traits;

trait PolicyRESTMethodExist
{
    public function test_policy_has_viewAny_method(){
        $this->checkViewAnyExist();

        $this->assertTrue($this->checkPolicyMethodExist('viewAny'));
    }

    public function test_policy_has_view_method(){
        $this->checkViewExist();

        $this->assertTrue($this->checkPolicyMethodExist('view'));
    }

    public function test_policy_has_create_method(){
        $this->checkCreateExist();

        $this->assertTrue($this->checkPolicyMethodExist('create'));
    }

    public function test_policy_has_update_method(){
        $this->checkUpdateExist();

        $this->assertTrue($this->checkPolicyMethodExist('update'));
    }

    public function test_policy_has_delete_method(){
        $this->checkDeleteExist();

        $this->assertTrue($this->checkPolicyMethodExist('delete'));
    }

    public function test_policy_has_restore_method(){
        $this->checkRestoreExist();

        $this->assertTrue($this->checkPolicyMethodExist('restore'));
    }

    public function test_policy_has_force_delete_method(){
        $this->checkForceDeleteExist();

        $this->assertTrue($this->checkPolicyMethodExist('forceDelete'));
    }
}
