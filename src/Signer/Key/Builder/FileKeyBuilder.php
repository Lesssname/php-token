<?php
declare(strict_types=1);

namespace LessToken\Signer\Key\Builder;

use LessToken\Signer\Key\FileKey;
use LessToken\Signer\Key\Key;

final class FileKeyBuilder implements KeyBuilder
{
    /**
     * @param array<mixed> $config
     */
    public function build(array $config): Key
    {
        assert(is_string($config['file']));

        return new FileKey($config['file']);
    }
}
