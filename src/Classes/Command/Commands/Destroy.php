<?php

namespace DannyXCII\EnvironmentManager\Classes\Command\Commands;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Enums\CommandStatus;
use DannyXCII\EnvironmentManager\Interface\RunnableCommandInterface;

class Destroy extends Command implements RunnableCommandInterface
{
    public function initialize(): void
    {
        $this->requiredArguments = ['name'];

        parent::initialize();
    }

    public function run(): CommandStatus
    {
        if (!file_exists($this->getPaths('project'))) {
            $this->writer->addError(' A project with this name is not defined.');

            return CommandStatus::Error;
        }
        return CommandStatus::Success;
    }
}