<?php

declare(strict_types=1);

use MazeDEV\NavigationMiddleware\Navigation\Navigation;

return [
    'mazenav' => [
        Navigation::class => [
            'data'               => [
                'Teilnehmerbereich'  => [
                    'display'        => 'fas fa-home nav-icon',
                    'route'          => 'home',
                    'attributes'     => [
                        'id'     => '_user_landing_',
                        'class ' => 'nav-item menu-open',
                    ],
                    'linkAttributes' => [
                        'id'    => '_',
                        'class' => 'nav-link',
                    ],
                ],
                'User Dashboard' => [
                    'display'        => 'fas fa-tachometer-alt nav-icon',
                    'route'          => 'userLanding',
                    'attributes'     => [
                        'class ' => 'nav-item menu-open',
                    ],
                    'linkAttributes' => [
                        'id'    => '_user_landing_',
                        'class' => 'nav-link',
                    ],
                ],
                'Admin Dashboard' => [
                    'display'        => 'fas fa-tachometer-alt nav-icon',
                    'route'          => 'adminLanding',
                    'attributes'     => [
                        'class ' => 'nav-item menu-open',
                    ],
                    'linkAttributes' => [
                        'id'    => '_admin_landing_',
                        'class' => 'nav-link',
                    ],
                ],
            ],
        ],
    ],
];
