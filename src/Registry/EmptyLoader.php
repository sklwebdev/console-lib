<?php

declare(strict_types=1);

namespace sklwebdev\Console\Registry;

use sklwebdev\Console\Registry;

class EmptyLoader implements LoaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(): Registry\Registry
    {
        return new Registry\Registry();
    }
}
