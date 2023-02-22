<?php
return [
    'lmc_mail' => [
/*
        'type' => 'file',
        'options' => [
            'path' => __DIR__ . '/../data/emails',
        ],
*/
        'from' => [
            'email' => 'user@example.com',
            'name' => 'User',
        ],
        'transport' => [
            'type' => 'file',
            'options' => [
                'path' => __DIR__ . '/../data/emails',
            ],
        ]
    ],
    'view_manager' => [
        'template_map' => [
            'mail/test' => __DIR__ . '/./view/test.phtml',
            'mail/test_text' => __DIR__ . '/./view/test_text.phtml',
        ],
    ],
];
