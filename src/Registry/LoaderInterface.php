<?php

declare(strict_types=1);

namespace sklwebdev\Console\Registry;

interface LoaderInterface
{
    /**
     * Load registry
     *
     * @return Registry
     */
    public function load(): Registry;
}
