<?php

namespace DannyXCII\EnvironmentManager\Classes\Command\Commands;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Enums\CommandStatus;
use DannyXCII\EnvironmentManager\Interface\RunnableCommandInterface;

class Destroy extends Command implements RunnableCommandInterface
{
    /**
     * @return void
     */
    public function initialize(): void
    {
        $this->requiredArguments = ['name'];

        parent::initialize();
    }

    /**
     * @return CommandStatus
     */
    public function run(): CommandStatus
    {
        if (!$this->isDockerEngineRunning()) {
            return CommandStatus::Error;
        }

        if (!file_exists($this->getPaths('env'))) {
            $this->writer->addError('A project with this name is not defined.');

            return CommandStatus::Error;
        }

        ob_start();
        passthru(
            sprintf(
                'cd %s && docker-compose --env-file=%s -p %s down',
                $this->getPaths('docker'),
                $this->getPaths('env'),
                $this->options->get('name')
            ),
            $error
        );
        ob_end_clean();

        if ($error) {
            $this->writer
                ->addError(
                    'There was an error running the docker-compose command. Review the output above for more information.'
                );

            return CommandStatus::Error;
        }

        $this->removeProjectConfigFiles();
        $this->writer->writeInfo('Successfully removed environment and saved configuration.');

        return CommandStatus::Success;
    }

    /**
     * @return void
     */
    private function removeProjectConfigFiles(): void
    {
        unlink($this->getPaths('env'));

        $this->removeDirectory($this->getPaths('mysql'));
        $this->removeDirectory($this->getPaths('redis'));
        $this->removeDirectory($this->getPaths('project'));
    }

    /**
     * @param string $path
     *
     * @return void
     */
    private function removeDirectory(string $path): void
    {
        if (file_exists($path)) {
            $fileSystemIterator = new \FilesystemIterator($path);

            foreach ($fileSystemIterator as $file) {
                if (is_dir($file)) {
                    $directoryIterator = new \FilesystemIterator($file);

                    foreach ($directoryIterator as $nestedFile) {
                        unlink($nestedFile);
                    }

                    rmdir($file);
                } else {
                    unlink($file);
                }
            }

            rmdir($path);
        }
    }
}