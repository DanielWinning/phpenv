<?php

namespace DannyXCII\EnvironmentManager\Classes\Command\Commands;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Enums\CommandStatus;
use DannyXCII\EnvironmentManager\Interface\RunnableCommandInterface;

final class Build extends Command implements RunnableCommandInterface
{
    /**
     * @return CommandStatus
     */
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
            $this->writer->addError('The specified project directory does not exist.');

            return CommandStatus::Error;
        }

        $this->createConfigurationFiles();

        if (!$this->executeDockerBuildCommand()) return CommandStatus::Error;

        return CommandStatus::Success;
    }

    /**
     * @return void
     */
    public function createConfigurationFiles(): void
    {
        $this->writer->writeInfo('Creating configuration files...');

        mkdir($this->getPaths()['project']);

        file_put_contents(
            $this->getPaths()['env'],
            sprintf(
                "PROJECT_DIRECTORY=%s\nPROJECT_NAME=%s\n",
                $this->options->get('path'),
                $this->options->get('name')
            )
        );

        $this->writer->writeInfo('Configuration files created.');
    }

    /**
     * @return bool
     */
    public function executeDockerBuildCommand(): bool
    {
        $dockerComposeCommand = sprintf(
            'cd %s && docker-compose -p %s --env-file=%s up --build -d',
            $this->getPaths()['docker'],
            $this->options->get('name'),
            $this->getPaths()['env']
        );

        $this->writer->writeInfo('Running docker-compose build command. This may take a while...');

        passthru(sprintf('%s 2>&1', $dockerComposeCommand), $error);

        if ($error) {
            $this->writer->addError('There was an error running the docker-compose command. Review the output above for more information.');

            unlink($this->getPaths()['env']);
            rmdir($this->getPaths()['project']);

            return false;
        }

        $this->writer->writeInfo('Docker container built and running.');

        return true;
    }
}