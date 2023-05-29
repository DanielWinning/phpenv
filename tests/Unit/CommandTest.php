<?php

namespace tests\Unit;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Classes\Command\CommandOptions;
use DannyXCII\EnvironmentManager\Exceptions\InvalidCommandException;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use tests\DataProviders\CommandDataProvider;

class CommandTest extends TestCase
{
    #[Test]
    public function throwsInvalidCommandExceptionIfRanDirectly()
    {
        $command = new Command(new CommandOptions(['phpenv', 'build']));

        $this->expectException(InvalidCommandException::class);
        $command->execute();
    }

    #[Test]
    #[DataProviderExternal(CommandDataProvider::class, 'validCommandSetupOptions')]
    public function setsCorrectPaths(CommandOptions $options, array $expectedPaths)
    {
        $command = new Command($options);

        $this->assertEquals($command->getPaths(), $expectedPaths);
    }
}