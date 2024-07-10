# Middleware-Navigation


## Installation

Run the following to install this library:

```bash
$ composer require marcel-maqsood/middleware-navigation
```

## Documentation

After installing the module, you have to implement the navigation-middleware into your pipeline,
so you basically add this line above the RouteMiddleware:
```php
     $app->pipe(MazeDEV\NavigationMiddleware\Middleware\NavigationMiddleware::class);
```

<br/>

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
    'attributes' => [...], //possibilities in attributes-table described (at the bottom of the doc)
]
```

You could also add a nice little icon infront of your List Item by configuring it like that:
```php
'{navigation_Name}' => [
    'display' => 'fas fa-home nav-icon' // Would display a home icon infront of your link
]
```

<br/>

if you want to add link-attributes to a menu-item (to the a element), do this:
```php
'{navigation_Name}' => [
    'linkAttributes' => [...], //possibilities in link-attributes-table described (at the bottom of the doc)
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
    'uri' => '{https://www.technikhafen.de}',
]
```

<br/>

A menu-item which contains any of the given examples could look like this:
```php
'{navigation_Name}' => [
    'display' => 'fas fa-home nav-icon'
    'route' => '{route_name}',
    'permission' => 'somePermission',
    'uri' => '{https://www.technikhafen.de}',
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
            'display' => 'fas fa-home nav-icon'
            'route' => '{route_name}',
            'permission' => 'somePermission2',
            'uri' => '{https://www.technikhafen.de}',
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
        <a href="{https://www.technikhafen.de}">{navigationName}</a>
        <ul class="menu_level_1">
            <li class="first last">
                <a href="{https://www.technikhafen.de}">{childNavigationName}</a>
            </li>
        </ul>
    </li>
</ul>
```

Which would look like this:
<ul>
    <li id="{some_id}" class="{class1 class2} first last">
        <a href="{https://www.technikhafen.de}">
            <i class="fas fa-tachometer-alt nav-icon"></i>
            {navigationName}
        </a>
        <ul class="menu_level_1">
            <li class="first last">
                <a href="{https://www.technikhafen.de}">
                    <i class="fas fa-tachometer-alt nav-icon"></i>
                    {childNavigationName}
                </a>
            </li>
        </ul>
    </li>
</ul>

<br/>

Keep in mind that at some point you either have to add our Middleware: NavigationMiddleware inside of your pipeline (that way you will always be able to use the rendered menu):
#### If you want to add our Middleware in your pipeline, it is crucial to include our SessionAuthMiddleware *AFTER* the ```Mezzio\Helper\UrlHelperMiddleware``` which is included in every base pipeline: ####
```
$app->pipe(UrlHelperMiddleware::class);
$app->pipe(NavigationMiddleware::class);
```

If you want to use our ```MazeDEV\SessionAuth\SessinAuthMiddleware``` for permission handling within the NavigationMiddleware, you also need to include our NavigationMiddleware *AFTER* our SessionAuthMiddleware:
```
$app->pipe(UrlHelperMiddleware::class);
$app->pipe(SessionAuthMiddleware::class);
$app->pipe(NavigationMiddleware::class);
```
Thats the only way you can use these middlewares combined within a global scope.


However, you could also include the Middlewares within your routes:
```
$app->route('/user[/]',
        [
            MazeDEV\SessionAuth\SessionAuthMiddleware::class,
            MazeDEV\NavigationMiddleware\Middleware\NavigationMiddleware::class,
            MazeDEV\SessionAuth\LoginHandler\GlobalLoginHandler::class
        ],
        [
            'GET',
            'POST'
        ],
        'userLogin'
    );
```

But as stated above, it is way easier and much better maintainable to just add it to your pipeline.


#### Permission based Naviagation ####
Our NavigationMiddleware is capable of rendering only navigation elements, that  the user has permissions for.
This is achived by including our [SessionAuthMiddleware](https://github.com/marcel-maqsood/Mezzio-Session-Auth-Middleware/)
The NaviagationMiddleware will only check for permissions if the SAM is present, otherwise it will render every element you supplied.
You can either work with the "route" param of each object as their permission (always) or also check against another permission, defined in "permission" entry.



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


We did not listed every link-/attribute, take a closer look at [knpLabs/KnpMenu](https://github.com/KnpLabs/KnpMenu/) for more informations!



## Credits

This Software has been developed by MazeDEV/Marcel-Maqsood(https://github.com/marcel-maqsood/).


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

