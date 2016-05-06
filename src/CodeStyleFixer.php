<?php

namespace Karriere\CodeQuality;

use Composer\Script\Event;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CodeStyleFixer implements ComposerScriptInterface
{
    public static $command = 'phpcbf src -v --colors';

    public static function run(Event $event)
    {
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->writeln('<info>Running </info><fg=green;options=bold>' . self::$command . '</>');

        $process = new Process(self::$command);
        $process->run();

        $exitCode = self::phpcbfExitCodeToComposerExitCode($process->getExitCode());
        if ($exitCode !== ComposerScriptInterface::EXIT_CODE_OK) {
            throw new ProcessFailedException($process);
        }

        $consoleOutput->write($process->getOutput());
        $consoleOutput->writeln('<fg=black;bg=yellow>Finished!</>');
    }

    /**
     * Map phpcbf exit codes to cli (composer) exit codes.
     * Works for version "squizlabs/php_codesniffer": "^2.6".
     *
     * @param int  $exitCode
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
                // phpcbf reported errors that can't be fixed.
                return ComposerScriptInterface::EXIT_CODE_OK;
            case 3:
                // phpcbf exec command (patch) returned an error.
                return ComposerScriptInterface::EXIT_CODE_ERROR;
            default:
                return ComposerScriptInterface::EXIT_CODE_ERROR;
        }
    }
}
