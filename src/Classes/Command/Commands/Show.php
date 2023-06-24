<?php

namespace DannyXCII\EnvironmentManager\Classes\Command\Commands;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Enums\CommandStatus;
use DannyXCII\EnvironmentManager\Interface\RunnableCommandInterface;

final class Show extends Command implements RunnableCommandInterface
{
    public function run(): CommandStatus
    {
        $this->writer->writeInfo('Listing environments configured.');

        return CommandStatus::Success;
    }
}