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
                Navigation\NavigationInterface::class => Navigation\NavigationServiceFactory::class,
            ],
            'aliases' => [
                Navigation\Navigation::class => Navigation\NavigationInterface::class,
            ],
        ];
    }
}
