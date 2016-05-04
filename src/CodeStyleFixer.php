<?php

namespace Karriere\CodeQuality;

use Composer\Script\Event;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CodeStyleFixer implements ComposerScriptInterface
{
    public static $command = 'phpcbf src -v --colors';

    public static function run(Event $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        var_dump($vendorDir);

        $process = new Process(self::$command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }
}
