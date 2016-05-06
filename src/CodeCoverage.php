<?php

namespace Karriere\CodeQuality;

use Composer\Script\Event;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CodeCoverage implements ComposerScriptInterface
{
    public static $command = 'phpspec run -c phpspec-coverage.yml';

    public static function run(Event $event)
    {
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->writeln('<info>Running </info><fg=green;options=bold>' . self::$command . '</>');

        $process = new Process(self::$command);
        $process->run();

        $exitCode = $process->getExitCode();
        if ($exitCode !== ComposerScriptInterface::EXIT_CODE_OK) {
            //throw new ProcessFailedException($process);
        }

        $consoleOutput->write($process->getOutput());
        $consoleOutput->writeln('<fg=black;bg=yellow>Finished!</>');
    }
}
