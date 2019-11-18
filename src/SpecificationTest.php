<?php

namespace Karriere\CodeQuality;

use Composer\Script\Event;
use Karriere\CodeQuality\Console\ScriptArgumentsTrait;
use Karriere\CodeQuality\Process\Process;

class SpecificationTest implements ComposerScriptInterface
{
    use ScriptArgumentsTrait;

    /**
     * The code phpspec command.
     *
     * @var string
     */
    private static $commands = [
        'default' => 'phpspec run',
        'verbose' => 'phpspec run -v',
        'v'       => 'phpspec run -v'
    ];

    public static function run(Event $event)
    {
        $eventArguments = self::getComposerScriptArguments($event->getArguments());

        $command = self::getArrayValueByEventArguments(self::$commands, $eventArguments);

        $composerIO = $event->getIO();
        $composerIO->write('<info>Running </info><fg=green;options=bold>' . $command . '</>');

        $process = new Process($command);
        $process->setTtyByArguments($eventArguments);
        $process->setProcessTimeoutByArguments($eventArguments);
        $process->run();

        $composerIO->write($process->getOutput());

        $exitCode = $process->getExitCode();

        $fail = self::hasParameterOption(ComposerScriptInterface::FLAG_FAIL, $eventArguments);

        if ($exitCode !== ComposerScriptInterface::EXIT_CODE_OK && $fail) {
            throw new \Exception('Failed with exit code ' . $exitCode . '.');
        }

        return $exitCode;
    }
}
