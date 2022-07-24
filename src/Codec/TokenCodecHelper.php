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
        assert(is_string($config['builider']));
        assert(is_subclass_of($config['builider'], TokenCodevBuilder::class));

        $builder = new $config['builider']();

        assert(is_array($config['config']));

        return $builder->build($config['config']);
    }
}
