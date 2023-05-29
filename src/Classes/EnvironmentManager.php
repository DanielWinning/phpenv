<?php

namespace DannyXCII\EnvironmentManager\Classes;

use DannyXCII\EnvironmentManager\Classes\Command\CommandOptions;
use DannyXCII\EnvironmentManager\Exceptions\CommandNotFoundException;

class EnvironmentManager
{
    private CommandOptions $options;

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
        if (!class_exists(sprintf('%s%s', self::COMMAND_NAMESPACE, $this->options->getCommandName()))) {
            throw new CommandNotFoundException();
        }
    }
}