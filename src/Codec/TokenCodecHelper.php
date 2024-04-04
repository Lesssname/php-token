<?php
declare(strict_types=1);

namespace LessToken\Codec;

use LessToken\Codec\Builder\TokenCodevBuilder;

final class TokenCodecHelper
{
    /**
     * @param array<mixed> $config
     */
    public static function fromConfig(array $config): TokenCodec
    {
        assert(is_string($config['builder']));
        assert(is_subclass_of($config['builder'], TokenCodevBuilder::class));

        $builder = new $config['builder']();

        assert(is_array($config['config']));

        return $builder->build($config['config']);
    }
}
