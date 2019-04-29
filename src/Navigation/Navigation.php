<?php


namespace depa\NavigationMiddleware\Navigation;


class Navigation
{
    private $data;

    public function __construct($navigationData)
    {
        $this->data = $navigationData;
    }
}