<?php

declare(strict_types=1);

namespace ExeQue\Remix\Mutate\Array;

use ExeQue\Remix\Concerns\Makes;

/**
 * Return an array with elements in reverse order
 *
 * @see array_reverse()
 *
 * @author Morten Harders <mmh@harders-it.dk>
 */
class Reverse extends ArrayMutator
{
    use Makes;

    protected function mutateArray(array $array): array
    {
        return array_reverse($array);
    }
}
