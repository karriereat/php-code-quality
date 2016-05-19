<?php

namespace Karriere\CodeQuality;

use Composer\Script\Event;
use Karriere\CodeQuality\Console\ScriptArgumentsTrait;
use Karriere\CodeQuality\Process\Process;

class CodeCoverage implements ComposerScriptInterface
{
    use ScriptArgumentsTrait;

    private static $commands = [
        'local'   => 'phpspec run -c phpspec-coverage.yml',
        'jenkins' => 'phpspec run -c phpspec-coverage.yml --format=junit > junit.xml'
    ];

    public static function run(Event $event)
    {
        $eventArguments = self::getComposerScriptArguments($event->getArguments());

        $command = self::getArrayValueByEventArguments('env', self::$commands, $eventArguments);

        $composerIO = $event->getIO();
        $composerIO->write('<info>Running </info><fg=green;options=bold>' . $command . '</>');

        $process = new Process($command);
        $process->setTtyByArguments($eventArguments);
        $process->run();

        return $process->getExitCode();
    }
}
