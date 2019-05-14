<?php

namespace depa\NavigationMiddleware;

use depa\NavigationMiddleware\Middleware\NavigationMiddleware;
use depa\NavigationMiddleware\Middleware\NavigationMiddlewareFactory;
use depa\NavigationMiddleware\Navigation\Navigation;
use depa\NavigationMiddleware\Navigation\NavigationAbstractServiceFactory;
use depa\NavigationMiddleware\Navigation\NavigationServiceFactory;

class ConfigProvider
{
    /**
     * Return general-purpose zend-navigation configuration.
     *
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
        ];
    }

    /**
     * Return application-level dependency configuration.
     *
     * @return array
     */
    public function getDependencyConfig()
    {
        return [
            'abstract_factories' => [
                Navigation\NavigationAbstractServiceFactory::class,
            ],
            'factories' => [
                Navigation\Navigation::class => Navigation\NavigationServiceFactory::class,
                Middleware\NavigationMiddleware::class => Middleware\NavigationMiddlewareFactory::class
            ],
            'aliases' => [
                'navigation' => Navigation\Navigation::class
            ],
        ];
    }
}
