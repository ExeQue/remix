<?php

declare(strict_types=1);

namespace ExeQue\Remix\Mutate\Array;

use ExeQue\Remix\Assert;
use ExeQue\Remix\Mutate\Mutator;

/**
 * Get element at the specified index. If the index does not exist, the default value is returned.
 *
 * If the default value is a callable, it will be invoked with the array and the index as arguments.
 *
 * @author Morten Harders <mmh@harders-it.dk>
 */
class At extends Mutator
{
    private string|int $index;
    private mixed $default;

    /**
     * @param string|int $index The index to get
     * @param mixed|null $default The default value to return if the index does not exist. Will be called with the array and the index as arguments if it is a callable (defaults to null).
     */
    public function __construct(string|int $index, mixed $default = null)
    {
        $this->index   = $index;
        $this->default = $default;
    }

    /**
     * @param string|int $index The index to get
     * @param mixed|null $default The default value to return if the index does not exist. Will be called with the array and the index as arguments if it is a callable (defaults to null).
     */
    public static function make(string|int $index, mixed $default = null): self
    {
        return new self($index, $default);
    }

    public function mutate(mixed $value): mixed
    {
        Assert::isIterable($value, static::class . ' expects an iterable value');

        if (! is_array($value)) {
            $value = iterator_to_array($value);
        }

        if (is_int($this->index) && array_is_list($value)) {
            return $this->resolveAsList($value);
        }

        return $value[$this->index] ?? $this->resolveDefault($value);
    }

    private function resolveAsList(mixed $value)
    {
        if ($this->index < 0) {
            $index = count($value) + $this->index;
        } else {
            $index = $this->index;
        }

        return $value[$index] ?? $this->resolveDefault($value);
    }

    private function resolveDefault(array $value): mixed
    {
        if (! is_string($this->default) && is_callable($this->default)) {
            return ($this->default)($value, $this->index);
        }

        return $this->default;
    }
}
