<?php

declare(strict_types=1);

namespace sklwebdev\Console\Command;

use sklwebdev\Console\Input;
use sklwebdev\Console\Output;

class HelpCommand extends Command
{
    /**
     * @param Command $command
     */
    public function __construct(private readonly Command $command)
    { }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return '_help';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return 'Display the help of command';
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(Input\InputInterface $input, Output\OutputInterface $output): void
    {
        $output->writeln();
        $output->writeln($this->command->getDescription());
        $output->writeln();
    }
}
