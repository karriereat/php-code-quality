<?php

namespace Karriere\CodeQuality;

use Composer\Script\Event;
use Karriere\CodeQuality\Console\ScriptArgumentsTrait;
use Karriere\CodeQuality\Process\Process;

class SpecificationTest implements ComposerScriptInterface
{
    use ScriptArgumentsTrait;

    private static $command = 'phpspec run';

    public static function run(Event $event)
    {
        $composerIO = $event->getIO();
        $composerIO->write('<info>Running </info><fg=green;options=bold>' . self::$command . '</>');

        $eventArguments = self::getComposerScriptArguments($event->getArguments());

        $process = new Process(self::$command);
        $process->setTtyByArguments($eventArguments);
        $process->run();

        $composerIO->write($process->getOutput());

        return $process->getExitCode();
    }
}
