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

        $user = $this->createTestUser();
        $this->actingAs($user);

        $response = $this->get(route($this->route . '.index'));
        $response->assertStatus(403);
    }

    public function test_create_return_403_for_non_permission()
    {
        $this->checkCreateExist();
        $this->checkCreatePermissionNotEmpty();
        $this->checkRouteNotNull();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $user = $this->createTestUser();
        $this->actingAs($user);

        $response = $this->get(route($this->route . '.create'));
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

        $user = $this->createTestUser();
        $this->actingAs($user);

        $response = $this->post(route($this->route . '.store'), $this->createTestData());
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

        $user = $this->createTestUser();
        $this->actingAs($user);

        $response = $this->get(route($this->route . '.show', [$this->getRouteParameterName() => $this->createTestRecord()]));
        $response->assertStatus(403);
    }

    public function test_edit_return_403_for_non_permission()
    {
        $this->checkUpdateExist();
        $this->checkUpdatePermissionNotEmpty();
        $this->checkRouteNotNull();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $user = $this->createTestUser();
        $this->actingAs($user);

        $response = $this->get(route($this->route . '.edit', [$this->getRouteParameterName() => $this->createTestRecord()]));
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

        $user = $this->createTestUser();
        $this->actingAs($user);

        $response = $this->put(route($this->route . '.update', [$this->getRouteParameterName() => $this->createTestRecord()]), $this->createTestData());
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

        $user = $this->createTestUser();
        $this->actingAs($user);

        $response = $this->delete(route($this->route . '.destroy', [$this->getRouteParameterName() => $this->createTestRecord()]));
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

            $response = $this->get(route($this->route . '.index'));
            $response->assertStatus(200);
        }
    }

    public function test_create_return_200_for_permission()
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

            $response = $this->get(route($this->route . '.create'));
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

            $response = $this->post(route($this->route . '.store'), $this->createTestData());

            $response->assertStatus(302);
        }
    }

    public function test_edit_return_200_for_permission()
    {
        $this->checkUpdateExist();
        $this->checkUpdatePermissionNotEmpty();
        $this->checkRouteNotNull();

        $this->disableMiddleware([
            Authenticate::class,
            CurrentDivisionMiddleware::class,
        ]);

        $this->runProdSeeder();

        foreach ($this->permissions['update'] as $permission) {
            $user = $this->createTestUser();

            $user->permissions()->attach([Permission::byCode($permission)->id]);
            $user->load('permissions');

            $this->actingAs($user);

            $response = $this->get(route($this->route . '.edit', [$this->getRouteParameterName() => $this->createTestRecord()]));
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

        foreach ($this->permissions['update'] as $permission) {
            $user = $this->createTestUser();

            $user->permissions()->attach([Permission::byCode($permission)->id]);
            $user->load('permissions');

            $this->actingAs($user);

            $response = $this->put(route($this->route . '.update', [$this->getRouteParameterName() => $this->createTestRecord()]), $this->createTestData());
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

        foreach ($this->permissions['delete'] as $permission) {
            $user = $this->createTestUser();

            $user->permissions()->attach([Permission::byCode($permission)->id]);
            $user->load('permissions');

            $this->actingAs($user);

            $response = $this->delete(route($this->route . '.update', [$this->getRouteParameterName() => $this->createTestRecord()]));
            $response->assertStatus(302);
        }
    }
}
