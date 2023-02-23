<?php
return [
    'lmc_mail' => [
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
            'mail/test_html' => __DIR__ . '/./view/test_html.phtml',
            'mail/test_text' => __DIR__ . '/./view/test_text.phtml',
        ],
    ],
];
