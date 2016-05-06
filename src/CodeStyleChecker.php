<?php

namespace Karriere\CodeQuality;

use Composer\Script\Event;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CodeStyleChecker implements ComposerScriptInterface
{
    public static $command = 'phpcs src -s -p --standard=PSR2';

    public static function run(Event $event)
    {
        $process = new Process(self::$command);
        $process->run();

        $exitCode = $process->getExitCode();
        if ($exitCode !== ComposerScriptInterface::EXIT_CODE_OK) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }
}
