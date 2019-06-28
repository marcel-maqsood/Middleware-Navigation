# Middleware-Navigation

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![StyleCI](https://styleci.io/repos/183914100/shield?branch=master)](https://github.styleci.io/repos/183914100)
[![Coverage Status](https://coveralls.io/repos/github/depa-berlin/Middleware-Navigation/badge.svg?branch=master)](https://coveralls.io/github/depa-berlin/Middleware-Navigation?branch=master)
## Installation

Run the following to install this library:

```bash
$ composer require depa/middleware-navigation
```

## Documentation

To create a navigation, use the navigation.global.php (it's inside the config folder)
as your basic (put it into config\autoload)

The basic structure of a menu-item must look like this:
```php
'{navigation_Name}' => [
    'route' => '{route_name}', //route-name which is set in routes.php
]
```

<br/>

if you want to add attributes to a menu-item (to the ul element), do this:
```php
'{navigation_Name}' => [
    'attributes' => [...], //possibilitys in attributes-table described (at the bottom of the doc)
]
```

<br/>

if you want to add link-attributes to a menu-item (to the a element), do this:
```php
'{navigation_Name}' => [
    'linkAttributes' => [...], //possibilitys in link-attributes-table described (at the bottom of the doc)
]
```

<br/>

if you want to add child-items to a menu-item, do this (you can use as many as you want):
```php
'{navigation_Name}' => [
    'childs' => [...], //build the same as a normal menu-item
]
```

<br/>

if you want to force a link-direction to an item then add this:

```php
'{navigation_Name}' => [
    'uri' => '{https://www.designpark.de}',
]
```

<br/>

a menu-item which contains any of the given examples could look like this:
```php
'{navigation_Name}' => [
    'route' => '{route_name}',
    'uri' => '{https://www.designpark.de}',
    'attributes' => [
        'id' => '{some_id}',
        'class' => ['{class1} {class2}'],
    ],
    'linkAttributes' => [
        'id' => '{some_id}',
        'class' => '{class_1} {class2}',
    ],
    'childs' => [
        '{childNavigation_Name}' => [
            'route' => '{route_name}',
            'uri' => '{https://www.designpark.de}',
            'attributes' => [],
            'linkAttributes' => [],
            'childs' => [],
        ]
    ]
]
```

<br/>

The example provided above would output the following HTML:
```
<ul>
    <li id="{some_id} class="{class1 class2} first last">
        <a href="{https://www.designpark.de}">{navigationName}</a>
        <ul class="menu_level_1">
            <li class="first last">
                <a href="{https://www.designpark.de}">{childNavigationName}</a>
            </li>
        </ul>
    </li>
</ul>
```
which would look like this:
<ul>
    <li id="{some_id} class="{class1 class2} first last">
        <a href="{https://www.designpark.de}">{navigationName}</a>
        <ul class="menu_level_1">
            <li class="first last">
                <a href="{https://www.designpark.de}">{childNavigationName}</a>
            </li>
        </ul>
    </li>
</ul>

<br/>

Attributes you could use and what they do:

|Attribute|Description|Example
|---------|-----------|-------|
|  Id     |  Sets the id of the element  |  'id' => 'some_id'
|  class  |  Sets the classes of the elements  |  'class' => 'class1 class2'|


<br/>

Link-Attributes you could use and what they do:

|Attribute|Description|Example
|---------|-----------|------|
|  Id     |  Sets the id of the element | 'id' => 'some_id'
|  Class  |  Sets the classes of the element  |  'class' => 'class1 class2'
|  Target |  Sets the target-window of the element  |  'target' => '_blank'


we did not listed every link-/attribute, take a closer look at [knpLabs/KnpMenu](https://github.com/KnpLabs/KnpMenu/blob/master/doc/01-Basic-Menus.markdown#menu-attributes) for more informations!



## Credits

This bundle is inspired by [Zend Framework](https://framework.zend.com). It has been developed by [designpark](https://www.designpark.de).


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

