<?php
declare(strict_types=1);

namespace LessToken\Signer\Key\Builder;

use LessToken\Signer\Key\Key;
use LessToken\Signer\Key\NullKey;

final class NullKeyBuilder implements KeyBuilder
{
    public function build(array $config): Key
    {
        return new NullKey();
    }
}
