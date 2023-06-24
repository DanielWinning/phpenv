<?php

namespace DannyXCII\EnvironmentManager\Classes\Command\Commands;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Enums\CommandStatus;
use DannyXCII\EnvironmentManager\Interface\RunnableCommandInterface;

final class Stop extends Command implements RunnableCommandInterface
{
    protected function initialize(): void
    {
        $this->requiredArguments = ['name'];

        parent::initialize();
    }

    /**
     * @return CommandStatus
     */
    public function run(): CommandStatus
    {
        if (!$this->options->get('name')) {
            $this->writer->addError('Please specify the name of the container you wish to stop.');

            return CommandStatus::Error;
        }

        if (!file_exists($this->getPaths()['project'])) {
            $this->writer->addError('A project with this name does not exist in your saved configurations.');

            return CommandStatus::Error;
        }

        return CommandStatus::Success;
    }
}