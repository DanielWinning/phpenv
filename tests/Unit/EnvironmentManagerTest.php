<?php

namespace tests\Unit;

use DannyXCII\EnvironmentManager\Classes\EnvironmentManager;
use DannyXCII\EnvironmentManager\Exceptions\CommandNotFoundException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class EnvironmentManagerTest extends TestCase
{
    #[Test]
    public function throwsCommandNotFoundExceptionWithInvalidCommandName()
    {
        $this->expectException(CommandNotFoundException::class);
        new EnvironmentManager(['phpenv', 'load']);
    }
}