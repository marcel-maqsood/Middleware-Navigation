<?php

namespace depa\NavigationMiddleware\Middleware;

use Psr\Container\ContainerInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;

class NavigationMiddlewareFactory
{
    public function __invoke(ContainerInterface $container, $requestedName): NavigationMiddleware
    {
        if (!isset($container->get('config')['mazenav'])) 
        {
            throw new \Exception('Die Config beinhaltet keinen Navigations-Eintrag (mazenav)!');
        }

        if (!is_array($container->get('config')['mazenav'])) 
        {
            throw new \Exception('Die Definition einer Navigation muss ein Array sein (mazenav)!');
        }

        if (!isset($container->get('config')['mazenav']['navigations'])) 
        {
            if (!isset($container->get('config')['mazenav'])) 
            {
                throw new \Exception('Die Config beinhaltet keine Navigation (mazenav)!');
            }

            $navigationConfigArray = $container->get('config')['mazenav'];

            return $this->createNavigationObjects($navigationConfigArray, $container);
        }

        $navigationConfigArray = $container->get('config')['mazenav']['navigations'];

        return $this->createNavigationObjects($navigationConfigArray, $container);
    }

    private function createNavigationObjects($navigationConfigArray, $container)
    {
        $navigationObjects = [];
        foreach ($navigationConfigArray as $navigationName => $naviParams)
        {
            if ($container->get($navigationName) instanceof \MazeDEV\NavigationMiddleware\Navigation\Navigation) 
            {
                $navigationObjects[$navigationName] = $container->get($navigationName);
            }
        }
        $router = $container->get(RouterInterface::class);

        return new NavigationMiddleware($navigationObjects, $container->get(TemplateRendererInterface::class), $router);
    }
}
