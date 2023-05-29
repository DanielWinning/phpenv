<?php

namespace DannyXCII\EnvironmentManager\Enums;

enum Output
{
    case Bold;
    case Reset;

    case TextRed;
    case TextGreen;

    public function get(): string
    {
        return match ($this) {
            self::Bold => "\033[1m",
            self::Reset => "\033[0m",
            self::TextRed => "\033[31m",
            self::TextGreen => "\033[32m"
        };
    }
}
