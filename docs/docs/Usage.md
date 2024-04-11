---
sidebar_position: 4
---
The Mail service can be retrieved from the service manager:

```php
$messageService = $serviceManager->get(LmcMail\Service\MessageService::class);
```

Basic example to send an HTML email:

```php
$viewModel = new \Laminas\View\Model\ViewModel();
$viewModel->setTemplate('mail/html');
$message = $messageService->createHtmlMessage(
    ['email' => 'john@example.com', 'name' => 'John'], //from 
    ['email' => 'jane@example.com', 'name' => 'Jane'] //to
    "This is the subject line, //subject
    $viewModel); // View model

$messageService->send($message);
```

The `'mail/html'` template must exist in the application's view template map. The HTML mail renderer will use
a layout template aliased as `'mail/layout'` in the view template map. This is defined in the `module.config.php` file.

## Available methods

### createHtmlMessage

````php
 /**
  * Create an HTML message
  * @param string|Address|AddressInterface|array|AddressList|Traversable $from
  * @param string|Address|AddressInterface|array|AddressList|Traversable $to
  * @param string $subject
  * @param string|ModelInterface $nameOrModel
  * @return Message
  */
createHtmlMessage(string|Address|AddressInterface|array|AddressList|Traversable $from, 
                  string|Address|AddressInterface|array|AddressList|Traversable $to, 
                  string $subject, 
                  string|ModelInterface $nameOrModel): \Laminas\Mime\Message::class
````
If `$nameorModel` is a string, it must correspond to the view template to use.


### createTextMessage
````php
/**
 * Create a text message
 * @param string|Address|AddressInterface|array|AddressList|Traversable $from
 * @param string|Address|AddressInterface|array|AddressList|Traversable $to
 * @param string $subject
 * @param string|ModelInterface $nameOrModel
 * @return Message
 */
createTextMessage(string|Address|AddressInterface|array|AddressList|Traversable $from, 
                  string|Address|AddressInterface|array|AddressList|Traversable $to, 
                  string $subject, 
                  ModelInterface $nameOrModel): \Laminas\Mail\Message::class
````
If `$nameorModel` is a string, it must correspond to the view template to use.

### send
````php
/**
 * Send the message
 * @param Message $message
 */
send(Message $message): void
````
where `$message` can be any object of type `\Laminas\Mail\Message` not necessarily one created by the above methods.
