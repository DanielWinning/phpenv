<?php

namespace DannyXCII\EnvironmentManager\Classes\Command;

use DannyXCII\EnvironmentManager\Interface\CommandOptionsInterface;

final class CommandOptions implements CommandOptionsInterface
{
    private array $options = [];
    private array $flags = [];
    private string $command;

    public function __construct(array $arguments)
    {
        $this->setOptions($arguments);
    }

    /**
     * @param array $arguments
     *
     * @return void
     */
    public function setOptions(array $arguments): void
    {
        array_shift($arguments);

        if (!count($arguments)) {
            $this->command = 'Help';
            return;
        }

        foreach ($arguments as $index => $argument) {
            if (!$index) $this->command = ucfirst(strtolower($argument));

            if (str_contains($argument, '--')) {
                $this->flags[] = ltrim($argument, '--');
            } else if (!str_contains($argument, '=')) {
                if ($index === 1) $this->options['name'] = $argument;

                if ($index === 2) $this->options['path'] = $argument;

                if ($index > 2) $this->options[] = $argument;

                continue;
            } else {
                $exploded = explode('=', $argument);
                $this->options[$exploded[0]] = $exploded[1];
            }
        }
    }

    /**
     * @param string $argumentName
     *
     * @return ?string
     */
    public function get(string $argumentName): ?string
    {
        return $this->options[$argumentName] ?? null;
    }

    /**
     * @return string
     */
    public function getCommandName(): string
    {
        return $this->command;
    }

    /**
     * @return int
     */
    public function countArguments(): int
    {
        return count($this->options);
    }

    /**
     * @param string $flag
     *
     * @return bool
     */
    public function hasFlag(string $flag): bool
    {
        return in_array($flag, $this->flags);
    }
}