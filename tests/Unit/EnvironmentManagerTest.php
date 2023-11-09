<?php

namespace tests\Unit;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Classes\EnvironmentManager;
use DannyXCII\EnvironmentManager\Classes\Writer;
use DannyXCII\EnvironmentManager\Exceptions\CommandNotFoundException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class EnvironmentManagerTest extends TestCase
{
    #[Test]
    public function throwsCommandNotFoundExceptionWithInvalidCommandName()
    {
        $this->expectException(CommandNotFoundException::class);
        new EnvironmentManager(['phpenv', 'load'], new Writer());
    }

    public function testItValidatesCommand(): void
    {
        $environmentManager = new EnvironmentManager(['phpenv', 'help'], new Writer());

        $this->assertEquals($environmentManager->getCommand(), new Command());
    }
}