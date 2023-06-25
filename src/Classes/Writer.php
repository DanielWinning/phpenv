<?php

namespace DannyXCII\EnvironmentManager\Classes;

use DannyXCII\EnvironmentManager\Enums\Output;
use DannyXCII\EnvironmentManager\Interface\OutputInterface;

class Writer implements OutputInterface
{
    private array $errorBag = [];

    /**
     * @param string $message
     * @param bool $emphasis
     *
     * @return void
     */
    public function writeInfo(string $message, bool $emphasis = false): void
    {
        echo sprintf(
            "%s%s%s%s\n",
            Output::Reset->get(),
            $emphasis ? Output::Bold->get() : '',
            $message,
            Output::Reset->get()
        );
    }

    /**
     * @param string $message
     *
     * @return void
     */
    public function writeError(string $message): void
    {
        echo sprintf(
            "%s%s%s%s%s\n",
            Output::Reset->get(),
            Output::Bold->get(),
            Output::TextRed->get(),
            $message,
            Output::Reset->get()
        );
    }

    /**
     * @param string $message
     *
     * @return void
     */
    public function writeSuccess(string $message): void
    {
        echo sprintf(
            "%s%s%s%s%s\n",
            Output::Reset->get(),
            Output::Bold->get(),
            Output::TextGreen->get(),
            $message,
            Output::Reset->get()
        );
    }

    /**
     * @return void
     */
    public function blankLine(): void
    {
        echo "\n";
    }

    /**
     * @param string $error
     *
     * @return void
     */
    public function addError(string $error): void
    {
        $this->errorBag[] = $error;
    }

    /**
     * @return void
     */
    public function writeVerboseError(): void
    {
        foreach ($this->errorBag as $error) {
            $this->writeError(sprintf(' Error: %s', $error));
        }
    }
}