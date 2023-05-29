<?php

namespace DannyXCII\EnvironmentManager\Classes\Command\Commands;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Enums\CommandStatus;
use DannyXCII\EnvironmentManager\Interface\RunnableCommandInterface;

class Build extends Command implements RunnableCommandInterface
{
    public function run(): CommandStatus
    {
        if (!$this->options->get('name') || !$this->options->get('path')) return CommandStatus::Error;

        return CommandStatus::Success;
    }
}