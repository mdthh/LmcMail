<?php

namespace LmcMailTest\Mock;

class MockAddress implements \Laminas\Mail\Address\AddressInterface
{

    const EMAIL_ADDRESS = 'test@example.com';
    const NAME = 'Test Example';

    /**
     * @inheritDoc
     */
    public function getEmail()
    {
        return self::EMAIL_ADDRESS;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * @inheritDoc
     */
    public function toString()
    {
        return sprintf('%s <%s>', self::NAME, self::EMAIL_ADDRESS);
    }
}
