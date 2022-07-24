<?php
declare(strict_types=1);

namespace LessToken\Signer\Builder;

use LessToken\Signer\Signer;

final class SignerBuilderHelper
{
    /**
     * @param array<mixed> $config
     */
    public static function fromConfig(array $config): Signer
    {
        assert(is_string($config['builder']));
        assert(is_subclass_of($config['builder'], SignerBuilder::class));

        $builder = new $config['builder']();

        assert(is_array($config['config']));

        return $builder->build($config['config']);
    }
}
