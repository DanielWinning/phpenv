<?php

namespace DannyXCII\EnvironmentManager\Classes\Command\Commands;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Enums\CommandStatus;
use DannyXCII\EnvironmentManager\Interface\RunnableCommandInterface;

class Build extends Command implements RunnableCommandInterface
{
    public function run(): CommandStatus
    {
        if (!$this->options->get('name') || !$this->options->get('path')) {
            $this->writer->addError(
                'Please set both a name for your container and the full path to your project directory.'
            );

            return CommandStatus::Error;
        }

        if (file_exists($this->getPaths()['project'])) {
            $this->writer->addError('A project with this name is already defined.');

            return CommandStatus::Error;
        }

        if (!file_exists($this->options->get('path'))) {
            $this->writer->addError('The specified project directory does not exist');

            return CommandStatus::Error;
        }

        return CommandStatus::Success;
    }
}