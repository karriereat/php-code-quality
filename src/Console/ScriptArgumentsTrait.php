<?php

namespace Karriere\CodeQuality\Console;

trait ScriptArgumentsTrait
{
    /**
     * Convert composer script arguments (-- --foo --bar=foo) to a key-value array.
     *
     * @param array  $arguments  String from new Composer\Script\Event()->getArguments()
     * @return array
     */
    public static function getComposerScriptArguments($arguments)
    {
        $keyValueArguments = array();

        foreach ($arguments as $argument) {
            list($argKey, $argValue) = (strpos($argument, '=') !== false) ? explode('=', $argument) : [$argument, null];
            $keyValueArguments[trim($argKey, '-')] = $argValue;
        }

        return $keyValueArguments;
    }
}
