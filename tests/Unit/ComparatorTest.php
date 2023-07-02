<?php

declare(strict_types=1);

namespace Tests\Unit;

use ExeQue\Mutators\Comparator;
use Mockery;

test('invokes compare method when invoked as a callable', function () {
    $mutator = Mockery::mock(Comparator::class)->shouldAllowMockingProtectedMethods()->expects('compare')->once()->getMock();

    $mutator('foo');
})->covers(Comparator::class);
