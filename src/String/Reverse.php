<?php

declare(strict_types=1);

namespace ExeQue\Mutators\String;

use ExeQue\Mutators\Concerns\Definitions\UsesEncoding;

/**
 * Reverses the string
 *
 * @see mb_strrev()
 *
 * @author Morten Harders <mmh@harders-it.dk>
 */
class Reverse extends StringMutator
{
    use UsesEncoding;

    public function __construct(string $encoding = null)
    {
        $this->setEncoding($encoding);
    }

    public static function make(string $encoding = null): self
    {
        return new self($encoding);
    }

    protected function mutateString(string $value): string
    {
        return mb_strrev($value, $this->getEncoding($value));
    }
}
