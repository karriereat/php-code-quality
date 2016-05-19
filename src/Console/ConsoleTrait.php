<?php

namespace Karriere\CodeQuality\Console;

trait ConsoleTrait
{
    public static function supportsColors()
    {
        // Windows platform does not support ANSI output.
        if ('\\' === DIRECTORY_SEPARATOR) {
            return false;
        }

        return true;
    }
}
