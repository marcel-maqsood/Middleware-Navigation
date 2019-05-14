<?php

namespace depa\NavigationMiddleware;

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
