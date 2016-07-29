<?php

namespace Karriere\CodeQuality\Console;

use Symfony\Component\Console\Output\ConsoleOutput;

trait ScriptArgumentsTrait
{
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
     * @param  array  $array      Array to be searched
     * @param  array  $eventArgs  Event arguments from self::getComposerScriptArguments()
     * @param  string $key        Get value by a specific key.
     * @param  bool   $verbose    Whether to print verbose information to console.
     * @return string Array value
     */
    public static function getArrayValueByEventArguments(array $array, array $eventArgs, $key = '', $verbose = true)
    {
        if ($key === '') {
            $matching = array_intersect_key($array, $eventArgs);
            $arrayValue = (count($matching) > 0) ? reset($matching) : reset($array);
        } elseif (array_key_exists($key, $eventArgs) && array_key_exists($eventArgs[$key], $array)) {
            $arrayValue = $array[$eventArgs[$key]];
        } elseif (array_key_exists($key, $eventArgs)) {
            $arrayValue = reset($array);

            if ($verbose) {
                $consoleOutput = new ConsoleOutput();
                $consoleOutput->writeln(
                    '<comment>Value <options=bold>' .
                    $eventArgs[$key] .
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
     * Check if a parameter was supplied with command.
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
