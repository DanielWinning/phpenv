<?php

namespace tests\Unit;

use DannyXCII\EnvironmentManager\Classes\Command\CommandOptions;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use tests\DataProviders\CommandOptionsProvider;

class CommandOptionsTest extends TestCase
{
    #[Test]
    #[DataProviderExternal(CommandOptionsProvider::class, 'commandNameTestCases')]
    public function setsCommandName(array $arguments, string $expectedName)
    {
        $commandOptions = new CommandOptions($arguments);

        $this->assertEquals($commandOptions->getCommandName(), $expectedName);
    }

    #[Test]
    #[DataProviderExternal(CommandOptionsProvider::class, 'commandOptionValueCases')]
    public function setsCorrectOptionValues(array $arguments, string $optionName, ?string $expectedValue)
    {
        $commandOptions = new CommandOptions($arguments);

        $this->assertEquals($commandOptions->get($optionName), $expectedValue);
    }
}