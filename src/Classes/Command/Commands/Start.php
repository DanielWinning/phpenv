<?php

namespace DannyXCII\EnvironmentManager\Classes\Command\Commands;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Enums\CommandStatus;
use DannyXCII\EnvironmentManager\Interface\RunnableCommandInterface;

final class Start extends Command implements RunnableCommandInterface
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
        if (file_exists($this->getPaths()['project']) && is_dir($this->getPaths()['project'])) {
            passthru(sprintf(
                'cd %s && docker-compose -p %s --env-file=%s up -d',
                $this->getPaths('docker'),
                $this->options->get('name'),
                $this->getPaths('env')
            ), $error);

            if ($error) {
                $this->writer
                    ->addError(
                        ' There was an error running the docker-compose command. Review the output above for more information.'
                    );

                return CommandStatus::Error;
            }

            $this->writer->blankLine();
            $this->writer->writeInfo(' Successfully started your container.');
            $this->writer->blankLine();

            return CommandStatus::Success;
        }

        throw new \InvalidArgumentException('A saved project with that name could not be found.');
    }
}