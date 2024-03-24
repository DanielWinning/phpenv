<?php

namespace DannyXCII\EnvironmentManager\Classes\Command\Commands;

use DannyXCII\EnvironmentManager\Classes\Command\Command;
use DannyXCII\EnvironmentManager\Enums\CommandStatus;
use DannyXCII\EnvironmentManager\Interface\RunnableCommandInterface;

final class Build extends Command implements RunnableCommandInterface
{
    private array $ports = [];

    /**
     * @return void
     */
    protected function initialize(): void
    {
        $this->requiredArguments = ['name', 'path'];

        parent::initialize();
    }

    /**
     * @return CommandStatus
     */
    public function run(): CommandStatus
    {
        if (file_exists($this->getPaths('project'))) {
            $this->writer->addError('A project with this name is already defined.');

            return CommandStatus::Error;
        }

        if (!file_exists($this->options->get('path'))) {
            $this->writer->addError('The specified project directory does not exist.');

            return CommandStatus::Error;
        }

        $this->createConfigurationFiles();

        if (!$this->executeDockerBuildCommand()) {
            return CommandStatus::Error;
        }

        $this->removeTemporaryIni();

        return CommandStatus::Success;
    }

    /**
     * @return void
     */
    public function createConfigurationFiles(): void
    {
        $this->writer->writeInfo('Creating configuration files...');
        mkdir($this->getPaths('project'));
        $this->createEnvFile();
        $this->prepareTemporaryXdebugIni();
        $this->writer->writeInfo('Configuration files created.');
    }

    /**
     * @return bool
     */
    public function executeDockerBuildCommand(): bool
    {
        if (!$this->isDockerEngineRunning()) {
            $this->rollbackChanges();

            return false;
        }

        $dockerComposeCommand = sprintf(
            'cd %s && docker-compose -p %s --env-file=%s up --build -d',
            $this->getPaths('docker'),
            $this->options->get('name'),
            $this->getPaths('env')
        );

        $this->writer->writeInfo('Running docker-compose build command. This may take a while...');

        if (!$this->options->hasFlag('debug')) {
            ob_start();
        }

        passthru(sprintf('%s 2>&1', $dockerComposeCommand), $buildCommandError);

        if (!$this->options->hasFlag('debug')) {
            ob_end_clean();
        }

        if ($buildCommandError) {
            $this->writer
                ->addError(
                    'There was an error running the docker-compose command. Review the output above for more information.'
                );

            $this->rollbackChanges();

            return false;
        }

        $this->writer->writeInfo('Docker container built and running.');
        $this->writer->blankLine();
        $this->writer->writeInfo(sprintf('Access your application at http://localhost:%s', $this->ports[0]), true);
        $this->writer->blankLine();

        return true;
    }

    /**
     * @return void
     */
    private function createEnvFile(): void
    {
        file_put_contents(
            $this->getPaths('env'),
            sprintf(
                "PROJECT_DIRECTORY=%s\nPROJECT_NAME=%s\nNGINX_PORT=%s\nMYSQL_PORT=%s\nREDIS_PORT=%s\nPHP_PORT=%s",
                $this->options->get('path'),
                $this->options->get('name'),
                $this->generateRandomPort(),
                $this->generateRandomPort(),
                $this->generateRandomPort(),
                $this->generateRandomPort()
            )
        );
    }

    /**
     * @return void
     */
    private function rollbackChanges(): void
    {
        $this->writer->writeInfo('Rolling back config file creation...');

        if (file_exists($this->getPaths('project'))) {
            if (!$this->options->hasFlag('debug')) {
                ob_start();
            }

            passthru(
                sprintf(
                    'rm -r %s',
                    $this->getPaths('project')
                )
            );

            if (!$this->options->hasFlag('debug')) {
                ob_end_clean();
            }
        }

        $this->removeTemporaryIni();
    }

    /**
     * @return string
     */
    private function generateRandomPort(): string
    {
        $port = 0;

        $portInUse = true;

        while ($portInUse) {
            $port = rand(49152, 65535);

            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            $bindResult = @socket_bind($socket, '127.0.0.1', $port);

            if ($bindResult && !in_array($port, $this->ports)) {
                $this->ports[] = $port;
                $portInUse = false;
            }

            socket_close($socket);
        }

        return (string) $port;
    }

    /**
     * @return void
     */
    private function prepareTemporaryXdebugIni(): void
    {
        $xdebugPath = sprintf('%s/xdebug.ini', $this->getPaths('php-fpm'));
        $xdebugTmpPath = sprintf('%s/xdebug.ini.tmp', $this->getPaths('php-fpm'));
        $xdebugIni = file_get_contents($xdebugPath);
        $xdebugIni = str_replace('PHP_PORT', $this->ports[3] ?? '9003', $xdebugIni);

        file_put_contents($xdebugTmpPath, $xdebugIni);
    }

    /**
     * @return void
     */
    private function removeTemporaryIni(): void
    {
        $xdebugTmpIni = sprintf('%s/xdebug.ini.tmp', $this->getPaths('php-fpm'));

        unlink($xdebugTmpIni);

    }
}