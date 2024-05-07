<?php

namespace MazeDEV\NavigationMiddleware\Navigation;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

class NavigationServiceFactory implements FactoryInterface
{
    /**
     * Create navigation service.
     *
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array              $options
     *
     * @return Navigation
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');

        $sessionAuthMiddleware = $container->get(MazeDEV\SessionAuth\SessinAuthMiddleware::class) ?? null;

        return new Navigation($config['mazenav']);
    }

    /**
     * Create db adapter service (v2).
     *
     * @param ServiceLocatorInterface $container
     *
     * @return Adapter
     */
    public function createService(ServiceLocatorInterface $container)
    {
        return $this($container, Navigation::class);
    }
}
