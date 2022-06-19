<?php

return [
    'version'   => EXTREMIS_VERSION,
    'priority'  => 50,
    'dist_path' => get_theme_file_path().'/dist',
    'dist_uri'  => get_theme_file_uri().'/dist',
    'assets'    => [
        'admin' => [
            'styles'  => ['styles/admin.css'],
            'scripts' => ['scripts/admin.js'],
        ],
        'front' => [
            'styles'  => ['styles/main.css'],
            'scripts' => ['scripts/main.js'],
        ]
    ],
];
