<?php

namespace DannyXCII\EnvironmentManager\Interface;

interface RunnableCommandInterface
{
    public function run(): bool;
}