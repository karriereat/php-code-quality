<?php

namespace tests\specs\Karriere\CodeQuality\Console;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ScriptArgumentsTraitSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('Karriere\CodeQuality\Console\Stubs\ScriptArgumentsTraitStub');
    }

    function it_returns_an_empty_array()
    {
        self::getComposerScriptArguments(array())
            ->shouldReturn(array());
    }

    function it_returns_a_key_value_array()
    {
        self::getComposerScriptArguments(array('--foo'))
            ->shouldReturn(array('foo' => null));

        self::getComposerScriptArguments(array('--foo=bar'))
            ->shouldReturn(array('foo' => 'bar'));

        self::getComposerScriptArguments(array('--foo=bar foo'))
            ->shouldReturn(array('foo' => 'bar foo'));

        self::getComposerScriptArguments(array('--foo', '--bar'))
            ->shouldReturn(array('foo' => null, 'bar' => null));

        self::getComposerScriptArguments(array('--foo=bar', '--bar=foo'))
            ->shouldReturn(array('foo' => 'bar', 'bar' => 'foo'));

        self::getComposerScriptArguments(array('--foo=bar', '--bar=foo'))
            ->shouldReturn(array('foo' => 'bar', 'bar' => 'foo'));
    }

    function it_returns_a_default_command()
    {
        self::getArrayValueByEventArguments(
            'env',
            [
                'foo' => 'command foo',
                'bar' => 'command bar'
            ],
            ['env' => 'novalidenv'],
            false
        )->shouldReturn('command foo');
    }

    function it_returns_a_command()
    {
        self::getArrayValueByEventArguments(
            'env',
            [
                'foo' => 'command foo',
                'bar' => 'command bar'
            ],
            ['env' => 'foo']
        )->shouldReturn('command foo');

        self::getArrayValueByEventArguments(
            'env',
            [
                'foo' => 'command foo',
                'bar' => 'command bar'
            ],
            ['env' => 'bar']
        )->shouldReturn('command bar');
    }
}
