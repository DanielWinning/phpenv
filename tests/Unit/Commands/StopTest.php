<?php

namespace tests\Unit\Commands;

use DannyXCII\EnvironmentManager\Classes\Command\CommandOptions;
use DannyXCII\EnvironmentManager\Classes\Command\Commands\Stop;
use DannyXCII\EnvironmentManager\Classes\Writer;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class StopTest extends TestCase
{
    #[Test]
    public function throwsInvalidArgumentExceptionWhenNoProjectNameIsProvided()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Stop(new CommandOptions(['phpenv', 'stop']), new Writer());
    }
}