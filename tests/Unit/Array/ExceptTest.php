<?php

declare(strict_types=1);

namespace Tests\Unit\Array;

use ExeQue\Mutators\Array\Except;

test('removes specified keys from an array', function () {
    $mutator = Except::make(['foo', 'bar']);

    expect($mutator->mutate(['foo' => 2, 'bar' => 4, 'baz' => 6]))->toBe(['baz' => 6]);
});
