<?php

declare(strict_types=1);

namespace sklwebdev\Console\Tests\Input;

use PHPUnit\Framework\TestCase;
use sklwebdev\Console\Exception;
use sklwebdev\Console\Input;

class ArgvInputTest extends TestCase
{
    public function testEmpty()
    {
        $input = new Input\ArgvInput([]);

        $this->assertNull($input->getCommandName());
        $this->assertFalse($input->needHelp());

        $this->assertSame([], $input->getArguments());
        $this->assertSame(0, $input->countArguments());
        $this->assertFalse($input->hasArgument(0));
        $this->expectExceptionObject(new Exception\InvalidArgumentException('Argument with index `0` not passed'));
        $input->getArgument(0);

        $this->assertSame([], $input->getOptions());
        $this->assertSame(0, $input->countOptions());
        $this->assertFalse($input->hasOption('test_name'));
        $this->expectExceptionObject(new Exception\InvalidOptionException('Option with name `test_name` not passed'));
        $input->getOption('test_name');
    }

    public function testNotEmpty()
    {
        $input = new Input\ArgvInput([
            'file.php',
            'command_name',
            '{arg1}',
            '[opt1=val1]',
            '{arg2,arg3}',
            '[opt2={val21,val22}]',
            '{arg4}',
            '{help}',
            '{{arg5}}',
            '[opt3={val3}]',
            '[opt4={val4]',
            '[opt5={{val5}}]',
        ]);

        $this->assertSame('command_name', $input->getCommandName());
        $this->assertTrue($input->needHelp());

        $arguments = ['arg1','arg2','arg3','arg4','{arg5}'];
        $this->assertSame($arguments, $input->getArguments());
        $this->assertSame(5, $input->countArguments());
        foreach (range(0,4) as $index) {
            $this->assertTrue($input->hasArgument($index));
        }
        $this->assertFalse($input->hasArgument(5));
        foreach ($arguments as $index => $value) {
            $this->assertSame($value,  $input->getArgument($index));
        }
        $this->expectExceptionObject(new Exception\InvalidArgumentException('Argument with index `5` not passed'));
        $input->getArgument(5);

        $options = ['opt1' => 'val1', 'opt2' => ['val21','val22'], 'opt3' => ['val3'], 'opt4' => '{val4', 'opt5' => ['{val5}']];
        $this->assertSame($options, $input->getOptions());
        $this->assertSame(5, $input->countOptions());
        foreach (range(0,4) as $name => $value) {
            $this->assertTrue($input->hasOption($name));
        }
        $this->assertFalse($input->hasOption('test_name'));
        foreach ($options as $name => $value) {
            $this->assertSame($value,  $input->getOption($name));
        }
        $this->expectExceptionObject(new Exception\InvalidOptionException('Option with name `test_name` not passed'));
        $input->getOption('test_name');
    }
}
