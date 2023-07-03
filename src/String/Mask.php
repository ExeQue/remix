<?php

declare(strict_types=1);

namespace ExeQue\Mutators\String;

use ExeQue\Mutators\Assert;

/**
 * Masks a string with a single character based on a regular expression
 *
 * @author Morten Harders <mmh@harders-it.dk>
 */
class Mask extends StringMutator
{
    private string $pattern;
    private string $replacement;

    public function __construct(string $pattern, string $replacement = '*')
    {
        $this->validate($replacement, $pattern);

        $this->pattern     = $pattern;
        $this->replacement = $replacement;
    }

    public static function make(string $pattern, string $replacement = '*'): self
    {
        return new self($pattern, $replacement);
    }

    protected function mutateString(string $value): string
    {
        return preg_replace_callback($this->pattern, function ($matches) {
            return str_repeat($this->replacement, mb_strlen($matches[0]));
        }, $value);
    }

    private function validate(string $replacement, string $pattern): void
    {
        Assert::length($replacement, 1, 'Replacement must be a single character.');
    }
}
