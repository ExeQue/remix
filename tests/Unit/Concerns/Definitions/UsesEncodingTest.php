<?php

declare(strict_types=1);

namespace Tests\Unit\Concerns\Definitions;

use ExeQue\Mutators\Concerns\Definitions\UsesEncoding;
use ExeQue\Mutators\Exceptions\InvalidArgumentException;

test('outputs string encoding if value is set when calling getEncoding', function () {
    $instance = createUsesEncodingInstance();

    expect($instance->forward('foo æøå'))->toBe('UTF-8');
})->with([
    'ascii' => [
        'input'    => 'foo',
        'expected' => 'ascii',
    ],
    'utf-8' => [
        'input'    => 'æøå',
        'expected' => 'UTF-8',
    ],
]);

test('outputs stored encoding if value is not set when calling getEncoding', function () {
    $instance = createUsesEncodingInstance('ASCII');

    expect($instance->forward('foo æøå'))->toBe('ASCII');
});

test('outputs null if value and stored encoding is both null', function () {
    $instance = createUsesEncodingInstance();

    expect($instance->forward(null))->toBeNull();
});

test('throws error if given invalid encoding', function () {
    $instance = createUsesEncodingInstance('invalid encoding');

    $instance->forward('foo');
})->throws(InvalidArgumentException::class);

function createUsesEncodingInstance(string $encoding = null): object
{
    return new class($encoding)
    {
        use UsesEncoding;

        public function __construct(string $encoding = null)
        {
            $this->setEncoding($encoding);
        }

        public function forward(?string $value): ?string
        {
            return $this->getEncoding($value);
        }
    };
}
