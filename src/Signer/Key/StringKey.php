<?php
declare(strict_types=1);

namespace LessToken\Signer\Key;

/**
 * @psalm-immutable
 */
final class StringKey implements Key
{
    public function __construct(private readonly string $key)
    {}

    public function __toString(): string
    {
        return $this->key;
    }
}
