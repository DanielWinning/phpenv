<?php

namespace DannyXCII\EnvironmentManager\Classes;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Classes\Command\CommandOptions;
use DannyXCII\EnvironmentManager\Exceptions\CommandNotFoundException;
use DannyXCII\EnvironmentManager\Exceptions\InvalidCommandException;

class EnvironmentManager
{
    private CommandOptions $options;
    private Command $command;

    private const COMMAND_NAMESPACE = 'DannyXCII\\EnvironmentManager\\Classes\\Command\\Commands\\';

    /**
     * @throws CommandNotFoundException
     */
    public function __construct(array $arguments)
    {
        $this->options = new CommandOptions($arguments);
        $this->validateCommand();
    }

    /**
     * @return void
     *
     * @throws CommandNotFoundException
     */
    private function validateCommand(): void
    {
        $className = sprintf('%s%s', self::COMMAND_NAMESPACE, $this->options->getCommandName());

        if (!class_exists($className)) {
            throw new CommandNotFoundException();
        }

        $this->command = new $className;
    }
}