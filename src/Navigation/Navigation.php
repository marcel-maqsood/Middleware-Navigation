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
            $menu->addChild($key, $attributes);//Wie bringt man eine Navi unter, die childs, und childs von childs hat?
            if(isset($attributes['childs'])){
                foreach ($attributes['childs'] as $childKey => $child){
                    $menu[$key]->addChild($childKey, $child);
                }
            }
        }

        $renderer = new ListRenderer(new \Knp\Menu\Matcher\Matcher());
        return $renderer->render($menu);
    }
}