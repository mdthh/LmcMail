<?php
/**
 * @author Eric Richer <eric.richer@vistoconsulting.com
 *
 */

namespace LmcMail\Service;

use Laminas\Mail\Message;

class MessageEvent extends \Laminas\EventManager\Event implements MessageEventInterface
{

    const SEND = 'send';
    const SEND_POST = 'send_post';
    public Message $message;
    /**
     * @inheritDoc
     */
    public function setMessage(Message $message): void
    {
        $this->setParam('message', $message);
        $this->message = $message;
    }

    /**
     * @inheritDoc
     */
    public function getMessage(): Message
    {
        return $this->message;
    }
}
