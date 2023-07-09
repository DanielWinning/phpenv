<?php

namespace DannyXCII\EnvironmentManager\Classes\Command\Commands;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Enums\CommandStatus;
use DannyXCII\EnvironmentManager\Interface\RunnableCommandInterface;

class Attach extends Command implements RunnableCommandInterface
{
    /**
     * @return void
     */
    protected function initialize(): void
    {
        $this->requiredArguments = ['name'];

        parent::initialize();
    }

    public function run(): CommandStatus
    {
        if (!file_exists($this->getPaths('project'))) {
            $this->writer->addError('A project with this name is not configured.');

            return CommandStatus::Error;
        }

        if (!$this->isDockerEngineRunning()) {
            return CommandStatus::Error;
        }

        $this->writer->writeInfo('Attempting to attach to your container...');

        $dockerExecCommand = sprintf(
            'docker exec -it %s-php-1 bash',
            $this->options->get('name')
        );

        passthru(sprintf('%s 2>&1', $dockerExecCommand), $execCommandError);

        if ($execCommandError) {
            $this->writer
                ->addError(
                    'There was an error running the docker exec command. Review the output above for more information.'
                );

            return CommandStatus::Error;
        }

        $this->writer->writeInfo('Exited container.');

        return CommandStatus::Success;
    }
}