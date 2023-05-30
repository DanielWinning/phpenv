<?php

namespace tests\Unit\Commands;

use DannyXCII\EnvironmentManager\Classes\Command\CommandOptions;
use DannyXCII\EnvironmentManager\Classes\Command\Commands\Build;
use DannyXCII\EnvironmentManager\Classes\Writer;
use DannyXCII\EnvironmentManager\Enums\CommandStatus;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BuildTest extends TestCase
{
    #[Test]
    public function returnsErrorWhenNoArgumentsArePassed()
    {
        $buildCommand = new Build(new CommandOptions(['phpenv', 'build']), new Writer());

        $this->assertEquals(CommandStatus::Error, $buildCommand->run());
    }

    #[Test]
    public function returnsErrorWhenProjectNameIsInUse()
    {
        $buildCommand = new Build(new CommandOptions([
            'phpenv', 'build', 'unit-testing', 'path=unit-testing'
        ]), new Writer());

        mkdir($buildCommand->getPaths()['project']);

        $this->assertEquals(CommandStatus::Error, $buildCommand->run());

        rmdir($buildCommand->getPaths()['project']);
    }

    #[Test]
    public function returnsErrorWhenPassedInvalidProjectSourceDirectory()
    {
        $buildCommand = new Build(new CommandOptions([
            'phpenv', 'build', 'unit-testing', 'path=F:/path/does/not/exist'
        ]), new Writer());

        $this->assertEquals(CommandStatus::Error, $buildCommand->run());
    }
}