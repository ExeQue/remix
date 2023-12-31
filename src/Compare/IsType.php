<?php

declare(strict_types=1);

namespace ExeQue\Remix\Compare;

use Closure;
use ExeQue\Remix\Assert;
use ExeQue\Remix\Exceptions\InvalidArgumentException;
use ExeQue\Remix\Helpers\Uses;

/**
 * Check if the value is of a given type. Supports all scalar types, objects, arrays, callables, classes, interfaces and traits.
 *
 * Supports the following types:
 * - `int`
 * - `float`
 * - `bool`
 * - `string`
 * - `scalar`
 * - `numeric`
 * - `null`
 * - `array`
 * - `object`
 * - `resource`
 * - `callable`
 * - `iterable`
 * - `class` (e.g. `MyClass::class`)
 * - `interface` (e.g. `MyInterface::class`)
 * - `trait` (e.g. `MyTrait::class`)
 *
 * @author Morten Harders <mmh@harders-it.dk>
 */
class IsType extends Comparator
{
    private Closure $callback;

    /**
     * @param string $type The type to check for
     *
     * @throws InvalidArgumentException If the given type is not supported
     */
    public function __construct(string $type)
    {
        if ($this->isTrait($type)) {
            $this->callback = fn ($value) => $this->checkIfValueUsesTrait($value, $type);
        }

        if ($this->isClass($type) || $this->isInterface($type)) {
            $this->callback = fn ($value) => $this->checkIfValueIsInstanceOfType($value, $type);
        }

        if ($this->isScalar($type) || $this->isObject($type) || $this->isArray($type)) {
            $this->callback = fn ($value) => $this->checkIfValueIsBuiltIn($value, $type);
        }

        if ($this->isNumeric($type)) {
            $this->callback = fn ($value) => $this->checkIfValueIsNumeric($value);
        }

        if ($this->isNull($type)) {
            $this->callback = fn ($value) => $this->checkIfValueIsNull($value);
        }

        if ($this->isIterable($type)) {
            $this->callback = fn ($value) => $this->checkIfValueIsIterable($value);
        }

        if ($this->isCallable($type)) {
            $this->callback = fn ($value) => $this->checkIfValueIsCallable($value);
        }

        if ($this->isResource($type)) {
            $this->callback = fn ($value) => $this->checkIfValueIsResource($value);
        }

        if (! isset($this->callback)) {
            throw new InvalidArgumentException('Invalid type given. Got: ' . $type);
        }
    }

    /**
     * @param string $type The type to check for
     *
     * @throws InvalidArgumentException If the given type is not supported
     */
    public static function make(string $type): self
    {
        return new self($type);
    }

    public static function int(): self
    {
        return self::make('int');
    }

    public static function float(): self
    {
        return self::make('float');
    }

    public static function bool(): self
    {
        return self::make('bool');
    }

    public static function string(): self
    {
        return self::make('string');
    }

    public static function scalar(): self
    {
        return self::make('scalar');
    }

    public static function numeric(): self
    {
        return self::make('numeric');
    }

    public static function null(): self
    {
        return self::make('null');
    }

    public static function array(): self
    {
        return self::make('array');
    }

    public static function object(): self
    {
        return self::make('object');
    }

    public static function resource(): self
    {
        return self::make('resource');
    }

    public static function callable(): self
    {
        return self::make('callable');
    }

    public static function iterable(): self
    {
        return self::make('iterable');
    }

    public static function class(string $class): self
    {
        Assert::classExists($class, "Class {$class} does not exist. Got: %s");

        return self::make($class);
    }

    public static function interface(string $interface): self
    {
        Assert::interfaceExists($interface, "Interface {$interface} does not exist. Got: %s");

        return self::make($interface);
    }

    public static function trait(string $trait): self
    {
        Assert::traitExists($trait, "Trait {$trait} does not exist. Got: %s");

        return self::make($trait);
    }

    public function check(mixed $value): bool
    {
        return ($this->callback)($value);
    }

    private function isClass(string $type): bool
    {
        return class_exists($type);
    }

    private function isInterface(string $type): bool
    {
        return interface_exists($type);
    }

    private function checkIfValueIsInstanceOfType(mixed $value, string $type): bool
    {
        return $value instanceof $type;
    }

    private function isTrait(string $type): bool
    {
        return trait_exists($type);
    }

    private function checkIfValueUsesTrait(mixed $value, string $type): bool
    {
        return in_array($type, Uses::classUsesRecursive($value), true);
    }

    private function isScalar(string $type): bool
    {
        $type = $this->resolveScalarType($type);

        return in_array($type, ['integer', 'double', 'boolean', 'string', 'scalar'], true);
    }

    private function isObject(string $type): bool
    {
        return $type === 'object';
    }

    private function isArray(string $type): bool
    {
        return $type === 'array';
    }

    private function checkIfValueIsBuiltIn(mixed $value, string $type): bool
    {
        $type = $this->resolveScalarType($type);

        if ($type === 'scalar') {
            return is_scalar($value);
        }

        return gettype($value) === $type;
    }

    private function isNull(string $type): bool
    {
        return $type === 'null';
    }

    private function checkIfValueIsNull($value): bool
    {
        return is_null($value);
    }

    private function isIterable(string $type): bool
    {
        return $type === 'iterable';
    }

    private function checkIfValueIsIterable($value): bool
    {
        return is_iterable($value);
    }

    private function isCallable(string $type): bool
    {
        return $type === 'callable';
    }

    private function checkIfValueIsCallable(mixed $value): bool
    {
        return ! is_string($value) && is_callable($value);
    }

    private function isResource(string $type): bool
    {
        return $type === 'resource';
    }

    private function checkIfValueIsResource($value): bool
    {
        return is_resource($value);
    }

    private function resolveScalarType(string $type): string
    {
        return match ($type) {
            'int'   => 'integer',
            'float' => 'double',
            'bool'  => 'boolean',
            'text'  => 'string',
            default => $type,
        };
    }

    private function isNumeric(string $type): bool
    {
        return $type === 'numeric';
    }

    private function checkIfValueIsNumeric($value): bool
    {
        return is_numeric($value);
    }
}
