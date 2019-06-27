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
as your basic (put it into config/autoload)


if you want to add a menu-item to the navigation, 
provide the following structure inside of the data array: 
```php
'{navigationpoint}' => [
    'uri' => '{path}', //if not set, the navigation will try to get a link by the route-name
    'route' => '{route}', //route-name of route (e.g. FastRoute)
    ];
```

if you want to use sub-items on the one you just created,
the use the following inside your item:
```php
'childs' => [
    'child1' => [
        'uri' => '{path}',
        'route' => '{route}',
    ],
]
```

if you want to use attributes for the "ul HTML-element"-item, 
then add (whatever you need of those) to the menu-item you just added:
```php
'attributes' => [
    'id' => '{id}',
    'class' => '{classes seperated by space}', //if not set, default is 'current' and used to provide highlighting
    'label' => '{label}',   
],
```

you might also want to define attributes to the "a HTML-element"-item, 
if so add (whatever you need of those) the following:
```php
'linkAttributes' => [
    'id' => '{id}',
    'class' => '{classes seperated by space}',
    'target' => '{target}' //example: '_blank'
],
```

## Credits

This bundle is inspired by [Zend Framework](https://framework.zend.com). It has been developed by [designpark](https://www.designpark.de).


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

