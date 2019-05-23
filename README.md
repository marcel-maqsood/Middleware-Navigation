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

...


```php
 '{navigationpoint}' => [
                    'uri' => '{path}',//evtl. überflüssig
                    'attributes' => [
                        'id' => '{id from html-element}',
                        'class ' => '{css-class}'
                    ],
                    'route' => '{route}', //Bezeichner der Route
                    ];
```


## Credits

This bundle is inspired by [Zend Framework](https://framework.zend.com). It has been developed by [designpark](https://www.designpark.de).


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

