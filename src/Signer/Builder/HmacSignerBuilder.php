<?php
declare(strict_types=1);

namespace LessToken\Signer\Builder;

use LessToken\Signer\HmacSigner;
use LessToken\Signer\Key\Builder\KeyBuilderHelper;
use LessToken\Signer\Signer;

final class HmacSignerBuilder implements SignerBuilder
{
    /**
     * @param array<mixed> $config
     */
    public function build(array $config): Signer
    {
        assert(is_array($config['key']));
        $key = KeyBuilderHelper::fromConfig($config['key']);

        assert(is_string($config['algorithm']));

        return new HmacSigner($key, $config['algorithm']);
    }
}
