<?php

namespace DannyXCII\EnvironmentManager\Classes\Command\Commands;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Enums\CommandStatus;
use DannyXCII\EnvironmentManager\Interface\RunnableCommandInterface;

final class Help extends Command implements RunnableCommandInterface
{
    /**
     * @return CommandStatus
     */
    public function run(): CommandStatus
    {
        $this->writer->writeInfo(' Show:', true);
        $this->writer->writeInfo(' -----------');
        $this->writer->writeInfo(' Lists saved containers.');
        $this->writer->writeInfo(' > phpenv show', true);
        $this->writer->blankLine();

        $this->writer->writeInfo(' Build:', true);
        $this->writer->writeInfo(' -----------');
        $this->writer->writeInfo(' Builds a new Docker container for your project.');
        $this->writer->writeInfo(' > phpenv build name=project-name path=/abs/path/to/project', true);
        $this->writer->writeInfo(' > phpenv build project-name /abs/path/to/project', true);
        $this->writer->blankLine();

        $this->writer->writeInfo(' Start:', true);
        $this->writer->writeInfo(' -----------');
        $this->writer->writeInfo(' Starts a saved container by name.');
        $this->writer->writeInfo(' > phpenv start name=project-name', true);
        $this->writer->writeInfo(' > phpenv start project-name', true);
        $this->writer->blankLine();

        $this->writer->writeInfo(' Stop:', true);
        $this->writer->writeInfo(' -----------');
        $this->writer->writeInfo(' Stops a running saved container by name.');
        $this->writer->writeInfo(' > phpenv stop name=project-name', true);
        $this->writer->writeInfo(' > phpenv stop project-name', true);
        $this->writer->blankLine();

        $this->writer->writeInfo(' Destroy:', true);
        $this->writer->writeInfo(' -----------');
        $this->writer->writeInfo(' Removes config and destroys the container for the named resource.');
        $this->writer->writeInfo(' > phpenv destroy name=project-name', true);
        $this->writer->writeInfo(' > phpenv destroy project-name', true);
        $this->writer->blankLine();

        $this->writer->writeInfo(' Help:', true);
        $this->writer->writeInfo(' -----------');
        $this->writer->writeInfo(' Show a list of available commands.');
        $this->writer->writeInfo(' > phpenv help', true);
        $this->writer->blankLine();

        return CommandStatus::Success;
    }
}