<?php

namespace DannyXCII\EnvironmentManager\Classes;

use DannyXCII\EnvironmentManager\Classes\Command\CommandOptions;

class EnvironmentManager
{
    private CommandOptions $options;

    public function __construct(array $arguments)
    {
        $this->options = new CommandOptions($arguments);
    }
}