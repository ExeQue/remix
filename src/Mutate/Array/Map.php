<?php

declare(strict_types=1);

namespace ExeQue\Remix\Mutate\Array;

/**
 * Applies the callback to the elements of the given array
 *
 * @see array_map()
 *
 * @author Morten Harders <mmh@harders-it.dk>
 */
class Map extends ArrayMutator
{
    private $callback;

    /**
     * @param callable $callback The callback to apply to each element
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @param callable $callback The callback to apply to each element
     */
    public static function make(callable $callback): self
    {
        return new self($callback);
    }

    protected function mutateArray(array $array): array
    {
        return array_map($this->callback, $array, array_keys($array));
    }
}
