<?php

namespace Karriere\CodeQuality\Process;

use Karriere\CodeQuality\Console\ScriptArgumentsTrait;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Process\Process as SymfonyProcess;
use Symfony\Component\Process\Exception\RuntimeException;

class Process extends SymfonyProcess
{
    use ScriptArgumentsTrait;

    /**
     * Flag to deactivate tty, must be used in Jenkins environment.
     *
     * @var string
     */
    const NO_TTY_FLAG = 'notty';

    public function __construct($commandline)
    {
        parent::__construct($commandline);
    }

    /**
     * Check if the process was started with a 'notty' flag, if yes, deactivate it.
     *
     * @param $eventArguments
     * @param $verbose
     */
    public function setTtyByArguments($eventArguments, $verbose = true)
    {
        if (self::hasParameterOption(self::NO_TTY_FLAG, $eventArguments)) {
            $this->setTty(false);
        } else {
            // We have to try, because enabling TTY on Windows will throw an exception.
            try {
                $this->setTty(true);
            } catch (RuntimeException $e) {
                if ($verbose) {
                    $console = new ConsoleOutput();
                    $console->writeln('Could not enable TTY: ' . $e->getMessage());
                }
            }
        }
    }
}
