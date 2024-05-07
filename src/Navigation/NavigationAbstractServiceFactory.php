<?php

namespace MazeDEV\NavigationMiddleware\Navigation;

use Interop\Container\ContainerInterface;
use MazeDEV\SessionAuth\SessionAuthMiddleware;
use Mezzio\Router\RouterInterface;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 * Database adapter abstract service factory.
 *
 * Allows configuring several database instances (such as writer and reader).
 */
class NavigationAbstractServiceFactory implements AbstractFactoryInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * Can we create a navigation by the requested name?
     *
     * @param ContainerInterface $container
     * @param string             $requestedName
     *
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $config = $this->getConfig($container);
        if (empty($config)) 
        {
            return false;
        }

        return
            isset($config[$requestedName])
            && is_array($config[$requestedName])
            && !empty($config[$requestedName]);
    }

    /**
     * Determine if we can create a service with name (SM v2 compatibility).
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param string                  $name
     * @param string                  $requestedName
     *
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return $this->canCreate($serviceLocator, $requestedName);
    }

    /**
     * Create a DB adapter.
     *
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array              $options
     *
     * @return Navigation
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $this->getConfig($container);
        $router = $container->get(RouterInterface::class);
		$sessionAuthMiddleware = $container->get(SessionAuthMiddleware::class) ?? null;
        $naviStructure = $config[$requestedName]['data'];
        $debug = $container->get('config')['debug'];
        if ($debug !== true)
        {
            $debug = false;
        }

        return new Navigation($naviStructure, $router, $sessionAuthMiddleware, $debug);
    }

    /**
     * Create service with name.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param string                  $name
     * @param string                  $requestedName
     *
     * @return Navigation
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return $this($serviceLocator, $requestedName);
    }

    /**
     * Get db configuration, if any.
     *
     * @param ContainerInterface $container
     *
     * @return array
     */
    protected function getConfig(ContainerInterface $container)
    {
        if ($this->config !== null) 
        {
            return $this->config;
        }

        if (!$container->has('config')) 
        {
            $this->config = [];

            return $this->config;
        }

        $config = $container->get('config');
        if (!isset($config['mazenav'])
            || !is_array($config['mazenav'])
        ) 
        {
            $this->config = [];

            return $this->config;
        }

        $config = $config['mazenav'];
        if (!isset($config['navigations'])
            || !is_array($config['navigations'])
        ) 
        {
            $this->config = $config;

            return $this->config;
        }

        $this->config = $config['navigations'];

        return $this->config;
    }
}
