<?php

namespace Karriere\CodeQuality;

use Composer\Script\Event;
use Karriere\CodeQuality\Console\ScriptArgumentsTrait;
use Karriere\CodeQuality\Process\Process;
use Symfony\Component\Console\Output\ConsoleOutput;

class SpecificationTest implements ComposerScriptInterface
{
    use ScriptArgumentsTrait;

    private static $command = 'phpspec run';

    public static function run(Event $event)
    {
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->writeln('<info>Running </info><fg=green;options=bold>' . self::$command . '</>');

        $eventArguments = self::getComposerScriptArguments($event->getArguments());

        $process = new Process(self::$command);
        $process->setTtyByArguments($eventArguments);
        $process->run();

        $consoleOutput->write($process->getOutput());

        return $process->getExitCode();
    }
}
