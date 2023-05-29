<?php

namespace DannyXCII\EnvironmentManager\Classes\Command;

use DannyXCII\EnvironmentManager\Exceptions\InvalidCommandException;
use DannyXCII\EnvironmentManager\Interface\CommandInterface;

class Command implements CommandInterface
{
    private CommandOptions $options;

    public const ERROR = 0;
    public const SUCCESS = 1;

    public function __construct(CommandOptions $options)
    {
        $this->options = $options;
    }

    /**
     * @return bool
     *
     * @throws InvalidCommandException
     */
    public function execute(): bool
    {
        if (method_exists($this, 'run')) {
            return $this->run();
        }

        throw new InvalidCommandException();
    }
}