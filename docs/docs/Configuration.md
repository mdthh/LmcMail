---
sidebar_position: 3
---
LmcMail supports the Laminas SMTP Mail Transport or the Laminas File Mail Transport and this is configured by the `transport` config key in the `lmcmail.local.php` file:

```php title="/config/autoload/lmcmail.local.php"
<?php
return [
    'lmc_mail' => [
        'from' => [
            'email' => 'user@example.com',
            'name' => 'User',
        ],

        // For SMTP
        'transport' => [
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
        ]    
         // OR
            
        'transport' => [
            'type' => 'file',
            'options' => [
                'path' => '/path/to/email/folder',
            ],
        ],
    ],
];
```
In a production environment, an SMTP Mail Transport will more likely be used.

In a development environment, it is typical to use a File Mail Transport to write message to files to validate the
rendered output.

The `'transport'` configuration must comply with the `Laminas\Mail\Transport\Factory\Factory::create` method.

The `'from'` configuration defines a default *from* address.  The *from* address can also be specified at message creation.
