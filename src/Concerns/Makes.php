<?php

declare(strict_types=1);

namespace ExeQue\Remix\Concerns;

trait Makes
{
    /**
     * Create a new instance of the class.
     */
    public static function make(): self
    {
        return new self();
    }
}
