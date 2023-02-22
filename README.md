# LmcEmail

An email service module that provides the ability to use the View renderer of a Laminas MVC application
and the installed View Helper plugins to render HTML emails.


## Requirements

- PHP 8.1 or higher
- Laminas MVC

## Installation

Install the module:

````shell
$ composer require lm-commons/lmc-mail
````

Composer will inject the module into the modules configuration or you can add it manually to the `modules.config.php` or
`application.config.php`.

Customize the module by copying and renaming the sample configuration file `lm-commons/lmc-mail/config/lmcmail.local.php.dist` to the application's 
`config/autoload`.

## Configuration

LmcMail supports with the Laminas SMTP Mail Transport or the Laminas File Mail Transport and this is configured by the `transport` config key in the `lmcmail.local.php` file:

````php
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
````
In a development environment, it is typical to use a File Mail Transport.  In a production environment, a SMTP Mail Transport will more likely be used.

The `'transport'` configuration must comply with the `Laminas\Mail\Transport\Factory\Factory::create` method.

The `'from'` configuration defines a default *from* address.  The *from* address can also be specified at message creation.

## Usage

The Mail service can be retrieved from the service manager:

````php
$messageService = $serviceManager->get(LmcMail\Service\MessageService::class);
````

Basic example to send an HTML email:

````php
$viewModel = new \Laminas\View\Model\ViewModel();
$viewModel->setTemplate('mail/html');
$message = $messageService->createHtmlMessage(
    ['email' => 'john@example.com', 'name' => 'John'], //from 
    ['email' => 'jane@example.com', 'name' => 'Jane'] //to
    "This is the subject line, //subject
    $viewModel); // View model

$messageService->send($message);
````

The `'mail/html'` template must exist in the application's view template map. The HTML mail renderer will use
a layout template aliased as `'mail/layout'` in the view template map. This is defined in the `module.config.php` file.

### Available methods

#### createHtmlMessage

````php
createHtmlMessage(string|array $from, string|array $to, string $subject, ModelInterface $nameOrModel, array $values=[]): \Laminas\Mime\Message::class
````

#### createTextMessage
````php
createTextMessage(string|array $from, string|array $to, string $subject, ModelInterface $nameOrModel, array $values=[]): \Laminas\Mail\Message::class
````

#### send
````php
send(MailMessage $message): void
````
