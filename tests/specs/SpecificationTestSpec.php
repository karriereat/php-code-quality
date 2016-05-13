<?php

namespace tests\specs\Karriere\CodeQuality;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SpecificationTestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Karriere\CodeQuality\SpecificationTest');
    }

    function it_implements_the_correct_interface()
    {
        $this->shouldImplement('Karriere\CodeQuality\ComposerScriptInterface');
    }
}
