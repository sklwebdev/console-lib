<?php

declare(strict_types=1);

namespace sklwebdev\Console\Tests;

use PHPUnit\Framework\TestCase;
use sklwebdev\Console\Application;
use sklwebdev\Console\Command;
use sklwebdev\Console\Input;
use sklwebdev\Console\Output;
use sklwebdev\Console\Registry;

class ApplicationTest extends TestCase
{
    public function testNoCommands()
    {
        $reg = new Registry\Registry();
        $input = new Input\ArgvInput(['file.php']);
        $output = new Output\ConsoleOutput();

        $loader = $this->createMock(Registry\EmptyLoader::class);
        $loader
            ->method('load')
            ->willReturn($reg);

        $this->expectOutputString("\n\rNo commands registered\n\r\n\r");
        $app = new Application($loader);
        $app->run($input, $output);
    }

    public function testList()
    {
        $command = new Command\ListCommand(new Registry\Registry());

        $reg = new Registry\Registry();
        $reg->add($command);
        $input = new Input\ArgvInput(['file.php']);
        $output = new Output\ConsoleOutput();

        $loader = $this->createMock(Registry\EmptyLoader::class);
        $loader
            ->method('load')
            ->willReturn($reg);

        $this->expectOutputString(sprintf("\n\r%s\t|\t%s\n\r\n\r", $command->getName(), $command->getDescription()));
        $app = new Application($loader);
        $app->run($input, $output);
    }

    public function testConcreteHelp()
    {
        $command = new Command\ListCommand(new Registry\Registry());

        $reg = new Registry\Registry();
        $reg->add($command);
        $input = new Input\ArgvInput(['file.php', '_list', '{help}']);
        $output = new Output\ConsoleOutput();

        $loader = $this->createMock(Registry\EmptyLoader::class);
        $loader
            ->method('load')
            ->willReturn($reg);

        $this->expectOutputString(sprintf("\n\r%s\n\r\n\r", $command->getDescription()));
        $app = new Application($loader);
        $app->run($input, $output);
    }

    public function testNotFound()
    {
        $command = new Command\ListCommand(new Registry\Registry());

        $reg = new Registry\Registry();
        $reg->add($command);
        $input = new Input\ArgvInput(['file.php', '{help}']);
        $output = new Output\ConsoleOutput();

        $loader = $this->createMock(Registry\EmptyLoader::class);
        $loader
            ->method('load')
            ->willReturn($reg);

        $this->expectOutputString("\n\rCommand name `{help}` is not registered\n\r\n\r");
        $app = new Application($loader);
        $app->run($input, $output);
    }

    public function testNotFoundHelp()
    {
        $command = new Command\ListCommand(new Registry\Registry());

        $reg = new Registry\Registry();
        $reg->add($command);
        $input = new Input\ArgvInput(['file.php', 'test_name', '{help}']);
        $output = new Output\ConsoleOutput();

        $loader = $this->createMock(Registry\EmptyLoader::class);
        $loader
            ->method('load')
            ->willReturn($reg);

        $this->expectOutputString("\n\rCommand name `test_name` is not registered\n\r\n\r");
        $app = new Application($loader);
        $app->run($input, $output);
    }
}
