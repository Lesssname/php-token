<?php
declare(strict_types=1);

namespace LessToken\Codec;

use Psr\Container\ContainerInterface;

final class TokenCodecFactory
{
    public function __invoke(ContainerInterface $container): TokenCodec
    {
        $config = $container->get('config');
        assert(is_array($config));
        assert(is_array($config[TokenCodec::class]));

        return TokenCodecHelper::fromConfig($config[TokenCodec::class]);
    }
}
