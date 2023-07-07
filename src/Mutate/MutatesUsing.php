<?php

declare(strict_types=1);

namespace ExeQue\Remix\Mutate;

/**
 * Mutate a value using a callback.
 *
 * The callback can accept a single argument and return a value
 *
 * @author Morten Harders <mmh@harders-it.dk>
 */
class MutatesUsing extends Mutator
{
    private $callback;

    /**
     * @param  callable  $callback The callback to use for mutation.
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @param  callable  $callback The callback to use for mutation.
     */
    public static function make(callable $callback): self
    {
        return new self($callback);
    }

    public function mutate(mixed $value): mixed
    {
        return ($this->callback)($value);
    }
}
