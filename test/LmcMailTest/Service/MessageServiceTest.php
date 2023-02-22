<?php

namespace Service;

use Laminas\Mail\Message;
use Laminas\Mime\Message as MimeMessage;
use Laminas\ServiceManager\ServiceManager;
use Laminas\View\Model\ViewModel;
use LmcMail\Service\MessageService;
use LmcMailTest\Util\ServiceManagerFactory;

class MessageServiceTest extends \PHPUnit\Framework\TestCase
{
    protected MessageService|null $messageService;
    protected ServiceManager|null $serviceManager;

    protected string|null $path = null;

    public function setUp(): void
    {
        $this->serviceManager = ServiceManagerFactory::getServiceManager();
        $this->messageService = $this->serviceManager->get(MessageService::class);
        $this->deleteFiles($this->getPath());
    }

    public function tearDown(): void
    {
        $this->serviceManager = null;
        $this->messageService = null;
        $this->deleteFiles($this->getPath());
    }

    public function testCreateTextMessage()
    {
        $message = $this->messageService->createTextMessage([],[], 'test', 'mail/test_text');
        $this->assertInstanceOf(Message::class, $message);
        $body = $message->getBody();
        $this->assertIsString($body);
        $from = $message->getFrom();
        $addresses = $from->get('user@example.com');
        $this->assertNotFalse($addresses,'Address not found');
        $this->assertEquals('user@example.com', $addresses->getEmail(), "Was expecting email address to be user@example.com");
        $this->assertEquals('User', $addresses->getName(), "Was expecting name to be user");
    }

    public function testCreateHtmlMessage()
    {
        $viewModel = new ViewModel();
        $viewModel->setTemplate('mail/test_html');
        $message = $this->messageService->createHtmlMessage([],[], 'test',$viewModel);
        $this->assertInstanceOf(Message::class, $message);
        $body = $message->getBody();
        $this->assertInstanceOf(MimeMessage::class, $body);
        $from = $message->getFrom();
        $addresses = $from->get('user@example.com');
        $this->assertNotFalse($addresses,'Address not found');
        $this->assertEquals('user@example.com', $addresses->getEmail(), "Was expecting email address to be user@example.com");
        $this->assertEquals('User', $addresses->getName(), "Was expecting name to be user");
    }

    public function testSendMessage()
    {
        $message = $this->messageService->createTextMessage([],[], 'test', 'mail/test_text');
        $this->messageService->send($message);
        $files = glob($this->getPath() . '/*');
        $this->assertGreaterThan(0, count($files));
    }

    private function deleteFiles($path)
    {
        $files = glob(rtrim($path, '/') . '/*');
        foreach ($files as $file) unlink($file);
    }

    private function getPath()
    {
        if (!$this->path) {
            $config = $this->serviceManager->get('config');
            $this->path = $config['lmc_mail']['transport']['options']['path'];
        }
        return $this->path;
    }
}
