<?php

declare(strict_types=1);

namespace ExeQue\Remix\Mutate\String;

use ExeQue\Remix\Concerns\Definitions\UsesEncoding;
use ExeQue\Remix\Concerns\ResolvesStringInput;
use ExeQue\Remix\Mutate\Mutator;

/**
 * Finds the position of the first occurrence of a substring in a string
 *
 * @see mb_strpos()
 *
 * @author Morten Harders <mmh@harders-it.dk>
 */
class PositionOf extends Mutator
{
    use UsesEncoding;
    use ResolvesStringInput;

    protected string $needle;
    private bool $last;
    protected int $offset = 0;
    private bool $caseSensitive;

    /**
     * @param string $needle The substring to search for.
     * @param bool $last Whether to search for the last occurrence of the substring (default: false).
     * @param int $offset The position to start searching from (default: 0).
     * @param string|null $encoding The encoding to use (optional).
     */
    public function __construct(string $needle, bool $last = false, int $offset = 0, bool $caseSensitive = true, string $encoding = null)
    {
        $this->needle        = $needle;
        $this->last          = $last;
        $this->offset        = $offset;
        $this->caseSensitive = $caseSensitive;

        $this->setEncoding($encoding);
    }

    /**
     * @param string $needle The substring to search for.
     * @param bool $last Whether to search for the last occurrence of the substring (default: false).
     * @param int $offset The position to start searching from (default: 0).
     * @param string|null $encoding The encoding to use (optional).
     */
    public static function make(string $needle, bool $last = false, int $offset = 0, bool $caseSensitive = true, string $encoding = null): self
    {
        return new self($needle, $last, $offset, $caseSensitive, $encoding);
    }

    public static function first(string $needle, int $offset = 0, bool $caseSensitive = true, string $encoding = null): self
    {
        return new self($needle, false, $offset, $caseSensitive, $encoding);
    }

    public static function last(string $needle, int $offset = 0, bool $caseSensitive = true, string $encoding = null): self
    {
        return new self($needle, true, $offset, $caseSensitive, $encoding);
    }

    public function mutate(mixed $value): int|false
    {
        $value = $this->resolveStringInput($value);

        $encoding = $this->getEncoding($value);

        if ($this->last) {
            if(! $this->caseSensitive) {
                return mb_strripos($value, $this->needle, $this->offset, $encoding);
            }

            return mb_strrpos($value, $this->needle, $this->offset, $encoding);
        }

        if(! $this->caseSensitive) {
            return mb_stripos($value, $this->needle, $this->offset, $encoding);
        }

        return mb_strpos($value, $this->needle, $this->offset, $encoding);
    }
}
