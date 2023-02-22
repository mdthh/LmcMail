<?php

namespace LmcMail\Options;

use Laminas\Mail\Transport\Factory;
use Laminas\Mail\Transport\TransportInterface;
use Laminas\Stdlib\AbstractOptions;

class MailOptions extends AbstractOptions
{
    protected array $from = [
        'email' => 'user@example.com',
        'name' => 'User',
    ];

    protected TransportInterface $transport;

    /**
     * Set from
     * @param array $from
     * @return $this
     */
    public function setFrom(array $from): MailOptions
    {
        $this->from = $from;
        return $this;
    }

    /**
     * Get from
     * @return array|string[]
     */
    public function getFrom(): array
    {
        return $this->from;
    }

    public function setOptions($options)
    {
        return $this;
    }

    public function setType($type)
    {
        return $this;
    }

    public function setTransport(array $transportConfig): MailOptions
    {
        $this->transport = Factory::create($transportConfig);
        return $this;
    }

    public function getTransport(): TransportInterface
    {
        return $this->transport;
    }
}
