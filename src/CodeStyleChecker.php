<?php

namespace Karriere\CodeQuality;

use Composer\Script\Event;
use Karriere\CodeQuality\Console\ScriptArgumentsTrait;
use Karriere\CodeQuality\Process\Process;

class CodeStyleChecker implements ComposerScriptInterface
{
    use ScriptArgumentsTrait;

    /**
     * The code style checker command.
     * An alternative is php-cs-fixer: 'php-cs-fixer fix src --level=psr2 --dry-run --diff'
     *
     * @var string
     */
    private static $commands = [
        'local'   => 'phpcs src --standard=PSR2 --colors',
        'jenkins' => 'phpcs src --standard=PSR2 --report=checkstyle --report-file=checkstyle.xml'
    ];

    public static function run(Event $event)
    {
        $eventArguments = self::getComposerScriptArguments($event->getArguments());

        $command = self::getArrayValueByEventArguments('env', self::$commands, $eventArguments);
        $command = self::setColorParamIfSupported($command);

        $composerIO = $event->getIO();
        $composerIO->write('<info>Running </info><fg=green;options=bold>' . $command . '</>');

        $process = new Process($command);
        $process->setTtyByArguments($eventArguments);
        $process->run();

        $composerIO->write($process->getOutput());

        $exitCode = $process->getExitCode();

        if ($exitCode === ComposerScriptInterface::EXIT_CODE_OK) {
            $composerIO->write('<fg=black;bg=green>Finished without errors!</>');
        }

        return $exitCode;
    }
}
