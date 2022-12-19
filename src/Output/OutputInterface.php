<?php

declare(strict_types=1);

namespace sklwebdev\Console\Output;

interface OutputInterface
{
    /**
     * Write a message
     *
     * @param string $message
     * @param bool $withNewLine
     */
    public function write(string $message = '', bool $withNewLine = false): void;

    /**
     * Write a message and move cursor to next line
     *
     * @param string $message
     */
    public function writeln(string $message = ''): void;
}
