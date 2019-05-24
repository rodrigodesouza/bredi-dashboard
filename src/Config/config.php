<?php

return [
    'name'      => 'BrediDashboard',
    'prefix'    => 'controle',
    'default'   => 'color-admin',
    'templates' => [
        'color-admin' => [
            'name' => 'bredicoloradmin',
        ],
        'admin-lte'   => [
            'name' => 'brediadminlte',
        ],
    ],
    'superadmin' => [
        'contato@bredi.com.br'
    ],
    'menu' => [
        
    ],
    'background_image' => [
        'input_file' => 'background_image',
        'destino' => 'background_image/',
        'resolucao' => ['h' => 1280, 'w' => 1280]
        // 'resolucao' => ['p' => ['h' => 200, 'w' => 200], 'g' => ['h' => 980, 'w' => 980]]
    ]
    ,
    'logo' => [
        'input_file' => 'logo',
        'destino' => 'company/',
        'resolucao' => ['p' => ['h' => 200, 'w' => 200], 'g' => ['h' => 30, 'w' => 100]]
    ]
];