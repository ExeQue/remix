<?php

declare(strict_types=1);

namespace ExeQue\Remix\Compare;

/**
 * Compare a value using a callback.
 *
 * The callback can accept a single argument and return a value
 * (any non-boolean values will be cast to a boolean value).
 *
 * @author Morten Harders <mmh@harders-it.dk>
 */
class ComparesUsing extends Comparator
{
    private $callback;

    /**
     * @param callable $callback The callback to use for comparison
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @param callable $callback The callback to use for comparison
     */
    public static function make(callable $callback): self
    {
        return new self($callback);
    }

    public function check(mixed $value): bool
    {
        return (bool)($this->callback)($value);
    }
}
