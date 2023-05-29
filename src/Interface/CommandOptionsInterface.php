<?php

namespace DannyXCII\EnvironmentManager\Interface;

interface CommandOptionsInterface
{
    public function get(string $argumentName): ?string;
}