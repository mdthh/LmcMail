<?php
/**
 * @author Eric Richer <eric.richer@vistoconsulting.com
 *
 */
namespace LmcMail\Options;

use Laminas\Mail\Transport\Smtp;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\Stdlib\AbstractOptions;

class TransportOptions extends AbstractOptions
{

    /**
     * Transport options
     */
    protected array $transportOptions = [
        'path' => 'data/mail',
    ];

    /**
     * Options class
     */
    protected string $optionsClass = SmtpOptions::class;

    /**
     * Transport class
     * @var string
     */
    protected string $transportClass = Smtp::class;

    /**
     * Set transport options
     * @param array $transportOptions
     * @return $this
     */
    public function setTransportOptions(array $transportOptions): TransportOptions
    {
        $this->transportOptions = $transportOptions;
        return $this;
    }

    /**
     * Returns transport options
     * @return array|string[]
     */
    public function getTransportOptions(): array
    {
        return $this->transportOptions;
    }

    /**
     * Set Options class
     * @param string $optionsClass
     * @return $this
     */
    public function setOptionsClass(string $optionsClass): TransportOptions
    {
        $this->optionsClass = $optionsClass;
        return $this;
    }

    /**
     * Get Options class
     * @return string
     */
    public function getOptionsClass(): string
    {
        return $this->optionsClass;
    }

    /**
     * Set Transport class
     * @param string $transportClass
     * @return TransportOptions
     */
    public function setTransportClass(string $transportClass): TransportOptions
    {
        $this->transportClass = $transportClass;
        return $this;
    }

    /**
     * Get Transport class
     * @return string
     */
    public function getTransportClass(): string
    {
        return $this->transportClass;

    }
}
