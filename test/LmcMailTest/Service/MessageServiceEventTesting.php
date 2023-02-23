<?php

namespace Service;

use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\Mail\Message;
use Laminas\ServiceManager\ServiceManager;
use LmcMail\Service\MessageEvent;
use LmcMail\Service\MessageService;
use LmcMailTest\Service\PreSendListener;
use LmcMailTest\Util\ServiceManagerFactory;

class MessageServiceEventTesting extends \PHPUnit\Framework\TestCase implements ListenerAggregateInterface
{
    protected ServiceManager $serviceManager;
    protected MessageService $messageService;

    private Message $onSendMessage;
    private Message $onSendPostMessage;

    public function setUp(): void
    {
        $this->serviceManager = ServiceManagerFactory::getServiceManager();
        $this->messageService = $this->serviceManager->get(MessageService::class);
    }

    public function testPreSendEvent()
    {
        // Attach a listener
        $this->attach($this->messageService->getEventManager());
        $message = $this->messageService->createTextMessage([], ['test@example.com'], 'Test', 'mail/test_text');
        $this->messageService->send($message);
        $this->assertEquals($message, $this->onSendMessage);
        $this->assertEquals($message, $this->onSendPostMessage);
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $events->attach(MessageEvent::SEND, [$this, 'onSend']);
        $events->attach(MessageEvent::SEND_POST, [$this, 'onSendPost']);
    }

    public function detach(EventManagerInterface $events)
    {
        // TODO: Implement detach() method.
    }

    public function onSend(MessageEvent $event)
    {
        $this->onSendMessage = $event->getMessage();
    }

    public function onSendPost(MessageEvent $event)
    {
        $this->onSendPostMessage = $event->getMessage();
    }
}
