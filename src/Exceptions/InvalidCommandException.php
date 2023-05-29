<?php

namespace DannyXCII\EnvironmentManager\Exceptions;

class InvalidCommandException extends \Exception
{
    private const MESSAGE = 'The command you are attempting to run has not been configured to run manually.';

    public function __construct(string $message = '')
    {
        parent::__construct($message === '' ? self::MESSAGE : $message);
    }
}