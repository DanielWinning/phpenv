<?php

namespace DannyXCII\EnvironmentManager\Classes\Command\Commands;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Enums\CommandStatus;
use DannyXCII\EnvironmentManager\Interface\RunnableCommandInterface;

final class Build extends Command implements RunnableCommandInterface
{
    /**
     * @return void
     */
    protected function initialize(): void
    {
        $this->requiredArguments = ['name', 'path'];

        parent::initialize();
    }

    /**
     * @return CommandStatus
     */
    public function run(): CommandStatus
    {
        if (file_exists($this->getPaths('project'))) {
            $this->writer->addError('A project with this name is already defined.');

            return CommandStatus::Error;
        }

        if (!file_exists($this->options->get('path'))) {
            $this->writer->addError('The specified project directory does not exist.');

            return CommandStatus::Error;
        }

        $this->createConfigurationFiles();

        if (!$this->executeDockerBuildCommand())
        {
            return CommandStatus::Error;
        }

        return CommandStatus::Success;
    }

    /**
     * @return void
     */
    public function createConfigurationFiles(): void
    {
        $this->writer->writeInfo('Creating configuration files...');

        mkdir($this->getPaths('project'));

        file_put_contents(
            $this->getPaths('env'),
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
        exec('docker info 2>&1', $output, $dockerInfoError);

        if ($dockerInfoError) {
            $this->writer->addError(
                'It looks like the Docker Engine is not running. Please start it and try again.'
            );

            $this->rollbackChanges();

            return false;
        }

        $dockerComposeCommand = sprintf(
            'cd %s && docker-compose -p %s --env-file=%s up --build -d',
            $this->getPaths('docker'),
            $this->options->get('name'),
            $this->getPaths('env')
        );

        $this->writer->writeInfo('Running docker-compose build command. This may take a while...');

        passthru(sprintf('%s 2>&1', $dockerComposeCommand), $buildCommandError);

        if ($buildCommandError) {
            $this->writer
                ->addError(
                    'There was an error running the docker-compose command. Review the output above for more information.'
                );

            $this->rollbackChanges();

            return false;
        }

        $this->writer->writeInfo('Docker container built and running.');
        $this->writer->blankLine();

        return true;
    }

    /**
     * @return void
     */
    private function rollbackChanges(): void
    {
        $this->writer->writeInfo('Rolling back config file creation...');

        if (file_exists($this->getPaths('env'))) {
            unlink($this->getPaths('env'));
        }

        if (file_exists($this->getPaths('project'))) {
            rmdir($this->getPaths('project'));
        }
    }
}