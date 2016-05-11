<?php

namespace Karriere\CodeQuality;

use Composer\Script\Event;
use Karriere\CodeQuality\Console\ScriptArgumentsTrait;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CodeStyleChecker implements ComposerScriptInterface
{
    use ScriptArgumentsTrait;

    /**
     * The code style checker command.
     * An alternative is php-cs-fixer: 'php-cs-fixer fix src --level=psr2 --dry-run --diff'
     *
     * @var string
     */
    private static $command = [
        'local' => 'phpcs src --standard=PSR2 --colors',
        'jenkins' => 'phpcs src --standard=PSR2 --colors --report=diff'
    ];

    public static function run(Event $event)
    {
        $consoleOutput = new ConsoleOutput();

        $eventArguments = self::getComposerScriptArguments($event->getArguments());

        $command = self::getCommandByEventArguments($eventArguments);

        $consoleOutput->writeln('<info>Running </info><fg=green;options=bold>' . $command . '</>');

        $process = new Process($command);
        $process->setTty(true);
        $process->run();

        $consoleOutput->write($process->getOutput());

        $exitCode = $process->getExitCode();

        if ($exitCode === ComposerScriptInterface::EXIT_CODE_OK) {
            $consoleOutput->writeln('<fg=black;bg=green>Finished without errors!</>');
        }

        exit($exitCode);
    }

    /**
     * Use the fitting command, according to the script argument '--env'.
     *
     * @param array  $eventArguments
     * @return string  $command
     */
    private static function getCommandByEventArguments($eventArguments)
    {
        $consoleOutput = new ConsoleOutput();

        if (array_key_exists('env', $eventArguments) && array_key_exists($eventArguments['env'], self::$command)) {
            $command = self::$command[$eventArguments['env']];
        } elseif (array_key_exists('env', $eventArguments)) {
            $command = self::$command['local'];
            $consoleOutput->writeln(
                '<comment>Environment <options=bold>' .
                $eventArguments['env'] .
                '</> is not defined. Using default command.</comment>'
            );
        } else {
            $command = self::$command['local'];
        }

        return $command;
    }
}
