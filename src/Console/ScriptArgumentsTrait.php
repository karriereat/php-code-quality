<?php

namespace Karriere\CodeQuality\Console;

use Symfony\Component\Console\Output\ConsoleOutput;

trait ScriptArgumentsTrait
{
    use ConsoleTrait;

    /**
     * Convert composer script arguments (-- --foo --bar=foo) to a key-value array.
     *
     * @param  array $arguments String from new Composer\Script\Event()->getArguments()
     * @return array
     */
    public static function getComposerScriptArguments(array $arguments)
    {
        $keyValueArguments = array();

        foreach ($arguments as $argument) {
            list($argKey, $argValue) = (strpos($argument, '=') !== false) ? explode('=', $argument) : [$argument, null];
            $keyValueArguments[trim($argKey, '-')] = $argValue;
        }

        return $keyValueArguments;
    }

    /**
     * Gets a value from array, depending on event arguments.
     * If no match is found, the first item of $array is returned.
     *
     * @param  string $key
     * @param  array  $array          Array to be searched
     * @param  array  $eventArguments
     * @param  bool   $verbose        Whether to print verbose information to console.
     * @return string Array value
     */
    public static function getArrayValueByEventArguments($key, array $array, array $eventArguments, $verbose = true)
    {
        if (array_key_exists($key, $eventArguments) && array_key_exists($eventArguments[$key], $array)) {
            $arrayValue = $array[$eventArguments[$key]];
        } elseif (array_key_exists($key, $eventArguments)) {
            $arrayValue = reset($array);

            if ($verbose) {
                $consoleOutput = new ConsoleOutput();
                $consoleOutput->writeln(
                    '<comment>Value <options=bold>' .
                    $eventArguments[$key] .
                    '</> is not defined. Using <options=bold>' .
                    key($array) . '</>.</comment>'
                );
            }
        } else {
            $arrayValue = reset($array);
        }

        return $arrayValue;
    }

    /**
     * Adds the '--colors' param if it is supported by the current OS and a placeholder is found in the command.
     *
     * @param $command
     * @param string $param
     * @param string $placeholder
     * @return mixed
     */
    public static function setColorParamIfSupported($command, $param = '--colors', $placeholder = '{--colors}')
    {
        if (self::supportsColors()) {
            $command = str_replace($placeholder, $param, $command);
        } else {
            $command = str_replace($placeholder, '', $command);
        }

        return trim($command);
    }

    /**
     * Adds the '--no-ansi' param if ANSI is not supported by the current OS and a placeholder is found in the command.
     *
     * @param $command
     * @param string $param
     * @param string $placeholder
     * @return mixed
     */
    public static function setNoAnsiParamIfNeeded($command, $param = '--no-ansi', $placeholder = '{--no-ansi}')
    {
        if (self::supportsColors()) {
            $command = str_replace($placeholder, '', $command);
        } else {
            $command = str_replace($placeholder, $param, $command);
        }

        return trim($command);
    }

    /**
     * Check if an paramater was supplied with command.
     *
     * @param string $parameter
     * @param array  $eventArguments
     * @return bool
     */
    public static function hasParameterOption($parameter, array $eventArguments)
    {
        if (array_key_exists($parameter, $eventArguments)) {
            return true;
        }

        return false;
    }
}
