<?php

namespace tests\Unit;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Classes\Command\CommandOptions;
use DannyXCII\EnvironmentManager\Exceptions\InvalidCommandException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    #[Test]
    public function throwsInvalidCommandExceptionIfRanDirectly()
    {
        $command = new Command(new CommandOptions(['phpenv', 'build']));

        $this->expectException(InvalidCommandException::class);
        $command->execute();
    }
}