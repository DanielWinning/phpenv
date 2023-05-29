<?php

namespace DannyXCII\EnvironmentManager\Classes\Command;

use DannyXCII\EnvironmentManager\Exceptions\InvalidCommandException;
use DannyXCII\EnvironmentManager\Interface\CommandInterface;

class Command implements CommandInterface
{
    /**
     * @return void
     *
     * @throws InvalidCommandException
     */
    public function execute(): void
    {
        if (method_exists($this, 'run')) {
            $this->run();
            return;
        }

        throw new InvalidCommandException('The command you are attempting to run has not been configured to run manually.');
    }
}