<?php
declare(strict_types=1);

namespace LessToken\Codec;

use LessToken\Signer\Builder\SignerBuilderHelper;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class JwtTokenCodecFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): JwtTokenCodec
    {
        $config = $container->get('config');
        assert(is_array($config));
        assert(is_array($config[JwtTokenCodec::class]));

        $settings = $config[JwtTokenCodec::class];

        assert(is_array($settings['signer']));
        $signer = SignerBuilderHelper::fromConfig($settings['signer']);

        return new JwtTokenCodec($signer);
    }
}
