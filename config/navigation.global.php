<?php

return [
    'depaNavigation' => [
        /*'Application\depaNavigation\DefaultNavigation' => [
            'data' => [
                'irgendwas' => [
                    'uri' => 'https://designpark.de',
                    'attributes' => [
                        'id' => 'l',
                        'class ' => 'Test_class'
                    ],
                    'route' => 'adminNavi',
                    'childs' => [
                        'subpath' => [
                            'uri' => '/appnavi',
                            'attributes' => [
                                'id' => 'l',
                                'class ' => 'Test2_class'
                            ],
                            'route' => 'appNavi',
                        ]
                    ]
                ]
            ],
            'permission_manager' => 'rbac'
        ],*/
        'navigations' => [
            'Application\depaNavigation\AppNavigation' => [
                'data' => [
                    'admNavi' => [
                        'uri'        => '/adminnavi',
                        'attributes' => [
                            'id'     => 'l',
                            'class ' => 'Test_class',
                        ],
                        'route'  => 'adminNavi',
                        'routeArguments' => [
                            'locale' => 'en',
                        ],
                        'childs' => [
                            'subpath' => [
                                'uri'        => '/appnavi',
                                'attributes' => [
                                    'id'     => 'l',
                                    'class ' => 'Test2_class',
                                ],
                                'route' => 'appNavi',
                            ],
                        ],
                    ],
                ],
                'permission_manager' => 'rbac',
            ],

            'Application\depaNavigation\AdminNavigation' => [
                'data' => [
                    'admin1' => [
                        'uri'        => '/appnavi',
                        'attributes' => [
                            'id'     => 'l',
                            'class ' => 'Test_class',
                        ],
                        'route'  => 'appnavi',
                        'childs' => [
                            'subadmin' => [
                                'uri'   => '/adminnavi',
                                'route' => 'adminNavi',
                            ],
                        ],
                    ],
                    'admin2' => [
                        'uri'   => '/adminnavi',
                        'route' => 'adminNavi',
                    ],
                ],
                'permission_manager' => 'rbac',
            ],
        ],
    ],
];
