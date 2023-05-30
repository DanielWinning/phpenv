<?php

namespace DannyXCII\EnvironmentManager\Classes\Command\Commands;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Enums\CommandStatus;
use DannyXCII\EnvironmentManager\Interface\RunnableCommandInterface;

class Help extends Command implements RunnableCommandInterface
{
    public function run(): CommandStatus
    {
        $this->writer->blankLine();
        $this->writer->writeInfo('Help:     phpenv help', true);
        $this->writer->writeInfo('Build:    phpenv name=test path=C:/path/to/project', true);
        $this->writer->writeInfo('          phpenv test C:/path/to/project', true);

        return CommandStatus::Success;
    }
}