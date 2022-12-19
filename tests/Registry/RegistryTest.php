<?php

declare(strict_types=1);

namespace sklwebdev\Console\Tests\Registry;

use PHPUnit\Framework\TestCase;
use sklwebdev\Console\Command\ListCommand;
use sklwebdev\Console\Exception;
use sklwebdev\Console\Registry;

class RegistryTest extends TestCase
{
    public function testEmpty(): void
    {
        $reg = new Registry\Registry();

        $this->expectExceptionObject(new Exception\CommandNotFoundException('Command `test_name` not found'));
        $reg->get('test_name');

        $this->assertFalse($reg->has('test_name'));
        $this->assertSame([], $reg->all());
        $this->assertSame(0, $reg->count());
    }

    public function testNotEmpty(): void
    {
        $command = new ListCommand(new Registry\Registry());
        $name = $command->getName();

        $reg = new Registry\Registry();
        $reg->add($command);

        $this->expectExceptionObject(new Exception\CommandNotFoundException('Command `test_name` not found'));
        $reg->get('test_name');
        $this->assertSame($command, $reg->get($name));

        $this->assertFalse($reg->has('test_name'));
        $this->assertTrue($reg->has($name));

        $this->assertSame([$command], $reg->all());

        $this->assertSame(1, $reg->count());
    }
}
