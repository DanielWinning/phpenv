<?php

namespace DannyXCII\EnvironmentManager\Classes\Command;

use DannyXCII\EnvironmentManager\Exceptions\InvalidCommandException;
use DannyXCII\EnvironmentManager\Interface\CommandInterface;

class Command implements CommandInterface
{
    protected CommandOptions $options;
    protected array $paths = [];

    public function __construct(CommandOptions $options)
    {
        $this->options = $options;
        $this->setPaths();
    }

    /**
     * @return bool
     *
     * @throws InvalidCommandException
     */
    public function execute(): bool
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