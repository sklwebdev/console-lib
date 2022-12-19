<?php

declare(strict_types=1);

namespace sklwebdev\Console\Tests\Command;

use PHPUnit\Framework\TestCase;
use sklwebdev\Console\Command;
use sklwebdev\Console\Input;
use sklwebdev\Console\Output;

class NotFoundCommandTest extends TestCase
{
    public function test()
    {
        $input = new Input\ArgvInput(['file.php', 'test_name']);
        $output = new Output\ConsoleOutput();

        $this->expectOutputString("\n\rCommand name `test_name` is not registered\n\r\n\r");
        (new Command\NotFoundCommand())->run($input, $output);
    }
}
