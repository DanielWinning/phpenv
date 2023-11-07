<?php

namespace tests\Unit;

use DannyXCII\EnvironmentManager\Classes\Writer;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class WriterTest extends TestCase
{
    #[Test]
    public function itInstantiatesAnInstanceOfWriter(): void
    {
        $this->assertInstanceOf(Writer::class, new Writer());
    }

    #[Test]
    public function itWritesErrors(): void
    {
        $writer = new Writer();
        $this->expectOutputString("\033[0m\033[1m\033[31merror message\033[0m\n");
        $writer->writeError('error message');
    }

    #[Test]
    public function itWritesSuccessMessages(): void
    {
        $writer = new Writer();
        $this->expectOutputString("\033[0m\033[1m\033[32msuccess message\033[0m\n");
        $writer->writeSuccess('success message');
    }

    #[Test]
    public function itInsertsBlankLine(): void
    {
        $writer = new Writer();
        $this->expectOutputString("\n");
        $writer->blankLine();
    }

    #[Test]
    public function itWritesVerboseError(): void
    {
        $writer = new Writer();
        $writer->addError('test error');
        $this->expectOutputString("\n\033[0m\033[1m\033[31mError: test error\033[0m\n");
        $writer->writeVerboseError();
    }
}