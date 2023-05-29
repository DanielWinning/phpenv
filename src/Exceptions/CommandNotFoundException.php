<?php

namespace DannyXCII\EnvironmentManager\Exceptions;

class CommandNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Command does not exist.');
    }
}