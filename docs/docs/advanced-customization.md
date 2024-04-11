---
sidebar_position: 5
title: Advanced Configuration
---
LmcMail can be customized to the applications needs.

#### Using view templates

LmcMail uses nested view models to render the body of HTML messages.

In a similar fashion to the view model structure of the Laminas MVC Skeleton,
the body is rendered using a layout view model to which the view model parameter (`$nameOrModel`) to the 
`createHtmlMessage` method is added a child.
The rendered output of the `$nameOrModel` view model is captured in the variable `message` which is passed to the layout view model.

A default template `'mail/layout'` is supplied in `lm-commons/lmc-mail/view/layout/layout.phtml`. This template can be 
the starting point for your own layout template.
The layout template can be set using the `setLayoutTemplate()` method. Alternatively,
the `'mail/layout'` entry in the View Manager template map can be overridden to point to your template. Another 
alternative is to use a factory delegator to the `MessageServiceFactory::class` to set the layout template after the 
Message Service is created.

View Helpers can be used when rendering view models. A common use case is to use `$this->url()` to render a link to your 
application.

#### Use alternate View Resolved and View Helper Manager

LmcMail uses Service Manager aliases to get the View Resolver and View Helper Manager which resolves to the 
Laminas MVC View resolver and manager. This allows to use any view template and helpers already defined in the application.

````php
'aliases' => [
    // These aliases are used by the MailViewRendererFactory
    // by default, they resolve to the Laminas MVC View Helper manager and Resolver
    'lmc_mail_view_helper_manager' => 'ViewHelperManager',
    'lmc_mail_view_resolver' => 'ViewResolver',
],
````
If you want to use a different resolver and view helper manager, then update the aliases to point to your classes:

````php
'aliases' => [
    'lmc_mail_view_helper_manager' => 'MyHelperManager',
    'lmc_mail_view_resolver' => 'MyViewResolver',
],
````

If you want to use your own renderer, then you can override the Service Manager factory:
````php
'factories' => [
    // Override the factory with your own
    'lmc_mail_view_renderer' => MyViewRendererFactory::class,
    /* ... */
],
````

### Event Listening

`MessageService::send()` triggers two events:

- `MessageEvent::SEND` is triggered right before the message is sent by the transport service.
- `MessageEvent::SEND_POST` is triggered right after the message has been sent by the transport service.

A listener to these events will receive an event of class `LmcMail\Service\MessageEvent` that extends the `\Laminas\EventManager\Event` 
class with:

- A `$message` property containing the message. The message is also stored in an event parameter named 'message'.
- A `getMessage()` method to get the `$message` property.
- A `setMessage(Message $message)` method to set the `$message` property and the corresponding event parameters.

The `MessageService::send()` method, after triggering the `MessageEvent::SEND` event, will retrieve the message from the event and pass it to the transport service. This allows for the listener to modify the message if needed.

A typical use case for listening to the send events would be to log that a message was sent.
