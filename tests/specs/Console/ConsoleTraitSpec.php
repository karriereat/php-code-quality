<?php

namespace tests\specs\Karriere\CodeQuality\Console;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConsoleTraitSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('Karriere\CodeQuality\Console\Stubs\ConsoleTraitStub');
    }

    function it_supports_colors()
    {
        // Since we have no color support on Windows platform, we have to adapt our spec according to the current OS.
        if ('\\' === DIRECTORY_SEPARATOR) {
            // Windows
            self::supportsColors()
                ->shouldReturn(false);
        } else {
            // Unix
            self::supportsColors()
                ->shouldReturn(true);
        }
    }
}
