<?php

namespace Karriere\CodeQuality;

use Composer\Script\Event;
use Karriere\CodeQuality\Console\ScriptArgumentsTrait;
use Karriere\CodeQuality\Process\Process;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CodeCoverage implements ComposerScriptInterface
{
    use ScriptArgumentsTrait;

    private static $commands = [
        'local'   => 'phpspec run -c phpspec-coverage.yml',
        'jenkins' => 'phpspec run -c phpspec-coverage.yml --format=junit > junit.xml'
    ];

    public static function run(Event $event)
    {
        $consoleOutput = new ConsoleOutput();

        $eventArguments = self::getComposerScriptArguments($event->getArguments());

        $command = self::getArrayValueByEventArguments('env', self::$commands, $eventArguments);

        $consoleOutput->writeln('<info>Running </info><fg=green;options=bold>' . $command . '</>');

        $process = new Process($command);
        $process->setTtyByArguments($eventArguments);
        $process->run();

        exit($process->getExitCode());
    }
}
