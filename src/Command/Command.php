<?php

declare(strict_types=1);

namespace sklwebdev\Console\Command;

use sklwebdev\Console\Input;
use sklwebdev\Console\Output;

abstract class Command
{
    /**
     * Command name
     *
     * @return string
     */
    abstract public function getName(): string;

    /**
     * Command description
     *
     * @return string
     */
    abstract public function getDescription(): string;

    /**
     * Main logic for command
     *
     * @param Input\InputInterface $input
     * @param Output\OutputInterface $output
     */
    abstract protected function execute(Input\InputInterface $input, Output\OutputInterface $output);

    /**
     * Run the command
     *
     * @param Input\InputInterface $input
     * @param Output\OutputInterface $output
     * @return void
     */
    public function run(Input\InputInterface $input, Output\OutputInterface $output)
    {
        $this->execute($input, $output);
    }
}
