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
    private static $command = 'php-cs-fixer fix src --rules=@PSR2 --using-cache=false';

    public static function run(Event $event)
    {
        $eventArguments = self::getComposerScriptArguments($event->getArguments());

        $composerIO = $event->getIO();
        $composerIO->write('<info>Running </info><fg=green;options=bold>' . self::$command . '</>');

        $process = new Process(self::$command);
        $process->setTtyByArguments($eventArguments);
        $process->run();

        $composerIO->write($process->getOutput());

        $exitCode = $process->getExitCode();

        if ($exitCode !== ComposerScriptInterface::EXIT_CODE_OK) {
            throw new ProcessFailedException($process);
        }

        return $exitCode;
    }
}
