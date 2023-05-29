<?php

namespace DannyXCII\EnvironmentManager\Interface;

interface OutputInterface
{
    public function writeInfo(string $message, bool $emphasis = false): void;

    public function writeError(string $message): void;

    public function writeSuccess(string $message): void;
}