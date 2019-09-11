<?php

namespace depa\NavigationMiddleware\Middleware;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class NavigationMiddlewareFactory
{
    public function __invoke(ContainerInterface $container, $requestedName): NavigationMiddleware
    {
        if (!isset($container->get('config')['depaNavigation'])) {
            throw new \Exception('Die Config beinhaltet keinen Navigations-Eintrag (depaNavigation)!');
        }

        if (!is_array($container->get('config')['depaNavigation'])) {
            throw new \Exception('Die Definition einer Navigation muss ein Array sein (depaNavigation)!');
        }

        if (!isset($container->get('config')['depaNavigation']['navigations'])) {
            if (!isset($container->get('config')['depaNavigation'])) {
                throw new \Exception('Die Config beinhaltet keine Navigation (depaNavigation)!');
            }

            $navigationConfigArray = $container->get('config')['depaNavigation'];

            return $this->createNavigationObjects($navigationConfigArray, $container);
        }

        $navigationConfigArray = $container->get('config')['depaNavigation']['navigations'];

        return $this->createNavigationObjects($navigationConfigArray, $container);
    }

    private function createNavigationObjects($navigationConfigArray, $container)
    {
        $navigationObjects = [];
        foreach ($navigationConfigArray as $navigationName => $naviParams) {
            if ($container->get($navigationName) instanceof \depa\NavigationMiddleware\Navigation\Navigation) {
                $navigationObjects[$navigationName] = $container->get($navigationName);
            }
        }
        $router = $container->get(RouterInterface::class);

        return new NavigationMiddleware($navigationObjects, $container->get(TemplateRendererInterface::class), $router);
    }
}
