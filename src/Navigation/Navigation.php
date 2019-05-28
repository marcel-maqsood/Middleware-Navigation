<?php

namespace depa\NavigationMiddleware\Navigation;

use Knp\Menu\MenuFactory;
use Knp\Menu\Renderer\ListRenderer;

class Navigation
{
    private $data;

    private $activeRoute;

    private $routeParams;

    public function __construct($navigationData)
    {
        $this->data = $navigationData;
    }

    /**
     * Setzt die aktive Route.
     *
     * @param string $activeRoute
     */
    public function setRoute(string $activeRoute){
        $this->activeRoute = $activeRoute;
    }

    /**
     * Setzt die übergebenen Parameter.
     *
     * @param array $routeParams
     */
    public function setParams(array $routeParams){
        $this->routeParams = $routeParams;
    }

    /**
     * Gibt die momentane Route wieder.
     *
     * @return mixed
     */
    public function getRoute() : string{
        return $this->activeRoute;
    }

    /**
     * Gibt die momentan vorhanden Parameter zurück
     *
     * @return array
     */
    public function getParams() : array{
        return $this->routeParams;
    }

    public function render(array $navi = null)
    {
        $factory = new MenuFactory();
        $menu = $factory->createItem('My menu');
        foreach ($this->data as $key => $attributes) {
            $menu->addChild($key, $attributes);
            if (isset($attributes['route']) && $this->activeRoute === $attributes['route']) {
                $menu->addChild($key, $attributes)->setCurrent(true);
            }
            if (isset($attributes['childs'])) {
                foreach ($attributes['childs'] as $childKey => $child) {
                    $menu[$key]->addChild($childKey, $child);
                    
                    $this->renderChilds($menu[$key], $attributes['childs']);
                }
            }
        }
        
        $renderer = new ListRenderer(new \Knp\Menu\Matcher\Matcher());
        return $renderer->render($menu);
    }
    
    private function renderChilds($menu, array $childs)
    {
        foreach ($childs as $childKey => $child) {
            if (! is_array($child)) {
                break;
            }
            if (is_null($menu)) {
                throw new \Exception("Error! no menu defined!");
            }
            $menu->addChild($childKey, $child);
            
            if (isset($child['childs'])) {
                $this->renderChilds($menu[$childKey], $child['childs']);
            }
            if (isset($child['route']) && $this->activeRoute === $child['route']) {
                $menu->addChild($childKey, $child)->setCurrent(true);
            }
        }
    }
}
