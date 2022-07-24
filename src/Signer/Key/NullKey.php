<?php
declare(strict_types=1);

namespace LessToken\Signer\Key;

use RuntimeException;

final class NullKey implements Key
{
    public function __toString(): string
    {
        throw new RuntimeException();
    }
}
