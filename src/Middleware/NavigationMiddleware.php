<?php

namespace depa\NavigationMiddleware\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Router\RouteResult;

/**
 * Pipeline middleware for injecting Navigations with a RouteResult.
 */
class NavigationMiddleware implements MiddlewareInterface
{
    private $navigationObjects;

    private $renderer;

    private $router;

    /**
     * @param NavigationObjects[] $navigationObjects
     */
    public function __construct(array $navigationObjects, $renderer, $router)
    {
        $this->navigationObjects = $navigationObjects;
        $this->renderer = $renderer;
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {

        //$routeResult = $request->getAttribute(RouteResult::class, false);
        $routeResult = $this->router->match($request);
        if (!$routeResult instanceof RouteResult) {
            return $handler->handle($request);
        }

        foreach ($this->navigationObjects as $navigationName => $navigationObj) {
            $navigationObj->setRoute($routeResult->getMatchedRouteName());
            $navigationObj->setParams($routeResult->getMatchedParams());
            $this->renderer->addDefaultParam($this->renderer::TEMPLATE_ALL, substr($navigationName, strrpos($navigationName, '\\') + 1), $navigationObj->render());
        }

        return $handler->handle($request);
    }
}
