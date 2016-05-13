<?php

namespace tests\specs\Karriere\CodeQuality;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CodeStyleCheckerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Karriere\CodeQuality\CodeStyleChecker');
    }

    function it_implements_the_correct_interface()
    {
        $this->shouldImplement('Karriere\CodeQuality\ComposerScriptInterface');
    }
}
