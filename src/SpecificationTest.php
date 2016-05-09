<?php

namespace Karriere\CodeQuality;

use Composer\Script\Event;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Process\Process;

class SpecificationTest implements ComposerScriptInterface
{
    public static $command = 'phpspec run';

    public static function run(Event $event)
    {
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->writeln('<info>Running </info><fg=green;options=bold>' . self::$command . '</>');

        $process = new Process(self::$command);
        $process->setTty(true);
        $process->run();

        $consoleOutput->write($process->getOutput());

        exit($process->getExitCode());
    }
}
