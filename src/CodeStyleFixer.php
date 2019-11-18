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
    private static $command = 'phpcbf src --standard=PSR12';

    public static function run(Event $event)
    {
        $eventArguments = self::getComposerScriptArguments($event->getArguments());

        $composerIO = $event->getIO();
        $composerIO->write('<info>Running </info><fg=green;options=bold>' . self::$command . '</>');

        $process = new Process(self::$command);
        $process->setTtyByArguments($eventArguments);
        $process->setProcessTimeoutByArguments($eventArguments);
        $process->run();

        $composerIO->write($process->getOutput());

        // PHPCBF exit codes:
        //  0 = Nothing was fixed by PHPCBF.
        //  1 = PHPCBF fixed all fixable errors.
        //  2 = PHPCBF fixed some fixable errors, but others failed to fix.
        return $process->getExitCode();
    }
}
