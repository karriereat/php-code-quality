<?php

namespace Karriere\CodeQuality;

use Composer\Script\Event;
use Karriere\CodeQuality\Console\ScriptArgumentsTrait;
use Karriere\CodeQuality\Process\Process;

class MessDetector implements ComposerScriptInterface
{
    use ScriptArgumentsTrait;

    private static $commands = [
        'local' => 'phpmd src text ' . __DIR__ . '/../config/phpmd.xml',
        'jenkins' => 'phpmd src xml ' . __DIR__ . '/../config/phpmd.xml --reportfile phpmd.xml'
    ];

    public static function run(Event $event)
    {
        $eventArguments = self::getComposerScriptArguments($event->getArguments());

        $command = self::getArrayValueByEventArguments(self::$commands, $eventArguments, 'env');

        $composerIO = $event->getIO();
        $composerIO->write('<info>Running </info><fg=green;options=bold>' . $command . '</>');

        $process = new Process($command);
        $process->setTtyByArguments($eventArguments);
        $process->setProcessTimeoutByArguments($eventArguments);
        $process->run();

        return $process->getExitCode();
    }
}
