<?php

namespace MazeDEV\NavigationMiddleware\Navigation;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Mezzio\Router\RouterInterface;
use MazeDEV\SessionAuth\SessionAuthMiddleware;

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

        $sessionAuthMiddleware = $container->get(SessionAuthMiddleware::class) ?? null;
		$router = $container->get(RouterInterface::class) ?? null;
		if($router == null)
		{
			throw new \Exception('router service not found, you need atleast one RouterInterface within your application running.');
		}

        return new Navigation($config['mazenav'], $router, $sessionAuthMiddleware);
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
