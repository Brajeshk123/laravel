<?php

return [

    [
        'title' => 'Dashboard',
        'icon' => 'bi bi-speedometer2',
        'route' => 'admin.dashboard',
        'permission' => 'view dashboard',
    ],

    [
        'title' => 'Content',
        'icon' => 'bi bi-folder',
        'children' => [

            [
                'title' => 'Contents',
                'route' => 'admin.contents.index',
                'permission' => 'view contents',
            ],

            [
                'title' => 'Categories',
                'route' => 'admin.categories.index',
                'permission' => 'view categories',
            ],

            [
                'title' => 'Tags',
                'route' => 'admin.tags.index',
                'permission' => 'view tags',
            ],

            [
                'title' => 'Media Library',
                'route' => 'admin.media.index',
                'permission' => 'view media',
            ],

        ]
    ],

    [
        'title' => 'Administration',
        'icon' => 'bi bi-shield-lock',

        'children' => [

            [
                'title' => 'Users',
                'route' => 'admin.users.index',
                'permission' => 'view users',
            ],

            [
                'title' => 'Roles',
                'route' => 'admin.roles.index',
                'permission' => 'view roles',
            ],

            [
                'title' => 'Permissions',
                'route' => 'admin.permissions.index',
                'permission' => 'view permissions',
            ],

        ]
    ],

    [
        'title' => 'Website',
        'icon' => 'bi bi-globe',

        'children' => [

            [
                'title' => 'Menus',
                'route' => 'admin.menus.index',
                'permission' => 'view menus',
            ],

            [
                'title' => 'Settings',
                'route' => 'admin.settings.index',
                'permission' => 'manage settings',
            ],

        ]
    ],

];