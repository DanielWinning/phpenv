<?php

namespace DannyXCII\EnvironmentManager\Classes\Command;

use DannyXCII\EnvironmentManager\Classes\Writer;
use DannyXCII\EnvironmentManager\Enums\CommandStatus;
use DannyXCII\EnvironmentManager\Exceptions\InvalidCommandException;
use DannyXCII\EnvironmentManager\Interface\CommandInterface;

class Command implements CommandInterface
{
    protected CommandOptions $options;
    protected array $paths = [];
    protected Writer $writer;
    protected array $requiredArguments = [];

    public function __construct(CommandOptions $options, Writer $writer)
    {
        $this->options = $options;
        $this->writer = $writer;
        $this->setPaths();
        $this->initialize();
    }

    /**
     * @return void
     */
    protected function initialize(): void
    {
        $this->checkRequiredArguments();
    }

    /**
     * @return void
     */
    protected function checkRequiredArguments(): void
    {
        foreach ($this->requiredArguments as $argument) {
            if (!$this->options->get($argument)) {
                throw new \InvalidArgumentException(sprintf('Please provide the %s argument.', $argument));
            }
        }
    }

    /**
     * @return CommandStatus
     *
     * @throws InvalidCommandException
     */
    public function execute(): CommandStatus
    {
        if (method_exists($this, 'run')) {
            return $this->run();
        }

        throw new InvalidCommandException();
    }

    /**
     * @return void
     */
    private function setPaths(): void
    {
        $projectRoot = dirname(__DIR__, 3);

        $this->paths = [
            'docker' => sprintf('%s/docker', $projectRoot),
            'data' => sprintf('%s/docker/data', $projectRoot),
        ];

        if ($this->options->get('name')) {
            $this->paths['project'] = sprintf(
                '%s/docker/data/%s',
                $projectRoot,
                $this->options->get('name')
            );
            $this->paths['env'] = sprintf(
                '%s/docker/data/%s/.env',
                $projectRoot,
                $this->options->get('name')
            );
        }
    }

    /**
     * @return array
     */
    public function getPaths(): array
    {
        return $this->paths;
    }
}