<?php

namespace tests\DataProviders;

use DannyXCII\EnvironmentManager\Classes\Command\CommandOptions;

class CommandDataProvider
{
    public static function validCommandSetupOptions(): array
    {
        $projectRoot = dirname(__DIR__, 2);
        $basePaths = [
            'docker' => sprintf('%s/docker', $projectRoot),
            'data' => sprintf('%s/docker/data', $projectRoot),
        ];

        return [
            [
                new CommandOptions(['phpenv', 'build', 'name=test', 'path=c:/Development/test']),
                array_merge($basePaths, [
                    'project' => sprintf('%s/docker/data/test', $projectRoot),
                    'env' => sprintf('%s/docker/data/test/.env', $projectRoot),
                ]),
            ],
            [
                new CommandOptions(['phpenv', 'build', 'test', 'C:/Development/test']),
                array_merge($basePaths, [
                    'project' => sprintf('%s/docker/data/test', $projectRoot),
                    'env' => sprintf('%s/docker/data/test/.env', $projectRoot),
                ]),
            ],
            [
                new CommandOptions(['phpenv', 'help']),
                $basePaths,
            ],
        ];
    }
}