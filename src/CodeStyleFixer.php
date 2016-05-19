<?php

namespace Karriere\CodeQuality;

use Composer\Script\Event;
use Karriere\CodeQuality\Console\ScriptArgumentsTrait;
use Karriere\CodeQuality\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CodeStyleFixer implements ComposerScriptInterface
{
    use ScriptArgumentsTrait;

    /**
     * The code style fixer command.
     *
     * @var string
     */
    private static $commands = [
        'php-cs-fixer' => 'php-cs-fixer fix src --level=psr2 --diff {--no-ansi}',
        'phpcbf'       => 'phpcbf src --standard=PSR2 {--colors}'
    ];

    public static function run(Event $event)
    {
        $eventArguments = self::getComposerScriptArguments($event->getArguments());

        $command = self::getArrayValueByEventArguments('tool', self::$commands, $eventArguments);
        $command = self::setColorParamIfSupported($command);
        $command = self::setNoAnsiParamIfNeeded($command);

        $composerIO = $event->getIO();
        $composerIO->write('<info>Running </info><fg=green;options=bold>' . $command . '</>');

        $process = new Process($command);
        $process->setTtyByArguments($eventArguments);
        $process->run();

        $composerIO->write($process->getOutput());

        $exitCode = self::phpcbfExitCodeToComposerExitCode($process->getExitCode());

        if ($exitCode !== ComposerScriptInterface::EXIT_CODE_OK) {
            throw new ProcessFailedException($process);
        }

        return $exitCode;
    }

    /**
     * Map phpcbf exit codes to cli (composer) exit codes.
     * Works for version "squizlabs/php_codesniffer": "^2.6".
     *
     * @param  int $exitCode
     * @return int
     */
    private static function phpcbfExitCodeToComposerExitCode($exitCode)
    {
        switch ($exitCode) {
            case 0:
                // phpcbf didn't fix anything and reported no errors, this is ok.
                return ComposerScriptInterface::EXIT_CODE_OK;
            case 1:
                // phpcbf fixed all found issues.
                return ComposerScriptInterface::EXIT_CODE_OK;
            case 2:
                // phpcbf reported errors that can't be fixed. that's ok for us.
                return ComposerScriptInterface::EXIT_CODE_OK;
            case 3:
                // phpcbf exec command (patch) returned an error.
                return ComposerScriptInterface::EXIT_CODE_ERROR;
            default:
                return ComposerScriptInterface::EXIT_CODE_ERROR;
        }
    }
}
