<?php
declare(strict_types=1);

namespace LessToken\Codec\Builder;

use LessToken\Codec\TokenCodec;

interface TokenCodevBuilder
{
    /**
     * @param array<mixed> $config
     */
    public function build(array $config): TokenCodec;
}
