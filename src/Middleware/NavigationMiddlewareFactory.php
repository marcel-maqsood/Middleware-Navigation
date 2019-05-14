<?php

namespace depa\NavigationMiddleware\Middleware;

use Psr\Container\ContainerInterface;

class NavigationMiddlewareFactory
{
    public function __invoke(ContainerInterface $container, $requestedName) : NavigationMiddleware
    {

        if(!isset($container->get('config')['depaNavigation']) && !is_array($container->get('config')['depaNavigation'])){
            throw new \Exception('Error! der Configeintrag für depaNavigation ist kein array oder nicht gesetzt.');
        }

        if(!isset($container->get('config')['depaNavigation']['navigations']) && !is_array($container->get('config')['depaNavigation']['navigations'])){
            throw new \Exception('Error! die Navigations Einträge sind entweder keine arrays oder nicht gesetzt.');
        }

        $navigationConfigArray = $container->get('config')['depaNavigation']['navigations'];

        foreach ($navigationConfigArray as $navigationName => $naviParams)
        {
            if($container->get($navigationName) instanceof \depa\NavigationMiddleware\Navigation\Navigation){
                $navigationObjects[] = $container->get($navigationName);
            }
        }
        return new NavigationMiddleware($navigationObjects);
    }
}
