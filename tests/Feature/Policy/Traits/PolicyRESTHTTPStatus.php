<?php

namespace Tests\Feature\Policy\Traits;

use App\Http\Middleware\CurrentDivisionMiddleware;
use App\Models\Auth\Permission;
use Illuminate\Auth\Middleware\Authenticate;

trait PolicyRESTHTTPStatus
{
    public function test_viewAny_return_403_for_non_permission()
    {
        $this->checkViewAnyExist();
        $this->checkViewAnyPermissionNotEmpty();
        $this->checkRouteNotNull();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $this->runProdSeeder();

        $user = $this->createTestUser();
        $this->actingAs($user);

        $response = $this->get(route($this->route . '.index', $this->getIndexRouteParams()));
        $response->assertStatus(403);
    }

    public function test_create_return_403_for_non_permission()
    {
        $this->checkCreateExist();
        $this->checkCreatePermissionNotEmpty();
        $this->checkRouteNotNull();
        $this->checkCreateRouteExist();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $this->runProdSeeder();

        $user = $this->createTestUser();
        $this->actingAs($user);

        $response = $this->get(route($this->route . '.create', $this->getCreateRouteParams()));
        $response->assertStatus(403);
    }

    public function test_store_return_403_for_non_permission()
    {
        $this->checkCreateExist();
        $this->checkCreatePermissionNotEmpty();
        $this->checkRouteNotNull();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $this->runProdSeeder();

        $user = $this->createTestUser();
        $this->actingAs($user);

        $response = $this->post(route($this->route . '.store', $this->getStoreRouteParams()), $this->createTestData());
        $response->assertStatus(403);
    }

    public function test_view_return_403_for_non_permission()
    {
        $this->checkViewExist();
        $this->checkViewPermissionNotEmpty();
        $this->checkRouteNotNull();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $this->runProdSeeder();

        $user = $this->createTestUser();
        $record = $this->createTestRecord();
        $this->actingAs($user);

        $response = $this->get(route($this->route . '.show', $this->getShowRouteParams($record)));
        $response->assertStatus(403);
    }

    public function test_edit_return_403_for_non_permission()
    {
        $this->checkUpdateExist();
        $this->checkUpdatePermissionNotEmpty();
        $this->checkRouteNotNull();
        $this->checkEditRouteExist();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $this->runProdSeeder();

        $user = $this->createTestUser();
        $record = $this->createTestRecord();
        $this->actingAs($user);

        $response = $this->get(route($this->route . '.edit', $this->getEditRouteParams($record)));
        $response->assertStatus(403);
    }

    public function test_update_return_403_for_non_permission()
    {
        $this->checkUpdateExist();
        $this->checkUpdatePermissionNotEmpty();
        $this->checkRouteNotNull();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $this->runProdSeeder();

        $user = $this->createTestUser();
        $record = $this->createTestRecord();
        $this->actingAs($user);

        $response = $this->put(route($this->route . '.update', $this->getUpdateRouteParams($record)), $this->createTestData());
        $response->assertStatus(403);
    }

    public function test_delete_return_403_for_non_permission()
    {
        $this->checkDeleteExist();
        $this->checkDeletePermissionNotEmpty();
        $this->checkRouteNotNull();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $this->runProdSeeder();

        $user = $this->createTestUser();
        $record = $this->createTestRecord();
        $this->actingAs($user);

        $response = $this->delete(route($this->route . '.destroy', $this->getDestroyRouteParams($record)));
        $response->assertStatus(403);
    }

    public function test_restore_return_403_for_non_permission()
    {
        $this->checkRestoreExist();
        $this->checkRestorePermissionNotEmpty();
        $this->checkRouteNotNull();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $this->runProdSeeder();

        $user = $this->createTestUser();
        $record = $this->createTestRecord();
        $record->delete();
        $record->fresh();
        $this->actingAs($user);

        $response = $this->post(route($this->route . '.restore', $this->getRestoreRouteParams($record)));
        $response->assertStatus(403);
    }

    public function test_force_delete_return_403_for_non_permission()
    {
        $this->checkForceDeleteExist();
        $this->checkForceDeletePermissionNotEmpty();
        $this->checkRouteNotNull();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $this->runProdSeeder();

        $user = $this->createTestUser();
        $record = $this->createTestRecord();
        $this->actingAs($user);

        $response = $this->delete(route($this->route . '.force-delete', $this->getForceDeleteRouteParams($record)));
        $response->assertStatus(403);
    }

    public function test_viewAny_return_200_for_permission()
    {
        $this->checkViewAnyExist();
        $this->checkViewAnyPermissionNotEmpty();
        $this->checkRouteNotNull();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $this->runProdSeeder();

        foreach ($this->permissions['viewAny'] as $permission) {
            $user = $this->createTestUser();
            $user->permissions()->attach([Permission::byCode($permission)->id]);
            $user->load('permissions');

            $this->actingAs($user);

            $response = $this->get(route($this->route . '.index', $this->getIndexRouteParams()));
            $response->assertStatus(200);
        }
    }

