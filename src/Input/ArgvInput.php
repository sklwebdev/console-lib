<?php

declare(strict_types=1);

namespace sklwebdev\Console\Input;

use sklwebdev\Console\Exception;

class ArgvInput implements InputInterface
{
    /**
     * Command name
     *
     * @var string|null
     */
    private string|null $commandName = null;

    /**
     * Need help
     *
     * @var bool
     */
    private bool $needHelp = false;

    /**
     * List of arguments
     *
     * @var array
     */
    private array $arguments = [];

    /**
     * List of options
     *
     * @var array
     */
    private array $options = [];

    /**
     * @param array $argv
     */
    public function __construct(array $argv)
    {
        // Delete console file name
        array_shift($argv);

        $this->parse($argv);
    }

    /**
     * {@inheritdoc}
     */
    public function getCommandName(): string|null
    {
        return $this->commandName;
    }

    /**
     * {@inheritdoc}
     */
    public function needHelp(): bool
    {
        return $this->needHelp;
    }

    /**
     * {@inheritdoc}
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * {@inheritdoc}
     */
    public function countArguments(): int
    {
        return count($this->arguments);
    }

    /**
     * {@inheritdoc}
     */
    public function hasArgument(int $index): bool
    {
        return array_key_exists($index, $this->arguments);
    }

    /**
     * {@inheritdoc}
     */
    public function getArgument(int $index): string
    {
        if (!$this->hasArgument($index)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Argument with index `%s` not passed',
                $index
            ));
        }

        return $this->arguments[$index];
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function countOptions(): int
    {
        return count($this->options);
    }

    /**
     * {@inheritdoc}
     */
    public function hasOption(string $name): bool
    {
        return array_key_exists($name, $this->options);
    }

    /**
     * {@inheritdoc}
     */
    public function getOption(string $name): string|array
    {
        if (!$this->hasOption($name)) {
            throw new Exception\InvalidOptionException(sprintf(
                'Option with name `%s` not passed',
                $name
            ));
        }

        return $this->options[$name];
    }

    /**
     * Parses the whole passed list
     *
     * @param array $argv
     */
    private function parse(array $argv): void
    {
        $this->commandName = array_shift($argv);
        foreach ($argv as $item) {
            if ($item === '{help}') {
                $this->needHelp = true;
            } elseif (str_starts_with($item, '{') && str_ends_with($item, '}')) {
                $this->parseArgument($item);
            } elseif (str_starts_with($item, '[') && str_ends_with($item, ']')) {
                $this->parseOption($item);
            } else {
                throw new Exception\RuntimeException(sprintf(
                    'Bad input parameters. Arguments must be passed like %s, Options like %s. Other syntax is not allowed',
                    '`{arg1} {arg2}` or `{arg1,arg2}`',
                    '[opt1=value1] [opt2={value21,value23}]'
                ));
            }
        }
    }

    /**
     * Parses argument
     *
     * @param string $raw
     * @return void
     */
    private function parseArgument(string $raw): void
    {
        $value = substr($raw, 1, -1);
        $values = explode(',', $value);

        $this->arguments = [...$this->arguments, ...$values];
    }

    /**
     * Parses option
     *
     * @param string $raw
     * @return void
     */
    private function parseOption(string $raw): void
    {
        $value = substr($raw, 1, -1);
        $values = explode('=', $value);
        if (count($values) !== 2) {
            throw new Exception\RuntimeException(sprintf(
                'Bad input option (`%s`). Options must be passed like %s. Other syntax is not allowed',
                $raw,
                '[opt1=value1] [opt2={value21,value23}]'
            ));
        }

        $name = $values[0];
        $value = $values[1];
        // option value is an array
        if (str_starts_with($value, '{') && str_ends_with($value, '}')) {
            $value = substr($value, 1, -1);
            $values = explode(',', $value);

            $this->addOption($name, $values);

            return;
        }

        $this->addOption($name, $value);
    }

    /**
     * Add option to a list
     *
     * @param string $name
     * @param string|array $value
     */
    private function addOption(string $name, string|array $value)
    {
        if ($this->hasOption($name)) {
            throw new Exception\RuntimeException(sprintf(
                'Bad input option. Option `%s` is duplicated',
                $name
            ));
        }

        $this->options[$name] = $value;
    }
}
