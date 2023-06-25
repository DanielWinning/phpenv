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
        if ($this->getPaths('project') && !file_exists($this->getPaths('project'))) {
            $this->writer->addError('A project with this name does not exist in your saved configurations.');

            return CommandStatus::Error;
        }

        passthru(sprintf(
            'cd %s && docker-compose -p %s --env-file=%s stop',
            $this->getPaths('docker'),
            $this->options->get('name'),
            $this->getPaths('env')
        ), $error);

        if ($error) {
            $this->writer
                ->addError(
                    'There was an error running the docker-compose command. Review the output above for more information.'
                );

            return CommandStatus::Error;
        }

        $this->writer->blankLine();

        return CommandStatus::Success;
    }
}