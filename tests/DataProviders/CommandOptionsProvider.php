<?php

namespace tests\DataProviders;

class CommandOptionsProvider
{
    public static function commandNameTestCases(): array
    {
        return [
            [['bin/phpenv', 'build', 'name=project-name', 'path=C:/Development/data'], 'Build'],
            [['phpenv', 'list'], 'List'],
            [['phpenv'], 'Help'],
        ];
    }

    public static function commandOptionValueCases(): array
    {
        return [
            [['bin/phpenv', 'build', 'path=C:/Development/data'], 'path', 'C:/Development/data'],
            [['bin/phpenv', 'build', 'path=C:/Development/data'], 'name', null],
            [['bin/phpenv', 'build', 'path=C:/Development/data', 'name=project-name'], 'name', 'project-name'],
        ];
    }
}