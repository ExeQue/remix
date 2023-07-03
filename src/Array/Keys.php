<?php

declare(strict_types=1);

namespace ExeQue\Mutators\Array;

use ExeQue\Mutators\Concerns\Makes;

/**
 * Retrieve all the keys of an array
 *
 * @see array_keys()
 *
 * @author Morten Harders <mmh@harders-it.dk>
 */
class Keys extends ArrayMutator
{
    use Makes;

    protected function mutateArray(array $array): array
    {
        return array_keys($array);
    }
}
