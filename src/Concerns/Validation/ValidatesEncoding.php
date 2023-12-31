<?php

declare(strict_types=1);

namespace ExeQue\Remix\Concerns\Validation;

use ExeQue\Remix\Assert;

/**
 * @internal
 */
trait ValidatesEncoding
{
    protected function validateEncoding(?string $encoding): void
    {
        if ($encoding !== null && ! in_array(mb_strtoupper($encoding), mb_list_encodings(), true)) {
            Assert::report('Invalid encoding provided. Got: %s', $encoding);
        }
    }
}
