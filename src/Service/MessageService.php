<?php
/**
 * @author Eric Richer <eric.richer@vistoconsulting.com
 *
 */

namespace LmcMail\Service;

use Exception;
use Laminas\Mail\Message;
use Laminas\Mail\Message as MailMessage;
use Laminas\Mail\Transport\TransportInterface;
use Laminas\Mime\Message as MimeMessage;
use Laminas\Mime\Mime;
use Laminas\Mime\Part as MimePart;
use Laminas\View\Model\ModelInterface;
use Laminas\View\Model\ViewModel;
use Laminas\View\Renderer\PhpRenderer;

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

    public function setRenderer(PhpRenderer $renderer): MessageService
    {
        $this->renderer = $renderer;
        return $this;
    }

    public function getRenderer(): PhpRenderer
    {
        return $this->renderer;
    }

    public function setTransport(TransportInterface $transport): MessageService
    {
        $this->transport = $transport;
        return $this;
    }

    public function getTransport(): TransportInterface
    {
        return $this->transport;
    }


    /**
     * Create an HTML message
     * @param string|array $from
     * @param string|array $to
     * @param string $subject
     * @param ModelInterface $nameOrModel
     * @param array $values
     * @return Message
     * @throws Exception
     */
    public function createHtmlMessage(string|array $from, string|array $to, string $subject, ModelInterface $nameOrModel, array $values=[]): Message
    {
        $view = new ViewModel();
        $view->setTemplate('mail/layout');

        if (!$nameOrModel instanceof ModelInterface) {
            throw new Exception('$nameOrModel must be a View Model');
        }
        $view->addChild($nameOrModel,'message');
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
     * @param string|array $from
     * @param string|array $to
     * @param string $subject
     * @param ModelInterface $nameOrModel
     * @param array $values
     * @return Message
     */
    public function createTextMessage(string|array $from, string|array $to, string $subject, ModelInterface $nameOrModel, array $values=[]): Message
    {
        $content = $this->renderer->render($nameOrModel, $values);
        return $this->getDefaultMessage($from, 'utf-8', $to, $subject, $content);
    }

    /**
     * Send the message
     * @param MailMessage $message
     */
    public function send(MailMessage $message): void
    {
        $this->transport->send($message);
    }

    /**
     * Create default message
     * @param string|array $from
     * @param string $encoding
     * @param string|array $to
     * @param string $subject
     * @param Message|string $body
     * @return MailMessage
     */
    protected function getDefaultMessage(string|array $from, string $encoding, string|array $to, string $subject, MimeMessage|string $body): MailMessage
    {
        $message = new MailMessage();
        if (is_string($from)) {
            $from = [
                'email' => $from,
                'name' => $from,
            ];
        } else if (!is_array($from) || empty($from)) {
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
            return [
                'email' => $from,
                'name' => $from,
            ];
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
