<?php

declare(strict_types=1);

namespace ExeQue\Mutators\String;

use ExeQue\Mutators\Assert;
use ExeQue\Mutators\Mutator;

/**
 * Explode a string into an array
 *
 * @see explode()
 *
 * @author Morten Harders <mmh@harders-it.dk>
 */
class Explode extends Mutator
{
    private string $delimiter;
    private int $limit;

    public function __construct(string $delimiter, int $limit = PHP_INT_MAX)
    {
        Assert::greaterThanEq($limit, 1, 'Limit must be greater than or equal to 1');

        $this->delimiter = $delimiter;
        $this->limit     = $limit;
    }

    public static function make(string $delimiter, int $limit = PHP_INT_MAX): self
    {
        return new self($delimiter, $limit);
    }

    public function mutate(mixed $value): array
    {
        return explode($this->delimiter, $value, $this->limit);
    }
}
