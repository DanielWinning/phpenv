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
    private Writer $writer;

    private const COMMAND_NAMESPACE = 'DannyXCII\\EnvironmentManager\\Classes\\Command\\Commands\\';

    /**
     * @throws CommandNotFoundException
     */
    public function __construct(array $arguments, Writer $writer)
    {
        $this->options = new CommandOptions($arguments);
        $this->writer = $writer;
        $this->validateCommand();

        return $this;
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

        $this->command = new $className($this->options);
    }

    /**
     * @return void
     *
     * @throws InvalidCommandException
     */
    public function execute(): void
    {
        $this->command->execute();
    }
}