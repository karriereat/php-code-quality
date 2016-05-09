<?php

namespace Karriere\CodeQuality;

use Composer\Script\Event;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CodeStyleChecker implements ComposerScriptInterface
{
    public static $command = 'phpcs src -s --colors --report=diff --standard=PSR2';

    public static function run(Event $event)
    {
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->writeln('<info>Running </info><fg=green;options=bold>' . self::$command . '</>');

        $process = new Process(self::$command);
        $process->setTty(true);
        $process->run();

        $consoleOutput->write($process->getOutput());

        $exitCode = $process->getExitCode();

        if ($exitCode === ComposerScriptInterface::EXIT_CODE_OK) {
            $consoleOutput->writeln('<fg=black;bg=green>Finished without errors!</>');
        }

        exit($exitCode);
    }
}
