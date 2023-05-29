<?php

namespace DannyXCII\EnvironmentManager\Classes\Command;

use DannyXCII\EnvironmentManager\Interface\CommandInterface;

class Command implements CommandInterface
{
    public function execute(): void
    {
        if (method_exists($this, 'run')) {
            $this->run();
            return;
        }

        echo 'This command has not been configured to be ran manually.';
    }
}