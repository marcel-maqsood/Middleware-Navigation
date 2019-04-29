<?php
namespace depa\NavigationMiddleware\Middleware;

use Psr\Container\ContainerInterface;

class NavigationMiddlewareFactory{

    public function __invoke(ContainerInterface $container, $requestedName) : NavigationMiddleware
    {
        // TODO: Implement __invoke() method.
    }

}