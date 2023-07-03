<?php

declare(strict_types=1);

namespace ExeQue\Mutators\String;

/**
 * Replace all occurrences of the search string with the replacement string.
 *
 * @see str_replace()
 *
 * @author Morten Harders <mmh@harders-it.dk>
 */
class Replace extends StringMutator
{
    private string|array $search;
    private string|array $replace;
    private bool $caseSensitive;

    public function __construct(array|string $search, array|string $replace, bool $caseSensitive = true)
    {
        $this->search        = $search;
        $this->replace       = $replace;
        $this->caseSensitive = $caseSensitive;
    }

    public static function make(array|string $search, array|string $replace, bool $caseSensitive = true): self
    {
        return new self($search, $replace, $caseSensitive);
    }

    protected function mutateString(string $value): string
    {
        if (! $this->caseSensitive) {
            return str_ireplace($this->search, $this->replace, $value);
        }

        return str_replace($this->search, $this->replace, $value);
    }
}
