<?php

namespace DannyXCII\EnvironmentManager\Classes\Command\Commands;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Interface\RunnableCommandInterface;

class Build extends Command implements RunnableCommandInterface
{
    public function run(): bool
    {
        if (!$this->options->get('name') || !$this->options->get('path')) return Command::ERROR;

        return Command::SUCCESS;
    }
}