<?php

declare(strict_types=1);

namespace sklwebdev\Console\Command;

use sklwebdev\Console\Input;
use sklwebdev\Console\Output;
use sklwebdev\Console\Registry;

class ListCommand extends Command
{
    /**
     * @param Registry\Registry $registry
     */
    public function __construct(private readonly Registry\Registry $registry)
    { }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return '_list';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return 'Display the list of registered commands';
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(Input\InputInterface $input, Output\OutputInterface $output): void
    {
        $output->writeln();
        if  (!$this->registry->count()) {
            $output->writeln('No commands registered');
            $output->writeln();

            return;
        }

        foreach ($this->registry->all() as $command) {
            $output->writeln(sprintf("%s\t|\t%s", $command->getName(), $command->getDescription()));
        }
        $output->writeln();
    }
}
