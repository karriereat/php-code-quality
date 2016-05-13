<?php

namespace tests\specs\Karriere\CodeQuality\Process;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Karriere\CodeQuality\Process\Process;

class ProcessSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('foo');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Karriere\CodeQuality\Process\Process');
    }

    function it_extends_a_base_class()
    {
        $this->shouldBeAnInstanceOf('Symfony\Component\Process\Process');
    }

    function its_tty_mode_can_be_set()
    {
        $this->setTtyByArguments(array(Process::NO_TTY_FLAG => null));
        $this->shouldNotBeTty();

        $this->setTtyByArguments(array('foo' => 'bar'));
        $this->shouldBeTty();
    }
}
