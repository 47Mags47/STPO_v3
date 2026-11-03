<?php

namespace App\Classes;

use Illuminate\Routing\ResourceRegistrar;
use Illuminate\Support\Str;

class AllResourceRegistrar extends ResourceRegistrar
{
    protected $resourceDefaults = [
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy',
        'restore',
        'forceDelete',
    ];


    public function register($name, $controller, array $options = [])
    {
        $name = trim(str_replace('\\', '/', $name), '/');

        return parent::register($name, $controller, $options);
    }

    protected function addResourceRestore(string $name, string $base, string $controller, array $options)
    {
        $uri = $this->getResourceUri($name)
            . '/{' . $this->getResourceWildcard($base)
            . '}/restore';

        $action = $this->getResourceAction($name, $controller, 'restore', $options);

        return $this->router->post($uri, $action)->withTrashed();
    }

    protected function addResourceForceDelete(string $name, string $base, string $controller, array $options)
    {
        $uri = $this->getResourceUri($name)
            . '/{' . $this->getResourceWildcard($base)
            . '}/force-delete';

        $action = $this->getResourceAction($name, $controller, 'forceDelete', $options);

        return $this->router->delete($uri, $action)->withTrashed();
    }

    protected function getResourceRouteName($resource, $method, $options)
    {
        if (in_array($method, ['restore', 'forceDelete'], true)) {
            $method = Str::snake($method, '-');
        }

        $resource = str_replace('/', '.', $resource);

        return parent::getResourceRouteName($resource, $method, $options);
    }
}
