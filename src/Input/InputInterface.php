<?php

declare(strict_types=1);

namespace sklwebdev\Console\Input;

interface InputInterface
{
    /**
     * Returns the name of the command
     *
     * @return string|null
     */
    public function getCommandName(): string|null;

    /**
     * Need help
     *
     * @return bool
     */
    public function needHelp(): bool;

    /**
     * Get list of arguments
     *
     * @return array
     */
    public function getArguments(): array;

    /**
     * Get number of arguments
     *
     * @return int
     */
    public function countArguments(): int;

    /**
     * Checks argument index for being exists
     *
     * @param int $index
     * @return bool
     */
    public function hasArgument(int $index): bool;

    /**
     * Get single argument by index
     *
     * @param int $index
     * @return string
     */
    public function getArgument(int $index): string;

    /**
     * Get list of options
     *
     * @return array
     */
    public function getOptions(): array;

    /**
     * Get number of options
     *
     * @return int
     */
    public function countOptions(): int;

    /**
     * Checks option name for being exists
     *
     * @param string $name
     * @return bool
     */
    public function hasOption(string $name): bool;

    /**
     * Get single option by name
     *
     * @param string $name
     * @return string|array
     */
    public function getOption(string $name): string|array;
}
