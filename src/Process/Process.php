<?php

namespace Karriere\CodeQuality\Process;

use Karriere\CodeQuality\Console\ScriptArgumentsTrait;
use Symfony\Component\Process\Process as SymfonyProcess;

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
     */
    public function setTtyByArguments($eventArguments)
    {
        if (self::argumentExists(self::NO_TTY_FLAG, $eventArguments)) {
            $this->setTty(false);
        } else {
            $this->setTty(true);
        }
    }
}
