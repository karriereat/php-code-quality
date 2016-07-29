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
            [
                'foo' => 'command foo',
                'bar' => 'command bar'
            ],
            ['env' => 'novalidenv'],
            'env',
            false
        )->shouldReturn('command foo');

        self::getArrayValueByEventArguments(
            ['foo' => 'bar'],
            ['bar' => 'foo'],
            'env',
            false
        )->shouldReturn('bar');

        self::getArrayValueByEventArguments(
            ['foo' => 'bar'],
            [],
            'env',
            false
        )->shouldReturn('bar');

        self::getArrayValueByEventArguments(
            [
                'default' => 'command default',
                'verbose' => 'command verbose'
            ],
            [],
            '',
            false
        )->shouldReturn('command default');
    }

    function it_returns_a_command()
    {
        self::getArrayValueByEventArguments(
            [
                'foo' => 'command foo',
                'bar' => 'command bar'
            ],
            ['env' => 'foo'],
            'env'
        )->shouldReturn('command foo');

        self::getArrayValueByEventArguments(
            [
                'foo' => 'command foo',
                'bar' => 'command bar'
            ],
            ['env' => 'bar'],
            'env'
        )->shouldReturn('command bar');

        self::getArrayValueByEventArguments(
            [
                'foo' => 'command foo',
                'bar' => 'command bar'
            ],
            [
                'env' => 'bar',
                'foo' => 'bar'
            ],
            'env'
        )->shouldReturn('command bar');

        self::getArrayValueByEventArguments(
            [
                'default' => 'command default',
                'verbose' => 'command verbose'
            ],
            ['verbose' => null]
        )->shouldReturn('command verbose');
    }

    function it_returns_if_argument_exists()
    {
        self::hasParameterOption('foo', array('foo' => null))
            ->shouldReturn(true);

        self::hasParameterOption('foo', array('bar' => null))
            ->shouldReturn(false);

        self::hasParameterOption('foo', array('foo' => 'bar'))
            ->shouldReturn(true);

        self::hasParameterOption('foo', array('bar' => 'foo'))
            ->shouldReturn(false);

        self::hasParameterOption('foo', array('foo' => 'bar', 'bar' => 'foo'))
            ->shouldReturn(true);
    }
}
