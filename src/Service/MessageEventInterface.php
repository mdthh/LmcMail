<?php
/**
 * @author Eric Richer <eric.richer@vistoconsulting.com
 *
 */

namespace LmcMail\Service;

use Laminas\Mail\Message;

interface MessageEventInterface extends \Laminas\EventManager\EventInterface
{
    /**
     * Set the message param
     * @param Message $message
     * @return void
     */
    public function setMessage(Message $message): void;

    /**
     * Returns the message param
     * @return Message
     */
    public function getMessage(): Message;
}
