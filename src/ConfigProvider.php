<?php

/**

 */

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
    public function getDependencyConfig(): array
    {
        return [
            'abstract_factories' => [
                Navigation\NavigationAbstractServiceFactory::class,
            ],
            'aliases' => [
                'navigation' => Navigation::class,
            ],
            'factories' => [
                Middleware\NavigationMiddleware::class => Middleware\NavigationMiddlewareFactory::class,
            ],
        ];
    }
}