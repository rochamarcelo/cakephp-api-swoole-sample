<?php

return [
    'CakeDC/Auth.api_permissions' => [
        [
            'role' => '*',
            'service' => ['Continents'],
            'action' => ['index', 'view'],
            'method' => 'GET',
            'bypassAuth' => true,
        ],
        [
            'role' => '*',
            'service' => ['Countries'],
            'action' => ['index', 'view'],
            'method' => 'GET',
            'bypassAuth' => true,
        ],
        [
            'role' => '*',
            'service' => ['Languages'],
            'action' => ['index', 'view'],
            'method' => 'GET',
            'bypassAuth' => true,
        ],
    ]
];
