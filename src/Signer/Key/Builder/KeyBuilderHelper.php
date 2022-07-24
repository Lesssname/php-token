<?php
declare(strict_types=1);

namespace LessToken\Signer\Key\Builder;

use LessToken\Signer\Key\Key;

final class KeyBuilderHelper
{
    /**
     * @param array<mixed> $config
     */
    public static function fromConfig(array $config): Key
    {
        assert(is_string($config['builder']));
        assert(is_subclass_of($config['builder'], KeyBuilder::class));

        $builder = new $config['builder']();

        assert(is_array($config['config']));

        return $builder->build($config['config']);
    }
}
