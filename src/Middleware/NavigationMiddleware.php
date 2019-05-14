<?php

namespace depa\NavigationMiddleware\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RecursiveIteratorIterator;
use Zend\Expressive\Navigation\Page\ExpressivePage;
use Zend\Expressive\Router\RouteResult;
use Zend\Navigation\AbstractContainer;
use Zend\Navigation\Exception;

/**
 * Pipeline middleware for injecting Navigations with a RouteResult.
 */
class NavigationMiddleware implements MiddlewareInterface
{
    private $navigationObjects;

    /**
     * @param NavigationObjects[] $navigationObjects
     */
    public function __construct(array $navigationObjects)
    {
        $this->navigationObjects = $navigationObjects;
    }

    /**
     * @inheritDoc
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {


        $routeResult = $request->getAttribute(RouteResult::class, false);

        if (!$routeResult instanceof RouteResult) {
            return $handler->handle($request);
        }

        foreach ($this->navigationObjects as $naviObj) {
            $naviObj->setRoute($routeResult->getMatchedRouteName());
            $naviObj->setParams($routeResult->getMatchedParams());
        }
        return $handler->handle($request);
    }
}
