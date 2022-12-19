<?php

declare(strict_types=1);

namespace sklwebdev\Console\Tests\Command;

use PHPUnit\Framework\TestCase;
use sklwebdev\Console\Command;
use sklwebdev\Console\Input;
use sklwebdev\Console\Output;
use sklwebdev\Console\Registry;

class ListCommandTest extends TestCase
{
    public function testNoCommands()
    {
        $reg = new Registry\Registry();
        $input = new Input\ArgvInput(['file.php']);
        $output = new Output\ConsoleOutput();

        $this->expectOutputString("\n\rNo commands registered\n\r\n\r");
        (new Command\ListCommand($reg))->run($input, $output);
    }

    public function testWithCommands()
    {
        $command = new Command\ListCommand(new Registry\Registry());

        $reg = new Registry\Registry();
        $reg->add($command);
        $input = new Input\ArgvInput(['file.php']);
        $output = new Output\ConsoleOutput();

        $this->expectOutputString(sprintf("\n\r%s\t|\t%s\n\r\n\r", $command->getName(), $command->getDescription()));
        (new Command\ListCommand($reg))->run($input, $output);
    }
}
