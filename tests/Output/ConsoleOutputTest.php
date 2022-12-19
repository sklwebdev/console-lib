<?php

declare(strict_types=1);

namespace sklwebdev\Console\Tests\Output;

use PHPUnit\Framework\TestCase;
use sklwebdev\Console\Output;

class ConsoleOutputTest extends TestCase
{
    public function testWrite()
    {
        $output =  new Output\ConsoleOutput();

        $this->expectOutputString('test_some_string');
        $output->write('test_some_string');
    }

    public function testWriteln()
    {
        $output =  new Output\ConsoleOutput();

        $this->expectOutputString("test_some_string\n\r");
        $output->writeln('test_some_string');
    }
}
