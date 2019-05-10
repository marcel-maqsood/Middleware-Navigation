<?php

return [
    'depaNavigation' => [
        'navigations' => [
            'Application\depaNavigation\AppNavigation' => [
                'test' => [
                    'uri'        => 'https://test1.de',
                    'attributes' => [
                        'id'     => 'l',
                        'class ' => 'Test_class',
                    ],
                    'childs' => [
                        'subpath' => [
                            'uri' => 'https://test2.de',
                        ],
                    ],
                ],
                'test2' => [
                    'uri' => 'https://test2.de',
                ],
            ],

            'Application\depaNavigation\AdminNavigation' => [
                'admin1' => [
                    'uri'        => 'https://test1.de',
                    'attributes' => [
                        'id'     => 'l',
                        'class ' => 'Test_class',
                    ],
                    'childs' => [
                        'subadmin' => [
                            'uri'    => 'https://test2.de',
                            'childs' => [
                                'subadmin' => [
                                    'uri' => 'https://test2.de',
                                ],
                            ],
                        ],
                    ],
                ],
                'admin2' => [
                    'uri' => 'https://test2.de',
                ],
            ],
        ],
    ],
];
