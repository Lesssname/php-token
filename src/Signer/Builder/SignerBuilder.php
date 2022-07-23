<?php
declare(strict_types=1);

namespace LessToken\Signer\Builder;

use LessToken\Signer\Signer;

interface SignerBuilder
{
    public function build(array $config): Signer;
}
