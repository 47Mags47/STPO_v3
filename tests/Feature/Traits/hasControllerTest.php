<?php

namespace Tests\Feature\Traits;

use Illuminate\Support\Collection;

trait hasControllerTest
{
    ### SETTINGS
    ########################################
    private array $methods = [
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy'
    ];

    ### METHODS
    ########################################
    public function methodExcept(array $methods = [])
    {
        $this->methods = array_values(array_diff($this->methods, $methods));
    }

    ### HELPERS
    ########################################
    public function checkControllerContainMethod(string $method)
    {
        if (!in_array($method, $this->methods)) {
            $this->markTestIncomplete('Тест этого метода отключен');
            return;
        }

        $error_message = 'Контроллер не реализует метод "' . $method . '"';
        $this->assertTrue(method_exists($this->model_class::getGuessNames('controller'), $method), $error_message);
    }

    ### TESTS
    ########################################
    public function test_controller_exist()
    {
        $this->assertTrue($this->model_class::getGuessNames('controller') !== false);
    }

    public function test_controller_contain_index_method()
    {
        $this->checkControllerContainMethod('index');
    }

    public function test_controller_contain_create_method()
    {
        $this->checkControllerContainMethod('create');
    }

    public function test_controller_contain_store_method()
    {
        $this->checkControllerContainMethod('store');
    }

    public function test_controller_contain_show_method()
    {
        $this->checkControllerContainMethod('show');
    }

    public function test_controller_contain_edit_method()
    {
        $this->checkControllerContainMethod('edit');
    }

    public function test_controller_contain_update_method()
    {
        $this->checkControllerContainMethod('update');
    }

    public function test_controller_contain_destroy_method()
    {
        $this->checkControllerContainMethod('destroy');
    }

    ###################################

    // HACK добавить тесты:
    // метод    index      return   page
    // метод    create     return   page
    // метод    store      return   302
    // метод    show       return   page
    // метод    edit       return   page
    // метод    update     return   302
    // метод    destroy    return   302

    // методы, возвращающие страницу, возвращают пропсы
    // методы, возвращающие редирект, возвращают на index страницу
}
