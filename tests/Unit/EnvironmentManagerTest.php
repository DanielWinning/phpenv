<?php

namespace tests\Unit;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Classes\Command\CommandOptions;
use DannyXCII\EnvironmentManager\Classes\Command\Commands\Help;
use DannyXCII\EnvironmentManager\Classes\EnvironmentManager;
use DannyXCII\EnvironmentManager\Classes\Writer;
use DannyXCII\EnvironmentManager\Enums\CommandStatus;
use DannyXCII\EnvironmentManager\Exceptions\CommandNotFoundException;
use DannyXCII\EnvironmentManager\Exceptions\InvalidCommandException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class EnvironmentManagerTest extends TestCase
{
    #[Test]
    public function throwsCommandNotFoundExceptionWithInvalidCommandName(): void
    {
        $this->expectException(CommandNotFoundException::class);
        new EnvironmentManager(['phpenv', 'load'], new Writer());
    }

    /**
     * @throws CommandNotFoundException
     */
    #[Test]
    public function testItValidatesCommand(): void
    {
        $environmentManager = new EnvironmentManager(['phpenv', 'help'], new Writer());

        $this->assertEquals($this->getHelpCommand(), $environmentManager->getCommand());
    }

    /**
     * @throws InvalidCommandException|CommandNotFoundException
     */
    #[Test]
    public function testItExecutes(): void
    {
        $environmentManager = new EnvironmentManager(['phpenv', 'help'], new Writer());

        $this->assertEquals(CommandStatus::Success, $environmentManager->execute());
    }

    /**
     * @return Help
     */
    private function getHelpCommand(): Help
    {
        return new Help(
            new CommandOptions(['phpenv', 'help']),
            new Writer()
        );
    }
}