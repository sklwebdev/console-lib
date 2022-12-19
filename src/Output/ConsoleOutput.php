<?php

declare(strict_types=1);

namespace sklwebdev\Console\Output;

class ConsoleOutput implements OutputInterface
{
    /**
     * {@inheritdoc}
     */
    public function write(string $message = '', bool $withNewLine = false): void
    {
        echo $message;
        if ($withNewLine) {
            echo "\n\r";
        }
    }

    /**
     * {@inheritdoc}
     */
    public function writeln(string $message = ''): void
    {
        $this->write($message, true);
    }

}
