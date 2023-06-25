<?php

namespace DannyXCII\EnvironmentManager\Classes\Command\Commands;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Enums\CommandStatus;
use DannyXCII\EnvironmentManager\Interface\RunnableCommandInterface;

final class Show extends Command implements RunnableCommandInterface
{
    public function run(): CommandStatus
    {
        $environments = [];

        if (file_exists($this->getPaths('data'))) {
            foreach (new \DirectoryIterator($this->getPaths('data')) as $item) {
                if ($item->isDir() && !str_starts_with($item->getFilename(), '.')) {
                    $environments[] = $item->getFilename();
                }
            }
        }

        $this->writer->writeInfo(sprintf(
            'Found %d saved configurations%s',
            count($environments),
            count($environments) ? ':' : '.'
        ));

        foreach ($environments as $environment) {
            $this->writer->writeInfo(sprintf('--- %s', $environment));
        }

        $this->writer->blankLine();

        return CommandStatus::Success;
    }
}