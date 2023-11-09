<?php

namespace DannyXCII\EnvironmentManager\Classes;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Classes\Command\CommandOptions;
use DannyXCII\EnvironmentManager\Enums\CommandStatus;
use DannyXCII\EnvironmentManager\Exceptions\CommandNotFoundException;
use DannyXCII\EnvironmentManager\Exceptions\InvalidCommandException;

class EnvironmentManager
{
    private Command $command;
    private CommandOptions $options;
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

        $this->command = new $className($this->options, $this->writer);
    }

    /**
     * @return Command
     */
    public function getCommand(): Command
    {
        return $this->command;
    }

    /**
     * @return CommandStatus
     *
     * @throws InvalidCommandException
     */
    public function execute(): CommandStatus
    {
        $this->writer->blankLine();
        $this->writer->writeInfo(sprintf('Executing %s Command', $this->options->getCommandName()));

        return $this->command->execute();
    }
}