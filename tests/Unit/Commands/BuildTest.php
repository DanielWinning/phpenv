<?php

namespace tests\Unit\Commands;

use DannyXCII\EnvironmentManager\Classes\Command\CommandOptions;
use DannyXCII\EnvironmentManager\Classes\Command\Commands\Build;
use DannyXCII\EnvironmentManager\Classes\Writer;
use DannyXCII\EnvironmentManager\Enums\CommandStatus;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use tests\DataProviders\BuildCommandDataProvider;

class BuildTest extends TestCase
{
    #[Test]
    public function throwsInvalidArgumentExceptionWhenNoArgumentsArePassed(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Build(new CommandOptions(['phpenv', 'build']), new Writer());
    }

    #[Test]
    #[DataProviderExternal(BuildCommandDataProvider::class, 'invalidBuildCommandOptions')]
    public function throwsInvalidArgumentExceptionWhenOnlyProvidedOneArgument(string $argument): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Build(new CommandOptions(['phpenv', 'build', $argument]), new Writer());
    }

    #[Test]
    public function throwsInvalidArgumentExceptionIfProvidedTooManyArguments()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Build(new CommandOptions(['phpenv', 'build', 'test', 'test', 'test', 'test']), new Writer());
    }

    #[Test]
    public function returnsErrorWhenProjectNameIsInUse(): void
    {
        $buildCommand = new Build(new CommandOptions([
            'phpenv', 'build', 'unit-testing', 'path=unit-testing'
        ]), new Writer());

        mkdir($buildCommand->getPaths('project'));

        $this->assertEquals(CommandStatus::Error, $buildCommand->run());

        rmdir($buildCommand->getPaths('project'));
    }

    #[Test]
    public function returnsErrorWhenPassedInvalidProjectSourceDirectory(): void
    {
        $buildCommand = new Build(new CommandOptions([
            'phpenv', 'build', 'unit-testing', 'path=F:/path/does/not/exist'
        ]), new Writer());

        $this->assertEquals(CommandStatus::Error, $buildCommand->run());
    }

    #[Test]
    public function createsConfigurationFiles(): void
    {
        $buildCommand = new Build(new CommandOptions([
            'phpenv', 'build', 'unit-testing', 'path=C:/Development'
        ]), new Writer());

        $buildCommand->createConfigurationFiles();

        $this->assertTrue(file_exists($buildCommand->getPaths('project')));
        $this->assertTrue(file_exists($buildCommand->getPaths('env')));

        if (file_exists($buildCommand->getPaths('env'))) {
            unlink($buildCommand->getPaths('project') . '/.env');
        }

        if (file_exists($buildCommand->getPaths('project'))) {
            rmdir($buildCommand->getPaths('project'));
        }

        if (file_exists($buildCommand->getPaths('php-fpm') . '/xdebug.ini.tmp')) {
            unlink($buildCommand->getPaths('php-fpm') . '/xdebug.ini.tmp');
        }
    }
}