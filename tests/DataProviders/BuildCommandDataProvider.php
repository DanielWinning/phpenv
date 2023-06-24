<?php

namespace tests\DataProviders;

class BuildCommandDataProvider
{
    /**
     * @return array[]
     */
    public static function invalidBuildCommandOptions(): array
    {
        return [
            ['path=/sample/path'],
            ['name=project-name'],
            ['test-project'],
        ];
    }
}