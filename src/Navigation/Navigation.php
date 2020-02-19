<?php

namespace depa\NavigationMiddleware\Navigation;

use Knp\Menu\MenuFactory;
use Knp\Menu\Renderer\ListRenderer;

class Navigation
{
    private $data;

    private $activeRoute;

    private $routeParams;

    private $router;

    private $debug;

    public function __construct($naviStructure, $router, $debug)
    {
        $this->data = $naviStructure;
        $this->router = $router;
        $this->debug = $debug;
    }

    /**
     * Setzt die aktive Route.
     *
     * @param string $activeRoute
     */
    public function setRoute(string $activeRoute)
    {
        $this->activeRoute = $activeRoute;
    }

    /**
     * Setzt die übergebenen Parameter.
     *
     * @param array $routeParams
     */
    public function setParams(array $routeParams)
    {
        $this->routeParams = $routeParams;
    }

    /**
     * Gibt die momentane Route wieder.
     *
     * @return mixed
     */
    public function getRoute(): string
    {
        return $this->activeRoute;
    }

    /**
     * Gibt die momentan vorhanden Parameter zurück.
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->routeParams;
    }

    public function render(array $navi = null)
    {
        $factory = new MenuFactory();
        $menu = $factory->createItem('My menu');
        foreach ($this->data as $key => $item) {
            try {
                if(!isset($item['routeArguments'])){
                    $item['routeArguments'] = [];
                }
                if (!isset($item['uri'])) {
                    if (isset($item['route'])) {
                        $item['uri'] = $this->router->generateUri($item['route'], $item['routeArguments']);
                    }
                }
                $menu->addChild($key, $item);
                if (isset($item['route']) && strpos($this->activeRoute, $item['route']) !== false) {
                    $menu->addChild($key, $item)->setCurrent(true);
                }
                if (isset($item['childs'])) {
                    $this->renderChilds($menu[$key], $item['childs']);
                }
            } catch (\Exception $e) {
                if ($this->debug) {
                    throw new \Exception($e->getMessage());
                }
            }
        }
        $renderer = new ListRenderer(new \Knp\Menu\Matcher\Matcher());

        return $renderer->render($menu);
    }

    private function renderChilds($menu, array $childs)
    {
        foreach ($childs as $key => $item) {
            try {
                if (!is_array($item)) {
                    throw new \Exception('Error! Child must be type of Array!');
                }
                if(!isset($item['routeArguments'])){
                    $item['routeArguments'] = [];
                }
                if (!isset($item['uri'])) {
                    if (isset($item['route'])) {
                        $item['uri'] = $this->router->generateUri($item['route'], $item['routeArguments']);
                    }
                }
                $menu->addChild($key, $item);

                if (isset($item['childs'])) {
                    $this->renderChilds($menu[$key], $item['childs']);
                }
                if (isset($item['route']) && strpos($this->activeRoute, $item['route']) !== false) {
                    $menu->addChild($key, $item)->setCurrent(true);
                }
            } catch (\Exception $e) {
                if ($this->debug) {
                    throw new \Exception($e->getMessage());
                }
            }
        }
    }
}
