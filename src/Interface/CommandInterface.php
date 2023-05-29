<?php

namespace DannyXCII\EnvironmentManager\Interface;

use DannyXCII\EnvironmentManager\Enums\CommandStatus;

interface CommandInterface
{
    public function execute(): CommandStatus;
}