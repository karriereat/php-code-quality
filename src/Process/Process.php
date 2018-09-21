<?php

namespace Karriere\CodeQuality\Process;

use Karriere\CodeQuality\Console\ScriptArgumentsTrait;
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

    /**
     * Flag to set the symfony process timeout as parameter.
     *
     * @var string
     */
    const PROCESS_TIMEOUT = 'ptimeout';

    public function __construct($commandline)
    {
        parent::__construct($commandline);
    }

    /**
     * Check if the process was started with a 'notty' flag, if yes, deactivate it.
     *
     * @param array $eventArguments
     * @return bool
     */
    public function setTtyByArguments($eventArguments)
    {
        if (self::hasParameterOption(self::NO_TTY_FLAG, $eventArguments)) {
            $this->setTty(false);
        } else {
            // We have to try, because enabling TTY on an environment without TTY support will throw an exception.
            // This can be changed to `Process::isTtySupported()` if we only support symfony/process v4.1 and upwards.
            try {
                $this->setTty(true);
            } catch (RuntimeException $e) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if the process was started with a 'ptimeout' flag, if not, use default 60s timeout
     *
     * @param array $eventArguments
     * @return bool
     */
    public function setProcessTimeoutByArguments($eventArguments)
    {
        if (self::hasParameterOption(self::PROCESS_TIMEOUT, $eventArguments)) {
            $this->setTimeout($eventArguments[self::PROCESS_TIMEOUT]);
        }

        return true;
    }
}
