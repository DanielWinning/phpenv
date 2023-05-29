<?php

namespace DannyXCII\EnvironmentManager\Interface;

interface CommandInterface
{
    public function execute(): bool;
}