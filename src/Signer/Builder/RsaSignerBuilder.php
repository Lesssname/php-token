<?php
declare(strict_types=1);

namespace LessToken\Signer\Builder;

use LessToken\Signer\Key\Builder\KeyBuilderHelper;
use LessToken\Signer\RsaSigner;
use LessToken\Signer\Signer;

final class RsaSignerBuilder implements SignerBuilder
{
    public function build(array $config): Signer
    {
        assert(is_array($config['keyPrivate']));
        $keyPrivate = KeyBuilderHelper::fromConfig($config['keyPrivate']);

        assert(is_array($config['keyPublic']));
        $keyPublic = KeyBuilderHelper::fromConfig($config['keyPublic']);

        assert(is_string($config['algorithm']));

        return new RsaSigner(
            $keyPrivate,
            $keyPublic,
            $config['algorithm'],
        );
    }
}
