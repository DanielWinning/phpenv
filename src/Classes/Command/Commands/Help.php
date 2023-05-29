<?php

namespace DannyXCII\EnvironmentManager\Classes\Command\Commands;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Interface\RunnableCommandInterface;

class Help extends Command implements RunnableCommandInterface
{
    public function run(): bool
    {
        return Command::SUCCESS;
    }
}