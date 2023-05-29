<?php

namespace DannyXCII\EnvironmentManager\Interface;

use DannyXCII\EnvironmentManager\Enums\CommandStatus;

interface RunnableCommandInterface
{
    public function run(): CommandStatus;
}