    public function test_create_return_200_for_permission()
    {
        $this->checkCreateExist();
        $this->checkCreatePermissionNotEmpty();
        $this->checkRouteNotNull();
        $this->checkCreateRouteExist();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $this->runProdSeeder();

        foreach ($this->permissions['create'] as $permission) {
            $user = $this->createTestUser();
            $user->permissions()->attach([Permission::byCode($permission)->id]);
            $user->load('permissions');

            $this->actingAs($user);

            $response = $this->get(route($this->route . '.create', $this->getCreateRouteParams()));
            $response->assertStatus(200);
        }
    }

    public function test_store_return_302_for_permission()
    {
        $this->checkCreateExist();
        $this->checkCreatePermissionNotEmpty();
        $this->checkRouteNotNull();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $this->runProdSeeder();

        foreach ($this->permissions['create'] as $permission) {
            $user = $this->createTestUser();
            $user->permissions()->attach([Permission::byCode($permission)->id]);
            $user->load('permissions');

            $this->actingAs($user);

            $data = $this->createTestData();

            $response = $this->post(route($this->route . '.store', $this->getStoreRouteParams()), $data);

            $response->assertStatus(302);
        }
    }

    public function test_show_return_302_for_permission()
    {
        $this->checkViewExist();
        $this->checkViewPermissionNotEmpty();
        $this->checkRouteNotNull();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $this->runProdSeeder();

        $record = $this->createTestRecord();
        foreach ($this->permissions['create'] as $permission) {
            $user = $this->createTestUser();

            $user->permissions()->attach([Permission::byCode($permission)->id]);
            $user->load('permissions');

            $this->actingAs($user);
            $data = $this->createTestData();

            $response = $this->post(route($this->route . '.store', $this->getShowRouteParams($record)), $data);

            $response->assertStatus(302);
        }
    }

    public function test_edit_return_200_for_permission()
    {
        $this->checkUpdateExist();
        $this->checkUpdatePermissionNotEmpty();
        $this->checkRouteNotNull();
        $this->checkEditRouteExist();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $this->runProdSeeder();

        $record = $this->createTestRecord();
        foreach ($this->permissions['update'] as $permission) {
            $user = $this->createTestUser();

            $user->permissions()->attach([Permission::byCode($permission)->id]);
            $user->load('permissions');

            $this->actingAs($user);

            $response = $this->get(route($this->route . '.edit', $this->getEditRouteParams($record)));
            $response->assertStatus(200);
        }
    }

    public function test_update_return_302_for_permission()
    {
        $this->checkUpdateExist();
        $this->checkUpdatePermissionNotEmpty();
        $this->checkRouteNotNull();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $this->runProdSeeder();

        $record = $this->createTestRecord();
        foreach ($this->permissions['update'] as $permission) {
            $user = $this->createTestUser();

            $user->permissions()->attach([Permission::byCode($permission)->id]);
            $user->load('permissions');

            $this->actingAs($user);

            $response = $this->put(route($this->route . '.update', $this->getUpdateRouteParams($record)), $this->createTestData());
            $response->assertStatus(302);
        }
    }

    public function test_delete_return_302_for_permission()
    {
        $this->checkDeleteExist();
        $this->checkDeletePermissionNotEmpty();
        $this->checkRouteNotNull();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $this->runProdSeeder();

        $record = $this->createTestRecord();
        foreach ($this->permissions['delete'] as $permission) {
            $user = $this->createTestUser();

            $user->permissions()->attach([Permission::byCode($permission)->id]);
            $user->load('permissions');

            $this->actingAs($user);

            $response = $this->delete(route($this->route . '.destroy', $this->getDestroyRouteParams($record)));
            $response->assertStatus(302);
        }
    }

    public function test_restore_return_302_for_permission()
    {
        $this->checkRestoreExist();
        $this->checkRestorePermissionNotEmpty();
        $this->checkRouteNotNull();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $this->runProdSeeder();

        $record = $this->createTestRecord();
        $record->delete();
        $record->fresh();
        foreach ($this->permissions['delete'] as $permission) {
            $user = $this->createTestUser();

            $user->permissions()->attach([Permission::byCode($permission)->id]);
            $user->load('permissions');

            $this->actingAs($user);

            $response = $this->post(route($this->route . '.restore', $this->getRestoreRouteParams($record)));
            $response->assertStatus(302);
        }
    }

    public function test_force_delete_return_302_for_permission()
    {
        $this->checkForceDeleteExist();
        $this->checkForceDeletePermissionNotEmpty();
        $this->checkRouteNotNull();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $this->runProdSeeder();

        $record = $this->createTestRecord();
        foreach ($this->permissions['delete'] as $permission) {
            $user = $this->createTestUser();

            $user->permissions()->attach([Permission::byCode($permission)->id]);
            $user->load('permissions');

            $this->actingAs($user);

            $response = $this->delete(route($this->route . '.force-delete', $this->getForceDeleteRouteParams($record)));
            $response->assertStatus(302);
        }
    }
}
