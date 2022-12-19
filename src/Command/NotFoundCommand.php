<?php

declare(strict_types=1);

namespace sklwebdev\Console\Command;

use sklwebdev\Console\Input;
use sklwebdev\Console\Output;
use sklwebdev\Console\Registry;

class NotFoundCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return '_not_found';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return 'Display the message about not found command and shows the list of registered commands';
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(Input\InputInterface $input, Output\OutputInterface $output): void
    {
        $output->writeln();
        $output->writeln(sprintf('Command name `%s` is not registered', $input->getCommandName()));
        $output->writeln();
    }
}
