<?php

declare(strict_types=1);

namespace sklwebdev\Console\Registry;

use sklwebdev\Console\Command;
use sklwebdev\Console\Exception;

class Registry
{
    /**
     * @var Command\Command[]
     */
    protected array $commands = [];

    /**
     * Add command
     *
     * @param Command\Command $command
     */
    public function add(Command\Command $command)
    {
        $this->commands[$command->getName()] = $command;
    }

    /**
     * Get command by name
     *
     * @param string $name
     * @return Command\Command
     */
    public function get(string $name): Command\Command
    {
        if ($this->has($name)) {
            return $this->commands[$name];
        }

        throw new Exception\CommandNotFoundException(
            sprintf('Command `%s` not found', $name)
        );
    }

    /**
     * Checks command for being exists
     *
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($this->commands[$name]);
    }

    /**
     * Get list
     *
     * @return array
     */
    public function all(): array
    {
        return $this->commands;
    }

    /**
     * Count number of commands
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->commands);
    }
}
