<?php
declare(strict_types=1);

namespace LessToken\Signer\Key\Builder;

use LessToken\Signer\Key\Key;

interface KeyBuilder
{
    /**
     * @param array<mixed> $config
     */
    public function build(array $config): Key;
}
