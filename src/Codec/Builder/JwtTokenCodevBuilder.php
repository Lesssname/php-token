<?php
declare(strict_types=1);

namespace LessToken\Codec\Builder;

use LessToken\Codec\JwtTokenCodec;
use LessToken\Codec\TokenCodec;
use LessToken\Signer\SignerHelper;

final class JwtTokenCodevBuilder implements TokenCodevBuilder
{
    /**
     * @param array<mixed> $config
     */
    public function build(array $config): TokenCodec
    {
        assert(is_array($config['signer']));
        $signer = SignerHelper::fromConfig($config['signer']);

        return new JwtTokenCodec($signer);
    }
}
