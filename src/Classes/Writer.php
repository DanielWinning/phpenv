<?php

namespace DannyXCII\EnvironmentManager\Classes;

use DannyXCII\EnvironmentManager\Enums\Output;
use DannyXCII\EnvironmentManager\Interface\OutputInterface;

class Writer implements OutputInterface
{
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
            "%s%s%s%s%\n",
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
}