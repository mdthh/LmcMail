<?php

return [
    // For Linux
    /*
    'lmc_mail' => [
        'type' => 'smtp',
        'options' => [
            'host' => 'example.com',
            'connection_class' => 'plain',
            'connection_config' => [
                'ssl' => 'tls',
                'username' => 'user@example.com',
                'password' => 'somepassword',
            ],
            'port' => 587,
        ],
        'from' => [
            'email' => 'user@example.com',
            'name' => 'User',
        ],
    ],
    */
    // For local dev
    'lmc_mail' => [
        'type' => 'file',
        'options' => [
            'path' => __DIR__ . '/../data',
        ],
        'from' => [
            'email' => 'user@example.com',
            'name' => 'User',
        ],
    ],
];
