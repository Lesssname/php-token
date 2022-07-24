<?php
declare(strict_types=1);

namespace LessToken\Signer\Key;

/**
 * @psalm-immutable
 */
interface Key
{
    public function __toString(): string;
}
