<?php
/**
 * @author Eric Richer <eric.richer@vistoconsulting.com
 *
 */

namespace LmcMail\Service;

use Laminas\Mail\Address;
use Laminas\Mail\Address\AddressInterface;
use Laminas\Mail\AddressList;
use Laminas\Mail\Message;
use Laminas\Mail\Transport\TransportInterface;
use Laminas\Mime\Message as MimeMessage;
use Laminas\Mime\Mime;
use Laminas\Mime\Part as MimePart;
use Laminas\View\Model\ModelInterface;
use Laminas\View\Model\ViewModel;
use Laminas\View\Renderer\PhpRenderer;
use Traversable;

class MessageService
{
    /**
     * Renderer
     * @var PhpRenderer
     */
    protected PhpRenderer $renderer;

    /**
     * Mail Transport
     * @var TransportInterface
     */
    protected TransportInterface $transport;

    /**
     * default from
     * @var array
     */
    protected array $from = [];

    /**
     * Default layout template
     * @var string
     */
    protected string $layoutTemplate = 'mail/layout';


    /**
     * @param PhpRenderer $renderer
     * @param TransportInterface $transport
     * @param array $from
     */
    public function __construct(PhpRenderer $renderer, TransportInterface $transport, array $from=[])
    {
        $this->renderer = $renderer;
        $this->transport = $transport;
        $this->from = $from;
    }

    /**
     * @param PhpRenderer $renderer
     * @return $this
     */
    public function setRenderer(PhpRenderer $renderer): MessageService
    {
        $this->renderer = $renderer;
        return $this;
    }

    /**
     * @return PhpRenderer
     */
    public function getRenderer(): PhpRenderer
    {
        return $this->renderer;
    }

    /**
     * @param TransportInterface $transport
     * @return $this
     */
    public function setTransport(TransportInterface $transport): MessageService
    {
        $this->transport = $transport;
        return $this;
    }

    /**
     * @return TransportInterface
     */
    public function getTransport(): TransportInterface
    {
        return $this->transport;
    }

    /**
     * Set the layout template
     * @param string $layoutTemplate
     * @return $this
     */
    public function setLayoutTemplate(string $layoutTemplate): MessageService
    {
        $this->layoutTemplate = $layoutTemplate;
        return $this;
    }

    /**
     * Create an HTML message
     * @param string|Address|AddressInterface|array|AddressList|Traversable $from
     * @param string|Address|AddressInterface|array|AddressList|Traversable $to
     * @param string $subject
     * @param string|ModelInterface $nameOrModel
     * @return Message
     */
    public function createHtmlMessage(string|Address|AddressInterface|array|AddressList|Traversable $from,
                                      string|Address|AddressInterface|array|AddressList|Traversable $to,
                                      string $subject,
                                      string|ModelInterface $nameOrModel): Message
    {
        $view = new ViewModel();
        $view->setTemplate($this->layoutTemplate);

        if (is_string($nameOrModel)) {
            $childView = new ViewModel();
            $childView->setTemplate($nameOrModel);
        } else {
            $childView = $nameOrModel;
        }

        $view->addChild($childView,'message');
        $content = $this->render($view);

        $text = new MimePart('');
        $text->type = Mime::TYPE_TEXT;
        $html = new MimePart($content);
        $html->type = Mime::TYPE_HTML;
        $html->charset = 'utf-8';
        $html->encoding = Mime::ENCODING_QUOTEDPRINTABLE;
        $body = new MimeMessage();
        $body->setParts([$html]);
        return $this->getDefaultMessage($from, 'utf-8', $to, $subject, $body);
    }

    /**
     * Create a text message
     * @param string|Address|AddressInterface|array|AddressList|Traversable $from
     * @param string|Address|AddressInterface|array|AddressList|Traversable $to
     * @param string $subject
     * @param string|ModelInterface $nameOrModel
     * @return Message
     */
    public function createTextMessage(string|Address|AddressInterface|array|AddressList|Traversable $from,
                                      string|Address|AddressInterface|array|AddressList|Traversable $to,
                                      string $subject,
                                      string|ModelInterface $nameOrModel): Message
    {
        $content = $this->renderer->render($nameOrModel);
        return $this->getDefaultMessage($from, 'utf-8', $to, $subject, $content);
    }

    /**
     * Send the message
     * @param Message $message
     */
    public function send(Message $message): void
    {
        $this->transport->send($message);
    }

    /**
     * Create default message
     * @param string|Address|AddressInterface|array|AddressList|Traversable $from
     * @param string $encoding
     * @param string|array $to
     * @param string $subject
     * @param MimeMessage|string $body
     * @return Message
     */
    protected function getDefaultMessage(string|Address|AddressInterface|array|AddressList|Traversable $from, string $encoding, string|array $to, string $subject, MimeMessage|string $body): Message
    {
        $message = new Message();
        if (is_string($from)) {
            $from = ['email' => $from];
        } else if (is_array($from) || empty($from)) {
            $from = $this->from;
        }

        $message->setFrom($from['email'], $from['name'])
            ->setEncoding($encoding)
            ->setSubject($subject)
            ->setBody($body)
            ->setTo($to);
        return $message;
    }

    /**
     * @param $from
     * @return array|string[]
     */
    protected function getFrom($from):array
    {
        if (is_string($from)) {
            return ['email' => $from];
        }
        if (is_array($from) && !empty($from)) {
            return $from;
        }
        else return $this->from;
    }
    /**
     * Render the view model
     * @param ModelInterface $model
     * @return string
     */
    private function render(ModelInterface $model): string
    {
        if ($model->hasChildren()) {
            $this->renderChildren($model);
        }
        return $this->renderer->render($model);
    }

    /**
     * Loop through the children and render them into the model variables
     * @param ModelInterface $model
     */
    private function renderChildren($model): void
    {
        foreach ($model as $child) {
            $result = $this->render($child);
            $capture = $child->captureTo();
            if (! empty($capture)) {
                if ($child->isAppend()) {
                    $oldResult = $model->{$capture};
                    $model->setVariable($capture, $oldResult . $result);
                } else {
                    $model->setVariable($capture, $result);
                }
            }
        }
    }
}
