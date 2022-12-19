<?php

declare(strict_types=1);

namespace sklwebdev\Console;

use sklwebdev\Console\Command;
use sklwebdev\Console\Input;
use sklwebdev\Console\Registry;
use sklwebdev\Console\Output;

class Application
{
    private readonly Registry\Registry $registry;

    /**
     * @param Registry\LoaderInterface $loader
     */
    public function __construct(Registry\LoaderInterface $loader)
    {
        $this->registry = $loader->load();
    }

    /**
     * Application running
     *
     * @param Input\InputInterface $input
     * @param Output\OutputInterface $output
     */
    public function run(Input\InputInterface $input, Output\OutputInterface $output)
    {
        $name = $input->getCommandName();

        if (!$name) {
            $command = new Command\ListCommand($this->registry);
        } elseif (!$this->registry->has($name)) {
            $command = new Command\NotFoundCommand();
        } elseif ($input->needHelp()) {
            $command = new Command\HelpCommand($this->registry->get($name));
        } else {
            $command = $this->registry->get($name);
            if ($input->needHelp()) {
                $command = new Command\HelpCommand($command);
            }
        }

        $command->run($input, $output);
    }
}
