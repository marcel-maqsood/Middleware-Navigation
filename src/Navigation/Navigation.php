<?php

namespace depa\NavigationMiddleware\Navigation;

use Knp\Menu\MenuFactory;
use Knp\Menu\Renderer\ListRenderer;

class Navigation
{
    private $data;

    public function __construct($navigationData)
    {
        $this->data = $navigationData;
    }

    public function render(){
        $factory = new MenuFactory();
        $menu = $factory->createItem('My menu');
        foreach($this->data as $key => $attributes){
            $menu->addChild($key, $attributes);
            if(isset($attributes['route']) && $this->activeRoute === $attributes['route']){
                $menu->addChild($key, $attributes)->setCurrent(true);
            }
            if(isset($attributes['childs'])){
                foreach ($attributes['childs'] as $childKey => $child){
                    $menu[$key]->addChild($childKey, $child);
                    if(isset($attributes['route']) && $this->activeRoute === $child['route']){
                        $menu[$key]->addChild($childKey, $child)->setCurrent(true);
                    }
                }
            }
        }

        $renderer = new ListRenderer(new \Knp\Menu\Matcher\Matcher());
        return $renderer->render($menu);
    }
}
